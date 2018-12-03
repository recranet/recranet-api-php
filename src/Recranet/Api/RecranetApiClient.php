<?php

namespace Recranet\Api;

use Curl\Curl;
use Recranet\Api\Exceptions\ApiException;

class RecranetApiClient
{
    /**
     * Version of our client.
     */
    const CLIENT_VERSION = '1.0.0';

    /**
     * Endpoint of the remote API.
     */
    const API_ENDPOINT = 'https://app.recranet.com/api';

    /**
     * @var \Curl\Curl
     */
    protected $client;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->client = new Curl();
        $this->client->setBasicAuthentication(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->client->setDefaultDecoder('json');
        $this->client->setUserAgent('recranet-api-php/' . self::CLIENT_VERSION . ';PHP/' . phpversion());
    }

    /**
     * Get accommodations
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getAccommodations($params)
    {
        $params = array_merge($params, array('organization' => getenv('API_ORGANIZATION')));
        $this->client->get(self::API_ENDPOINT . '/accommodations/', $params);

        if ($this->client->error) {
            throw new ApiException($this->client->errorMessage, $this->client->errorCode);
        }

        return $this->client->getResponse();
    }
}
