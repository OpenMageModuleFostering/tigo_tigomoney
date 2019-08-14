<?php

/**
 * Interface Tigo_TigoMoney_Model_Payment_Redirect_Api_ResponseInterface
 */
interface Tigo_TigoMoney_Model_Payment_Redirect_Api_ResponseInterface
{
    /**
     * Adds an error to the response
     * @param string $error
     * @return $this
     */
    public function addError($error);

    /**
     * Adds response data
     * @param string $key
     * @param mixed $data
     * @return $this
     */
    public function addResponseData($key, $data);

    /**
     * Returns all errors
     * @return string[]
     */
    public function getErrors();

    /**
     * Returns response data
     * @param string $key
     * @return mixed
     */
    public function getResponseData($key);

    /**
     * Was there an error in the response?
     * @return bool
     */
    public function isError();

    /**
     * Was request successful?
     * @return bool
     */
    public function isSuccess();
}