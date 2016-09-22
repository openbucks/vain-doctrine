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

namespace Vain\Doctrine\Factory;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver\PDOConnection;
use Vain\Doctrine\DoctrineAdapter;
use Vain\Doctrine\Driver\Postgresql\DoctrinePostgresqlDriver;
use Vain\Database\DatabaseInterface;
use Vain\Database\Factory\AbstractDatabaseFactory;
use Vain\Database\Generator\Factory\GeneratorFactoryInterface;

/**
 * Class DoctrineDatabaseFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineDatabaseFactory extends AbstractDatabaseFactory
{
    private $config;

    private $eventManager;

    private $pdoInstance;

    private $generatorFactory;

    /**
     * DoctrineConnectionFactory constructor.
     *
     * @param Configuration             $config
     * @param EventManager              $eventManager
     * @param PDOConnection             $pdoInstance
     * @param GeneratorFactoryInterface $generatorFactory
     * @param string                    $name
     */
    public function __construct(
        Configuration $config,
        EventManager $eventManager,
        PDOConnection $pdoInstance,
        GeneratorFactoryInterface $generatorFactory,
        string $name
    ) {
        $this->config = $config;
        $this->eventManager = $eventManager;
        $this->pdoInstance = $pdoInstance;
        $this->generatorFactory = $generatorFactory;
        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    public function createDatabase(array $configData, $connection) : DatabaseInterface
    {

        switch ($configData['driver']) {
            default:
                $doctrineDriver = new DoctrinePostgresqlDriver($this->pdoInstance);
                break;
        }

        return new DoctrineAdapter(
            $configData,
            $doctrineDriver,
            $this->config,
            $this->eventManager,
            $this->generatorFactory
        );
    }
}