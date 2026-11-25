package generator

import (
	"os"
	"path/filepath"
	"strings"
	"testing"

	"github.com/pb33f/libopenapi"
)

func TestNestedReaderResources(t *testing.T) {
	t.Parallel()

	doc, err := libopenapi.NewDocument([]byte(`
openapi: 3.1.0
info: {title: Readers, version: 1.0.0}
tags:
  - name: Readers
  - name: ReaderCheckouts
    x-displayName: Checkouts
x-tagGroups:
  - name: Readers
    tags: [ReaderCheckouts]
paths:
  /readers/checkouts:
    get:
      operationId: ListReaders
      tags: [Readers]
      responses:
        '204': {description: OK}
    post:
      operationId: CreateReaderCheckout
      tags: [ReaderCheckouts]
      x-codegen: {method_name: create}
      responses:
        '204': {description: OK}
components: {schemas: {}}
`))
	if err != nil {
		t.Fatal(err)
	}
	model, err := doc.BuildV3Model()
	if err != nil {
		t.Fatal(err)
	}

	out := t.TempDir()
	oldDir := filepath.Join(out, "ReaderCheckouts")
	oldFile := filepath.Join(oldDir, "ReaderCheckouts.php")
	if err := os.Mkdir(oldDir, 0o755); err != nil {
		t.Fatal(err)
	}
	if err := os.WriteFile(oldFile, []byte("<?php"), 0o644); err != nil {
		t.Fatal(err)
	}
	generator := New(Config{Out: out})
	if err := generator.Load(&model.Model); err != nil {
		t.Fatal(err)
	}
	if err := generator.Build(); err != nil {
		t.Fatal(err)
	}
	data, err := os.ReadFile(filepath.Join(out, "Readers", "Readers.php"))
	if err != nil {
		t.Fatal(err)
	}
	for _, snippet := range []string{"function checkouts(): ReaderCheckouts", "function listReaders("} {
		if !strings.Contains(string(data), snippet) {
			t.Errorf("missing %q from Readers client", snippet)
		}
	}

	if strings.Contains(string(data), "function create(") {
		t.Error("checkout operation is only available on the nested client")
	}
	child, err := os.ReadFile(filepath.Join(out, "Readers", "Checkouts", "ReaderCheckouts.php"))
	if err != nil {
		t.Fatal(err)
	}
	if !strings.Contains(string(child), "function create(") {
		t.Error("missing annotated create method on nested client")
	}
	if _, err := os.Stat(oldFile); !os.IsNotExist(err) {
		t.Errorf("expected the old flat file to be removed, got %v", err)
	}
}

func TestResourceParentCycleAfterNormalization(t *testing.T) {
	t.Parallel()
	doc, err := libopenapi.NewDocument([]byte(`
openapi: 3.1.0
info: {title: Test, version: 1.0.0}
paths: {}
tags: [{name: A}, {name: B}, {name: a}]
x-tagGroups: [{name: A, tags: [B]}, {name: B, tags: [a]}]
`))
	if err != nil {
		t.Fatal(err)
	}
	model, err := doc.BuildV3Model()
	if err != nil {
		t.Fatal(err)
	}
	if _, err := readResourceParents(&model.Model); err == nil {
		t.Fatal("expected a cycle error for the normalized resource tags")
	}
}
