<?php

namespace Recranet\Api;

use Curl\Curl;
use Psr\Log\LoggerInterface;
use Recranet\Api\Exceptions\ApiException;

class RecranetApiClient
{
    /**
     * Version of our client.
     */
    const CLIENT_VERSION = '1.1.0';

    /**
     * Endpoint of the remote API.
     */
    const API_ENDPOINT = 'https://app.recranet.com/api';

    /**
     * @var \Curl\Curl
     */
    protected $client;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->client = new Curl();
        $this->client->setBasicAuthentication(getenv('RECRANET_API_USERNAME'), getenv('RECRANET_API_PASSWORD'));
        $this->client->setDefaultDecoder('json');
        $this->client->setUserAgent('recranet-api-php/' . self::CLIENT_VERSION . ';PHP/' . phpversion());

        $this->logger = $logger;
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
        return $this->performHttpRequest('/accommodations/', $params);
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
        return $this->performHttpRequest('/accommodation_price_components/', $params);
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
        return $this->performHttpRequest('/age_group_specifications/', $params);
    }

    /**
     * Get accommodation quotations
     *
     * @param int $accommodation
     * @param array $params
     *
     * @return array\null
     */
    public function getAccommodationQuotations($accommodation, $params)
    {
        return $this->performHttpRequest('/accommodations/' . $accommodation . '/quotations/', $params);
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
        return $this->performHttpRequest('/discount_specifications/', $params);
    }

    /**
     * Get guests
     *
     * @param array $params
     *
     * @return array\null
     */
    public function getGuests($params)
    {
        return $this->performHttpRequest('/guests/', $params);
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
        return $this->performHttpRequest('/package_specifications/', $params);
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
        return $this->performHttpRequest('/reservations/', $params);
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
        return $this->performHttpRequest('/supplements/', $params);
    }

    /**
     * Create reservation
     *
     * @param array $data
     *
     * @return array\null
     */
    public function createReservation($data)
    {
        return $this->performHttpPostRequest('/reservations/', $data);
    }

    /**
     * Update reservation
     *
     * @param int $id
     * @param string $token
     * @param array $data
     *
     * @return array\null
     */
    public function updateReservation($id, $token, $data)
    {
        return $this->performHttpPutRequest(sprintf('/reservations/%s?token=%s', $id, $token), $data);
    }

    /**
     * Place reservation
     *
     * @param int $id
     * @param string $token
     * @param array $data
     *
     * @return array\null
     */
    public function placeReservation($id, $token, $data)
    {
        return $this->performHttpPutRequest(sprintf('/reservations/%s/place?token=%s', $id, $token), $data);
    }

    /**
     * Perform HTTP GET request
     *
     * @param array $params
     *
     * @return array\null
     */
    public function performHttpRequest($url, $params)
    {
        // Remove modified date from if emtpy
        if (isset($params['modifiedDateFrom']) && empty($params['modifiedDateFrom'])) {
            unset($params['modifiedDateFrom']);
        }

        // Merge params with organization id
        $params = array_merge($params, array('organization' => getenv('RECRANET_API_ORGANIZATION')));
        $this->client->get(sprintf('%s%s', self::API_ENDPOINT, $url), $params);

        if ($this->client->error) {
            throw new ApiException($this->client->errorMessage, $this->client->errorCode);
        }

        if ($this->logger) {
            $this->logger->notice('HTTP GET request with URL: ' . $this->client->getUrl());
        }

        return $this->client->getResponse();
    }

    /**
     * Perform HTTP POST request
     *
     * @param array $data
     *
     * @return array\null
     */
    public function performHttpPostRequest($url, $data)
    {
        $this->client->post(sprintf('%s%s?organization=%s', self::API_ENDPOINT, $url, getenv('RECRANET_API_ORGANIZATION')), $data);

        if ($this->client->error) {
            throw new ApiException($this->client->errorMessage, $this->client->errorCode);
        }

        if ($this->logger) {
            $this->logger->notice('HTTP POST request with URL: ' . $this->client->getUrl());
        }

        return $this->client->getResponse();
    }

    /**
     * Perform HTTP PUT request
     *
     * @param array $data
     *
     * @return array\null
     */
    public function performHttpPutRequest($url, $data)
    {
        $this->client->put(sprintf('%s%s', self::API_ENDPOINT, $url), $data);

        if ($this->client->error) {
            throw new ApiException($this->client->errorMessage, $this->client->errorCode);
        }

        if ($this->logger) {
            $this->logger->notice('HTTP PUT request with URL: ' . $this->client->getUrl());
        }

        return $this->client->getResponse();
    }
}
