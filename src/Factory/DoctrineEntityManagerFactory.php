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
declare(strict_types = 1);

namespace Vain\Doctrine\Factory;

use Doctrine\Common\EventManager as DoctrineEventManager;
use Doctrine\DBAL\Driver\Connection as DBALDriverConnection;
use Doctrine\ORM\Configuration as DoctrineORMConfiguration;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineEntityManagerFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineEntityManagerFactory
{
    /**
     * @param DBALDriverConnection     $connection
     * @param DoctrineORMConfiguration $configuration
     * @param DoctrineEventManager     $eventManager
     *
     * @return EntityManager
     */
    public function create(
        DBALDriverConnection $connection,
        DoctrineORMConfiguration $configuration,
        DoctrineEventManager $eventManager
    ) : EntityManager
    {
        return EntityManager::create($connection, $configuration, $eventManager);
    }
}