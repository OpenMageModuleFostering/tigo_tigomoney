<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilderTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilderTest extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $authorizationRequest = null;

    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Helper_Data|PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataHelper = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $generateTokenRequest = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Mage_Sales_Model_Order_Payment|PHPUnit_Framework_MockObject_MockObject
     */
    protected $payment = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $reverseTransactionRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $transactionStatusRequest = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->getMock();

        $this->authorizationRequest = $this->getModelMock(
            'tigo_tigomoney/payment_redirect_api_authorizationRequest',
            array()
        );

        $this->authorizationRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::class)
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_authorizationRequest',
            $this->authorizationRequest
        );

        $this->generateTokenRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest::class)
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_generateTokenRequest',
            $this->generateTokenRequest
        );

        $this->reverseTransactionRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::class)
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_reverseTransactionRequest',
            $this->reverseTransactionRequest
        );

        $this->transactionStatusRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::class)
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_transactionStatusRequest',
            $this->transactionStatusRequest
        );

        $this->payment = $this
            ->getMockBuilder(Mage_Sales_Model_Order_Payment::class)
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock(
            'model',
            'sales/order_payment',
            $this->payment
        );

        $this->order = $this
            ->getMockBuilder(Mage_Sales_Model_Order::class)
            ->setMethods(array('getPayment'))#, 'getCustomerFirstname', 'getCustomerLastname', 'getCustomerEmail', 'getBaseGrandTotal', 'getIncrementId'))
            ->getMock();
        $this
            ->order
            ->expects($this->any())
            ->method('getPayment')
            ->will($this->returnValue($this->payment));
        $this->replaceByMock(
            'model',
            'sales/order',
            $this->order
        );

        $this->dataHelper = $this->getHelperMock(
            'tigo_tigomoney/data',
            array()
        );
        $this->replaceByMock(
            'helper',
            'tigo_tigomoney/data',
            $this->dataHelper
        );
    }

    /**
     * @loadFixture default
     */
    public function testBuildAuthorizationRequest()
    {
        /** @var Mage_Core_Model_Url $url */
        $url = Mage::getModel('core/url');

        $accessToken = 'kmsdmsdoi234';
        $masterMerchantAccount = 'zaq1xsw2cde3';
        $masterMerchantPin = '6464646737373';
        $masterMerchantId = '98098098';
        $merchantReference = 'Amazon';
        $merchantCurrencyCode = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD;
        $merchantFee = 0;
        $subscriberAccount = '234234234';
        $subscriberCountry = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_CODE;
        $subscriberCountryCode = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_DIAL_CODE;
        $subscriberFirstName = 'John';
        $subscriberLastName = 'Doe';
        $subscriberEmail = 'johndoe@hotmail.com';
        $localPaymentAmount = 123.32;
        $localPaymentCurrencyCode = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD;
        $originPaymentAmount = $localPaymentAmount;
        $originPaymentCurrencyCode = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD;
        $originPaymentTax = 0;
        $originPaymentFee = 0;
        $redirectUri = $url->getUrl('tigomoney/return');
        $callbackUri = $url->getUrl('tigomoney/sync');
        $language = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::LANGUAGE_CODE_SPANISH;
        $merchantTransactionId = '10000234';
        $terminalId = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::TERMINAL_ID;
        $exchangeRate = 1;

        $this
            ->payment
            ->setAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_PHONE_NUMBER, $subscriberAccount);

        $this
            ->order
            ->setCustomerFirstname($subscriberFirstName);

        $this
            ->order
            ->setCustomerLastname($subscriberLastName);

        $this
            ->order
            ->setCustomerEmail($subscriberEmail);

        $this
            ->order
            ->setBaseGrandTotal($localPaymentAmount);

        $this
            ->order
            ->setIncrementId($merchantTransactionId);

        $request = $this->subject->buildAuthorizationRequest(
            $accessToken,
            $this->order
        );

        $this->assertEquals(
            $accessToken,
            $request->getAccessToken()
        );

        $this->assertEquals(
            $masterMerchantAccount,
            $request->getMasterMerchantAccount()
        );

        $this->assertEquals(
            $masterMerchantPin,
            $request->getMasterMerchantPin()
        );

        $this->assertEquals(
            $masterMerchantId,
            $request->getMasterMerchantId()
        );

        $this->assertEquals(
            $merchantReference,
            $request->getMerchantReference()
        );

        $this->assertEquals(
            $merchantCurrencyCode,
            $request->getMerchantCurrencyCode()
        );

        $this->assertEquals(
            $merchantFee,
            $request->getMerchantFee()
        );

        $this->assertEquals(
            $subscriberAccount,
            $request->getSubscriberAccount()
        );

        $this->assertEquals(
            $subscriberCountry,
            $request->getSubscriberCountry()
        );

        $this->assertEquals(
            $subscriberCountryCode,
            $request->getSubscriberCountryCode()
        );

        $this->assertEquals(
            $subscriberFirstName,
            $request->getSubscriberFirstName()
        );

        $this->assertEquals(
            $subscriberLastName,
            $request->getSubscriberLastName()
        );

        $this->assertEquals(
            $subscriberEmail,
            $request->getSubscriberEmail()
        );

        $this->assertEquals(
            $localPaymentAmount,
            $request->getLocalPaymentAmount()
        );

        $this->assertEquals(
            $localPaymentCurrencyCode,
            $request->getLocalPaymentCurrencyCode()
        );

        $this->assertEquals(
            $originPaymentAmount,
            $request->getOriginPaymentAmount()
        );

        $this->assertEquals(
            $originPaymentCurrencyCode,
            $request->getOriginPaymentCurrencyCode()
        );

        $this->assertEquals(
            $originPaymentTax,
            $request->getOriginPaymentTax()
        );

        $this->assertEquals(
            $originPaymentFee,
            $request->getOriginPaymentFee()
        );

        $this->assertEquals(
            $redirectUri,
            $request->getRedirectUri()
        );

        $this->assertEquals(
            $callbackUri,
            $request->getCallbackUri()
        );

        $this->assertEquals(
            $language,
            $request->getLanguage()
        );

        $this->assertEquals(
            $merchantTransactionId,
            $request->getMerchantTransactionId()
        );

        $this->assertEquals(
            $terminalId,
            $request->getTerminalId()
        );

        $this->assertEquals(
            $exchangeRate,
            $request->getExchangeRate()
        );

        $this->assertEquals(
            $this->authorizationRequest,
            $request
        );
    }

    /**
     * @loadFixture default
     */
    public function testGenerateAccessTokenRequest()
    {
        $clientId = '123';
        $clientSecret = 'asdf123fdsa';

        $request = $this->subject->buildGenerateAccessTokenRequest();

        $this->assertEquals(
            $this->generateTokenRequest,
            $request
        );

        $this->assertEquals(
            $clientId,
            $request->getClientId()
        );

        $this->assertEquals(
            $clientSecret,
            $request->getClientSecret()
        );
    }

    /**
     * @loadFixture default
     */
    public function testBuildReverseTokenRequest()
    {
        $accessToken = 'sdlkfms3234';
        $masterMerchantAccount = 'zaq1xsw2cde3';
        $masterMerchantPin = '6464646737373';
        $masterMerchantId = '98098098';
        $mfsTransactionId = '234234234';
        $incrementId = '100000234';
        $subscriberAccount = '234234234';
        $localPaymentAmount = 123.32;
        $localPaymentCurrencyCode = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD;
        $country = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_CODE;

        $this
            ->order
            ->setBaseGrandTotal($localPaymentAmount);

        $this
            ->order
            ->setIncrementId($incrementId);

        $this
            ->payment
            ->setAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_PHONE_NUMBER,
                $subscriberAccount
            );

        $this
            ->payment
            ->setAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID,
                $mfsTransactionId
            );

        $request = $this->subject->buildReverseTransactionRequest(
            $accessToken,
            $this->order
        );

        $this->assertEquals(
            $this->reverseTransactionRequest,
            $request
        );

        $this->assertEquals(
            $accessToken,
            $request->getAccessToken()
        );

        $this->assertEquals(
            $masterMerchantAccount,
            $request->getMasterAccountAccount()
        );

        $this->assertEquals(
            $masterMerchantPin,
            $request->getMasterAccountPin()
        );

        $this->assertEquals(
            $masterMerchantId,
            $request->getMasterAccountId()
        );

        $this->assertEquals(
            $subscriberAccount,
            $request->getSubscriberAccount()
        );

        $this->assertEquals(
            $localPaymentCurrencyCode,
            $request->getLocalPaymentCurrencyCode()
        );

        $this->assertEquals(
            $country,
            $request->getCountry()
        );

        $this->assertEquals(
            $localPaymentAmount,
            $request->getLocalPaymentAmount()
        );

        $this->assertEquals(
            $incrementId,
            $request->getMerchantTransactionId()
        );

        $this->assertEquals(
            $mfsTransactionId,
            $request->getMfsTransactionId()
        );
    }



    /**
     * @loadFixture default
     */
    public function testBuildTransactionStatusRequest()
    {
        $orderIncrementId = '10000023';
        $accessToken = 'asdf123fdsa';
        $masterMerchantId = '98098098';
        $country = Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR;

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $request = $this->subject->buildTransactionStatusRequest(
            $accessToken,
            $this->order
        );

        $this->assertEquals(
            $this->transactionStatusRequest,
            $request
        );

        $this->assertEquals(
            $accessToken,
            $request->getAccessToken()
        );

        $this->assertEquals(
            $orderIncrementId,
            $request->getMerchantTransactionId()
        );

        $this->assertEquals(
            $country,
            $request->getCountry()
        );

        $this->assertEquals(
            $masterMerchantId,
            $request->getMasterMerchantId()
        );
    }
}

