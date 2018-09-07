<?php

/*
 * This file is part of the overtrue/youzan.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\Youzan;

use Overtrue\Http\Traits\HasHttpRequests;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Class AccessToken.
 *
 * @author overtrue <i@overtrue.me>
 */
class AccessToken
{
    use HasHttpRequests;

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
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    /**
     * @var string
     */
    protected $tokenUrl = 'https://open.youzan.com/oauth/token';

    /**
     * AccessToken constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param int    $storeId
     */
    public function __construct(string $clientId, string $clientSecret, int $storeId)
    {
        $this->storeId = $storeId;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param \Psr\SimpleCache\CacheInterface $cache
     *
     * @return $this
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
    public function getCache()
    {
        return $this->cache ?: $this->cache = new FilesystemCache();
    }

    /**
     * @return array|object|\Overtrue\Http\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getToken()
    {
        $key = \sprintf('youzan-access-token-%s', $this->storeId);

        $cached = $this->getCache()->get($key);

        if ($cached) {
            return $cached;
        }

        $token = $this->request($this->tokenUrl, 'POST', [
           'form_params' => [
               'client_id' => $this->clientId,
               'client_secret' => $this->clientSecret,
               'grant_type' => 'silent',
               'kdt_id' => $this->storeId,
           ],
        ]);

        $token = $this->castResponseToType($token, 'array');

        $this->getCache()->set($key, $token, $token['expires_in'] - 1000);

        return $token;
    }

    /**
     * @return string
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __toString()
    {
        try {
            return $this->getToken()['access_token'] ?? '';
        } catch (\Exception $e) {
        }

        return '';
    }
}
