<?php

class GenericOlapicTest 
{
    private $RestClient;
    private $jsonResponse;
    
    public function __construct(){
        $this->RestClient = new RestClient($this->RestClient);
    }
    
    public function ExistProviderPlaceId($providerName, $providerPlaceId, $path){
            $this->getProviderPlaceId($providerName, $providerPlaceId, $path);
            if ($this->jsonResponse['meta']['code'] == 200){
               return 1;
            }else{
               return 0;
            }
    }
    
    public function deleteProviderPlaceId($providerName, $providerPlaceId, $path){
            $deleteResponse = $this->RestClient->rest_call("DELETE" , "$path/$providerName/$providerPlaceId");
            $this->jsonResponse = json_decode($deleteResponse, true);
            return $this->jsonResponse;
    }
    
    public function createProviderPlaceId($providerName, $providerPlaceId, $path){
            $createResponse = $this->RestClient->rest_call("PUT" , "$path/$providerName/$providerPlaceId");
            $this->jsonResponse = json_decode($createResponse, true);
            return $this->jsonResponse;
    }
    
    public function getProviderPlaceId($providerName, $providerPlaceId, $path){
            $getResponseUUID = $this->RestClient->rest_call("GET" , "$path/$providerName/$providerPlaceId");
            $this->jsonResponse = json_decode($getResponseUUID, true);
            return $this->jsonResponse;
    }
    
    public function getProviderPlaceIdWithUUID($uuid, $path){
            $getResponse = $this->RestClient->rest_call("GET" , "$path/$uuid");
            $this->jsonResponse = json_decode($getResponse, true);
            return $this->jsonResponse;
    }
    
    public function statusCodeOk($response){
            if ($response['meta']['code'] != 200){
               throw new Exception("An error occurs; code: $response->meta->code, error: $response->meta->error ");
            }
    }
    
    public function statusCodeCreated($response){
            if ($response['meta']['code'] != 201){
               throw new Exception("An error occurs on creation; code: $response->meta->code, error: $response->meta->error");
            }
    }
    
    public function statusCodeNotFound($response){
            if ($response['meta']['code'] != 404){
               throw new Exception("An error occurs on search; code: $response->meta->code, error: $response->meta->error");
            }
    }
}