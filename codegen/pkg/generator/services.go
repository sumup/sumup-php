package generator

import (
	"fmt"
	"regexp"
	"strings"

	"slices"

	"github.com/iancoleman/strcase"
	"github.com/pb33f/libopenapi/datamodel/high/base"
)

var pathParamRegexp = regexp.MustCompile(`\{([^}]+)\}`)

func (g *Generator) buildServiceBlock(tagKey string, operations []*operation) string {
	className := g.displayTagName(tagKey)

	var buf strings.Builder
	buf.WriteString("namespace SumUp\\Services;\n\n")
	buf.WriteString("use SumUp\\HttpClient\\HttpClientInterface;\n")
	buf.WriteString("use SumUp\\ResponseDecoder;\n")
	buf.WriteString("use SumUp\\SdkInfo;\n\n")

	inlineResponseSchemas := collectInlineResponseSchemas(operations)
	if len(inlineResponseSchemas) > 0 {
		inlineNames := make([]string, 0, len(inlineResponseSchemas))
		for name := range inlineResponseSchemas {
			inlineNames = append(inlineNames, name)
		}
		slices.Sort(inlineNames)
		for _, name := range inlineNames {
			buf.WriteString(g.buildPHPClass(name, inlineResponseSchemas[name], "SumUp\\Services"))
			buf.WriteString("\n")
		}
	}

	seenParams := make(map[string]struct{})
	for _, op := range operations {
		if op == nil || !op.HasQuery {
			continue
		}
		paramsClass := queryParamsClassName(className, op)
		if _, ok := seenParams[paramsClass]; ok {
			continue
		}
		seenParams[paramsClass] = struct{}{}
		buf.WriteString(buildQueryParamsClass(paramsClass, op.QueryParams))
		buf.WriteString("\n")
	}

	fmt.Fprintf(&buf, "/**\n * Class %s\n *\n * @package SumUp\\Services\n */\n", className)
	fmt.Fprintf(&buf, "class %s implements SumUpService\n{\n", className)
	buf.WriteString("    /**\n")
	buf.WriteString("     * The client for the http communication.\n")
	buf.WriteString("     *\n")
	buf.WriteString("     * @var HttpClientInterface\n")
	buf.WriteString("     */\n")
	buf.WriteString("    protected HttpClientInterface $client;\n\n")
	buf.WriteString("    /**\n")
	buf.WriteString("     * The access token needed for authentication for the services.\n")
	buf.WriteString("     *\n")
	buf.WriteString("     * @var string\n")
	buf.WriteString("     */\n")
	buf.WriteString("    protected string $accessToken;\n\n")
	buf.WriteString("    /**\n")
	buf.WriteString("     * ")
	buf.WriteString(className)
	buf.WriteString(" constructor.\n")
	buf.WriteString("     *\n")
	buf.WriteString("     * @param HttpClientInterface $client\n")
	buf.WriteString("     * @param string $accessToken\n")
	buf.WriteString("     */\n")
	buf.WriteString("    public function __construct(HttpClientInterface $client, string $accessToken)\n")
	buf.WriteString("    {\n")
	buf.WriteString("        $this->client = $client;\n")
	buf.WriteString("        $this->accessToken = $accessToken;\n")
	buf.WriteString("    }\n\n")

	for idx, op := range operations {
		buf.WriteString(g.renderServiceMethod(className, op))
		if idx < len(operations)-1 {
			buf.WriteString("\n")
		}
	}

	buf.WriteString("}\n")

	return buf.String()
}

