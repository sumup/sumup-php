package generator

import (
	"bytes"
	"fmt"
	"log/slog"
	"maps"
	"os"
	"path/filepath"
	"slices"
	"strings"

	"github.com/pb33f/libopenapi/datamodel/high/base"
	v3 "github.com/pb33f/libopenapi/datamodel/high/v3"
)

const (
	sharedTagKey         = "__shared"
	sharedTagDisplayName = "Shared"
	sharedTagNamespace   = "SumUp\\Shared"
)

// Config defines generator options.
type Config struct {
	// Out is the output directory.
	Out string
}

// Generator orchestrates the SDK generation.
type Generator struct {
	cfg Config

	spec *v3.Document

	tagLookup map[string]*base.Tag

	// schemasByTag maps normalized tag names to schemas they own.
	schemasByTag map[string][]*base.SchemaProxy

	// schemaNamespaces tracks where a schema is defined so we can reference it.
	schemaNamespaces map[string]string

	operationsByTag map[string][]*operation

	// enumsByTag maps normalized tag names to enums they own.
	enumsByTag map[string][]enumDefinition

	// enumNamespaces tracks where an enum is defined so we can reference it.
	enumNamespaces map[string]string
}

type enumDefinition struct {
	Name        string
	Description string
	Values      []string
	Type        string // "string" or "int"
}

// New creates a new Generator instance.
func New(cfg Config) *Generator {
	return &Generator{
		cfg: cfg,
	}
}

// Load ingests the OpenAPI spec and prepares it for code generation.
func (g *Generator) Load(spec *v3.Document) error {
	if spec == nil {
		return fmt.Errorf("nil spec")
	}

	g.spec = spec
	g.tagLookup = make(map[string]*base.Tag)
	for _, tag := range spec.Tags {
		if tag == nil {
			continue
		}
		g.tagLookup[normalizeTagKey(tag.Name)] = tag
	}

	usage := g.collectSchemaUsage()
	g.schemasByTag, g.schemaNamespaces = g.assignSchemasToTags(usage)
	g.operationsByTag = g.collectOperations()
	g.enumsByTag, g.enumNamespaces = g.collectEnums()

	return nil
}

// Build generates the SDK in the configured destination.
func (g *Generator) Build() error {
	if g.spec == nil {
		return fmt.Errorf("missing specs: call Load to load the specs first")
	}

	tagKeys := slices.Collect(maps.Keys(g.schemasByTag))
	slices.Sort(tagKeys)

	for _, tagKey := range tagKeys {
		if len(g.schemasByTag[tagKey]) == 0 {
			continue
		}

		if err := g.writeTagModels(tagKey, g.schemasByTag[tagKey]); err != nil {
			return err
		}
	}

	slog.Info("models generated", slog.Int("tags", len(tagKeys)))

	if err := g.writeServices(); err != nil {
		return err
	}

	// Skip SumUp class generation to avoid breaking existing code
	// TODO: Fix Authorization service dependency before re-enabling
	// if err := g.writeSumUpClass(); err != nil {
	// 	return err
	// }

	return nil
}

func (g *Generator) writeTagModels(tagKey string, schemas []*base.SchemaProxy) error {
	tagName := g.displayTagName(tagKey)
	namespace := g.namespaceForTag(tagKey)

	dir := filepath.Join(g.cfg.Out, tagName)
	if err := os.MkdirAll(dir, os.ModePerm); err != nil {
		return fmt.Errorf("create tag directory: %w", err)
	}

	filename := filepath.Join(dir, fmt.Sprintf("%s.php", tagName))
	f, err := os.OpenFile(filename, os.O_CREATE|os.O_WRONLY|os.O_TRUNC, 0o644)
	if err != nil {
		return fmt.Errorf("open %q: %w", filename, err)
	}
	defer func() {
		_ = f.Close()
	}()

	var buf bytes.Buffer
	buf.WriteString("<?php\n\ndeclare(strict_types=1);\n\n")
	fmt.Fprintf(&buf, "namespace %s;\n\n", namespace)

	// Write enums first if any exist for this tag
	if enums, ok := g.enumsByTag[tagKey]; ok && len(enums) > 0 {
		for idx, enum := range enums {
			enumCode := g.buildPHPEnum(enum)
			buf.WriteString(enumCode)
			if idx < len(enums)-1 || len(schemas) > 0 {
				buf.WriteString("\n")
			}
		}
	}

	// Write classes
	for idx, schema := range schemas {
		className := schemaClassName(schema)
		classCode := g.buildPHPClass(className, schema, namespace)
		buf.WriteString(classCode)
		if idx < len(schemas)-1 {
			buf.WriteString("\n")
		}
	}

	if _, err := f.Write(buf.Bytes()); err != nil {
		return fmt.Errorf("write file %q: %w", filename, err)
	}

	enumCount := 0
	if enums, ok := g.enumsByTag[tagKey]; ok {
		enumCount = len(enums)
	}

	slog.Info("generated models file",
		slog.String("tag", tagName),
		slog.String("namespace", namespace),
		slog.String("file", filename),
		slog.Int("classes", len(schemas)),
		slog.Int("enums", enumCount),
	)

	return nil
}

