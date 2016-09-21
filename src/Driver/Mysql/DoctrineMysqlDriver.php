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

namespace Vain\Doctrine\Driver\Mysql;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use \PDO as PdoInstance;

/**
 * Class DoctrineMysqlDriver
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineMysqlDriver extends AbstractMySQLDriver
{
    private $pdoInstance;

    /**
     * PostgresqlDoctrineDriver constructor.
     *
     * @param PdoInstance $pdoInstance
     */
    public function __construct(PdoInstance $pdoInstance)
    {
        $this->pdoInstance = $pdoInstance;
    }

    /**
     * @inheritDoc
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        return $this->pdoInstance;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'pdo_mysql';
    }
}