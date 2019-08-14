<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect
 */
class Tigo_TigoMoney_Model_Payment_Redirect extends Mage_Payment_Model_Method_Abstract
{
    /**
     * Additional Information Key - Access Token
     */
    const ADDITIONAL_INFO_KEY_ACCESS_TOKEN = 'tigomoney_redirect_access_token';
    /**
     * Additional Information Key - Access Token
     */
    const ADDITIONAL_INFO_KEY_ACCESS_TOKEN_ERRORS = 'tigomoney_redirect_access_token_errors';
    /**
     * Additional Information Key - Auth Code
     */
    const ADDITIONAL_INFO_KEY_AUTH_CODE = 'tigomoney_redirect_auth_code';
    /**
     * Additional Information Key - Authorization Errors
     */
    const ADDITIONAL_INFO_KEY_AUTHORIZATION_ERRORS = 'tigomoney_redirect_authorization_errors';

    /**
     * Additional Information Key - Redirect Uri
     */
    const ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID = 'tigomoney_mfs_transaction_id';

    /**
     * Additional Information Key - Tigo Phone Number
     */
    const ADDITIONAL_INFO_KEY_PHONE_NUMBER = 'tigomoney_phone_number';

    /**
     * Additional Information Key - Redirect Uri
     */
    const ADDITIONAL_INFO_KEY_REDIRECT_URI = 'tigomoney_redirect_uri';

    /**
     * Additional Information Key - Transaction Code
     */
    const ADDITIONAL_INFO_KEY_TRANSACTION_CODE = 'tigomoney_transaction_code';

    /**
     * Additional Information Key - Transaction Description
     */
    const ADDITIONAL_INFO_KEY_TRANSACTION_DESCRIPTION = 'tigomoney_transaction_description';

    /**
     * Additional Information Key - Transaction Status
     */
    const ADDITIONAL_INFO_KEY_TRANSACTION_STATUS = 'tigomoney_transaction_status';

    /**
     * Payment method code
     */
    const METHOD_CODE = 'tigo_tigomoney';

    /**
     * Can Authorize
     * @var bool
     */
    protected $_canAuthorize = true;

    /**
     * Can Capture
     * @var bool
     */
    protected $_canCapture = true;

    /**
     * This is not a recurring payment method
     * @var bool
     */
    protected $_canManageRecurringProfiles = false;

    /**
     * Can order
     * @var bool
     */
    protected $_canOrder = false;

    /**
     * Refund method is available
     * @var bool
     */
    protected $_canRefund = true;

    /**
     * Can't Refund partial transactions, only full ones
     * @var bool
     */
    protected $_canRefundInvoicePartial = false;

    /**
     * Can be used in frontend checkout
     * @var bool
     */
    protected $_canUseCheckout = true;

    /**
     * This payment method depends on the user to access his account on Tigo, we
     * won't need it in the admin
     * @var bool
     */
    protected $_canUseInternal = false;

    /**
     * Payment method code
     * @var string
     */
    protected $_code = self::METHOD_CODE;

    /**
     * Data Helper
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_dataHelper = null;

    /**
     * Payment Method Form Block
     * @var string
     */
    protected $_infoBlockType = 'tigo_tigomoney/payment_redirect_info';

    /**
     * Payment Method Form Block
     * @var string
     */
    protected $_formBlockType = 'tigo_tigomoney/payment_redirect_form';

    /**
     * Is this payment method a payment gateway?
     * @var bool
     */
    protected $_isGateway = true;

    /**
     * Redirect Api
     * @var null|Tigo_TigoMoney_Model_Payment_Redirect_Api
     */
    protected $_redirectApi = null;

    /**
     * Request Builder
     * @var null|Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder
     */
    protected $_requestBuilder= null;


    /**
     * Assigns form data to payment info
     * @param mixed $data
     * @return $this
     */
    public function assignData($data)
    {
        parent::assignData($data);

        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }

        if ($data->getMethod() != self::METHOD_CODE) {
            return $this;
        }

        $phoneNumber = $data->getData(self::METHOD_CODE . '_phone_number');
        $this
            ->getInfoInstance()
            ->setAdditionalInformation(self::ADDITIONAL_INFO_KEY_PHONE_NUMBER, $phoneNumber);

