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

namespace Vain\Doctrine\Operation\Collection\Result;

use Vain\Core\Result\AbstractFailedResult;

/**
 * Class DoctrineCollectionFailedResult
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCollectionFailedResult extends AbstractFailedResult
{

    private $exception;

    /**
     * DoctrineCollectionFailedResult constructor.
     *
     * @param \Throwable $exception
     */
    public function __construct(\Throwable $exception)
    {
        $this->exception = $exception;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf('Cannot perform Doctrine action: %s', $this->exception->getMessage());
    }
}