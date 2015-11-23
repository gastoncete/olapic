<?php

namespace code;

use Exception;
use PHPUnit_Framework_Assert as Assertion;

class ProviderPlaceService
{
    private $RestClient;
    private $jsonResponse;

    public function __construct()
    {
        $this->RestClient = new RestClient($this->RestClient);
    }

    public function existProviderPlaceId($providerName, $providerPlaceId, $path)
    {
        $response = $this->getProviderPlaceId($providerName, $providerPlaceId, $path);
        $this->decodeJsonResponse($response);
        if ($this->jsonResponse->meta->code == 200) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteProviderPlaceId($providerName, $providerPlaceId, $path)
    {
        return $this->RestClient->rest_call("DELETE", "$path/$providerName/$providerPlaceId");
    }

    public function createProviderPlaceId($providerName, $providerPlaceId, $path)
    {
        return $this->RestClient->rest_call("PUT", "$path/$providerName/$providerPlaceId");
    }

    public function getProviderPlaceId($providerName, $providerPlaceId, $path)
    {
        return $this->RestClient->rest_call("GET", "$path/$providerName/$providerPlaceId");
    }

    public function getProviderPlaceIdWithUUID($uuid, $path)
    {
        return $this->RestClient->rest_call("GET", "$path/$uuid");
    }

    public function statusCodeOk($response)
    {
        $this->decodeJsonResponse($response);
        if ($this->jsonResponse->meta->code != 200) {
            print("Expected code: 200 but was:" . $this->jsonResponse->meta->code . "\n");
            if (isset($this->jsonResponse->meta->error)) {
                print("Error:" . $this->jsonResponse->meta->error);
            }
            throw new Exception("An error occurs!. The place was not returned");

        }
    }

    public function statusCodeCreated($response)
    {
        $this->decodeJsonResponse($response);
        if ($this->jsonResponse->meta->code != 201) {
            print("Expected code: 201 but was:" . $this->jsonResponse->meta->code);
            if (isset($this->jsonResponse->meta->error)) {
                print("Error:" . $this->jsonResponse->meta->error);
            }
            throw new Exception("An error occurs!. The place was not created");
        }
    }

    public function statusCodeNotFound($response)
    {
        $this->decodeJsonResponse($response);
        if ($this->jsonResponse->meta->code != 404) {
            print("Expected code: 404 but was:" . $this->jsonResponse->meta->code);
            if (isset($this->jsonResponse->meta->error)) {
                print("Error:" . $this->jsonResponse->meta->error);
            }
            throw new Exception("An error occurs! The place shouldn't exists but was returned.");
        }
    }

    public function validateUuid($uuid)
    {
        if (!preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $uuid)) {
            print ("Error! Expected: hhhhhhhh-hhhh-hhhh-hhhh-hhhhhhhhhhhh, Actual:  " . $uuid);
            throw new Exception("The UUID has not a valid format.");
        }
    }

    public function validateValues($expectedValue, $actualValue)
    {
        Assertion::assertEquals($expectedValue, $actualValue, "Assertion fails. Expected: ". $expectedValue . ", Actual: " . $actualValue);
    }

    public function validateUrl($expectedUrl, $actualUrl)
    {
        if (filter_var($actualUrl, FILTER_VALIDATE_URL)) {
            Assertion::assertEquals($expectedUrl, $actualUrl, "The place url has not the expected value");
        } else {
            throw new Exception("The URL has not a valid URL format.");
        }
    }

    public function decodeJsonResponse($response)
    {
        return $this->jsonResponse = json_decode($response);
    }
}
