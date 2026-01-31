package generator

import (
	"bytes"
	"fmt"
	"maps"
	"os"
	"path/filepath"
	"slices"
	"strings"

	"github.com/iancoleman/strcase"
)

//nolint:unused // retained for future SumUp class generation
var reservedServiceNames = map[string]struct{}{
	"Authorization": {},
}

//nolint:unused // writeSumUpClass is kept for the legacy SumUp SDK surface
func (g *Generator) writeSumUpClass() error {
	dir := g.cfg.Out
	if err := os.MkdirAll(dir, os.ModePerm); err != nil {
		return fmt.Errorf("create SumUp directory: %w", err)
	}

	filename := filepath.Join(dir, "SumUp.php")
	f, err := os.OpenFile(filename, os.O_CREATE|os.O_WRONLY|os.O_TRUNC, 0o644)
	if err != nil {
		return fmt.Errorf("open %q: %w", filename, err)
	}
	defer func() {
		_ = f.Close()
	}()

	services := g.collectServiceDefinitions()

	var buf bytes.Buffer
	buf.WriteString(`<?php

namespace SumUp;

`)

	for _, useStmt := range sumUpUseStatements(services) {
		fmt.Fprintf(&buf, "use %s;\n", useStmt)
	}

	buf.WriteString("\n")
	buf.WriteString(`/**
 * Class SumUp
 *
 * @package SumUp
`)

	if propertyDocs := renderSumUpPropertyDocs(services); propertyDocs != "" {
		buf.WriteString(propertyDocs)
	}

	buf.WriteString(` */
class SumUp
{
    /**
     * The access token for API authentication.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * @var HttpClientInterface
     */
    protected $client;

`)

	if serviceMap := renderSumUpServiceMap(services); serviceMap != "" {
		buf.WriteString(serviceMap)
	}

	buf.WriteString(`

    /**
     * SumUp constructor.
     *
     * @param string|array|null $configOrApiKey
     *
     * @throws SDKException
     */
    public function __construct($configOrApiKey = null)
    {
        $config = [];
        if (is_string($configOrApiKey) && $configOrApiKey !== '') {
            $config['api_key'] = $configOrApiKey;
        } elseif (is_array($configOrApiKey)) {
            $config = $configOrApiKey;
        }
        $customHttpClient = $config['client'] ?? null;
        if (array_key_exists('client', $config)) {
            unset($config['client']);
        }
        $config = $this->normalizeConfig($config);
        if ($customHttpClient instanceof HttpClientInterface) {
            $this->client = $customHttpClient;
        } else {
            $this->client = new CurlClient(
                $config['base_uri'],
                $config['custom_headers'],
                $config['ca_bundle_path']
            );
        }
        if (!empty($config['api_key'])) {
            $this->accessToken = $config['api_key'];
        } elseif (!empty($config['access_token'])) {
            $this->accessToken = $config['access_token'];
        }
    }

    /**
     * Returns the default access token.
     *
     * @return string|null
     */
    public function getDefaultAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Normalize configuration and apply defaults.
     *
     * @param array $config
     *
     * @return array
     *
     * @throws ConfigurationException
     */
    private function normalizeConfig(array $config)
    {
        $config = array_merge([
            'api_key' => null,
            'access_token' => null,
            'base_uri' => 'https://api.sumup.com',
            'custom_headers' => [],
            'ca_bundle_path' => null,
        ], $config);

        if ($config['api_key'] === null) {
            $config['api_key'] = getenv('SUMUP_API_KEY') ?: null;
        }

        if ($config['access_token'] === null) {
            $config['access_token'] = getenv('SUMUP_ACCESS_TOKEN') ?: null;
        }

        $headers = is_array($config['custom_headers']) ? $config['custom_headers'] : [];
        $headers['User-Agent'] = SdkInfo::getUserAgent();
        $config['custom_headers'] = $headers;

        return $config;
    }

    /**
     * Proxy access to services via properties.
     *
     * @param string $name
     *
     * @return SumUpService|null
     */
    public function __get($name)
    {
        if (!array_key_exists($name, self::$serviceClassMap)) {
            trigger_error('Undefined property: ' . static::class . '::$' . $name);

            return null;
        }

        if (empty($this->accessToken)) {
            throw new ConfigurationException('No access token provided');
        }

        $token = $this->accessToken;
        $serviceClass = self::$serviceClassMap[$name];

        return new $serviceClass($this->client, $token);
    }
}
`)

	if _, err := f.Write(buf.Bytes()); err != nil {
		return fmt.Errorf("write SumUp file %q: %w", filename, err)
	}

	return nil
}

//nolint:unused // helper is used when SumUp class generation is re-enabled
func (g *Generator) collectServiceDefinitions() []string {
	if len(g.operationsByTag) == 0 {
		return nil
	}

	tagKeys := slices.Collect(maps.Keys(g.operationsByTag))
	slices.Sort(tagKeys)
	services := make([]string, 0, len(tagKeys))

	for _, tagKey := range tagKeys {
		if tagKey == sharedTagKey {
			continue
		}

		operations := g.operationsByTag[tagKey]
		if len(operations) == 0 {
			continue
		}

		className := g.displayTagName(tagKey)
		if _, reserved := reservedServiceNames[className]; reserved {
			continue
		}

		services = append(services, className)
	}

	return services
}

//nolint:unused // helper for the SumUp class code generation
func sumUpUseStatements(serviceNames []string) []string {
	uses := []string{
		"SumUp\\Exception\\ConfigurationException",
		"SumUp\\Exception\\SDKException",
		"SumUp\\HttpClient\\CurlClient",
		"SumUp\\HttpClient\\HttpClientInterface",
		"SumUp\\SdkInfo",
	}

	serviceSet := map[string]struct{}{
		"SumUp\\Services\\SumUpService": {},
	}

	for _, name := range serviceNames {
		serviceSet[fmt.Sprintf("SumUp\\Services\\%s", name)] = struct{}{}
	}

	serviceUses := slices.Collect(maps.Keys(serviceSet))
	slices.Sort(serviceUses)

	return append(uses, serviceUses...)
}

//nolint:unused // helper for generating the SumUp class docblocks
func renderSumUpPropertyDocs(serviceNames []string) string {
	if len(serviceNames) == 0 {
		return ""
	}

	var buf strings.Builder
	buf.WriteString(" *\n")
	for _, service := range serviceNames {
		fmt.Fprintf(&buf, " * @property %s $%s\n", service, strcase.ToLowerCamel(service))
	}

	return buf.String()
}

//nolint:unused // helper for generating the SumUp class service map
func renderSumUpServiceMap(serviceNames []string) string {
	if len(serviceNames) == 0 {
		return ""
	}

	var buf strings.Builder
	buf.WriteString("    /**\n")
	buf.WriteString("     * Map of property names to service classes.\n")
	buf.WriteString("     *\n")
	buf.WriteString("     * @var array<string, string>\n")
	buf.WriteString("     */\n")
	buf.WriteString("    private static $serviceClassMap = [\n")
	for _, service := range serviceNames {
		fmt.Fprintf(&buf, "        '%s' => %s::class,\n", strcase.ToLowerCamel(service), service)
	}
	buf.WriteString("    ];\n\n")

	return buf.String()
}
