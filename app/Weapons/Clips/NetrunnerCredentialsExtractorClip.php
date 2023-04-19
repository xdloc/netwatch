<?php

namespace App\Weapons\Clips;

use Symfony\Component\DomCrawler\Crawler;

class NetrunnerCredentialsExtractorClip implements NetrunnerExtractorClipInterface
{
    private Crawler $crawler;
    private string $credentialsDom;

    /**
     * @param Crawler $crawler
     * @param string $credentialsDom
     */
    public function __construct(
        Crawler $crawler,
        string $credentialsDom
    )
    {
        $this->crawler = $crawler;
        $this->credentialsDom = $credentialsDom;
    }

    /**
     * @return Crawler
     */
    public function getCrawler(): Crawler
    {
        return $this->crawler;
    }

    /**
     * @return string
     */
    public function getCredentialsDom(): string
    {
        return $this->credentialsDom;
    }
}
