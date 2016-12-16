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
use Vain\Core\Connection\Factory\AbstractConnectionFactory;
use Vain\Core\Connection\Storage\ConnectionStorageInterface;
use Vain\Doctrine\Connection\DoctrinePostgresqlConnection;
use Vain\Doctrine\Exception\UnknownDoctrineTypeException;

/**
 * Class DoctrineConnectionFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineConnectionFactory extends AbstractConnectionFactory
{
    private $connectionStorage;

    /**
     * DoctrineConnectionFactory constructor.
     *
     * @param \ArrayAccess               $configData
     * @param ConnectionStorageInterface $connectionStorage
     */
    public function __construct(\ArrayAccess $configData, ConnectionStorageInterface $connectionStorage)
    {
        $this->connectionStorage = $connectionStorage;
        parent::__construct($configData);
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
        $config = $this->getConfigData($connectionName);
        $type = $config['type'];
        switch ($type) {
            case 'pgsql':
                return new DoctrinePostgresqlConnection($this->connectionStorage->getConnection($connectionName));
                break;
            case 'mysql':
                return new DoctrinePostgresqlConnection($this->connectionStorage->getConnection($connectionName));
                break;
            default:
                throw new UnknownDoctrineTypeException($this, $type);
        }
    }
}
