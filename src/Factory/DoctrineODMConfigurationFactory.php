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

use Doctrine\ODM\MongoDB\Configuration as DoctrineODMConfiguration;
use Vain\Core\Api\Extension\Storage\ApiExtensionStorageInterface;
use Doctrine\Common\Cache\Cache as DoctrineCacheInterface;
use Doctrine\ODM\MongoDB\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\Common\Proxy\AbstractProxyFactory;

/**
 * Class DoctrineODMConfigurationFactory
 *
 * @author Nazar Ivanenko <nivanenko@gmail.com>
 */
class DoctrineODMConfigurationFactory
{
    private $extensionStorage;

    /**
     * DoctrineODMConfigurationFactory constructor.
     *
     * @param ApiExtensionStorageInterface $extensionStorage
     */
    public function __construct(ApiExtensionStorageInterface $extensionStorage)
    {
        $this->extensionStorage = $extensionStorage;
    }

    /**
     * @param DoctrineCacheInterface $doctrineCache
     * @param string                 $applicationEnv
     * @param string                 $configDir
     * @param string                 $cacheDir
     * @param string                 $globalFileName
     * @param string                 $extension
     *
     * @return DoctrineODMConfiguration
     */
    public function getConfiguration(
        DoctrineCacheInterface $doctrineCache,
        string $applicationEnv,
        string $configDir,
        string $cacheDir,
        string $globalFileName,
        string $extension
    ) : DoctrineODMConfiguration
    {
        $paths = [];
        foreach ($this->extensionStorage->getPaths() as $path => $namespace) {
            $paths[$path] = $namespace;
        }
        $paths[$configDir] = '';

        $driver = new SimplifiedYamlDriver($paths, $extension);
        $driver->setGlobalBasename($globalFileName);

        $config = new DoctrineODMConfiguration();
        $config->setProxyDir($cacheDir.'/proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir($cacheDir.'/hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setMetadataDriverImpl($driver);
        $config->setMetadataCacheImpl($doctrineCache);
        $config->setAutoGenerateProxyClasses('dev' === $applicationEnv ? AbstractProxyFactory::AUTOGENERATE_ALWAYS : AbstractProxyFactory::AUTOGENERATE_NEVER);

        return $config;
    }
}
