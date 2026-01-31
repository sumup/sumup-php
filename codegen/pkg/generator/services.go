package generator

import (
	"fmt"
	"regexp"
	"strings"
)

var pathParamRegexp = regexp.MustCompile(`\{([^}]+)\}`)

func (g *Generator) buildServiceBlock(tagKey string, operations []*operation) string {
	className := g.displayTagName(tagKey)

	var buf strings.Builder
	buf.WriteString("namespace SumUp\\Services;\n\n")
	buf.WriteString("use SumUp\\HttpClient\\HttpClientInterface;\n")
	buf.WriteString("use SumUp\\ResponseDecoder;\n")
	buf.WriteString("use SumUp\\SdkInfo;\n\n")
	fmt.Fprintf(&buf, "/**\n * Class %s\n *\n * @package SumUp\\Services\n */\n", className)
	fmt.Fprintf(&buf, "class %s implements SumUpService\n{\n", className)
	buf.WriteString("    /**\n")
	buf.WriteString("     * The client for the http communication.\n")
	buf.WriteString("     *\n")
	buf.WriteString("     * @var HttpClientInterface\n")
	buf.WriteString("     */\n")
	buf.WriteString("    protected $client;\n\n")
	buf.WriteString("    /**\n")
	buf.WriteString("     * The access token needed for authentication for the services.\n")
	buf.WriteString("     *\n")
	buf.WriteString("     * @var string\n")
	buf.WriteString("     */\n")
	buf.WriteString("    protected $accessToken;\n\n")
	buf.WriteString("    /**\n")
	buf.WriteString("     * ")
	buf.WriteString(className)
	buf.WriteString(" constructor.\n")
	buf.WriteString("     *\n")
	buf.WriteString("     * @param HttpClientInterface $client\n")
	buf.WriteString("     * @param $accessToken\n")
	buf.WriteString("     */\n")
	buf.WriteString("    public function __construct(HttpClientInterface $client, $accessToken)\n")
	buf.WriteString("    {\n")
	buf.WriteString("        $this->client = $client;\n")
	buf.WriteString("        $this->accessToken = $accessToken;\n")
	buf.WriteString("    }\n\n")

	for idx, op := range operations {
		buf.WriteString(g.renderServiceMethod(op))
		if idx < len(operations)-1 {
			buf.WriteString("\n")
		}
	}

	buf.WriteString("}\n")

	return buf.String()
}

func (g *Generator) renderServiceMethod(op *operation) string {
	var buf strings.Builder

	methodName := op.methodName()
	if methodName == "" {
		methodName = "call"
	}

	buf.WriteString("    /**\n")
	summary := op.Summary
	if summary == "" {
		summary = op.Description
	}
	if summary == "" {
		summary = fmt.Sprintf("Call %s %s.", op.Method, op.Path)
	}
	buf.WriteString("     * ")
	buf.WriteString(summary)
	buf.WriteString("\n     *\n")

	for _, param := range op.PathParams {
		buf.WriteString("     * @param string $")
		buf.WriteString(param.VarName)
		if param.Description != "" {
			buf.WriteString(" ")
			buf.WriteString(param.Description)
		}
		buf.WriteString("\n")
	}

	if op.HasQuery {
		buf.WriteString("     * @param array $queryParams Optional query string parameters\n")
	}

	if op.HasBody {
		buf.WriteString("     * @param array|null $body Optional request payload\n")
	}

	buf.WriteString("     *\n")
	fmt.Fprintf(&buf, "     * @return %s\n", renderOperationReturnDoc(op))

	if op.Deprecated {
		buf.WriteString("     *\n")
		buf.WriteString("     * @deprecated\n")
	}

	buf.WriteString("     */\n")

	args := make([]string, 0, len(op.PathParams)+2)
	for _, param := range op.PathParams {
		args = append(args, "$"+param.VarName)
	}
	if op.HasQuery {
		args = append(args, "$queryParams = []")
	}
	if op.HasBody {
		args = append(args, "$body = null")
	}

	buf.WriteString("    public function ")
	buf.WriteString(methodName)
	buf.WriteString("(")
	buf.WriteString(strings.Join(args, ", "))
	buf.WriteString(")\n")
	buf.WriteString("    {\n")

	buf.WriteString(renderPathAssignment(op))

	if op.HasQuery {
		buf.WriteString("        if (!empty($queryParams)) {\n")
		buf.WriteString("            $queryString = http_build_query($queryParams);\n")
		buf.WriteString("            if (!empty($queryString)) {\n")
		buf.WriteString("                $path .= '?' . $queryString;\n")
		buf.WriteString("            }\n")
		buf.WriteString("        }\n")
	}

	buf.WriteString("        $payload = [];\n")
	if op.HasBody {
		buf.WriteString("        if ($body !== null) {\n")
		buf.WriteString("            $payload = $body;\n")
		buf.WriteString("        }\n")
	}

	buf.WriteString("        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];\n")
	buf.WriteString("        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());\n")
	buf.WriteString("        $headers['Authorization'] = 'Bearer ' . $this->accessToken;\n\n")
	fmt.Fprintf(&buf, "        $response = $this->client->send('%s', $path, $payload, $headers);\n\n", strings.ToUpper(op.Method))
	if descriptor := renderOperationResponseDescriptor(op); descriptor != "" {
		fmt.Fprintf(&buf, "        return ResponseDecoder::decode($response, %s);\n", descriptor)
	} else {
		buf.WriteString("        return ResponseDecoder::decode($response);\n")
	}
	buf.WriteString("    }\n")

	return buf.String()
}

