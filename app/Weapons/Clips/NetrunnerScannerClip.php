<?php

namespace App\Weapons\Clips;

use App\ValueObjects\HttpMethod;
use App\ValueObjects\WebsiteURL;
use Http\Client\HttpClient; // todo wrong namespace

class NetrunnerScannerClip implements ClipInterface
{
    private WebsiteURL $url;
    private HttpMethod $method;
    private ?HttpClient $httpClient = null;

    /**
     * @param WebsiteURL $url
     * @param HttpMethod $method
     * @param HttpClient|null $httpClient
     */
    public function __construct(WebsiteURL $url, HttpMethod $method, ?HttpClient $httpClient = null)
    {
        $this->url = $url;
        $this->method = $method;
        //$this->httpClient = $httpClient;
    }

    /**
     * @return WebsiteURL
     */
    public function getUrl(): WebsiteURL
    {
        return $this->url;
    }

    /**
     * @return HttpMethod
     */
    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    /**
     * @return HttpClient|null
     */
    public function getHttpClient(): ?HttpClient
    {
        return $this->httpClient;
    }
}
