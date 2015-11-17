<?php

namespace Vendor\Features;

use Exception;

class RestClient
{
    private $response;
    private $options;

    public function __construct()
    {
        $this->options = $this->generic_options();
    }

    public function rest_call($method, $url)
    {
        switch ($method) {
            case "PUT":
                $this->put_rest_call("$url");
                break;
            case "GET":
                $this->get_rest_call("$url");
                break;
            case "DELETE":
                $this->delete_rest_call("$url");
                break;
            default:
                throw new Exception("method not allowed. $method");
        }

        return $this->response;
    }

    private function get_rest_call($url)
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = "GET";
        $this->sendRequest($url);
    }

    private function put_rest_call($url)
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = "PUT";
        $this->sendRequest($url);
    }

    private function delete_rest_call($url)
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = "DELETE";
        $this->sendRequest($url);
    }

    private function sendRequest($url)
    {
        $curlSession = curl_init($url);
        curl_setopt_array($curlSession, $this->options);
        $this->response = curl_exec($curlSession);
        curl_close($curlSession);
    }

    private function generic_options()
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER => false,  // return headers
            CURLOPT_FOLLOWLOCATION => false,  // follow redirects
            CURLOPT_MAXREDIRS => 10,     // stop after 10 redirects
            CURLOPT_ENCODING => "",     // handle compressed
            CURLOPT_USERAGENT => "test", // name of client
            CURLOPT_AUTOREFERER => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT => 120,    // time-out on response
        );

        return $options;
    }

}
