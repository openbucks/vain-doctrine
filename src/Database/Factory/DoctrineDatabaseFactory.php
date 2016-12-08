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

namespace Vain\Doctrine\Database\Factory;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver as DoctrineDatabaseDriver;
use Vain\Connection\ConnectionInterface;
use Vain\Doctrine\Database\DoctrineDatabase;
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

    private $generatorFactory;

    /**
     * DoctrineConnectionFactory constructor.
     *
     * @param Configuration             $config
     * @param EventManager              $eventManager
     * @param GeneratorFactoryInterface $generatorFactory
     * @param string                    $name
     */
    public function __construct(
        Configuration $config,
        EventManager $eventManager,
        GeneratorFactoryInterface $generatorFactory,
        string $name
    ) {
        $this->config = $config;
        $this->eventManager = $eventManager;
        $this->generatorFactory = $generatorFactory;
        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    public function createDatabase(array $configData, ConnectionInterface $connection) : DatabaseInterface
    {
        /**
         * @var DoctrineDatabaseDriver $connection
         */
        return new DoctrineDatabase(
            $configData,
            $connection,
            $this->config,
            $this->eventManager,
            $this->generatorFactory
        );
    }
}
