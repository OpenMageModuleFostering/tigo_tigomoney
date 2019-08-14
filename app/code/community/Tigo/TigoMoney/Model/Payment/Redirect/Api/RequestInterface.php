<?php

/**
 * Interface Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface
 */
interface Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface
{
    /**
     * Returns request body
     * @return string
     */
    public function getBody();

    /**
     * @return string
     */
    public function getEndpointPath();

    /**
     * Returns request headers
     * @return array
     */
    public function getHeaders();

    /**
     * Returns request method
     * @return string
     */
    public function getMethod();

    /**
     * Validates current request
     * @return float
     */
    public function validate();

}