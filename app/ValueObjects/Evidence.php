<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Evidence implements ValueObjectInterface
{
    /**
     * Evidence types
     * If you have new evidence to put in DB - you need to put it here first
     * It requires for DB consistency, to exclude random keys in array you will never find out later
     */
    public const PASSED = 'passed';
    public const RAW_CREDENTIALS = 'raw_credentials';
    public const LEGAL_ENTITY = 'legal_entity';

    /**
     * Evidence data types
     */
    private const DATA_TYPE_BOOLEAN = 'boolean';
    private const DATA_TYPE_STRING = 'string';
    private const DATA_TYPE_INTEGER = 'integer';
    private const DATA_TYPE_DOUBLE = 'double'; // this is float also
    private const DATA_TYPE_ARRAY = 'array';
    private const DATA_TYPE_OBJECT = 'object'; // todo parse objects to VO also
    private const DATA_TYPE_RESOURCE = 'resource';
    private const DATA_TYPE_NULL = 'null';
    private const DATA_TYPE_UNKNOWN_TYPE = 'unknown type';

    /**
     * @var array
     */
    private array $evidence;

    /**
     * @param array $data
     * @throws InconsistentValueObjectException
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $datum) {
            if (!$this->isAvailableEvidence($key, $datum)) {
                throw new InconsistentValueObjectException('Invalid evidence type, please add new one if this is the correct one');
            }
        }
        $this->evidence = $data;
    }

    /**
     * integer, double, string, array, object, resource, NULL, unknown type
     * @return string[]
     */
    #[ArrayShape([
        self::PASSED => "string",
        self::RAW_CREDENTIALS => "string",
        self::LEGAL_ENTITY => "string"])]
    private function getAvailableEvidenceType(): array
    {
        return [
            self::PASSED => self::DATA_TYPE_BOOLEAN, // true - check was OK, false - check found something bad
            self::RAW_CREDENTIALS => self::DATA_TYPE_STRING, // credentials we parsed from html
            self::LEGAL_ENTITY => self::DATA_TYPE_OBJECT // legal entity object
        ];
    }

    /**
     * @param int|string $key
     * @param mixed $datum
     * boolean
     * @return bool
     */
    #[Pure]
    private function isAvailableEvidence(int|string $key, mixed $datum): bool
    {
        return gettype($datum) === $this->getAvailableEvidenceType()[$key];
    }
}
