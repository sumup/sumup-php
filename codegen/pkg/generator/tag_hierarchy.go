package generator

import (
	"cmp"
	"fmt"
	"strings"

	"github.com/iancoleman/strcase"
	v3 "github.com/pb33f/libopenapi/datamodel/high/v3"
)

type resourceParent struct {
	tag   string
	label string
}

func readResourceParents(doc *v3.Document) (map[string]resourceParent, error) {
	if doc.Extensions == nil {
		return nil, nil
	}
	node, ok := doc.Extensions.Get("x-tagGroups")
	if !ok {
		return nil, nil
	}
	var groups []struct {
		Name string   `yaml:"name"`
		Tags []string `yaml:"tags"`
	}
	if err := node.Decode(&groups); err != nil {
		return nil, fmt.Errorf("decode x-tagGroups: %w", err)
	}
	labels := make(map[string]string, len(doc.Tags))
	for _, tag := range doc.Tags {
		var displayName string
		if tag.Extensions != nil {
			if label, ok := tag.Extensions.Get("x-displayName"); ok {
				if err := label.Decode(&displayName); err != nil {
					return nil, fmt.Errorf("decode x-displayName for %s: %w", tag.Name, err)
				}
			}
		}
		labels[tag.Name] = cmp.Or(displayName, tag.Name)
	}
	parents := map[string]resourceParent{}
	for _, group := range groups {
		if labels[group.Name] == "" {
			continue
		}
		for _, child := range group.Tags {
			if child == group.Name || labels[child] == "" || parents[child].tag != "" {
				continue
			}
			for ancestor := group.Name; ancestor != ""; ancestor = parents[ancestor].tag {
				if ancestor == child {
					return nil, fmt.Errorf("tag hierarchy contains a cycle at %s", child)
				}
			}
			parents[child] = resourceParent{tag: group.Name, label: labels[child]}
		}
	}
	return parents, nil
}

func (g *Generator) resourcePath(tag string) string {
	if parent := g.resourceParents[tag]; parent.tag != "" {
		return g.resourcePath(parent.tag) + "()->" + phpPropertyName(parent.label)
	}
	return phpPropertyName(g.displayTagName(tag))
}

// scopedMethodNames removes a resource suffix when the shorter name is unambiguous.
func scopedMethodNames(names []string, suffixes ...string) map[string]string {
	original := make(map[string]bool, len(names))
	proposed := make(map[string]string, len(names))
	counts := make(map[string]int, len(names))
	for _, name := range names {
		original[name] = true
		short := unqualifiedMethodName(name, suffixes)
		proposed[name] = short
		counts[short]++
	}
	for name, short := range proposed {
		if original[short] || counts[short] > 1 {
			delete(proposed, name)
		}
	}
	return proposed
}

func unqualifiedMethodName(name string, suffixes []string) string {
	for _, suffix := range suffixes {
		for _, ending := range []string{suffix, strings.TrimSuffix(suffix, "s")} {
			if ending != "" {
				if short, found := strings.CutSuffix(name, ending); found && short != "" {
					return short
				}
			}
		}
	}
	return name
}

func (g *Generator) nestedMethodNames(tag string) map[string]string {
	parent := g.resourceParents[tag]
	if parent.tag == "" {
		return nil
	}
	ops := g.operationsByTag[tag]
	names := make([]string, 0, len(ops))
	for _, op := range ops {
		names = append(names, op.methodName())
	}
	return scopedMethodNames(names, g.displayTagName(tag), strcase.ToCamel(parent.label))
}
