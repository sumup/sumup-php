package generator

import (
	"os"
	"path/filepath"
	"strings"
	"testing"

	"github.com/pb33f/libopenapi"
)

const webhookSpec = `{
  "openapi": "3.1.0",
  "info": {"title": "Events", "version": "1.0.0"},
  "paths": {},
  "components": {"schemas": {
    "Widget": {"type": "object", "properties": {"id": {"type": "string"}}}
  }},
  "webhooks": {
    "widgets.created": {"post": {
      "operationId": "WidgetCreatedWebhook",
      "x-object": {"$ref": "#/components/schemas/Widget"},
      "responses": {"2XX": {"description": "Accepted"}}
    }}
  }
}`

func TestGenerateEvents(t *testing.T) {
	t.Parallel()
	doc, err := libopenapi.NewDocument([]byte(webhookSpec))
	if err != nil {
		t.Fatal(err)
	}
	model, err := doc.BuildV3Model()
	if err != nil {
		t.Fatal(err)
	}
	out := t.TempDir()
	g := New(Config{Out: out})
	if err := g.Load(&model.Model); err != nil {
		t.Fatal(err)
	}
	if err := g.Build(); err != nil {
		t.Fatal(err)
	}
	for file, snippets := range map[string][]string{
		"Events/WidgetCreatedEvent.php": {"const TYPE = 'widgets.created'", "fetchObject(?RequestOptions $options = null): ?Widget", "Widget::class"},
		"Events/EventFactory.php":       {"WidgetCreatedEvent::TYPE => new WidgetCreatedEvent", "new UnknownEvent"},
		"Events/EventsHandler.php":      {"callable(WidgetCreatedEvent): void", "function onWidgetCreated(callable $callback): self"},
		"Types/Widget.php":              {"class Widget", "public ?string $id"},
	} {
		data, err := os.ReadFile(filepath.Join(out, file))
		if err != nil {
			t.Fatal(err)
		}
		for _, snippet := range snippets {
			if !strings.Contains(string(data), snippet) {
				t.Errorf("%s missing %q", file, snippet)
			}
		}
	}
}

func TestRejectInvalidWebhooks(t *testing.T) {
	t.Parallel()
	for name, spec := range map[string]string{
		"missing operation": strings.Replace(webhookSpec, `"WidgetCreatedWebhook"`, `""`, 1),
		"missing object":    strings.Replace(webhookSpec, `"x-object"`, `"x-other"`, 1),
		"nonlocal object":   strings.Replace(webhookSpec, `#/components/schemas/Widget`, `https://example.com/Widget`, 1),
		"unknown object":    strings.Replace(webhookSpec, `#/components/schemas/Widget`, `#/components/schemas/Missing`, 1),
	} {
		t.Run(name, func(t *testing.T) {
			t.Parallel()
			doc, err := libopenapi.NewDocument([]byte(spec))
			if err != nil {
				t.Fatal(err)
			}
			model, err := doc.BuildV3Model()
			if err == nil {
				err = New(Config{}).Load(&model.Model)
			}
			if err == nil {
				t.Fatal("expected invalid webhook definition to fail")
			}
		})
	}
}
