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

namespace Vain\Doctrine\Connection;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use Vain\Core\Connection\ConnectionInterface;

/**
 * Class DoctrineMysqlConnection
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineMysqlConnection extends AbstractMySQLDriver
{
    private $connection;

    /**
     * PostgresqlDoctrineDriver constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        return $this->establish();
    }

    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return 'pdo_mysql';
    }

    /**
     * @inheritDoc
     */
    public function establish()
    {
        return $this->connection->establish();
    }
}
