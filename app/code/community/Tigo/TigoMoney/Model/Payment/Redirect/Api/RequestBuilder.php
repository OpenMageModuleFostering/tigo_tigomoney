<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder
{
    /**
     * Data Helper
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_dataHelper = null;

    /**
     * Builds a new authorization request object
     * @param string $accessToken
     * @param Mage_Sales_Model_Order $order
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest
     */
    public function buildAuthorizationRequest($accessToken, Mage_Sales_Model_Order $order)
    {
        $request = $this->_getAuthorizationRequestInstance();

        # Access Token
        $request->setAccessToken($accessToken);

        # Master Merchant Account Info
        $request->setMasterMerchantAccount($this->_getDataHelper()->getMerchantAccount());
        $request->setMasterMerchantPin($this->_getDataHelper()->getMerchantPin());
        $request->setMasterMerchantId($this->_getDataHelper()->getMerchantId());

        # Merchant Info
        $request->setMerchantReference($this->_getDataHelper()->getMerchantReference());
        $request->setMerchantCurrencyCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD);
        $request->setMerchantFee(0);

        # Subscriber
        $request->setSubscriberAccount($order->getPayment()->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_PHONE_NUMBER));
        $request->setSubscriberCountry(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_CODE);
        $request->setSubscriberCountryCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_DIAL_CODE);
        $request->setSubscriberFirstName($order->getCustomerFirstname());
        $request->setSubscriberLastName($order->getCustomerLastname());
        $request->setSubscriberEmail($order->getCustomerEmail());

        # Local Payment
        $request->setLocalPaymentAmount($order->getBaseGrandTotal());
        $request->setLocalPaymentCurrencyCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD);

        # Origin Payment
        $request->setOriginPaymentAmount($order->getBaseGrandTotal());
        $request->setOriginPaymentCurrencyCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD);
        $request->setOriginPaymentTax(0);
        $request->setOriginPaymentFee(0);

        # Additional Info
        $request->setRedirectUri($this->_getDataHelper()->getRedirectUri());
        $request->setCallbackUri($this->_getDataHelper()->getCallbackUri());
        $request->setLanguage(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::LANGUAGE_CODE_SPANISH);
        $request->setMerchantTransactionId($order->getIncrementId());
        $request->setTerminalId(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::TERMINAL_ID);
        $request->setExchangeRate(1);

        return $request;
    }

    /**
     * Builds a new generate access token request object
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest
     */
    public function buildGenerateAccessTokenRequest()
    {
        $request = $this->_getGenerateAccessTokenRequestInstance();
        $request->setClientId($this->_getDataHelper()->getClientId());
        $request->setClientSecret($this->_getDataHelper()->getClientSecret());
        return $request;
    }

    /**
     * Builds a new reverse transaction request object
     * @param Mage_Sales_Model_Order $order
     * @param string $accessToken
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest
     */
    public function buildReverseTransactionRequest($accessToken, Mage_Sales_Model_Order $order)
    {
        $request = $this->_getReverseTransactionRequestInstance();

        $request->setAccessToken($accessToken);
        $request->setMasterAccountAccount($this->_getDataHelper()->getMerchantAccount());
        $request->setMasterAccountPin($this->_getDataHelper()->getMerchantPin());
        $request->setMasterAccountId($this->_getDataHelper()->getMerchantId());
        $request->setSubscriberAccount(
            $order->getPayment()->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_PHONE_NUMBER
            )
        );
        $request->setLocalPaymentCurrencyCode(
            Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::CURRENCY_CODE_USD
        );
        $request->setCountry(
            Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::COUNTRY_CODE_EL_SALVADOR
        );
        $request->setLocalPaymentAmount($order->getBaseGrandTotal());
        $request->setMerchantTransactionId($order->getIncrementId());
        $request->setMfsTransactionId(
            $order->getPayment()->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID
            )
        );
        return $request;
    }

    /**
     * Builds a new transaction status request object
     * @param Mage_Sales_Model_Order $order
     * @param string $accessToken
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest
     */
    public function buildTransactionStatusRequest($accessToken, Mage_Sales_Model_Order $order)
    {
        $request = $this->_getTransactionStatusRequestInstance();

        $orderIncrementId = $order->getIncrementId();

        $request->setAccessToken($accessToken);
        $request->setCountry(
            Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR
        );
        $request->setMasterMerchantId($this->_getDataHelper()->getMerchantId());
        $request->setMerchantTransactionId($orderIncrementId);
        return $request;
    }

    /**
     * Gets new AuthorizationRequest Instance
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest
     */
    protected function _getAuthorizationRequestInstance()
    {
        return Mage::getModel('tigo_tigomoney/payment_redirect_api_authorizationRequest');
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
     * Gets new GenerateTokenRequest Instance
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest
     */
    protected function _getGenerateAccessTokenRequestInstance()
    {
        return Mage::getModel('tigo_tigomoney/payment_redirect_api_generateTokenRequest');
    }

    /**
     * Gets new ReverseTransactionRequest Instance
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest
     */
    protected function _getReverseTransactionRequestInstance()
    {
        return Mage::getModel('tigo_tigomoney/payment_redirect_api_reverseTransactionRequest');
    }

    /**
     * Gets new TransactionStatusRequest Instance
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest
     */
    protected function _getTransactionStatusRequestInstance()
    {
        return Mage::getModel('tigo_tigomoney/payment_redirect_api_transactionStatusRequest');
    }
}