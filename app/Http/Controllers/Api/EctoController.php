<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InconsistentValueObjectException;
use App\Models\Suspect;
use App\ValueObjects\CustomerCode;
use App\ValueObjects\WebsiteURL;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller;

class EctoController extends Controller implements EctoControllerInterface
{
    /**
     * @inheritdoc
     * @throws JsonRpcException
     */
    public function setUrl(string $customer_code, string $url, string $page): mixed
    {
        try {
            $customerCode = new CustomerCode($customer_code);
            $websiteURL = new WebsiteURL($url, $page);
            $suspect = Suspect::byCustomerCode($customerCode)->firstOrNew();
            $suspect->setUrl($websiteURL);
        } catch (InconsistentValueObjectException $exception) {
            throw new JsonRpcException(JsonRpcException::CODE_VALIDATION_ERROR, $exception->getMessage());
        }
        return $suspect->save();
    }

    /**
     * @inheritdoc
     * @throws JsonRpcException
     */
    public function getUrl(string $customer_code, string $page = WebsiteURL::PAGE_MAIN): mixed
    {
        try {
            $customerCode = new CustomerCode($customer_code);
            $suspect = Suspect::byCustomerCode($customerCode)->firstOrFail();
            $url = $suspect->getUrl($page);
        } catch (InconsistentValueObjectException $exception) {
            throw new JsonRpcException(JsonRpcException::CODE_VALIDATION_ERROR, $exception->getMessage());
        } catch (ModelNotFoundException) {
            return null;
        }
        return $url;
    }
}
