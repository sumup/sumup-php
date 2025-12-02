package generator

import (
	"fmt"
	"slices"
	"strings"

	"github.com/iancoleman/strcase"
	"github.com/pb33f/libopenapi/datamodel/high/base"
)

type phpProperty struct {
	Name           string
	SerializedName string
	Type           string
	DocType        string
	Optional       bool
	Description    string
}

func (g *Generator) schemaProperties(schema *base.SchemaProxy, currentNamespace string) []phpProperty {
	propertySpecs := g.collectSchemaPropertyEntries(schema)
	if len(propertySpecs) == 0 {
		return nil
	}

	props := make([]phpProperty, 0, len(propertySpecs))
	for _, spec := range propertySpecs {
		prop := phpProperty{
			Name:           phpPropertyName(spec.Name),
			SerializedName: spec.Name,
			Optional:       !spec.Required,
		}

		if spec.Schema != nil && spec.Schema.Schema() != nil {
			prop.Description = spec.Schema.Schema().Description
		}

		prop.Type, prop.DocType = g.resolvePHPType(spec.Schema, currentNamespace)
		props = append(props, prop)
	}

	return props
}

func phpPropertyName(name string) string {
	name = strings.TrimSpace(name)
	name = strings.ReplaceAll(name, "[]", "List")
	name = strings.ReplaceAll(name, ".", "_")
	name = strings.ReplaceAll(name, "-", "_")
	name = strings.ReplaceAll(name, " ", "_")
	if name == "" {
		name = "field"
	}

	name = strcase.ToLowerCamel(name)
	if phpReservedWords[name] {
		return name + "Value"
	}

	return name
}

var phpReservedWords = map[string]bool{
	"abstract":  true,
	"array":     true,
	"callable":  true,
	"class":     true,
	"const":     true,
	"default":   true,
	"function":  true,
	"global":    true,
	"interface": true,
	"new":       true,
	"private":   true,
	"protected": true,
	"public":    true,
	"static":    true,
	"string":    true,
	"int":       true,
	"float":     true,
	"bool":      true,
	"self":      true,
	"parent":    true,
	"trait":     true,
	"namespace": true,
}

type schemaPropertyEntry struct {
	Name     string
	Schema   *base.SchemaProxy
	Required bool
}

func (g *Generator) collectSchemaPropertyEntries(schema *base.SchemaProxy) []schemaPropertyEntry {
	props := make([]schemaPropertyEntry, 0)
	if schema == nil {
		return props
	}

	seen := make(map[string]int)
	g.walkSchemaPropertyEntries(schema, make(map[*base.SchemaProxy]struct{}), seen, &props)

	return props
}

func (g *Generator) walkSchemaPropertyEntries(schema *base.SchemaProxy, stack map[*base.SchemaProxy]struct{}, seen map[string]int, props *[]schemaPropertyEntry) {
	if schema == nil {
		return
	}

	if _, ok := stack[schema]; ok {
		return
	}
	stack[schema] = struct{}{}
	defer delete(stack, schema)

	spec := schema.Schema()
	if spec == nil {
		return
	}

	required := make(map[string]struct{}, len(spec.Required))
	for _, name := range spec.Required {
		required[name] = struct{}{}
	}

	if spec.Properties != nil {
		for propName, propSchema := range spec.Properties.FromOldest() {
			entry := schemaPropertyEntry{
				Name:   propName,
				Schema: propSchema,
			}
			if _, ok := required[propName]; ok {
				entry.Required = true
			}

			if idx, ok := seen[propName]; ok {
				if entry.Required && !(*props)[idx].Required {
					(*props)[idx].Required = true
				}
				continue
			}

			seen[propName] = len(*props)
			*props = append(*props, entry)
		}
	}

	for _, composite := range spec.AllOf {
		g.walkSchemaPropertyEntries(composite, stack, seen, props)
	}
}

func (g *Generator) renderProperty(prop phpProperty) string {
	var b strings.Builder

	b.WriteString("    /**\n")
	if prop.Description != "" {
		for _, line := range strings.Split(prop.Description, "\n") {
			line = strings.TrimSpace(line)
			if line == "" {
				continue
			}
			b.WriteString("     * ")
			b.WriteString(line)
			b.WriteString("\n")
		}
	}
	b.WriteString("     *\n")
	docType := prop.DocType
	if prop.Optional {
		if !strings.Contains(docType, "null") {
			docType += "|null"
		}
	}
	fmt.Fprintf(&b, "     * @var %s\n", docType)
	b.WriteString("     */\n")

	propertyType := prop.Type
	if prop.Optional && propertyType != "mixed" && !strings.HasPrefix(propertyType, "?") {
		propertyType = "?" + propertyType
	}

	if propertyType == "" {
		propertyType = "mixed"
	}

	if prop.Optional {
		fmt.Fprintf(&b, "    public %s $%s = null;\n\n", propertyType, prop.Name)
	} else {
		fmt.Fprintf(&b, "    public %s $%s;\n\n", propertyType, prop.Name)
	}

	return b.String()
}

func (g *Generator) resolvePHPType(schema *base.SchemaProxy, currentNamespace string) (string, string) {
	if schema == nil {
		return "mixed", "mixed"
	}

	if ref := schema.GetReference(); ref != "" {
		if !schemaIsObject(schema) {
			return g.resolvePHPTypeFromSpec(schema.Schema(), currentNamespace)
		}

		// Check if this is an additionalProperties-only schema - treat as array
		if schemaIsAdditionalPropertiesOnly(schema) {
			return "array", "array"
		}

		name := schemaClassName(schema)
		namespace := g.schemaNamespaces[name]
		if namespace == "" {
			return name, name
		}

		typeName := name
		if namespace != currentNamespace {
			typeName = fmt.Sprintf("\\%s\\%s", namespace, name)
		}

		return typeName, typeName
	}

	return g.resolvePHPTypeFromSpec(schema.Schema(), currentNamespace)
}

func (g *Generator) resolvePHPTypeFromSpec(spec *base.Schema, currentNamespace string) (string, string) {
	if spec == nil {
		return "mixed", "mixed"
	}

	if len(spec.Enum) > 0 {
		return "string", "string"
	}

	switch {
	case hasSchemaType(spec, "string"):
		return "string", "string"
	case hasSchemaType(spec, "integer"):
		return "int", "int"
	case hasSchemaType(spec, "number"):
		return "float", "float"
	case hasSchemaType(spec, "boolean"):
		return "bool", "bool"
	case hasSchemaType(spec, "array"):
		itemDoc := "mixed"
		if spec.Items != nil && spec.Items.A != nil {
			_, itemDoc = g.resolvePHPType(spec.Items.A, currentNamespace)
		}
		return "array", itemDoc + "[]"
	case hasSchemaType(spec, "object"):
		return "array", "array"
	default:
	}

	if len(spec.OneOf) > 0 || len(spec.AnyOf) > 0 || len(spec.AllOf) > 0 {
		return "mixed", "mixed"
	}

	return "mixed", "mixed"
}

func hasSchemaType(schema *base.Schema, typ string) bool {
	if schema == nil {
		return false
	}
	return slices.Contains(schema.Type, typ)
}
