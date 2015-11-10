<?php 

namespace Vendor\Features;

use Exception;

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
        $this->getProviderPlaceId($providerName, $providerPlaceId, $path);
        if ($this->jsonResponse['meta']['code'] == 200) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteProviderPlaceId($providerName, $providerPlaceId, $path)
    {
       // $deleteResponse = $this->RestClient->rest_call("DELETE", "$path/$providerName/$providerPlaceId");
       // $this->jsonResponse = json_decode($deleteResponse, true);

        //return $this->jsonResponse;
        
        return $this->RestClient->rest_call("DELETE", "$path/$providerName/$providerPlaceId");
    }

    public function createProviderPlaceId($providerName, $providerPlaceId, $path)
    {
       // $createResponse = $this->RestClient->rest_call("PUT", "$path/$providerName/$providerPlaceId");
       // $this->jsonResponse = json_decode($createResponse, true);

        //return $this->jsonResponse;
        
        return $this->RestClient->rest_call("PUT", "$path/$providerName/$providerPlaceId");
    }

    public function getProviderPlaceId($providerName, $providerPlaceId, $path)
    {
       // $getResponseUUID = $this->RestClient->rest_call("GET", "$path/$providerName/$providerPlaceId");
       // $this->jsonResponse = json_decode($getResponseUUID, true);

        //return $this->jsonResponse;
        
        return $this->RestClient->rest_call("GET", "$path/$providerName/$providerPlaceId");
    }

    public function getProviderPlaceIdWithUUID($uuid, $path)
    {
        //$getResponse = $this->RestClient->rest_call("GET", "$path/$uuid");
        //$this->jsonResponse = json_decode($getResponse, true);

        //return $this->jsonResponse;
        
        return $this->RestClient->rest_call("GET", "$path/$uuid");
    }

    public function statusCodeOk($response)
    {
        $this->decodeJsonResponse($response);
        if ($this->jsonResponse->meta->code != 200)
        {
            print("Expected code: 200 but was:" .$this->jsonResponse->meta->code);
            if (isset($this->jsonResponse->meta->error))
            {
               print("Error:" .$this->jsonResponse->meta->error);
            }
            throw new Exception("An error occurs on obtaining the place.");
            
        }
    }

    public function statusCodeCreated($response)
    {
        $this->decodeJsonResponse($response);
        if ($this->jsonResponse->meta->code != 201)
        {
            print("Expected code: 201 but was:" .$this->jsonResponse->meta->code);
            if (isset($this->jsonResponse->meta->error))
            {
               print("Error:" .$this->jsonResponse->meta->error);
            }
            throw new Exception("An error occurs on place creation.");
        }
    }

    public function statusCodeNotFound($response)
    {
        $this->decodeJsonResponse($response);
        if ($this->jsonResponse->meta->code != 404)
        {
            print("Expected code: 404 but was:" .$this->jsonResponse->meta->code);
            if (isset($this->jsonResponse->meta->error))
            {
               print("Error:" .$this->jsonResponse->meta->error);
            }
            throw new Exception("An error occurs on searching the place.");
        }
    }
    
    private function decodeJsonResponse($response)
    {
        return $this->jsonResponse = json_decode($response);
    }
}
