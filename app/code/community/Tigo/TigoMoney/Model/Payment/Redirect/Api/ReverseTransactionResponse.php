<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse extends
    Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse
{
    /**
     * Response data key - Error
     */
    const RESPONSE_DATA_KEY_ERROR = 'error';

    /**
     * Response data key - Error - Description
     */
    const RESPONSE_DATA_KEY_ERROR_DESCRIPTION = 'error_description';

    /**
     * Response data key - Error - Type
     */
    const RESPONSE_DATA_KEY_ERROR_TYPE = 'error_type';

    /**
     * Response data key - Status
     */
    const RESPONSE_DATA_KEY_STATUS = 'status';

    /**
     * Response data key - Transaction - Correlation Id
     */
    const RESPONSE_DATA_KEY_TRANSACTION_CORRELATION_ID = 'transaction_correlation_id';

    /**
     * Response data key - Transaction - Merchant Transaction Id
     */
    const RESPONSE_DATA_KEY_TRANSACTION_MERCHANT_TRANSACTION_ID = 'transaction_merchant_transaction_id';

    /**
     * Response data key - Transaction - Message
     */
    const RESPONSE_DATA_KEY_TRANSACTION_MESSAGE = 'transaction_message';

    /**
     * Response data key - Transaction - MFS Transaction Id
     */
    const RESPONSE_DATA_KEY_TRANSACTION_MFS_TRANSACTION_ID = 'transaction_mfs_transaction_id';

    /**
     * Response data key - Transaction - Reverse Transaction Id
     */
    const RESPONSE_DATA_KEY_TRANSACTION_MFS_REVERSE_TRANSACTION_ID = 'transaction_mfs_reverse_transaction_id';

    /**
     * Response data key - Transaction - Status
     */
    const RESPONSE_DATA_KEY_TRANSACTION_STATUS = 'transaction_status';

    /**
     * Gets Error from response data
     * @return string
     */
    public function getError()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ERROR);
    }

    /**
     * Gets ErrorDescription from response data
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ERROR_DESCRIPTION);
    }

    /**
     * Gets Error Type from response data
     * @return string
     */
    public function getErrorType()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ERROR_TYPE);
    }

    /**
     * Gets Status from response data
     * @return string
     */
    public function getStatus()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_STATUS);
    }

    /**
     * Gets Transaction - Correlation Id from response data
     * @return string
     */
    public function getTransactionCorrelationId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_CORRELATION_ID);
    }

    /**
     * Gets Transaction - Merchant Transaction Id from response data
     * @return string
     */
    public function getTransactionMerchantTransactionId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MERCHANT_TRANSACTION_ID);
    }

    /**
     * Gets Transaction - Message from response data
     * @return string
     */
    public function getTransactionMessage()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MESSAGE);
    }

    /**
     * Gets Transaction - Mfs Transaction Id from response data
     * @return string
     */
    public function getTransactionMfsTransactionId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MFS_TRANSACTION_ID);
    }

    /**
     * Gets Transaction - Reverse Transaction Id from response data
     * @return string
     */
    public function getTransactionMfsReverseTransactionId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MFS_REVERSE_TRANSACTION_ID);
    }

    /**
     * Gets Transaction - Status from response data
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_STATUS);
    }

    /**
     * Sets Error to response data
     * @param mixed $input
     * @return $this
     */
    public function setError($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ERROR, (string) $input);
    }

    /**
     * Sets Error Description to response data
     * @param mixed $input
     * @return $this
     */
    public function setErrorDescription($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ERROR_DESCRIPTION, (string) $input);
    }

    /**
     * Sets Error Type to response data
     * @param mixed $input
     * @return $this
     */
    public function setErrorType($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ERROR_TYPE, (string) $input);
    }

    /**
     * Sets Status to response data
     * @param mixed $input
     * @return $this
     */
    public function setStatus($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_STATUS, (string) $input);
    }

    /**
     * Sets Transaction - Correlation Id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionCorrelationId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_CORRELATION_ID, (string) $input);
    }

    /**
     * Sets Transaction - Merchant Transaction Id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionMerchantTransactionId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MERCHANT_TRANSACTION_ID, (string) $input);
    }

    /**
     * Sets Transaction - Message to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionMessage($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MESSAGE, (string) $input);
    }

    /**
     * Sets Transaction - Mfs Transaction Id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionMfsTransactionId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MFS_TRANSACTION_ID, (string) $input);
    }

    /**
     * Sets Transaction - Reverse Transaction Id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionMfsReverseTransactionId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MFS_REVERSE_TRANSACTION_ID, (string) $input);
    }

    /**
     * Sets Transaction - Status to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionStatus($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_STATUS, (string) $input);
    }
}