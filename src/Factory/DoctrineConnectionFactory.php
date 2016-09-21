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

namespace Vain\Doctrine\Factory;

use Doctrine\DBAL\Driver\PDOConnection;
use Vain\Connection\Exception\NoRequiredFieldException;
use Vain\Connection\Factory\AbstractConnectionFactory;

/**
 * Class DoctrineConnectionFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineConnectionFactory extends AbstractConnectionFactory
{
    /**
     * @param array $config
     *
     * @return array
     *
     * @throws NoRequiredFieldException
     */
    protected function getCredentials(array $config) : array
    {
        foreach (['driver', 'host', 'port', 'dbname', 'username', 'password'] as $requiredField) {
            if (false === array_key_exists($requiredField, $config)) {
                throw new NoRequiredFieldException($this, $requiredField);
            }
        }

        if (false === array_key_exists('sslmode', $config)) {
            $sslmode = '';
        } else {
            $sslmode = $config['sslmode'];
        }

        return [
            $config['driver'],
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['username'],
            $config['password'],
            $sslmode,
        ];
    }

    /**
     * @inheritDoc
     */
    public function createConnection(array $config)
    {
        list ($driver, $host, $port, $dbname, $username, $password, $sslmode) = $this->getCredentials($config);

        $dsn = sprintf('%s:host=%s;port=%d;dbname=%s', $driver, $host, $port, $dbname);

        if ('' !== $sslmode) {
            $dsn .= sprintf(';sslmode=%s', $sslmode);
        }

        $pdo = new PDOConnection($dsn, $username, $password);

        if (defined('PDO::PGSQL_ATTR_DISABLE_PREPARES')
            && (!isset($driverOptions[\PDO::PGSQL_ATTR_DISABLE_PREPARES])
                || true === $driverOptions[\PDO::PGSQL_ATTR_DISABLE_PREPARES]
            )
        ) {
            $pdo->setAttribute(\PDO::PGSQL_ATTR_DISABLE_PREPARES, true);
        }

        return $pdo;
    }
}