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
declare(strict_types = 1);

namespace Vain\Doctrine\Exception;

use Doctrine\ORM\EntityManagerInterface;
use Vain\Core\Exception\AbstractCoreException;

/**
 * Class EntityManagerException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EntityManagerException extends AbstractCoreException
{
    private $entityManager;

    /**
     * EntityManagerException constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string                 $message
     * @param int                    $code
     * @param \Exception|null        $previous
     */
    public function __construct(EntityManagerInterface $entityManager, string $message, int $code = 500, \Exception $previous = null)
    {
        $this->entityManager = $entityManager;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}