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
     * DoctrineConnection constructor.
     *
     * @param array                     $params
     * @param Driver                    $driver
     * @param Configuration             $config
     * @param EventManager              $eventManager
     * @param DatabaseGeneratorFactoryInterface $generatorFactory
     */
    public function __construct(
        array $params,
        Driver $driver,
        Configuration $config,
        EventManager $eventManager,
        DatabaseGeneratorFactoryInterface $generatorFactory
    ) {
        $this->generatorFactory = $generatorFactory;
        parent::__construct($params, $driver, $config, $eventManager);
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
        /**
         * @var Driver\PDOStatement $doctrineStatement
         */
        $doctrineStatement = $this->query($query, $bindParams);

        return $this->generatorFactory->create($this, new DoctrineCursor($doctrineStatement));
    }
}
