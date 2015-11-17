<?php

namespace Vendor\Features;

include 'ProviderPlaceService.php';

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Exception;

class FeatureContext implements Context, SnippetAcceptingContext
{

    private $paramCommonPath;
    private $param_places;
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
     * @When the I ask for the place for provider :providerName with id :providerPlaceId
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
     * @Then the provider_hash value returned is :arg1
     */
    public function validateProviderHash($providerHash)
    {
        $response = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        if (isset($response->data->provider_hash)) {
            $this->providerPlaceService->validateValues($providerHash, $response->data->provider_hash);
        } else {
            throw new Exception("The provider_hash value is not in the response!");
        }
    }

    /**
     * @Then the provider_id value returned is :arg1
     */
    public function validateProviderId($providerId)
    {
        $response = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        if (isset($response->data->provider_id)) {
            $this->providerPlaceService->validateValues($providerId, $response->data->provider_id);
        } else {
            throw new Exception("The provider_id value is not in the response!");
        }
    }

    /**
     * @Then the provider_name value returned is :arg1
     */
    public function validateProviderName($providerName)
    {
        $response = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        if (isset($response->data->provider_name)) {
            $this->providerPlaceService->validateValues($providerName, $response->data->provider_name);
        } else {
            throw new Exception("The provider_name value is not in the response!");
        }
    }

    /**
     * @Then the place name value returned is :arg1
     */
    public function validatePlaceName($placeName)
    {
        $response = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        if (isset($response->data->name)) {
            $this->providerPlaceService->validateValues($placeName, $response->data->name);
        } else {
            throw new Exception("The name value is not in the response!");
        }
    }

    /**
     * @Then the place url value returned is :arg1
     */
    public function validatePlaceUrl($placeUrl)
    {
        $response = $this->providerPlaceService->decodeJsonResponse($this->getResponse);
        if (isset($response->data->url)) {
            $this->providerPlaceService->validateValues($placeUrl, $response->data->url);
        } else {
            throw new Exception("The url value is not in the response!");
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
