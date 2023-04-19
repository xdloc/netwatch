<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;

class HttpMethod implements ValueObjectInterface
{
    private string $method;
    private const METHODS = ['GET','POST','PUT','DELETE','HEAD','CONNECT','OPTIONS','TRACE'];

    /**
     * @param string $method
     * @throws InconsistentValueObjectException
     */
    public function __construct(string $method)
    {
        if(!in_array(mb_strtoupper($method),self::METHODS) ){
            throw new InconsistentValueObjectException('Wrong HTTP method');
        }
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function __toString(): string
    {
        return $this->method;
    }
}
