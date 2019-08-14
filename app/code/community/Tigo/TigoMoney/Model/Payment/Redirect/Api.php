<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api
{
    /**
     * Tigo Payment Server Endpoint URL - Production
     */
    const PROD_ENVIRONMENT_DOMAIN = 'https://prod.api.tigo.com/';

    /**
     * Tigo Payment Server Endpoint URL - Test
     */
    const TEST_ENVIRONMENT_DOMAIN = 'https://securesandbox.tigo.com/';

    /**
     * Core Helper
     * @var null|Mage_Core_Helper_Data
     */
    protected $_coreHelper = null;

    /**
     * Data Helper
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_dataHelper = null;

    /**
     * Debug Model
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_debug = null;

    /**
     * Writes info to debug file
     * @param string $value
     */
    protected function _debug($value)
    {
        $this->_getDebug()->debug($value);
    }

    /**
     * Fetches a value from given array, checking for its' existence
     * @param array $array
     * @param string $key
     * @param string|null $subKey
     * @return mixed
     */
    protected function _fetchResponseValue($array, $key, $subKey = null)
    {
        $return = null;

        if (array_key_exists($key, $array)) {
            $return = $array[$key];
            if ($subKey !== null) {
                if (array_key_exists($subKey, $return)) {
                    $return = $return[$subKey];
                } else {
                    $return = null;
                }
            }
        }

        return $return;
    }

    /**
     * Queries the Tigo Money Payment Server for an Access Token
     * @param Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest $request
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse
     */
    public function getAccessToken(Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest $request)
    {
        $return = $this->_getGenerateTokenResponseInstance();

        if (!$request->validate()) {
            Mage::throwException($this->_getDataHelper()->__('Invalid Parameters Sent to Generate Token Request.'));
        }

        $httpResponse = $this->_makeRequest(
            $this->_getEndpointUrl($request),
            $request->getMethod(),
            $request->getHeaders(),
            $request->getBody()
        );
        $httpResponseArray = (array) $this->_getCoreHelper()->jsonDecode($httpResponse->getBody());

        if ($httpResponse->getStatus() == 200) {
            $return->setAccessToken((string) $this->_fetchResponseValue($httpResponseArray, 'accessToken'));
        } else {
            $return->addError((string) $this->_fetchResponseValue($httpResponseArray, 'error_description'));
        }
        return $return;
    }

    /**
     * Instantiates a new Authorization response object
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse
     */
    protected function _getAuthorizationResponseInstance()
    {
        return Mage::getModel(
            'tigo_tigomoney/payment_redirect_api_authorizationResponse',
            new Varien_Object()
        );
    }

    /**
     * Core Helper Getter
     * @return Mage_Core_Helper_Data
     */
    protected function _getCoreHelper()
    {
        if ($this->_coreHelper === null) {
            $this->_coreHelper = Mage::helper('core');
        }
        return $this->_coreHelper;
    }

    /**
     * Data Helper Getter
     * @return Tigo_TigoMoney_Helper_Data
     */
    protected function _getDataHelper()
    {
        if ($this->_dataHelper === null) {
            $this->_dataHelper = Mage::helper('tigo_tigomoney');
        }
        return $this->_dataHelper;
    }

    /**
     * Debug Model Getter
     * @return Tigo_TigoMoney_Model_Debug
     */
    protected function _getDebug()
    {
        if ($this->_debug === null) {
            $this->_debug = Mage::getModel('tigo_tigomoney/debug');
        }
        return $this->_debug;
    }

    /**
     * Returns URL for the access token endpoint
     * @param Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface $request
     * @return string
     */
    protected function _getEndpointUrl(Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestInterface $request)
    {
        return $this->_getEndpointDomain() . $request->getEndpointPath();
    }

    /**
     * Returns domain for the endpoint to be used, based on test mode being
     * enabled or not
     * @return string
     */
    protected function _getEndpointDomain()
    {
        if ($this->isTestMode()) {
            $return = self::TEST_ENVIRONMENT_DOMAIN;
        } else {
            $return = self::PROD_ENVIRONMENT_DOMAIN;
        }
        return $return;
    }

    /**
     * Instantiates a new Generate Token response object
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse
     */
    protected function _getGenerateTokenResponseInstance()
    {
        return Mage::getModel(
            'tigo_tigomoney/payment_redirect_api_generateTokenResponse',
            new Varien_Object()
        );
    }

    /**
     * Returns a new HTTP client instance
     * @return Zend_Http_Client
     */
    protected function _getHttpClient()
    {
        return new Zend_Http_Client(null, array('timeout'=> 30));
    }

    /**
     * Connects to API and retrieves redirect payment url for given order
     * @param Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest $request
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse
     * @throws Mage_Core_Exception
     */
    public function getRedirectUri(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest $request)
    {
        $return = $this->_getAuthorizationResponseInstance();

        if (!$request->validate()) {
            Mage::throwException($this->_getDataHelper()->__('Invalid Parameters Sent to Authorization Request.'));
        }

        $httpResponse = $this->_makeRequest(
            $this->_getEndpointUrl($request),
            $request->getMethod(),
            $request->getHeaders(),
            $request->getBody()
        );

        $httpResponseArray = (array) $this->_getCoreHelper()->jsonDecode($httpResponse->getBody());

        if ($httpResponse->getStatus() == 200) {
            $return
                ->setAuthCode((string) $this->_fetchResponseValue($httpResponseArray, 'authCode'))
                ->setRedirectUri((string) $this->_fetchResponseValue($httpResponseArray, 'redirectUrl'));
        } else {
            $return->addError((string) $this->_fetchResponseValue($httpResponseArray, 'error_description'));
        }

        return $return;
    }

    /**
     * Instantiates a new Reverse Transaction response object
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse
     */
    protected function _getReverseTransactionResponseInstance()
    {
        return Mage::getModel(
            'tigo_tigomoney/payment_redirect_api_reverseTransactionResponse',
            new Varien_Object()
        );
    }

    /**
     * Queries the Tigo Money Payment Server for a transaction status
     * @param Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse
     */
    public function getTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
    {
        $return = $this->_getTransactionStatusResponseInstance();

        if (!$request->validate()) {
            Mage::throwException($this->_getDataHelper()->__('Invalid Parameters Sent to Transaction Status Request.'));
        }

        $httpResponse = $this->_makeRequest(
            $this->_getEndpointUrl($request),
            $request->getMethod(),
            $request->getHeaders(),
            $request->getBody()
        );
        $httpResponseArray = (array) $this->_getCoreHelper()->jsonDecode($httpResponse->getBody());

        if ($httpResponse->getStatus() == 200) {
            $return->setTransactionMerchantTransactionId($this->_fetchResponseValue($httpResponseArray, 'Transaction', 'merchantTransactionId'));
            $return->setTransactionMfsTransactionId($this->_fetchResponseValue($httpResponseArray, 'Transaction', 'mfsTransactionId'));
            $return->setTransactionCreatedOn($this->_fetchResponseValue($httpResponseArray, 'Transaction', 'createdOn'));
            $return->setTransactionStatus($this->_fetchResponseValue($httpResponseArray, 'Transaction', 'status'));
            $return->setTransactionCompletedOn($this->_fetchResponseValue($httpResponseArray, 'Transaction', 'completedOn'));
            $return->setMasterMerchantAccount($this->_fetchResponseValue($httpResponseArray, 'MasterMerchant', 'account'));
            $return->setMasterMerchantId($this->_fetchResponseValue($httpResponseArray, 'MasterMerchant', 'id'));
            $return->setMerchantReference($this->_fetchResponseValue($httpResponseArray, 'Merchant', 'reference'));
            $return->setMerchantFee($this->_fetchResponseValue($httpResponseArray, 'Merchant', 'fee'));
            $return->setMerchantCurrencyCode($this->_fetchResponseValue($httpResponseArray, 'Merchant', 'currencyCode'));
            $return->setSubscriberAccount($this->_fetchResponseValue($httpResponseArray, 'Subscriber', 'account'));
            $return->setSubscriberCountryCode($this->_fetchResponseValue($httpResponseArray, 'Subscriber', 'countryCode'));
            $return->setSubscriberCountry($this->_fetchResponseValue($httpResponseArray, 'Subscriber', 'country'));
            $return->setSubscriberFirstName($this->_fetchResponseValue($httpResponseArray, 'Subscriber', 'firstName'));
            $return->setSubscriberLastName($this->_fetchResponseValue($httpResponseArray, 'Subscriber', 'lastName'));
            $return->setSubscriberEmail($this->_fetchResponseValue($httpResponseArray, 'Subscriber', 'emailId'));
            $return->setRedirectUri($this->_fetchResponseValue($httpResponseArray, 'redirectUri'));
            $return->setCallbackUri($this->_fetchResponseValue($httpResponseArray, 'callbackUri'));
            $return->setLanguage($this->_fetchResponseValue($httpResponseArray, 'language'));
            $return->setTerminalId($this->_fetchResponseValue($httpResponseArray, 'terminalId'));
            $return->setExchangeRate($this->_fetchResponseValue($httpResponseArray, 'exchangeRate'));
            $return->setOriginPaymentAmount($this->_fetchResponseValue($httpResponseArray, 'OriginPayment', 'amount'));
            $return->setOriginPaymentCurrencyCode($this->_fetchResponseValue($httpResponseArray, 'OriginPayment', 'currencyCode'));
            $return->setOriginPaymentTax($this->_fetchResponseValue($httpResponseArray, 'OriginPayment', 'tax'));
            $return->setOriginPaymentFee($this->_fetchResponseValue($httpResponseArray, 'OriginPayment', 'fee'));
            $return->setLocalPaymentAmount($this->_fetchResponseValue($httpResponseArray, 'LocalPayment', 'amount'));
            $return->setLocalPaymentCurrencyCode($this->_fetchResponseValue($httpResponseArray, 'LocalPayment', 'currencyCode'));
        } else {
            $return->addError((string) $this->_fetchResponseValue($httpResponseArray, 'error_description'));
        }
        return $return;
    }

    /**
     * Instantiates a new Transaction Status response object
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse
     */
    protected function _getTransactionStatusResponseInstance()
    {
        return Mage::getModel(
            'tigo_tigomoney/payment_redirect_api_transactionStatusResponse',
            new Varien_Object()
        );
    }

    /**
     * Are we in test mode?
     * @return boolean
     */
    public function isTestMode()
    {
        return $this->_getDataHelper()->isTestModeEnabled();
    }

    /**
     * Makes a HTTP request, returns the response as a string
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param string $body
     * @return Zend_Http_Response
     */
    protected function _makeRequest($url, $method, $headers, $body)
    {
        $this->_debug('---- Request ---');
        $this->_debug('Url: ' . $url);
        $this->_debug('Method: ' . $method);
        $this->_debug('Headers: ' . var_export($headers, true));
        $this->_debug('Body: ' . $body);

        $client = $this->_getHttpClient();
        $client
            ->setUri($url)
            ->setHeaders($headers)
            ->setRawData($body)
            ->setMethod($method);

        $response = $client->request();

        $this->_debug('---- Response ---');
        $this->_debug('Status: ' . $response->getStatus());
        $this->_debug('Body: ' . $response->getBody());

        return $response;
    }

    /**
     * Connects to API and reverses transaction for given order
     * @param Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest $request
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse
     * @throws Mage_Core_Exception
     */
    public function reverseTransaction(Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest $request)
    {
        $return = $this->_getReverseTransactionResponseInstance();

        if (!$request->validate()) {
            Mage::throwException($this->_getDataHelper()->__('Invalid Parameters Sent to Reverse Request.'));
        }

        $httpResponse = $this->_makeRequest(
            $this->_getEndpointUrl($request),
            $request->getMethod(),
            $request->getHeaders(),
            $request->getBody()
        );

        $httpResponseArray = (array) $this->_getCoreHelper()->jsonDecode($httpResponse->getBody());

        if ($httpResponse->getStatus() == 200) {
            $return
                ->setStatus((string) $this->_fetchResponseValue($httpResponseArray, 'status'))
                ->setTransactionMerchantTransactionId((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'merchantTransactionId'))
                ->setTransactionCorrelationId((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'correlationId'))
                ->setTransactionMfsTransactionId((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'mfsTransactionId'))
                ->setTransactionMfsReverseTransactionId((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'mfsReverseTransactionId'))
                ->setTransactionStatus((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'status'))
                ->setTransactionMessage((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'message'));
        } else {
            $return
                ->setStatus((string) $this->_fetchResponseValue($httpResponseArray, 'status'))
                ->setTransactionMerchantTransactionId((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'merchantTransactionId'))
                ->setTransactionCorrelationId((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'correlationId'))
                ->setTransactionMfsTransactionId((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'mfsTransactionId'))
                ->setTransactionStatus((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'status'))
                ->setTransactionMessage((string) $this->_fetchResponseValue($httpResponseArray, 'Transaction', 'message'))
                ->setError((string) $this->_fetchResponseValue($httpResponseArray, 'error'))
                ->setErrorType((string) $this->_fetchResponseValue($httpResponseArray, 'error_type'))
                ->setErrorDescription((string) $this->_fetchResponseValue($httpResponseArray, 'error_description'));
            $return->addError((string) $this->_fetchResponseValue($httpResponseArray, 'error_description'));
        }

        return $return;
    }
}