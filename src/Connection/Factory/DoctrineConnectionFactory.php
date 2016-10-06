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
        return new DoctrinePostgresqlConnection($this->pdoConnectionFactory->createConnection($config));
    }
}