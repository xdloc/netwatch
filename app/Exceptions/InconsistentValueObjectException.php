<?php

namespace App\Exceptions;

use App\ValueObjects\ValueObjectInterface;
use Throwable;

class InconsistentValueObjectException extends \Exception
{
    private ?ValueObjectInterface $valueObject = null;

    public function __construct($message = "", $code = 0, Throwable $previous = null, ?ValueObjectInterface $valueObject = null)
    {
        parent::__construct($message, $code, $previous);
        $this->valueObject = $valueObject;
    }

    /**
     * @return ValueObjectInterface|null
     */
    public function getValueObject(): ?ValueObjectInterface
    {
        return $this->valueObject;
    }

}
