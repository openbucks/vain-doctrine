<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   INFRA
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/INFRA
 */
declare(strict_types = 1);

namespace Vain\Doctrine\Factory;

use Doctrine\Common\Cache\Cache as DoctrineCacheInterface;
use Doctrine\ORM\Tools\Setup;

/**
 * Class DoctrineConfigurationFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineConfigurationFactory
{
    private $doctrineCache;

    private $paths;

    private $applicationEnv;

    /**
     * DoctrineConfigurationFactory constructor.
     *
     * @param DoctrineCacheInterface $doctrineCache
     * @param string                 $applicationEnv
     * @param array                  $paths
     */
    public function __construct(DoctrineCacheInterface $doctrineCache, string $applicationEnv, array $paths = [])
    {
        $this->doctrineCache = $doctrineCache;
        $this->paths = $paths;
        $this->applicationEnv = $applicationEnv;
    }

    /**
     * @param string $path
     *
     * @return DoctrineConfigurationFactory
     */
    public function addPath(string $path) : DoctrineConfigurationFactory
    {
        $this->paths[] = $path;

        return $this;
    }

    /**
     * @return \Doctrine\ORM\Configuration
     */
    public function getConfiguration()
    {
        return Setup::createYAMLMetadataConfiguration(
            $this->paths,
            'dev' === $this->applicationEnv,
            null,
            $this->doctrineCache
        );
    }
}