func (g *Generator) renderServiceMethod(serviceClass string, op *operation) string {
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
		fmt.Fprintf(&buf, "     * @param %s|null $queryParams Optional query string parameters\n", queryParamsClassName(serviceClass, op))
	}

	if op.HasBody {
		buf.WriteString("     * @param array|null $body Optional request payload\n")
	}
	buf.WriteString("     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)\n")

	buf.WriteString("     *\n")
	fmt.Fprintf(&buf, "     * @return %s\n", renderOperationReturnDoc(op))

	if op.Deprecated {
		buf.WriteString("     *\n")
		buf.WriteString("     * @deprecated\n")
	}

	buf.WriteString("     */\n")

	args := make([]string, 0, len(op.PathParams)+2)
	for _, param := range op.PathParams {
		args = append(args, "string $"+param.VarName)
	}
	if op.HasQuery {
		args = append(args, fmt.Sprintf("?%s $queryParams = null", queryParamsClassName(serviceClass, op)))
	}
	if op.HasBody {
		args = append(args, "?array $body = null")
	}
	args = append(args, "?array $requestOptions = null")

	buf.WriteString("    public function ")
	buf.WriteString(methodName)
	buf.WriteString("(")
	buf.WriteString(strings.Join(args, ", "))
	buf.WriteString(")")
	if returnType := renderOperationReturnTypeHint(op); returnType != "" {
		buf.WriteString(": ")
		buf.WriteString(returnType)
	}
	buf.WriteString("\n")
	buf.WriteString("    {\n")

	buf.WriteString(renderPathAssignment(op))

	if op.HasQuery {
		buf.WriteString("        if ($queryParams !== null) {\n")
		buf.WriteString("            $queryParamsData = [];\n")
		for _, qp := range op.QueryParams {
			if qp.VarName == "" || qp.OriginalName == "" {
				continue
			}
			fmt.Fprintf(&buf, "            if (isset($queryParams->%s)) {\n", qp.VarName)
			fmt.Fprintf(&buf, "                $queryParamsData['%s'] = $queryParams->%s;\n", qp.OriginalName, qp.VarName)
			buf.WriteString("            }\n")
		}
		buf.WriteString("            if (!empty($queryParamsData)) {\n")
		buf.WriteString("                $queryString = http_build_query($queryParamsData);\n")
		buf.WriteString("                if (!empty($queryString)) {\n")
		buf.WriteString("                    $path .= '?' . $queryString;\n")
		buf.WriteString("                }\n")
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
	fmt.Fprintf(&buf, "        $response = $this->client->send('%s', $path, $payload, $headers, $requestOptions);\n\n", strings.ToUpper(op.Method))
	successDescriptor := renderOperationSuccessResponseDescriptor(op)
	errorDescriptor := renderOperationErrorResponseDescriptor(op)

	switch {
	case successDescriptor != "" && errorDescriptor != "":
		fmt.Fprintf(
			&buf,
			"        return ResponseDecoder::decodeOrThrow($response, %s, %s, '%s', $path);\n",
			successDescriptor,
			errorDescriptor,
			strings.ToUpper(op.Method),
		)
	case successDescriptor != "":
		fmt.Fprintf(
			&buf,
			"        return ResponseDecoder::decodeOrThrow($response, %s, null, '%s', $path);\n",
			successDescriptor,
			strings.ToUpper(op.Method),
		)
	case errorDescriptor != "":
		fmt.Fprintf(
			&buf,
			"        return ResponseDecoder::decodeOrThrow($response, null, %s, '%s', $path);\n",
			errorDescriptor,
			strings.ToUpper(op.Method),
		)
	default:
		fmt.Fprintf(
			&buf,
			"        return ResponseDecoder::decodeOrThrow($response, null, null, '%s', $path);\n",
			strings.ToUpper(op.Method),
		)
	}
	buf.WriteString("    }\n")

	return buf.String()
}

func queryParamsClassName(serviceClass string, op *operation) string {
	methodName := op.methodName()
	if methodName == "" {
		methodName = "Operation"
	}
	if serviceClass != "" {
		return fmt.Sprintf("%s%sParams", serviceClass, strcase.ToCamel(methodName))
	}
	return fmt.Sprintf("%sParams", strcase.ToCamel(methodName))
}

func buildQueryParamsClass(className string, params []operationParam) string {
	var buf strings.Builder
	fmt.Fprintf(&buf, "/**\n * Query parameters for %s.\n *\n * @package SumUp\\Services\n */\n", className)
	fmt.Fprintf(&buf, "class %s\n{\n", className)

	for _, param := range params {
		prop := phpProperty{
			Name:        param.VarName,
			Type:        param.Type,
			DocType:     param.DocType,
			Optional:    !param.Required,
			Description: param.Description,
		}
		buf.WriteString(renderQueryParamProperty(prop))
	}

	buf.WriteString("}\n")
	return buf.String()
}

