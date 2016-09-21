<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   vain-doctrine
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/vain-doctrine
 */

namespace Vain\Doctrine\Cache\Apcu;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider as DoctrineCacheProvider;

/**
 * Class DoctrineApcuCache
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineApcuCache extends DoctrineCacheProvider
{
    /**
     * @inheritDoc
     */
    protected function doFetch($id)
    {
        trigger_error(sprintf('Method %s is not implemented', 'doFetch'), E_USER_ERROR);
    }

    /**
     * @inheritDoc
     */
    protected function doContains($id)
    {
        trigger_error(sprintf('Method %s is not implemented', 'doContains'), E_USER_ERROR);
    }

    /**
     * @inheritDoc
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        trigger_error(sprintf('Method %s is not implemented', 'doSave'), E_USER_ERROR);
    }

    /**
     * @inheritDoc
     */
    protected function doDelete($id)
    {
        trigger_error(sprintf('Method %s is not implemented', 'doDelete'), E_USER_ERROR);
    }

    /**
     * @inheritDoc
     */
    protected function doFlush()
    {
        trigger_error(sprintf('Method %s is not implemented', 'doFlush'), E_USER_ERROR);
    }

    /**
     * @inheritDoc
     */
    protected function doGetStats()
    {
        $info = [];

        return [
            Cache::STATS_HITS   => $info['keyspace_hits'],
            Cache::STATS_MISSES => $info['keyspace_misses'],
            Cache::STATS_UPTIME => $info['uptime_in_seconds'],
            Cache::STATS_MEMORY_USAGE      => $info['used_memory'],
            Cache::STATS_MEMORY_AVAILABLE  => false
        ];
    }
}