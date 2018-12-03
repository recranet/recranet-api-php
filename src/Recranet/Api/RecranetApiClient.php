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
        return $this->performHttpRequest('accommodations', $params);
    }

    /**
     * Get accommodation price components
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getAccommodationPriceComponents($params)
    {
        return $this->performHttpRequest('accommodation_price_components', $params);
    }

    /**
     * Get age group specifications
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getAgeGroupSpecifications($params)
    {
        return $this->performHttpRequest('age_group_specifications', $params);
    }

    /**
     * Get discount specifications
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getDiscountSpecifications($params)
    {
        return $this->performHttpRequest('discount_specifications', $params);
    }

    /**
     * Get package specifications
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getPackageSpecifications($params)
    {
        return $this->performHttpRequest('package_specifications', $params);
    }

    /**
     * Get reservations
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getReservations($params)
    {
        return $this->performHttpRequest('reservations', $params);
    }

    /**
     * Get supplements
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getSupplements($params)
    {
        return $this->performHttpRequest('supplements', $params);
    }

    /**
     * Perform http request
     *
     * @param array $params
     *
     * @return array\null
     */
    public function performHttpRequest($method, $params)
    {
        $params = array_merge($params, array('organization' => getenv('API_ORGANIZATION')));
        $this->client->get(sprintf('%s/%s/', self::API_ENDPOINT, $method), $params);

        if ($this->client->error) {
            throw new ApiException($this->client->errorMessage, $this->client->errorCode);
        }

        return $this->client->getResponse();
    }
}