func renderQueryParamProperty(prop phpProperty) string {
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

func collectInlineResponseSchemas(operations []*operation) map[string]*base.SchemaProxy {
	result := make(map[string]*base.SchemaProxy)
	for _, op := range operations {
		if op == nil {
			continue
		}
		for _, resp := range op.Responses {
			if resp == nil || resp.Type == nil {
				continue
			}
			collectInlineResponseSchema(resp.Type, result)
		}
	}
	return result
}

func collectInlineResponseSchema(rt *responseType, acc map[string]*base.SchemaProxy) {
	if rt == nil {
		return
	}
	if rt.InlineClassName != "" && rt.InlineSchema != nil {
		if _, ok := acc[rt.InlineClassName]; !ok {
			acc[rt.InlineClassName] = rt.InlineSchema
		}
	}
	if rt.ArrayItems != nil {
		collectInlineResponseSchema(rt.ArrayItems, acc)
	}
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
		return "\\SumUp\\HttpClient\\Response"
	}

	docTypes := make([]string, 0, len(op.Responses))
	seen := make(map[string]struct{})

	for _, resp := range op.Responses {
		if resp == nil || resp.Type == nil || !resp.IsSuccess {
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
		return "\\SumUp\\HttpClient\\Response"
	}

	return strings.Join(docTypes, "|")
}

func renderOperationReturnTypeHint(op *operation) string {
	if op == nil || len(op.Responses) == 0 {
		return ""
	}

	typeHints := make([]string, 0, len(op.Responses))
	seen := make(map[string]struct{})

	for _, resp := range op.Responses {
		if resp == nil || resp.Type == nil || !resp.IsSuccess {
			continue
		}

		typeHint, ok := renderResponseTypeHint(resp.Type)
		if !ok || typeHint == "" {
			return ""
		}

		if _, exists := seen[typeHint]; exists {
			continue
		}
		seen[typeHint] = struct{}{}
		typeHints = append(typeHints, typeHint)
	}

	if len(typeHints) == 0 {
		return ""
	}

	if len(typeHints) == 1 {
		return typeHints[0]
	}

	return strings.Join(typeHints, "|")
}

func renderResponseTypeHint(rt *responseType) (string, bool) {
	if rt == nil {
		return "", false
	}

	switch rt.Kind {
	case responseTypeClass:
		return formatClassReference(rt.ClassName), true
	case responseTypeArray:
		return "array", true
	case responseTypeScalar:
		switch rt.ScalarType {
		case "string", "int", "float", "bool":
			return rt.ScalarType, true
		default:
			return "", false
		}
	case responseTypeObject:
		return "array", true
	case responseTypeVoid:
		return "null", true
	default:
		return "", false
	}
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

func renderOperationSuccessResponseDescriptor(op *operation) string {
	if op == nil || len(op.Responses) == 0 {
		return ""
	}

	successResponses := make([]*operationResponse, 0, len(op.Responses))
	for _, resp := range op.Responses {
		if resp != nil && resp.IsSuccess {
			successResponses = append(successResponses, resp)
		}
	}

	if len(successResponses) == 0 {
		return ""
	}

	// Simplified approach: if there's a single 200 response with a class, just return the class name
	if len(successResponses) == 1 && successResponses[0].StatusCode == "200" {
		resp := successResponses[0]
		if resp.Type != nil && resp.Type.Kind == responseTypeClass && resp.Type.ClassName != "" {
			return fmt.Sprintf("%s::class", formatClassReference(resp.Type.ClassName))
		}
	}

	// For multiple success status codes, use descriptor array
	var buf strings.Builder
	buf.WriteString("[\n")
	for _, resp := range successResponses {
		if resp == nil || resp.Type == nil {
			continue
		}
		fmt.Fprintf(&buf, "            '%s' => %s,\n", resp.StatusCode, renderResponseTypeDescriptor(resp.Type))
	}
	buf.WriteString("        ]")

	return buf.String()
}

func renderOperationErrorResponseDescriptor(op *operation) string {
	if op == nil || len(op.Responses) == 0 {
		return ""
	}

	errorResponses := make([]*operationResponse, 0, len(op.Responses))
	for _, resp := range op.Responses {
		if resp != nil && !resp.IsSuccess {
			errorResponses = append(errorResponses, resp)
		}
	}

	if len(errorResponses) == 0 {
		return ""
	}

	var buf strings.Builder
	buf.WriteString("[\n")
	for _, resp := range errorResponses {
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
