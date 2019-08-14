<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest
    implements Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface
{
    /**
     * Content Type Json for Request Header
     */
    const CONTENT_TYPE_JSON = 'application/json';

    /**
     * Country Code - El Salvador
     */
    const COUNTRY_CODE = 'SLV';

    /**
     * Country Dial Code - El Salvador
     */
    const COUNTRY_DIAL_CODE = '503';

    /**
     * Currency Code - US Dollars
     */
    const CURRENCY_CODE_USD = 'USD';

    /**
     * Generate Token Enpoint Path
     */
    const ENDPOINT_PATH = 'v2/tigo/mfs/payments/authorizations';

    /**
     * Language Code - Spanish
     */
    const LANGUAGE_CODE_SPANISH = 'spa';

    /**
     * Terminal Id - Should be hardcoded to 1
     */
    const TERMINAL_ID = 'Magento';

    /**
     * Access Token
     * @var null|string
     */
    protected $_accessToken = null;

    /**
     * Callback Uri
     * @var null|string
     */
    protected $_callbackUri = null;

    /**
     * Exchange Rate
     * @var null|float
     */
    protected $_exchangeRate = null;

    /**
     * Language
     * @var null|string
     */
    protected $_language = null;

    /**
     * Local Payment - Amount
     * @var null|float
     */
    protected $_localPaymentAmount = null;

    /**
     * Local Payment - Currency Code
     * @var null|string
     */
    protected $_localPaymentCurrencyCode = null;

    /**
     * Master Merchant - Account
     * @var null|string
     */
    protected $_masterMerchantAccount = null;

    /**
     * Master Merchant - Pin
     * @var null|string
     */
    protected $_masterMerchantPin = null;

    /**
     * Master Merchant - Id
     * @var null|string
     */
    protected $_masterMerchantId = null;

    /**
     * Merchant - Reference
     * @var null|string
     */
    protected $_merchantReference = null;

    /**
     * Merchant - Transaction Id
     * @var null|string
     */
    protected $_merchantTransactionId = null;

    /**
     * Merchant - Fee
     * @var null|float
     */
    protected $_merchantFee = null;

    /**
     * Merchant - Currency Code
     * @var null|string
     */
    protected $_merchantCurrencyCode = null;

    /**
     * Origin Payment - Amount
     * @var null|float
     */
    protected $_originPaymentAmount = null;

    /**
     * Origin Payment - Currency Code
     * @var null|string
     */
    protected $_originPaymentCurrencyCode = null;

    /**
     * Origin Payment - Payment Tax
     * @var null|float
     */
    protected $_originPaymentTax = null;

    /**
     * Origin Payment - Fee
     * @var null|float
     */
    protected $_originPaymentFee = null;

    /**
     * Redirect URI
     * @var null|string
     */
    protected $_redirectUri = null;

    /**
     * Subscriber - Account
     * @var null|string
     */
    protected $_subscriberAccount = null;

    /**
     * Subscriber - Country Code
     * @var null|string
     */
    protected $_subscriberCountryCode = null;

    /**
     * Subscriber - Country
     * @var null|string
     */
    protected $_subscriberCountry = null;

    /**
     * Subscriber - First Name
     * @var null|string
     */
    protected $_subscriberFirstName = null;

    /**
     * Subscriber - Last Name
     * @var null|string
     */
    protected $_subscriberLastName = null;

    /**
     * Subscriber - Email
     * @var null|string
     */
    protected $_subscriberEmail = null;

    /**
     * Terminal Id
     * @var null|string
     */
    protected $_terminalId = null;

    /**
     * Sets a float to the correct format used by the Tigo Api
     * @param float $value
     * @return string
     */
    protected function _formatFloat($value) {
        return number_format($value, 2, '.', '');
    }

    /**
     * Access Token - Getter
     * @return null|string
     */
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    /**
     * Notice: parameters that are commented out exist in the API but will
     * not be used by this module
     * @inheritdoc
     */
    public function getBody()
    {
        $return = array();

        $return['MasterMerchant'] = array();
        $return['MasterMerchant']['account'] = $this->getMasterMerchantAccount();
        $return['MasterMerchant']['pin'] = $this->getMasterMerchantPin();
        $return['MasterMerchant']['id'] = $this->getMasterMerchantId();

        if ($this->_shouldSendMerchantInfo()) {
            $return['Merchant'] = array();
            $return['Merchant']['reference'] = $this->getMerchantReference();
            $return['Merchant']['fee'] = $this->_formatFloat($this->getMerchantFee());
            $return['Merchant']['currencyCode'] = $this->getMerchantCurrencyCode();
        }

        $return['Subscriber'] = array();
        $return['Subscriber']['account'] = $this->getSubscriberAccount();
        $return['Subscriber']['countryCode'] = $this->getSubscriberCountryCode();
        $return['Subscriber']['country'] = $this->getSubscriberCountry();
        $return['Subscriber']['firstName'] = $this->getSubscriberFirstName();
        $return['Subscriber']['lastName'] = $this->getSubscriberLastName();
        $return['Subscriber']['emailId'] = $this->getSubscriberEmail();

        $return['OriginPayment'] = array();
        $return['OriginPayment']['amount'] = $this->_formatFloat($this->getOriginPaymentAmount());
        $return['OriginPayment']['currencyCode'] = $this->getOriginPaymentCurrencyCode();
        $return['OriginPayment']['tax'] = $this->_formatFloat($this->getOriginPaymentTax());
        $return['OriginPayment']['fee'] = $this->_formatFloat($this->getOriginPaymentFee());

        $return['LocalPayment'] = array();
        $return['LocalPayment']['amount'] = $this->_formatFloat($this->getLocalPaymentAmount());
        $return['LocalPayment']['currencyCode'] = $this->getLocalPaymentCurrencyCode();

        # The URL is deemed invalid by Tigo Payment Server API if it contains a trailing slash.
        # Preg_replace's below removes this slash if present
        $return['redirectUri'] = preg_replace('/\/$/', '', $this->getRedirectUri());
        $return['callbackUri'] = preg_replace('/\/$/', '', $this->getCallbackUri());

        $return['language'] = $this->getLanguage();
        $return['terminalId'] = $this->getTerminalId();
        $return['exchangeRate'] = $this->_formatFloat($this->getExchangeRate());
        $return['merchantTransactionId'] = $this->getMerchantTransactionId();

        return json_encode($return, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Callback URL - Getter
     * @return null|string
     */
    public function getCallbackUri()
    {
        return $this->_callbackUri;
    }

    /**
     * @inheritdoc
     */
    public function getEndpointPath()
    {
        return self::ENDPOINT_PATH;
    }

    /**
     * Exchange Rate - Getter
     * @return null|string
     */
    public function getExchangeRate()
    {
        return $this->_exchangeRate;
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
     * Language - Getter
     * @return null|string
     */
    public function getLanguage()
    {
        return $this->_language;
    }

    /**
     * Local Payment Account - Getter
     * @return null|string
     */
    public function getLocalPaymentAmount()
    {
        return $this->_localPaymentAmount;
    }

    /**
     * Local Payment Currency Code - Getter
     * @return null|string
     */
    public function getLocalPaymentCurrencyCode()
    {
        return $this->_localPaymentCurrencyCode;
    }

    /**
     * Master Merchant Account - Getter
     * @return null|string
     */
    public function getMasterMerchantAccount()
    {
        return $this->_masterMerchantAccount;
    }

    /**
     * Master Merchant Pin - Getter
     * @return null|string
     */
    public function getMasterMerchantPin()
    {
        return $this->_masterMerchantPin;
    }

    /**
     * Master Merchant Id - Getter
     * @return null|string
     */
    public function getMasterMerchantId()
    {
        return $this->_masterMerchantId;
    }

    /**
     * Master Merchant Reference - Getter
     * @return null|string
     */
    public function getMerchantReference()
    {
        return $this->_merchantReference;
    }

    /**
     * Merchant Transaction Id - Getter
     * @return null|string
     */
    public function getMerchantTransactionId()
    {
        return $this->_merchantTransactionId;
    }

    /**
     * Merchant Fee - Getter
     * @return null|string
     */
    public function getMerchantFee()
    {
        return $this->_merchantFee;
    }

    /**
     * Merchant Currency Code - Getter
     * @return null|string
     */
    public function getMerchantCurrencyCode()
    {
        return $this->_merchantCurrencyCode;
    }

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return Varien_Http_Client::POST;
    }

    /**
     * Origin Payment Amount - Getter
     * @return null|string
     */
    public function getOriginPaymentAmount()
    {
        return $this->_originPaymentAmount;
    }

    /**
     * Origin Payment Currency Code - Getter
     * @return null|string
     */
    public function getOriginPaymentCurrencyCode()
    {
        return $this->_originPaymentCurrencyCode;
    }

    /**
     * Origin Payment Tax - Getter
     * @return null|string
     */
    public function getOriginPaymentTax()
    {
        return $this->_originPaymentTax;
    }

    /**
     * Origin Payment Fee - Getter
     * @return null|string
     */
    public function getOriginPaymentFee()
    {
        return $this->_originPaymentFee;
    }

    /**
     * Redirect Uri - Getter
     * @return null|string
     */
    public function getRedirectUri()
    {
        return $this->_redirectUri;
    }

    /**
     * Subscriber Account - Getter
     * @return null|string
     */
    public function getSubscriberAccount()
    {
        return $this->_subscriberAccount;
    }

    /**
     * Subscriber Country Code - Getter
     * @return null|string
     */
    public function getSubscriberCountryCode()
    {
        return $this->_subscriberCountryCode;
    }

    /**
     * Subscriber Country - Getter
     * @return null|string
     */
    public function getSubscriberCountry()
    {
        return $this->_subscriberCountry;
    }

    /**
     * Subscriber First Name - Getter
     * @return null|string
     */
    public function getSubscriberFirstName()
    {
        return $this->_subscriberFirstName;
    }

    /**
     * Subscriber Last Name - Getter
     * @return null|string
     */
    public function getSubscriberLastName()
    {
        return $this->_subscriberLastName;
    }

    /**
     * Subscriber Email - Getter
     * @return null|string
     */
    public function getSubscriberEmail()
    {
        return $this->_subscriberEmail;
    }

    /**
     * Terminal Id - Getter
     * @return null|string
     */
    public function getTerminalId()
    {
        return $this->_terminalId;
    }

    /**
     * Access Token - Setter
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->_accessToken = trim($accessToken);
    }

    /**
     * Callback URI - Setter
     * @param mixed $callbackUri
     */
    public function setCallbackUri($callbackUri)
    {
        $this->_callbackUri = trim($callbackUri);
    }

    /**
     * Exchange Rate - Setter
     * @param mixed $exchangeRate
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->_exchangeRate = (float) $exchangeRate;
    }

    /**
     * Language - Setter
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->_language = substr(trim($language), 0, 3);
    }

    /**
     * Local Payment Amount - Setter
     * @param mixed $localPaymentAmount
     */
    public function setLocalPaymentAmount($localPaymentAmount)
    {
        $this->_localPaymentAmount = (float) $localPaymentAmount;
    }

    /**
     * Local Payment Currency Code - Setter
     * @param mixed $localPaymentCurrencyCode
     */
    public function setLocalPaymentCurrencyCode($localPaymentCurrencyCode)
    {
        $this->_localPaymentCurrencyCode = substr(trim($localPaymentCurrencyCode), 0, 3);
    }

    /**
     * Master Merchant Account - Setter
     * @param mixed $masterMerchantAccount
     */
    public function setMasterMerchantAccount($masterMerchantAccount)
    {
        $this->_masterMerchantAccount = trim($masterMerchantAccount);
    }

    /**
     * Master Merchant Pin - Setter
     * @param mixed $masterMerchantPin
     */
    public function setMasterMerchantPin($masterMerchantPin)
    {
        $this->_masterMerchantPin = trim($masterMerchantPin);
    }

    /**
     * Master Merchant Id - Setter
     * @param mixed $masterMerchantId
     */
    public function setMasterMerchantId($masterMerchantId)
    {
        $this->_masterMerchantId = trim($masterMerchantId);
    }

    /**
     * Merchant Reference - Setter
     * @param mixed $merchantReference
     */
    public function setMerchantReference($merchantReference)
    {
        $this->_merchantReference = trim($merchantReference);
    }

    /**
     * Merchant Transaction Id - Setter
     * @param mixed $merchantTransactionId
     */
    public function setMerchantTransactionId($merchantTransactionId)
    {
        $this->_merchantTransactionId = trim($merchantTransactionId);
    }

    /**
     * Merchant Fee - Setter
     * @param mixed $merchantFee
     */
    public function setMerchantFee($merchantFee)
    {
        $this->_merchantFee = (float) $merchantFee;
    }

    /**
     * Merchant Currency Code - Setter
     * @param mixed $merchantCurrencyCode
     */
    public function setMerchantCurrencyCode($merchantCurrencyCode)
    {
        $this->_merchantCurrencyCode = substr(trim($merchantCurrencyCode), 0, 3);
    }

    /**
     * Origin Payment Amount - Setter
     * @param mixed $originPaymentAmount
     */
    public function setOriginPaymentAmount($originPaymentAmount)
    {
        $this->_originPaymentAmount = (float) $originPaymentAmount;
    }

    /**
     * Origin Payment Currency Code - Setter
     * @param mixed $originPaymentCurrencyCode
     */
    public function setOriginPaymentCurrencyCode($originPaymentCurrencyCode)
    {
        $this->_originPaymentCurrencyCode = substr(trim($originPaymentCurrencyCode), 0, 3);
    }

    /**
     * Origin Payment Tax - Setter
     * @param mixed $originPaymentTax
     */
    public function setOriginPaymentTax($originPaymentTax)
    {
        $this->_originPaymentTax = (float) $originPaymentTax;
    }

    /**
     * Origin Payment Fee - Setter
     * @param mixed $originPaymentFee
     */
    public function setOriginPaymentFee($originPaymentFee)
    {
        $this->_originPaymentFee = (float) $originPaymentFee;
    }

    /**
     * Redirect URI - Setter
     * @param mixed $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->_redirectUri = trim($redirectUri);
    }

    /**
     * Subscriber Account - Setter
     * @param mixed $subscriberAccount
     */
    public function setSubscriberAccount($subscriberAccount)
    {
        $this->_subscriberAccount = trim($subscriberAccount);
    }

    /**
     * Subscriber Country Code - Setter
     * @param mixed $subscriberCountryCode
     */
    public function setSubscriberCountryCode($subscriberCountryCode)
    {
        $this->_subscriberCountryCode = substr(trim($subscriberCountryCode), 0, 3);
    }

    /**
     * Subscriber Country - Setter
     * @param mixed $subscriberCountry
     */
    public function setSubscriberCountry($subscriberCountry)
    {
        $this->_subscriberCountry = substr(trim($subscriberCountry), 0, 3);
    }

    /**
     * Subscriber First Name - Setter
     * @param mixed $subscriberFirstName
     */
    public function setSubscriberFirstName($subscriberFirstName)
    {
        $this->_subscriberFirstName = trim($subscriberFirstName);
    }

    /**
     * Subscriber Last Name - Setter
     * @param mixed $subscriberLastName
     */
    public function setSubscriberLastName($subscriberLastName)
    {
        $this->_subscriberLastName = trim($subscriberLastName);
    }

    /**
     * Subscriber Email - Setter
     * @param mixed $subscriberEmail
     */
    public function setSubscriberEmail($subscriberEmail)
    {
        $this->_subscriberEmail = trim($subscriberEmail);
    }

    /**
     * Should we send merchant info in this request?
     * @return bool
     */
    protected function _shouldSendMerchantInfo()
    {
        return (bool) ($this->getMerchantReference());
    }

    /**
     * Terminal Id - Setter
     * @param mixed $terminalId
     */
    public function setTerminalId($terminalId)
    {
        $this->_terminalId = trim($terminalId);
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        if (
            !$this->getAccessToken() ||
            !$this->getMasterMerchantAccount() ||
            !$this->getMasterMerchantPin() ||
            !$this->getMasterMerchantId() ||
            !$this->getSubscriberAccount() ||
            !$this->getSubscriberCountry() ||
            !$this->getSubscriberCountryCode() ||
            !$this->getSubscriberFirstName() ||
            !$this->getSubscriberLastName() ||
            !$this->getSubscriberEmail() ||
            !$this->getLocalPaymentAmount() ||
            !$this->getLocalPaymentCurrencyCode() ||
            !$this->getRedirectUri() ||
            !$this->getCallbackUri() ||
            !$this->getLanguage() ||
            !$this->getMerchantTransactionId()
        ) {
            $return = false;
        } else {
            $return = true;
        }

        return $return;
    }
}