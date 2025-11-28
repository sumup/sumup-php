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

var reservedServiceNames = map[string]struct{}{
	"Authorization": {},
	"Custom":        {},
}

func (g *Generator) writeSumUpClass() error {
	dir := filepath.Join(g.cfg.Out, "SumUp")
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
     * The application's configuration.
     *
     * @var ApplicationConfiguration
     */
    protected $appConfig;

    /**
     * The access token that holds the data from the response.
     *
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @var SumUpHttpClientInterface
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
     * @param array $config
     * @param SumUpHttpClientInterface|null $customHttpClient
     *
     * @throws SumUpSDKException
     */
    public function __construct(array $config = [], SumUpHttpClientInterface $customHttpClient = null)
    {
        $this->appConfig = new ApplicationConfiguration($config);
        $this->client = HttpClientsFactory::createHttpClient($this->appConfig, $customHttpClient);
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->getToken();
    }

    /**
     * Returns the access token.
     *
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Refresh the access token.
     *
     * @param string $refreshToken
     *
     * @return AccessToken
     *
     * @throws SumUpSDKException
     */
    public function refreshToken($refreshToken = null)
    {
        if (isset($refreshToken)) {
            $rToken = $refreshToken;
        } elseif (!isset($refreshToken) && !isset($this->accessToken)) {
            throw new SumUpConfigurationException('There is no refresh token');
        } else {
            $rToken = $this->accessToken->getRefreshToken();
        }
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->refreshToken($rToken);
        return $this->accessToken;
    }

    /**
     * Get the service for authorization.
     *
     * @param ApplicationConfigurationInterface|null $config
     *
     * @return Authorization
     */
    public function getAuthorizationService(ApplicationConfigurationInterface $config = null)
    {
        if (empty($config)) {
            $cfg = $this->appConfig;
        } else {
            $cfg = $config;
        }
        return new Authorization($this->client, $cfg);
    }

    /**
     * Resolve the access token that should be used for a service.
     *
     * @param AccessToken|null $accessToken
     *
     * @return AccessToken
     */
    protected function resolveAccessToken(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            return $accessToken;
        }

        return $this->accessToken;
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
        return $this->getService($name);
    }

    /**
     * Resolve a service by its property name.
     *
     * @param string $name
     * @param AccessToken|null $accessToken
     *
     * @return SumUpService|null
     */
    public function getService($name, AccessToken $accessToken = null)
    {
        if (!array_key_exists($name, self::$serviceClassMap)) {
            trigger_error('Undefined property: ' . static::class . '::$' . $name);

            return null;
        }

        $token = $this->resolveAccessToken($accessToken);
        $serviceClass = self::$serviceClassMap[$name];

        return new $serviceClass($this->client, $token);
    }

`)

	buf.WriteString(`    /**
     * @param AccessToken|null $accessToken
     *
     * @return Custom
     */
    public function getCustomService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Custom($this->client, $token);
    }
}
`)

	if _, err := f.Write(buf.Bytes()); err != nil {
		return fmt.Errorf("write SumUp file %q: %w", filename, err)
	}

	return nil
}

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

func sumUpUseStatements(serviceNames []string) []string {
	uses := []string{
		"SumUp\\Application\\ApplicationConfiguration",
		"SumUp\\Application\\ApplicationConfigurationInterface",
		"SumUp\\Authentication\\AccessToken",
		"SumUp\\Exceptions\\SumUpConfigurationException",
		"SumUp\\Exceptions\\SumUpSDKException",
		"SumUp\\HttpClients\\HttpClientsFactory",
		"SumUp\\HttpClients\\SumUpHttpClientInterface",
	}

	serviceSet := map[string]struct{}{
		"SumUp\\Services\\Authorization": {},
		"SumUp\\Services\\Custom":        {},
		"SumUp\\Services\\SumUpService":  {},
	}

	for _, name := range serviceNames {
		serviceSet[fmt.Sprintf("SumUp\\Services\\%s", name)] = struct{}{}
	}

	serviceUses := slices.Collect(maps.Keys(serviceSet))
	slices.Sort(serviceUses)

	return append(uses, serviceUses...)
}

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
