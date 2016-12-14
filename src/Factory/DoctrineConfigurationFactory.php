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
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Configuration as DoctrineORMConfiguration;

/**
 * Class DoctrineConfigurationFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineConfigurationFactory
{
    /**
     * @param DoctrineCacheInterface $doctrineCache
     * @param string                 $applicationEnv
     * @param string                 $configDir
     * @param string                 $doctrineDir
     * @param string                 $doctrineProxy
     * @param string                 $globalFileName
     * @param string                 $extension
     *
     * @return DoctrineORMConfiguration
     */
    public function getConfiguration(
        DoctrineCacheInterface $doctrineCache,
        string $applicationEnv,
        string $configDir,
        string $doctrineDir,
        string $doctrineProxy,
        string $globalFileName,
        string $extension
    ) : DoctrineORMConfiguration
    {
        $driver = new SimplifiedYamlDriver([$configDir => ''], $extension);
        $driver->setGlobalBasename($globalFileName);

        $config = Setup::createConfiguration(
            'dev' === $applicationEnv,
            null,
            $doctrineCache
        );
        $config->setProxyDir($doctrineDir);
        $config->setProxyNamespace($doctrineProxy);
        $config->setMetadataDriverImpl($driver);

        return $config;
    }
}
