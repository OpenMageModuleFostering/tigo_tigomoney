<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest
    implements Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface
{
    /**
     * Country Code - El Salvador
     */
    const COUNTRY_CODE_EL_SALVADOR = 'SLV';

    /**
     * Generate Token Enpoint Path
     */
    const ENDPOINT_PATH = 'v2/tigo/mfs/payments/transactions/';

    /**
     * Access Token
     * @var null|string
     */
    protected $_accessToken = null;

    /**
     * Country
     * @var null|string
     */
    protected $_country = null;

    /**
     * Master Merchant Id
     * @var null|string
     */
    protected $_masterMerchantId = null;

    /**
     * Merchant Transaction Id
     * @var null|string
     */
    protected $_merchantTransactionId = null;

    /**
     * Access Token Getter
     * @return null|string
     */
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return '';
    }

    /**
     * Country Getter
     * @return null|string
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * @inheritdoc
     */
    public function getEndpointPath()
    {
        return self::ENDPOINT_PATH . strtoupper($this->getCountry()) . '/' . $this->getMasterMerchantId() . '/' .
             $this->getMerchantTransactionId();
    }

    /**
     * @inheritdoc
     */
    public function getHeaders()
    {
        return array(
            'Authorization' => 'Bearer ' . $this->getAccessToken()
        );
    }

    /**
     * Master Merchant Id Getter
     * @return null
     */
    public function getMasterMerchantId()
    {
        return $this->_masterMerchantId;
    }

    /**
     * Merchant Transaction Id Getter
     * @return null|string
     */
    public function getMerchantTransactionId()
    {
        return $this->_merchantTransactionId;
    }



    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return Varien_Http_Client::GET;
    }

    /**
     * Access Token Setter
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->_accessToken = $accessToken;
    }

    /**
     * Access Token Setter
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->_country = trim((string) $country);
    }

    /**
     * Master Merchant Id Setter
     * @param mixed $masterMerchantId
     */
    public function setMasterMerchantId($masterMerchantId)
    {
        $this->_masterMerchantId = trim((string)$masterMerchantId);
    }

    /**
     * Merchant Transaction Id Setter
     * @param mixed $merchantTransactionId
     */
    public function setMerchantTransactionId($merchantTransactionId)
    {
        $this->_merchantTransactionId = trim((string) $merchantTransactionId);
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        return ($this->getAccessToken() && $this->getCountry() &&
                $this->getMasterMerchantId() && $this->getMerchantTransactionId());
    }
}