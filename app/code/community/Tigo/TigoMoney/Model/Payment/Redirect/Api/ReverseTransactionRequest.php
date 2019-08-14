<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest
    implements Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface
{
    /**
     * Content Type Json for Request Header
     */
    const CONTENT_TYPE_JSON = 'application/json';

    /**
     * Country Code - El Salvador
     */
    const COUNTRY_CODE_EL_SALVADOR = 'SLV';

    /**
     * Currency Code - USD
     */
    const CURRENCY_CODE_USD = 'USD';

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
     * Local Payment - Amount
     * @var null|string
     */
    protected $_localPaymentAmount = null;

    /**
     * Local Payment - Currency Code
     * @var null|string
     */
    protected $_localPaymentCurrencyCode = null;

    /**
     * Master Account - Account
     * @var null|string
     */
    protected $_masterAccountAccount = null;

    /**
     * Master Account - Id
     * @var null|string
     */
    protected $_masterAccountId = null;

    /**
     * Master Account - Pin
     * @var null|string
     */
    protected $_masterAccountPin = null;

    /**
     * Merchant Transaction Id
     * @var null|string
     */
    protected $_merchantTransactionId = null;

    /**
     * Mfs Transaction Id
     * @var null|string
     */
    protected $_mfsTransactionId = null;

    /**
     * Subscriber Account
     * @var null|string
     */
    protected $_subscriberAccount = null;

    /**
     * Sets a float to the correct format used by the Tigo Api
     * @param float $value
     * @return string
     */
    protected function _formatFloat($value) {
        return number_format($value, 2, '.', '');
    }

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
        $return = array();

        $return['MasterAccount'] = array();
        $return['MasterAccount']['account'] = $this->getMasterAccountAccount();
        $return['MasterAccount']['id'] = $this->getMasterAccountId();
        $return['MasterAccount']['pin'] = $this->getMasterAccountPin();

        $return['subscriberAccount'] = $this->getSubscriberAccount();

        $return['LocalPayment'] = array();
        $return['LocalPayment']['amount'] = $this->_formatFloat($this->getLocalPaymentAmount());
        $return['LocalPayment']['currencyCode'] = $this->getLocalPaymentCurrencyCode();

        return json_encode($return, JSON_UNESCAPED_SLASHES);
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
        return self::ENDPOINT_PATH . strtoupper($this->getCountry()) . '/' . $this->getMfsTransactionId() . '/' .
             $this->getMerchantTransactionId();
    }

    /**
     * @inheritdoc
     */
    public function getHeaders()
    {
        return array(
            Varien_Http_Client::CONTENT_TYPE => self::CONTENT_TYPE_JSON,
            'Authorization' => 'Bearer ' . $this->getAccessToken()
        );
    }

    /**
     * Local Payment Amount Getter
     * @return null|string
     */
    public function getLocalPaymentAmount()
    {
        return $this->_localPaymentAmount;
    }

    /**
     * Local Payment Currency Code Getter
     * @return null|string
     */
    public function getLocalPaymentCurrencyCode()
    {
        return $this->_localPaymentCurrencyCode;
    }

    /**
     * Master Account - Account Getter
     * @return null|string
     */
    public function getMasterAccountAccount()
    {
        return $this->_masterAccountAccount;
    }

    /**
     * Master Account Id Getter
     * @return null|string
     */
    public function getMasterAccountId()
    {
        return $this->_masterAccountId;
    }

    /**
     * Master Account Pin Getter
     * @return null|string
     */
    public function getMasterAccountPin()
    {
        return $this->_masterAccountPin;
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
     * MFS Transaction Id Getter
     * @return null
     */
    public function getMfsTransactionId()
    {
        return $this->_mfsTransactionId;
    }

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return Varien_Http_Client::DELETE;
    }

    /**
     * Subscriber Account Getter
     * @return null|string
     */
    public function getSubscriberAccount()
    {
        return $this->_subscriberAccount;
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
     * Local Payment Amount Setter
     * @param mixed $localPaymentAmount
     */
    public function setLocalPaymentAmount($localPaymentAmount)
    {
        $this->_localPaymentAmount = $localPaymentAmount;
    }

    /**
     * Local Payment Currency Code Setter
     * @param mixed $localPaymentCurrencyCode
     */
    public function setLocalPaymentCurrencyCode($localPaymentCurrencyCode)
    {
        $this->_localPaymentCurrencyCode = $localPaymentCurrencyCode;
    }

    /**
     * Master Account - Account Setter
     * @param mixed $masterAccountAccount
     */
    public function setMasterAccountAccount($masterAccountAccount)
    {
        $this->_masterAccountAccount = $masterAccountAccount;
    }

    /**
     * Master Account - Id Setter
     * @param mixed $masterAccountId
     */
    public function setMasterAccountId($masterAccountId)
    {
        $this->_masterAccountId = $masterAccountId;
    }

    /**
     * Master Account - Pin Setter
     * @param mixed $masterAccountPin
     */
    public function setMasterAccountPin($masterAccountPin)
    {
        $this->_masterAccountPin = $masterAccountPin;
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
     * MFS Transaction Id Setter
     * @param mixed $mfsTransactionId
     */
    public function setMfsTransactionId($mfsTransactionId)
    {
        $this->_mfsTransactionId = trim((string) $mfsTransactionId);
    }

    /**
     * Subscriber Account Setter
     * @param mixed $subscriberAccount
     */
    public function setSubscriberAccount($subscriberAccount)
    {
        $this->_subscriberAccount = $subscriberAccount;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        return (
            $this->getAccessToken() && $this->getCountry() &&
            $this->getMfsTransactionId() && $this->getMerchantTransactionId() &&
            $this->getMasterAccountAccount() && $this->getMasterAccountPin() &&
            $this->getSubscriberAccount() &&
            $this->getLocalPaymentAmount() && $this->getLocalPaymentCurrencyCode()
        );
    }
}