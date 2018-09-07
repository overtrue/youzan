<?php

/*
 * This file is part of the overtrue/youzan.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\Youzan;

/**
 * Class Client.
 *
 * @author overtrue <i@overtrue.me>
 */
class Client extends \Overtrue\Http\Client
{
    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var int
     */
    protected $storeId;

    /**
     * @var float
     */
    protected $version = '3.0.0';

    /**
     * @var string
     */
    protected $format = 'json';

    /**
     * @var \Overtrue\Youzan\AccessToken
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $baseUri = 'https://open.youzan.com/api/oauthentry/';

    /**
     * Client constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param int    $storeId
     * @param array  $options
     */
    public function __construct(string $clientId, string $clientSecret, int $storeId, array $options = [])
    {
        parent::__construct();

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->storeId = $storeId;
        $this->version = $options['version'] ?? $this->version;
    }

    /**
     * @param string $uri
     * @param array  $params
     *
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get(string $uri, array $params = [])
    {
        return parent::get($this->buildUrl($uri), $this->createPayload($params));
    }

    /**
     * @param string $uri
     * @param array  $params
     *
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function post(string $uri, array $params = [])
    {
        return parent::post($this->buildUrl($uri), $this->createPayload($params));
    }

    /**
     * @return \Overtrue\Youzan\AccessToken
     */
    protected function getAccessToken()
    {
        return $this->accessToken ?: $this->accessToken = new AccessToken($this->clientId, $this->clientSecret, $this->storeId);
    }

    /**
     * @param \Overtrue\Youzan\AccessToken $accessToken
     *
     * @return $this
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function createPayload(array $params = [])
    {
        return \array_merge(['access_token' => $this->getAccessToken()->getToken()['access_token']], $params);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    protected function buildUrl(string $uri)
    {
        $segments = explode('.', $uri);

        $last = array_pop($segments);

        return implode('.', $segments).\sprintf('/%s/%s', $this->version, $last);
    }

    /**
     * @param array $params
     *
     * @return string
     */
    protected function signature(array $params)
    {
        \ksort($params);

        $text = '';

        foreach ($params as $name => $value) {
            $text .= $name.$value;
        }

        return md5(\sprintf('%s%s%s', $this->secret, $text, $this->secret));
    }
}