func (g *Generator) buildPHPClass(name string, schema *base.SchemaProxy, currentNamespace string) string {
	var buf strings.Builder
	description := ""
	if schema.Schema() != nil {
		description = schema.Schema().Description
	}

	if description != "" {
		buf.WriteString("/**\n")
		for _, line := range strings.Split(description, "\n") {
			line = strings.TrimSpace(line)
			if line == "" {
				buf.WriteString(" *\n")
				continue
			}
			buf.WriteString(" * ")
			buf.WriteString(line)
			buf.WriteString("\n")
		}
		buf.WriteString(" */\n")
	}

	fmt.Fprintf(&buf, "class %s\n{\n", name)

	properties := g.schemaProperties(schema, currentNamespace)
	if len(properties) == 0 {
		buf.WriteString("}\n")
		return buf.String()
	}

	for _, prop := range properties {
		propCode := g.renderProperty(prop)
		buf.WriteString(propCode)
	}

	buf.WriteString("}\n")
	return buf.String()
}

func (g *Generator) displayTagName(tagKey string) string {
	if tagKey == sharedTagKey {
		return sharedTagDisplayName
	}

	if tag, ok := g.tagLookup[tagKey]; ok && tag != nil && tag.Name != "" {
		return sanitizeTagName(tag.Name)
	}

	return sanitizeTagName(tagKey)
}

func (g *Generator) namespaceForTag(tagKey string) string {
	if tagKey == sharedTagKey {
		return sharedTagNamespace
	}

	tagName := g.displayTagName(tagKey)
	return fmt.Sprintf("SumUp\\%s", tagName)
}

func (g *Generator) buildPHPEnum(enum enumDefinition) string {
	var buf strings.Builder

	if enum.Description != "" {
		buf.WriteString("/**\n")
		for _, line := range strings.Split(enum.Description, "\n") {
			line = strings.TrimSpace(line)
			if line == "" {
				buf.WriteString(" *\n")
				continue
			}
			buf.WriteString(" * ")
			buf.WriteString(line)
			buf.WriteString("\n")
		}
		buf.WriteString(" */\n")
	}

	backingType := ""
	if enum.Type == "string" {
		backingType = ": string"
	} else if enum.Type == "int" {
		backingType = ": int"
	}

	fmt.Fprintf(&buf, "enum %s%s\n{\n", enum.Name, backingType)

	for _, value := range enum.Values {
		caseName := phpEnumCaseName(value)
		if enum.Type == "string" {
			fmt.Fprintf(&buf, "    case %s = '%s';\n", caseName, value)
		} else if enum.Type == "int" {
			fmt.Fprintf(&buf, "    case %s = %s;\n", caseName, value)
		} else {
			fmt.Fprintf(&buf, "    case %s;\n", caseName)
		}
	}

	buf.WriteString("}\n")
	return buf.String()
}

func (g *Generator) collectEnums() (map[string][]enumDefinition, map[string]string) {
	enumsByTag := make(map[string][]enumDefinition)
	enumNamespaces := make(map[string]string)
	enumsSeen := make(map[string]struct{})

	for tagKey, schemas := range g.schemasByTag {
		for _, schema := range schemas {
			g.collectEnumsFromSchema(schema, tagKey, enumsByTag, enumNamespaces, enumsSeen, make(map[*base.SchemaProxy]struct{}))
		}
	}

	// Sort enums by name within each tag
	for tag := range enumsByTag {
		slices.SortFunc(enumsByTag[tag], func(a, b enumDefinition) int {
			return strings.Compare(a.Name, b.Name)
		})
	}

	return enumsByTag, enumNamespaces
}

func (g *Generator) collectEnumsFromSchema(schema *base.SchemaProxy, tagKey string, enumsByTag map[string][]enumDefinition, enumNamespaces map[string]string, enumsSeen map[string]struct{}, visited map[*base.SchemaProxy]struct{}) {
	if schema == nil {
		return
	}

	if _, ok := visited[schema]; ok {
		return
	}
	visited[schema] = struct{}{}

	spec := schema.Schema()
	if spec == nil {
		return
	}

	// Check properties for enums
	if spec.Properties != nil {
		for propName, propSchema := range spec.Properties.FromOldest() {
			if propSchema == nil {
				continue
			}

			propSpec := propSchema.Schema()
			if propSpec == nil {
				continue
			}

			if len(propSpec.Enum) > 0 {
				enumName := phpEnumName(schemaClassName(schema), propName)
				if _, seen := enumsSeen[enumName]; seen {
					continue
				}
				enumsSeen[enumName] = struct{}{}

				enumType := "string"
				values := make([]string, 0, len(propSpec.Enum))
				for _, val := range propSpec.Enum {
					if val != nil && val.Value != "" {
						values = append(values, val.Value)
					}
				}

				if len(values) > 0 {
					enum := enumDefinition{
						Name:        enumName,
						Description: propSpec.Description,
						Values:      values,
						Type:        enumType,
					}
					enumsByTag[tagKey] = append(enumsByTag[tagKey], enum)
					enumNamespaces[enumName] = g.namespaceForTag(tagKey)
				}
			}

			// Recursively check nested schemas
			g.collectEnumsFromSchema(propSchema, tagKey, enumsByTag, enumNamespaces, enumsSeen, visited)
		}
	}

	// Check allOf, anyOf, oneOf compositions
	for _, composite := range spec.AllOf {
		g.collectEnumsFromSchema(composite, tagKey, enumsByTag, enumNamespaces, enumsSeen, visited)
	}
	for _, composite := range spec.AnyOf {
		g.collectEnumsFromSchema(composite, tagKey, enumsByTag, enumNamespaces, enumsSeen, visited)
	}
	for _, composite := range spec.OneOf {
		g.collectEnumsFromSchema(composite, tagKey, enumsByTag, enumNamespaces, enumsSeen, visited)
	}
}
