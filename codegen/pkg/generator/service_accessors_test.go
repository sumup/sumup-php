package generator

import (
	"os"
	"path/filepath"
	"strings"
	"testing"

	"github.com/pb33f/libopenapi"
)

func TestGenerateServiceAccessors(t *testing.T) {
	t.Parallel()
	const spec = `{
		"openapi": "3.1.0",
		"info": {"title": "Widgets", "version": "1.0.0"},
		"paths": {"/widgets": {"get": {
			"tags": ["Widgets"], "operationId": "listWidgets",
			"responses": {"204": {"description": "No widgets"}}
		}}}
	}`
	doc, err := libopenapi.NewDocument([]byte(spec))
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
	data, err := os.ReadFile(filepath.Join(out, "ServiceAccessors.php"))
	if err != nil {
		t.Fatal(err)
	}
	for _, snippet := range []string{
		`use SumUp\Services\Widgets;`,
		`public function widgets(): Widgets`,
		`return new Widgets($this->client, $this->resolveAccessToken());`,
	} {
		if !strings.Contains(string(data), snippet) {
			t.Errorf("service accessors missing %q", snippet)
		}
	}
}