func renderResponseTypeDescriptor(rt *responseType) string {
	if rt == nil {
		return "['type' => 'mixed']"
	}

	switch rt.Kind {
	case responseTypeClass:
		return fmt.Sprintf("['type' => 'class', 'class' => %s::class]", formatClassReference(rt.ClassName))
	case responseTypeArray:
		if rt.ArrayItems != nil {
			return fmt.Sprintf("['type' => 'array', 'items' => %s]", renderResponseTypeDescriptor(rt.ArrayItems))
		}
		return "['type' => 'array']"
	case responseTypeScalar:
		return fmt.Sprintf("['type' => 'scalar', 'scalar' => '%s']", rt.ScalarType)
	case responseTypeObject:
		return "['type' => 'object']"
	case responseTypeVoid:
		return "['type' => 'void']"
	case responseTypeMixed:
		return "['type' => 'mixed']"
	default:
		return "['type' => 'mixed']"
	}
}

func formatClassReference(name string) string {
	if name == "" {
		return "self"
	}

	if strings.HasPrefix(name, "\\") {
		return name
	}

	return name
}

func renderOperationReturnDoc(op *operation) string {
	if op == nil || len(op.Responses) == 0 {
		return "\\SumUp\\HttpClients\\Response"
	}

	docTypes := make([]string, 0, len(op.Responses))
	seen := make(map[string]struct{})

	for _, resp := range op.Responses {
		if resp == nil || resp.Type == nil {
			continue
		}
		doc := renderResponseDocType(resp.Type)
		if doc == "" {
			continue
		}
		if _, ok := seen[doc]; ok {
			continue
		}
		seen[doc] = struct{}{}
		docTypes = append(docTypes, doc)
	}

	if len(docTypes) == 0 {
		return "\\SumUp\\HttpClients\\Response"
	}

	return strings.Join(docTypes, "|")
}

func renderResponseDocType(rt *responseType) string {
	if rt == nil {
		return ""
	}

	switch rt.Kind {
	case responseTypeClass:
		return formatClassReference(rt.ClassName)
	case responseTypeArray:
		itemDoc := "mixed"
		if rt.ArrayItems != nil {
			doc := renderResponseDocType(rt.ArrayItems)
			if doc != "" {
				itemDoc = doc
			}
		}
		return itemDoc + "[]"
	case responseTypeScalar:
		if rt.ScalarType != "" {
			return rt.ScalarType
		}
		return "mixed"
	case responseTypeObject:
		return "array"
	case responseTypeVoid:
		return "null"
	case responseTypeMixed:
		return "mixed"
	default:
		return "mixed"
	}
}

func renderOperationResponseDescriptor(op *operation) string {
	if op == nil || len(op.Responses) == 0 {
		return ""
	}

	// Simplified approach: if there's a single 200 response with a class, just return the class name
	if len(op.Responses) == 1 && op.Responses[0].StatusCode == "200" {
		resp := op.Responses[0]
		if resp.Type != nil && resp.Type.Kind == responseTypeClass && resp.Type.ClassName != "" {
			return fmt.Sprintf("%s::class", formatClassReference(resp.Type.ClassName))
		}
	}

	// For multiple status codes or non-200 responses, use descriptor array
	var buf strings.Builder
	buf.WriteString("[\n")
	for _, resp := range op.Responses {
		if resp == nil || resp.Type == nil {
			continue
		}
		fmt.Fprintf(&buf, "            '%s' => %s,\n", resp.StatusCode, renderResponseTypeDescriptor(resp.Type))
	}
	buf.WriteString("        ]")

	return buf.String()
}

func renderPathAssignment(op *operation) string {
	if len(op.PathParams) == 0 {
		return fmt.Sprintf("        $path = '%s';\n", op.Path)
	}

	format := op.Path
	matches := pathParamRegexp.FindAllStringSubmatch(op.Path, -1)
	paramOrder := make([]string, 0, len(matches))
	for _, match := range matches {
		if len(match) < 2 {
			continue
		}
		format = strings.Replace(format, match[0], "%s", 1)
		paramOrder = append(paramOrder, match[1])
	}

	builder := strings.Builder{}
	builder.WriteString("        $path = sprintf('")
	builder.WriteString(format)
	builder.WriteString("'")
	for _, originalName := range paramOrder {
		varName := phpPropertyName(originalName)
		builder.WriteString(", rawurlencode((string) $")
		builder.WriteString(varName)
		builder.WriteString(")")
	}
	builder.WriteString(");\n")

	return builder.String()
}
