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

namespace Vain\Doctrine\Database;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Vain\Core\Database\Mvcc\MvccDatabaseInterface;
use Vain\Doctrine\Cursor\DoctrineCursor;
use Vain\Core\Database\Generator\Factory\DatabaseGeneratorFactoryInterface;
use Vain\Core\Database\Generator\DatabaseGeneratorInterface;

/**
 * Class DoctrineDatabase
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineDatabase extends Connection implements MvccDatabaseInterface
{
    private $generatorFactory;

    /**
     * DoctrineDatabase constructor.
     *
     * @param \ArrayAccess                      $params
     * @param Configuration                     $config
     * @param Driver                            $driver
     * @param EventManager                      $eventManager
     * @param DatabaseGeneratorFactoryInterface $generatorFactory
     */
    public function __construct(
        \ArrayAccess $params,
        Configuration $config,
        Driver $driver,
        EventManager $eventManager,
        DatabaseGeneratorFactoryInterface $generatorFactory
    ) {
        $this->generatorFactory = $generatorFactory;
        parent::__construct($params['databases']['mvcc'], $driver, $config, $eventManager);
    }

    /**
     * @inheritDoc
     */
    public function startTransaction() : bool
    {
        $this->beginTransaction();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function commitTransaction() : bool
    {
        $this->commit();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function rollbackTransaction() : bool
    {
        $this->rollBack();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function runQuery($query, array $bindParams, array $bindTypeParams = []) : DatabaseGeneratorInterface
    {
        return $this->generatorFactory->create(new DoctrineCursor($this->query($query, $bindParams)));
    }
}
