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

namespace Vain\Doctrine\Cursor;

use Doctrine\DBAL\Driver\PDOStatement as DoctrineDriverStatementInterface;
use Vain\Database\Cursor\CursorInterface;

/**
 * Class DoctrineCursor
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCursor implements CursorInterface
{
    private $doctrineStatement;

    private $mode;

    /**
     * DoctrineCursor constructor.
     *
     * @param DoctrineDriverStatementInterface $doctrineStatement
     * @param int                              $mode
     */
    public function __construct(DoctrineDriverStatementInterface $doctrineStatement, int $mode = \PDO::FETCH_ASSOC)
    {
        $this->doctrineStatement = $doctrineStatement;
        $this->mode = $mode;
    }

    /**
     * @inheritDoc
     */
    public function valid() : bool
    {
        return ($this->doctrineStatement->errorCode() === '00000');
    }

    /**
     * @inheritDoc
     */
    public function current() : array
    {
        return $this->doctrineStatement->fetch($this->mode);
    }

    /**
     * @inheritDoc
     */
    public function next() : bool
    {
        $this->doctrineStatement->nextRowset();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function close() : CursorInterface
    {
        $this->doctrineStatement->closeCursor();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mode(int $mode) : CursorInterface
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSingle() : array
    {
        return $this->doctrineStatement->fetch($this->mode);
    }

    /**
     * @inheritDoc
     */
    public function getAll() : array
    {
        return $this->doctrineStatement->fetchAll($this->mode);
    }

    /**
     * @inheritDoc
     */
    public function count() : int
    {
        return $this->doctrineStatement->rowCount();
    }
}
