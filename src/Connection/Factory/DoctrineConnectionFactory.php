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

use Vain\Connection\ConnectionInterface;
use Vain\Connection\Factory\AbstractConnectionFactory;
use Vain\Connection\Factory\ConnectionFactoryInterface;
use Vain\Doctrine\Connection\DoctrinePostgresqlConnection;
use Vain\Doctrine\Exception\UnknownDoctrineDriverException;
use Vain\Pdo\Connection\PdoConnectionInterface;

/**
 * Class DoctrineConnectionFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineConnectionFactory extends AbstractConnectionFactory
{
    private $pdoConnectionFactory;

    /**
     * DoctrineConnectionFactory constructor.
     *
     * @param string                     $name
     * @param ConnectionFactoryInterface $connectionFactory
     */
    public function __construct($name, ConnectionFactoryInterface $connectionFactory)
    {
        $this->pdoConnectionFactory = $connectionFactory;
        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    public function createConnection(array $config) : ConnectionInterface
    {
        /**
         * @var PdoConnectionInterface $connection
         */
        $connection = $this->pdoConnectionFactory->createConnection($config);
        $driver = $config['type'];
        switch ($driver) {
            case 'pgsql':
                return new DoctrinePostgresqlConnection($connection);
                break;
            case 'mysql':
                return new DoctrinePostgresqlConnection($connection);
                break;
            default:
                throw new UnknownDoctrineDriverException($this, $driver);
        }
    }
}