        return $this;
    }

    /**
     * Payment authorization, gets redirect URL from API
     * @param Varien_Object $payment
     * @param float $amount
     * @return $this
     * @throws Mage_Core_Exception
     */
    public function authorize(Varien_Object $payment, $amount)
    {
        /** @var Mage_Sales_Model_Order_Payment $payment */
        $order = $payment->getOrder();

        $accessTokenRequest = $this->_getRequestBuilder()->buildGenerateAccessTokenRequest();
        $accessTokenResponse = $this->_getRedirectApi()->getAccessToken($accessTokenRequest);

        if ($accessTokenResponse->isSuccess()) {
            $authorizationRequest = $this->_getRequestBuilder()->buildAuthorizationRequest(
                $accessTokenResponse->getAccessToken(),
                $order
            );
            $authorizationResponse = $this->_getRedirectApi()->getRedirectUri($authorizationRequest);

            if ($authorizationResponse->isSuccess()) {
                $payment
                    ->setAmount($amount)
                    ->setStatus(self::STATUS_APPROVED)
                    ->setIsTransactionPending(false)
                    ->setIsTransactionClosed(false)
                    ->setTransactionId($authorizationResponse->getAuthCode())
                    ->setAdditionalInformation(
                        self::ADDITIONAL_INFO_KEY_ACCESS_TOKEN,
                        $accessTokenResponse->getAccessToken()
                    )
                    ->setAdditionalInformation(
                        self::ADDITIONAL_INFO_KEY_REDIRECT_URI,
                        $authorizationResponse->getRedirectUri()
                    )
                    ->setAdditionalInformation(
                        self::ADDITIONAL_INFO_KEY_AUTH_CODE,
                        $authorizationResponse->getAuthCode()
                    )
                    ->save();
            } else {
                $payment
                    ->setAdditionalInformation(
                        self::ADDITIONAL_INFO_KEY_AUTHORIZATION_ERRORS,
                        implode('\n', $authorizationResponse->getErrors())
                    )
                    ->save();
                Mage::throwException(
                    $this->_getDataHelper()->__('There was an error while trying to complete your payment')
                );
            }
        } else {
            $payment
                ->setAdditionalInformation(
                    self::ADDITIONAL_INFO_KEY_ACCESS_TOKEN_ERRORS,
                    implode('\n', $accessTokenResponse->getErrors())
                )
                ->save();
            Mage::throwException(
                $this->_getDataHelper()->__('There was an error while trying to complete your payment')
            );
        }

        return $this;
    }

    /**
     * Capture payment, necessary for refund operation to be available
     * @param Varien_Object $payment
     * @param float $amount
     * @return bool
     */
    public function capture(Varien_Object $payment, $amount)
    {
        /** @var Mage_Sales_Model_Order_Payment $payment */
        $payment
            ->setAmount($amount)
            ->setStatus(self::STATUS_SUCCESS)
            ->setTransactionId($payment->getTransactionId())
            ->setIsTransactionClosed(true)
            ->save();
        return true;
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
     * Url to redirect the user after checkout is finished
     * This route will be responsible for forwarding the customer to the Tigo Money Payment Server
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return $this->_getDataHelper()->getInternalRedirectUri();
    }

    /**
     * Returns Redirect Api Instance
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api
     */
    protected function _getRedirectApi()
    {
        if ($this->_redirectApi === null) {
            $this->_redirectApi = Mage::getModel('tigo_tigomoney/payment_redirect_api');
        }
        return $this->_redirectApi;
    }

    /**
     * Returns Request Builder Instance
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder
     */
    protected function _getRequestBuilder()
    {
        if ($this->_requestBuilder === null) {
            $this->_requestBuilder = Mage::getModel('tigo_tigomoney/payment_redirect_api_requestBuilder');
        }
        return $this->_requestBuilder;
    }

    /**
     * Is method available?
     * @param null $quote
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        $isAvailable = parent::isAvailable($quote);

        if ($isAvailable) {
            if ($this->_getDataHelper()->getClientId() && $this->_getDataHelper()->getClientSecret() &&
                $this->_getDataHelper()->getMerchantAccount() && $this->_getDataHelper()->getMerchantPin()
            ) {
                $isAvailable = true;
            } else {
                $isAvailable = false;
            }
        }

        return $isAvailable;
    }

    /**
     * Refunds order, calling the Payment Server API and reversing the transaction
     * @param Varien_Object $payment
     * @param float $amount
     * @return $this
     */
    public function refund(Varien_Object $payment, $amount)
    {
        /** @var Mage_Sales_Model_Order_Payment $payment */
        $order = $payment->getOrder();
        $accessTokenRequest = $this->_getRequestBuilder()->buildGenerateAccessTokenRequest();
        $accessTokenResponse = $this->_getRedirectApi()->getAccessToken($accessTokenRequest);

        if ($accessTokenResponse->isSuccess()) {
            $reverseRequest = $this->_getRequestBuilder()->buildReverseTransactionRequest(
                $accessTokenResponse->getAccessToken(),
                $order
            );
            $reverseResponse = $this->_getRedirectApi()->reverseTransaction($reverseRequest);
            if ($reverseResponse->isSuccess()) {
                $payment->setTransactionId($reverseResponse->getTransactionMfsReverseTransactionId());
                $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_REFUND);
            } else {
                Mage::throwException(
                    $this->_getDataHelper()->__('There was an error while trying to refund this order')
                );
            }
        } else {
            Mage::throwException(
                $this->_getDataHelper()->__('There was an error while trying to refund this order')
            );
        }

        return $this;
    }
}