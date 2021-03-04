<?php

namespace Makini\Swagger;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Client as Guzzle;

/**
 * Interface abstracting model access.
 *
 * @package Makini\Swagger
 */
abstract class Client
{
    /**
     * @var Guzzle
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    public function __construct(string $uri, array $options = [], ?Configuration $config = null)
    {
        $uri = new Uri($uri);

        $this->config = $config ?? new Configuration();
        $this->config->setHost($uri->getScheme().'://'.$uri->getAuthority().'/api');

        if (!empty($options['user-agent'])) {
            $this->config->setUserAgent($options['user-agent']);
        }

        $this->client = new Guzzle([
            'timeout' => $options['timeout'] ?? 10,
            'headers' => $options['headers'] ?? [],
        ]);
    }
}
