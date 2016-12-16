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

namespace Vain\Doctrine\Connection\Factory;

use Vain\Core\Connection\ConnectionInterface;
use Vain\Doctrine\Connection\DoctrinePostgresqlConnection;
use Vain\Doctrine\Exception\UnknownDoctrineTypeException;

/**
 * Class DoctrineConnectionFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineConnectionFactory
{
    private $connection;

    /**
     * DoctrineConnectionFactory constructor.
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
    public function getName() : string
    {
        return 'doctrine';
    }

    /**
     * @inheritDoc
     */
    public function createConnection(string $connectionName) : ConnectionInterface
    {
        $type = 'pgsql';
        switch ($type) {
            case 'pgsql':
                return new DoctrinePostgresqlConnection($this->connection);
                break;
            case 'mysql':
                return new DoctrinePostgresqlConnection($this->connection);
                break;
            default:
                throw new UnknownDoctrineTypeException($this, $type);
        }
    }
}
