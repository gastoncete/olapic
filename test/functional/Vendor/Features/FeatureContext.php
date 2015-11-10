<?php

namespace Vendor\Features;

include 'ProviderPlaceService.php';

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

class FeatureContext implements Context, SnippetAcceptingContext
{

    private $genericPath;
    private $sonarPath;
    private $getResponse;
    private $deleteResponse;
    private $createResponse;
    private $uuid;
    private $Generic;

    public function __construct($commonPath)
    {
        $this->genericPath = $commonPath;
        $this->sonarPath = "$this->genericPath/sonar";
        $this->Generic = new ProviderPlaceService($this->Generic);
    }

    /**
     * @Given a place is created for provider :providerName with id :providerPlaceId
     */
    public function validatePlace($providerName, $providerPlaceId)
    {
        $exists = $this->Generic->ExistProviderPlaceId($providerName, $providerPlaceId, $this->genericPath);
        if ($exists == 1) {
            $this->deletePlace($providerName, $providerPlaceId, $this->genericPath);
        }
        $this->createPlace($providerName, $providerPlaceId, $this->genericPath);
    }

    /**
     * @When I delete the place for the provider :providerName with id :providerPlaceId
     */
    public function deletePlaceId($providerName, $providerPlaceId)
    {
        $this->deletePlace($providerName, $providerPlaceId, $this->genericPath);
    }

    /**
     * @When the I ask for the place for provider :providerName with id :providerPlaceId
     */
    public function getPlaceId($providerName, $providerPlaceId)
    {
        $this->getResponse = $this->Generic->getProviderPlaceId($providerName, $providerPlaceId, $this->genericPath);
    }

    /**
     * @When a place exists for provider :providerName with id :providerPlaceId
     */
    public function alreadyExistsPlace($providerName, $providerPlaceId)
    {
        $exists = $this->Generic->existProviderPlaceId($providerName, $providerPlaceId, $this->genericPath);
        if ($exists != 1) {
            $this->createPlace($providerName, $providerPlaceId, $this->genericPath);
        }
        $this->createPlace($providerName, $providerPlaceId, $this->genericPath);
       // $this->uuid = $this->createResponse['data']['id'];
       $jsonResponse = json_decode($this->createResponse);
        $this->uuid = $jsonResponse->data->id;
    }

    /**
     * @Then the place is created
     */
    public function validateResponseCreated()
    {
        $this->Generic->statusCodeCreated($this->createResponse);
    }

    /**
     * @Then the place is not created
     */
    public function validateResponseError()
    {
        $this->Generic->statusCodeNotFound($this->createResponse);
    }

    /**
     * @Then the place returned already exists
     */
    public function validateResponseExists()
    {
        $this->Generic->statusCodeOk($this->createResponse);
    }

    /**
     * @Then the place is deleted
     */
    public function validateDeletion()
    {
        $this->Generic->statusCodeOk($this->deleteResponse);
    }

    /**
     * @Then the delete return error
     */
    public function validateErrorOnDelete()
    {
        $this->Generic->statusCodeNotFound($this->deleteResponse);
    }

    /**
     * @Then the place is returned
     */
    public function validateGetOk()
    {
        $this->Generic->statusCodeOk($this->getResponse);
    }

    /**
     * @Then the place is not returned
     */
    public function validateGetError()
    {
        $this->Generic->statusCodeNotFound($this->getResponse);
    }

    /**
     * @When the get is perform with the UUID
     */
    public function obtainFromUUID()
    {
        $this->getResponse = $this->Generic->getProviderPlaceIdWithUUID($this->uuid, $this->sonarPath);
    }

    /**
     * @When the get is perform with an invalid UUID :arg1
     */
    public function getWithUUID($uuidFromUser)
    {
        $this->uuid = $uuidFromUser;
        $this->obtainFromUUID();
    }

    private function createPlace($providerName, $providerPlaceId, $path)
    {
        $this->createResponse = $this->Generic->createProviderPlaceId($providerName, $providerPlaceId, $path);
    }

    private function deletePlace($providerName, $providerPlaceId, $path)
    {
        $this->deleteResponse = $this->Generic->deleteProviderPlaceId($providerName, $providerPlaceId, $path);
    }
}
