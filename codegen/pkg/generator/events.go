package generator

import (
	"bytes"
	"embed"
	"fmt"
	"os"
	"path/filepath"
	"slices"
	"strings"
	"text/template"

	"github.com/iancoleman/strcase"

	"github.com/sumup/sumup-php/codegen/pkg/extension"
)

//go:embed templates/events/*.tmpl
var eventTemplates embed.FS

type eventDefinition struct {
	Name       string
	Type       string
	ObjectType string
	SchemaName string
	Method     string
}

func (g *Generator) collectEvents() ([]eventDefinition, error) {
	var events []eventDefinition
	names := make(map[string]bool)
	for eventType, item := range g.spec.Webhooks.FromOldest() {
		if item == nil || item.Post == nil || item.Post.OperationId == "" {
			return nil, fmt.Errorf("webhook %q is missing a POST operationId", eventType)
		}
		name := strcase.ToCamel(strings.TrimSuffix(item.Post.OperationId, "Webhook"))
		if name == "" || names[name] {
			return nil, fmt.Errorf("webhook %q has an empty or duplicate event class name", eventType)
		}
		names[name] = true
		object, ok := extension.Get[struct {
			Reference string `yaml:"$ref"`
		}](item.Post.Extensions, "x-object")
		schemaName, local := strings.CutPrefix(object.Reference, "#/components/schemas/")
		if !ok || !local || schemaName == "" || g.spec.Components == nil {
			return nil, fmt.Errorf("webhook %q requires a local x-object schema reference", eventType)
		}
		schema := g.spec.Components.Schemas.GetOrZero(schemaName)
		if schema == nil || !schemaShouldGenerateClass(schema) {
			return nil, fmt.Errorf("webhook %q has missing or unsupported object schema %q", eventType, schemaName)
		}
		events = append(events, eventDefinition{
			Name:       name + "Event",
			Type:       eventType,
			ObjectType: strcase.ToCamel(strings.NewReplacer(".", "_", "-", "_").Replace(schemaName)),
			SchemaName: schemaName,
			Method:     "on" + name,
		})
	}
	slices.SortFunc(events, func(a, b eventDefinition) int { return strings.Compare(a.Type, b.Type) })
	return events, nil
}

func (g *Generator) writeEvents() error {
	templates, err := template.ParseFS(eventTemplates, "templates/events/*.tmpl")
	if err != nil {
		return fmt.Errorf("parse event templates: %w", err)
	}
	dir := filepath.Join(g.cfg.Out, "Events")
	if err := os.MkdirAll(dir, 0o755); err != nil {
		return fmt.Errorf("create events directory: %w", err)
	}
	write := func(name, templateName string, data any) error {
		var buf bytes.Buffer
		if err := templates.ExecuteTemplate(&buf, templateName, data); err != nil {
			return fmt.Errorf("render event file %q: %w", name, err)
		}
		if err := os.WriteFile(filepath.Join(dir, name+".php"), buf.Bytes(), 0o644); err != nil {
			return fmt.Errorf("write event file %q: %w", name, err)
		}
		return nil
	}
	for _, event := range g.events {
		if err := write(event.Name, "event.tmpl", event); err != nil {
			return err
		}
	}
	if err := write("EventFactory", "factory.tmpl", g.events); err != nil {
		return err
	}
	return write("EventsHandler", "handler.tmpl", g.events)
}
