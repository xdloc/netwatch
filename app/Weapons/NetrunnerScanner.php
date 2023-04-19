<?php

namespace App\Weapons;

use App\ValueObjects\ExecutionInterface;
use App\Weapons\Clips\NetrunnerScannerClip;
use Goutte\Client;
use JetBrains\PhpStorm\Pure;

class NetrunnerScanner extends Weapon implements WeaponInterface
{
    #[Pure]
    public function __construct(NetrunnerScannerClip $clip)
    {
        $this->clip = $clip;
        parent::__construct($clip);
    }

    /**
     * @inheritdoc
     */
    public function execute(): \Symfony\Component\DomCrawler\Crawler
    {
        $client = new Client();
        return $client->request($this->clip->getMethod(), $this->clip->getUrl());
    }
}
