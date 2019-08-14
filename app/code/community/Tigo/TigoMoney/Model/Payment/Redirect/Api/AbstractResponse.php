<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse
 */
abstract class Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse implements
    Tigo_TigoMoney_Model_Payment_Redirect_Api_ResponseInterface
{
    /**
     * Errors that happened during the request
     * @var array
     */
    protected $_errors = array();

    /**
     * Was there an error in the request?
     * @var bool
     */
    protected $_isError = false;

    /**
     * Was the transaction successful?
     * @var bool
     */
    protected $_isSuccess = true;

    /**
     * Response data
     * @var Varien_Object
     */
    protected $_responseData = true;

    /**
     * Tigo_TigoMoney_Model_Payment_Redirect_Api_Response constructor.
     * @param Varien_Object $responseData
     */
    public function __construct(
        Varien_Object $responseData
    ) {
        $this->_responseData = $responseData;
    }

    /**
     * @inheritdoc
     */
    public function addError($error)
    {
        $this->_errors[] = trim($error);
        $this->_isSuccess = false;
        $this->_isError = true;
    }

    /**
     * @inheritdoc
     */
    public function addResponseData($key, $data)
    {
        return $this->_responseData->setData($key, $data);
    }

    /**
     * @inheritdoc
     */
    public function isError()
    {
        return $this->_isError;
    }

    /**
     * @inheritdoc
     */
    public function isSuccess()
    {
        return $this->_isSuccess;
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        return array_values(array_unique($this->_errors));
    }

    /**
     * @inheritdoc
     */
    public function getResponseData($key)
    {
        return $this->_responseData->getData($key);
    }
}