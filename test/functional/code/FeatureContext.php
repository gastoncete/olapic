<?php

namespace code;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Exception;

class FeatureContext implements Context, SnippetAcceptingContext
{

    private $paramCommonPath;
    private $sonarPath;
    private $getResponse;
    private $deleteResponse;
    private $createResponse;
    private $uuid;
    private $providerPlaceService;

    public function __construct($paramCommonPath)
    {
        $this->paramCommonPath = $paramCommonPath;
        $this->sonarPath = "$this->paramCommonPath/sonar";
        $this->providerPlaceService = new ProviderPlaceService($this->providerPlaceService);
    }

    /**
     * @Given a place is created for provider :providerName with id :providerPlaceId
     */
    public function validatePlace($providerName, $providerPlaceId)
    {
        $exists = $this->providerPlaceService->existProviderPlaceId($providerName, $providerPlaceId, $this->paramCommonPath);
        if ($exists == 1) {
            $this->deletePlace($providerName, $providerPlaceId, $this->paramCommonPath);
        }
        $this->createPlace($providerName, $providerPlaceId, $this->paramCommonPath);
    }

    /**
     * @When I delete the place for the provider :providerName with id :providerPlaceId
     */
    public function deletePlaceId($providerName, $providerPlaceId)
    {
        $this->deletePlace($providerName, $providerPlaceId, $this->paramCommonPath);
    }

    /**
     * @When the place for provider :providerName with id :providerPlaceId is asked
     */
    public function getPlaceId($providerName, $providerPlaceId)
    {
        $this->getResponse = $this->providerPlaceService->getProviderPlaceId($providerName, $providerPlaceId, $this->paramCommonPath);
    }

    /**
     * @When a place exists for provider :providerName with id :providerPlaceId
     */
    public function alreadyExistsPlace($providerName, $providerPlaceId)
    {
        $exists = $this->providerPlaceService->existProviderPlaceId($providerName, $providerPlaceId, $this->paramCommonPath);
        if ($exists != 1) {
            $this->createPlace($providerName, $providerPlaceId, $this->paramCommonPath);
        }
        $this->createPlace($providerName, $providerPlaceId, $this->paramCommonPath);
        // $this->uuid = $this->createResponse['data']['id'];
        $jsonResponse = json_decode($this->createResponse);
        $this->uuid = $jsonResponse->data->id;
    }

    /**
     * @Then the place is created
     */
    public function validateResponseCreated()
    {
        $this->providerPlaceService->statusCodeCreated($this->createResponse);
    }

    /**
     * @Then the place is not created
     */
    public function validateResponseError()
    {
        $this->providerPlaceService->statusCodeNotFound($this->createResponse);
    }

    /**
     * @Then the place returned already exists
     */
    public function validateResponseExists()
    {
        $this->providerPlaceService->statusCodeOk($this->createResponse);
    }

    /**
     * @Then the place is deleted
     */
    public function validateDeletion()
    {
        $this->providerPlaceService->statusCodeOk($this->deleteResponse);
    }

    /**
     * @Then the delete return error
     */
    public function validateErrorOnDelete()
    {
        $this->providerPlaceService->statusCodeNotFound($this->deleteResponse);
    }

    /**
     * @Then the place is returned
     */
    public function validateGetOk()
    {
        $this->providerPlaceService->statusCodeOk($this->getResponse);
    }

    /**
     * @Then the place is not returned
     */
    public function validateGetError()
    {
        $this->providerPlaceService->statusCodeNotFound($this->getResponse);
    }

    /**
     * @When the get is perform with the UUID
     */
    public function obtainFromUUID()
    {
        $this->getResponse = $this->providerPlaceService->getProviderPlaceIdWithUUID($this->uuid, $this->sonarPath);
    }

    /**
     * @When the get is perform with an invalid UUID :arg1
     */
    public function getWithUUID($uuidFromUser)
    {
        $this->uuid = $uuidFromUser;
        $this->obtainFromUUID();
    }

    /**
     * @Then the provider_hash value returned is :arg1 for :arg2 response
     */
    public function validateProviderHash($providerHash, $method)
    {
        $getJson = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        $createJson = $this->providerPlaceService->decodeJsonResponse($this->createResponse);

        if ($method === "get") {
            $this->providerPlaceService->validateValues($providerHash, $getJson->data->provider_hash);
        } else {
            $this->providerPlaceService->validateValues($providerHash, $createJson->data->source->provider_hash);
        }
    }


    /**
     * @Then the provider_id value returned is :arg1 for :arg2 response
     */
    public function validateProviderId($providerId, $method)
    {
        $getJson = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        $createJson = $this->providerPlaceService->decodeJsonResponse($this->createResponse);

        if ($method === "get") {
            $this->providerPlaceService->validateValues($providerId, $getJson->data->provider_id);
        } else {
            $this->providerPlaceService->validateValues($providerId, $createJson->data->source->provider_id);
        }
    }

    /**
     * @Then the provider_name value returned is :arg1 for :arg2 response
     */
    public function validateProviderName($providerName, $method)
    {
        $getJson = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        $createJson = $this->providerPlaceService->decodeJsonResponse($this->createResponse);

        if ($method === "get") {
            $this->providerPlaceService->validateValues($providerName, $getJson->data->provider_name);
        } else {
            $this->providerPlaceService->validateValues($providerName, $createJson->data->source->provider_name);
        }
    }

    /**
     * @Then the place name value returned is :arg1 for :arg2 response
     */
    public function validatePlaceName($placeName, $method)
    {
        $getJson = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        $createJson = $this->providerPlaceService->decodeJsonResponse($this->createResponse);

        if ($method === "get") {
            $this->providerPlaceService->validateValues($placeName, $getJson->data->name);
        } else {
            $this->providerPlaceService->validateValues($placeName, $createJson->data->source->name);
            $this->providerPlaceService->validateValues($placeName, $createJson->data->name);
        }
    }

    /**
     * @Then the place url value returned is :arg1 for :arg2 response
     */
    public function validatePlaceUrl($placeUrl, $method)
    {
        $getJson = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        $createJson = $this->providerPlaceService->decodeJsonResponse($this->createResponse);

        if ($method === "get") {
            $this->providerPlaceService->validateValues($placeUrl, $getJson->data->url);
        } else {
            $this->providerPlaceService->validateValues($placeUrl, $createJson->data->source->url);
            $this->providerPlaceService->validateValues($placeUrl, $createJson->data->url);
        }
    }

    /**
     * @Then the provider_id value returned is a valid UUID
     */
    public function validateProviderUUID()
    {
        $response = $this->providerPlaceService->decodeJsonResponse($this->createResponse);
        if (isset($response->data->id)) {
            $this->providerPlaceService->validateUuid($response->data->id);
        } else {
            throw new Exception("The UUID value is not in the response!");
        }
    }

    
    private function createPlace($providerName, $providerPlaceId, $path)
    {
        $this->createResponse = $this->providerPlaceService->createProviderPlaceId($providerName, $providerPlaceId, $path);
    }

    
    private function deletePlace($providerName, $providerPlaceId, $path)
    {
        $this->deleteResponse = $this->providerPlaceService->deleteProviderPlaceId($providerName, $providerPlaceId, $path);
    }
}
