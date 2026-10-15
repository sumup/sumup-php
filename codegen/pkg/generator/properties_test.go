package generator

import (
	"strings"
	"testing"

	"github.com/pb33f/libopenapi/datamodel/high/base"
)

func TestSchemaAllowsNull(t *testing.T) {
	t.Parallel()

	nullable := true
	tests := map[string]struct {
		schema *base.SchemaProxy
		want   bool
	}{
		"OpenAPI 3.0 nullable": {
			schema: base.CreateSchemaProxy(&base.Schema{
				Type:     []string{"string"},
				Nullable: &nullable,
			}),
			want: true,
		},
		"OpenAPI 3.1 null type": {
			schema: base.CreateSchemaProxy(&base.Schema{
				Type: []string{"string", "null"},
			}),
			want: true,
		},
		"non-nullable": {
			schema: base.CreateSchemaProxy(&base.Schema{
				Type: []string{"string"},
			}),
			want: false,
		},
		"nil": {
			want: false,
		},
	}

	for name, tt := range tests {
		t.Run(name, func(t *testing.T) {
			t.Parallel()

			if got := schemaAllowsNull(tt.schema); got != tt.want {
				t.Fatalf("schemaAllowsNull() = %t, want %t", got, tt.want)
			}
		})
	}
}

func TestRequiredNullableProperty(t *testing.T) {
	t.Parallel()

	generator := New(Config{})
	property := phpProperty{
		Name:     "value",
		Type:     "string",
		DocType:  "string",
		Nullable: true,
	}

	generated := generator.renderProperty(property)
	if !strings.Contains(generated, "@var string|null") {
		t.Fatalf("renderProperty() did not document nullability:\n%s", generated)
	}
	if !strings.Contains(generated, "public ?string $value;") {
		t.Fatalf("renderProperty() did not allow null:\n%s", generated)
	}
	if got, want := generator.propertyTypeHint(property), "?string"; got != want {
		t.Fatalf("propertyTypeHint() = %q, want %q", got, want)
	}
}

func TestOpenEnumProperty(t *testing.T) {
	t.Parallel()

	generator := New(Config{})
	generator.enumsByTag = map[string][]enumDefinition{
		typesTagKey: {
			{Name: "Status", Type: "string"},
			{Name: "Code", Type: "int"},
		},
	}
	tests := map[string]struct {
		property phpProperty
		wantType string
	}{
		"required": {
			property: phpProperty{Name: "value", Type: "Status", DocType: "Status"},
			wantType: "Status|string",
		},
		"optional": {
			property: phpProperty{Name: "value", Type: "Status", DocType: "Status", Optional: true},
			wantType: "Status|string|null",
		},
		"nullable": {
			property: phpProperty{Name: "value", Type: "Status", DocType: "Status", Nullable: true},
			wantType: "Status|string|null",
		},
		"integer backing type": {
			property: phpProperty{Name: "value", Type: `\SumUp\Types\Code`, DocType: `\SumUp\Types\Code`},
			wantType: `\SumUp\Types\Code|int`,
		},
	}
	for name, tt := range tests {
		t.Run(name, func(t *testing.T) {
			t.Parallel()

			generated := generator.renderProperty(tt.property)
			for _, want := range []string{"@var " + tt.wantType, "public " + tt.wantType + " $value"} {
				if !strings.Contains(generated, want) {
					t.Fatalf("renderProperty() missing %q:\n%s", want, generated)
				}
			}
			if got := generator.propertyTypeHint(tt.property); got != tt.wantType {
				t.Fatalf("propertyTypeHint() = %q, want %q", got, tt.wantType)
			}
		})
	}
}
