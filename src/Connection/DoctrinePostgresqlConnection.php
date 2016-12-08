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

namespace Vain\Doctrine\Connection;

use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use Vain\Connection\ConnectionInterface;

/**
 * Class DoctrinePostgresqlConnection
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrinePostgresqlConnection extends AbstractPostgreSQLDriver implements ConnectionInterface
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
    public function getName()
    {
        return 'pdo_pgsql';
    }

    /**
     * @inheritDoc
     */
    public function establish()
    {
        return $this->connection->establish();
    }
}