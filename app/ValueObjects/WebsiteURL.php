<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;
use Illuminate\Contracts\Support\Arrayable;

class WebsiteURL implements ValueObjectInterface, Arrayable, \JsonSerializable
{
    public const PAGE_MAIN = 'main';
    public const PAGE_CREDENTIALS = 'credentials';

    public const DUMMY_URL = 'https://dummy.dummy';

    private string $value;
    private string $page;
    private bool $isSecure;

    /**
     * @param string $websiteURL
     * @param string $page
     * @throws InconsistentValueObjectException
     */
    public function __construct(string $websiteURL, string $page)
    {
        if (!defined('static::PAGE_' . mb_strtoupper($page))) {
            throw new InconsistentValueObjectException('Incorrect web site page. Please, check it or define a new one');
        }
        if (mb_substr($websiteURL, 0, 7) !== 'http://' && mb_substr($websiteURL, 0, 8) !== 'https://') {
            throw new InconsistentValueObjectException('Website URL must contain protocol');
        }
        if (!str_contains($websiteURL, '.')) {
            throw new InconsistentValueObjectException('First level domain not found in website URL');
        }
        $this->value = $websiteURL;
        $this->page = $page;
        $this->isSecure = $this->setIsSecure();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isSecure(): bool
    {
        return $this->isSecure;
    }

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array|string
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    private function setIsSecure(): bool
    {
        return mb_substr($this->value, 4, 1) === 's';
    }
}
