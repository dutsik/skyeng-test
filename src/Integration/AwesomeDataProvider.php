<?php
/**
 * Created by PhpStorm.
 * User: DUTSIK
 * Date: 9/19/2018
 * Time: 11:25
 */

namespace Integration;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class AwesomeDataProvider
{
    private $service;
    /**
     * var CacheItemPoolInterface
     */
    private $cache;
    private $logger;

    /**
     * @param ServiceAdapterInterface $service
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(ServiceAdapterInterface $service, CacheItemPoolInterface $cache, LoggerInterface $logger)
    {

        $this->service = $service;
        $this->cache = $cache;
        $this->logger = $logger;

    }


    /**
     * @param array $input
     * @return array|mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getResponse(array $input)
    {

        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                $result = $cacheItem->get();
                $this->logger->debug("From Cache:" . $result);
                return $result;
            }

            $result = $this->service->get($input);
            $this->logger->debug("From Service:" . $result);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new \DateTime())->modify('+1 day')
                );
            $this->cache->save($cacheItem);

            return $result;
        } catch (\Exception $e) {
            $this->logger->critical('Error');
        }

        return [];

    }

    /**
     * @param array $input
     * @return false|string
     */
    private function getCacheKey(array $input)
    {

        return json_encode($input);

    }
}
