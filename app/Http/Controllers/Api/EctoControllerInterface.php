<?php

namespace App\Http\Controllers\Api;

use App\ValueObjects\WebsiteURL;

interface EctoControllerInterface
{
    //todo get verdict for suspect based on all investigations
    //public function getVerdict();

    /**
     * @param string $customer_code
     * @param string $url
     * @param string $page
     * @return mixed
     */
    public function setUrl(string $customer_code, string $url, string $page): mixed; //?string $page

    /**
     * @param string $customer_code
     * @param string $page
     * @return mixed
     */
    public function getUrl(string $customer_code,string $page = WebsiteURL::PAGE_MAIN): mixed;

    // todo get dom with credentials, for example, trying to find it on page
    //public function getDom();
}
