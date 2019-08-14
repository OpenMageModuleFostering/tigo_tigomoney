<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_ApiTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_ApiTest extends EcomDev_PHPUnit_Test_Case
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
     * @var Tigo_TigoMoney_Model_Debug|PHPUnit_Framework_MockObject_MockObject
     */
    protected $debug = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $generateTokenRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $reverseTransactionRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $transactionStatusRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;


    /**
     * @var Varien_Http_Client|PHPUnit_Framework_MockObject_MockObject
     */
    protected $varienHttpClient = null;


    /**
     * @var Zend_Http_Response|PHPUnit_Framework_MockObject_MockObject
     */
    protected $zendHttpResponse = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_getHttpClient'))
            ->getMock();


        $this->authorizationRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::class)
            ->setMethods(array('validate'))
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_authorizationRequest',
            $this->authorizationRequest
        );

        $this->generateTokenRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest::class)
            ->setMethods(array('validate'))
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_generateTokenRequest',
            $this->generateTokenRequest
        );

        $this->reverseTransactionRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::class)
            ->setMethods(array('validate'))
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_reverseTransactionRequest',
            $this->reverseTransactionRequest
        );

        $this->transactionStatusRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::class)
            ->setMethods(array('validate'))
            ->getMock();
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_transactionStatusRequest',
            $this->transactionStatusRequest
        );

        $this->zendHttpResponse = $this
            ->getMockBuilder(Zend_Http_Response::class)
            ->setMethods(array('getBody', 'getStatus'))
            ->disableOriginalConstructor()
            ->getMock();

        $this->varienHttpClient = $this
            ->getMockBuilder(Varien_Http_Client::class)
            ->setMethods(array('setUri', 'request'))
            ->getMock();
        $this->varienHttpClient
            ->expects($this->any())
            ->method('setUri')
            ->will($this->returnValue($this->varienHttpClient));
        $this->varienHttpClient
            ->expects($this->any())
            ->method('setHeaders')
            ->will($this->returnValue($this->varienHttpClient));
        $this->varienHttpClient
            ->expects($this->any())
            ->method('setRawData')
            ->will($this->returnValue($this->varienHttpClient));
        $this->varienHttpClient
            ->expects($this->any())
            ->method('setMethod')
            ->will($this->returnValue($this->varienHttpClient));
        $this->subject
            ->expects($this->any())
            ->method('_getHttpClient')
            ->will($this->returnValue($this->varienHttpClient));
    }

    public function testGetAccessTokenDoesNotRequestWhenValidationFails()
    {
        $this
            ->generateTokenRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(false));

        $this
            ->varienHttpClient
            ->expects($this->never())
            ->method('request');

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this
            ->subject
            ->getAccessToken($this->generateTokenRequest);
    }

    public function testGetRedirectUriDoesNotRequestWhenValidationFails()
    {
        $this
            ->authorizationRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(false));

        $this
            ->varienHttpClient
            ->expects($this->never())
            ->method('request');

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this
            ->subject
            ->getRedirectUri($this->authorizationRequest);
    }

    public function testGetTransactionStatusDoesNotRequestWhenValidationFails()
    {
        $this
            ->transactionStatusRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(false));

        $this
            ->varienHttpClient
            ->expects($this->never())
            ->method('request');

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this
            ->subject
            ->getTransactionStatus($this->transactionStatusRequest);
    }

    public function testReverseTransactionDoesNotRequestWhenValidationFails()
    {
        $this
            ->reverseTransactionRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(false));

        $this
            ->varienHttpClient
            ->expects($this->never())
            ->method('request');

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this
            ->subject
            ->reverseTransaction($this->reverseTransactionRequest);
    }

    public function testGetAccessTokenRequestsWhenValidationPasses()
    {
        $accessToken = 'sadf09i234lmsdf09';

        $this
            ->generateTokenRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'accessToken' => $accessToken
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(200));

        $return = $this
            ->subject
            ->getAccessToken($this->generateTokenRequest);

        $this->assertEquals(
            $accessToken,
            $return->getAccessToken()
        );
    }

    public function testGetRedirectUriRequestsWhenValidationPasses()
    {
        $authCode = 'sadf09i234lmsdf09';
        $redirectUri = 'http://google.com/redirect';

        $this
            ->authorizationRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'authCode' => $authCode,
            'redirectUrl' => $redirectUri,
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(200));

        $return = $this
            ->subject
            ->getRedirectUri($this->authorizationRequest);

        $this->assertEquals(
            $authCode,
            $return->getAuthCode()
        );

        $this->assertEquals(
            $redirectUri,
            $return->getRedirectUri()
        );
    }

    public function testGetTransactionStatusRequestsWhenValidationPasses()
    {
        $transactionMerchantTransactionId = '100002342';
        $transactionMfsTransactionId = '2398123891293';
        $transactionCreatedOn = '2017-02-02';
        $transactionStatus = 'success';
        $transactionCompletedOn = '2017-02-03';
        $masterMerchantAccount = '434376';
        $masterMerchantId = '123123';
        $merchantReference = 'Test';
        $merchantFee = '1.23';
        $merchantCurrencyCode = 'USD';
        $subscriberAccount = '5039292829';
        $subscriberCountryCode = '503';
        $subscriberCountry = 'SLV';
        $subscriberFirstName = 'John';
        $subscriberLastName = 'Doe';
        $subscriberEmail = 'johndoe@yahoo.com';
        $redirectUri = 'http://amazon.com/success';
        $callbackUri = 'http://google.com/callback';
        $language = 'spa';
        $terminalId = 'Magento';
        $exchangeRate = '1.23';
        $originPaymentAmount = '1000.32';
        $originPaymentCurrencyCode = 'ISD';
        $originPaymentTax = '12.32';
        $originPaymentFee = '5.00';
        $localPaymentAmount = '10323.34';
        $localPaymentCurrencyCode = 'USD';

        $this
            ->transactionStatusRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'Transaction' => array(
                'merchantTransactionId' => $transactionMerchantTransactionId,
                'mfsTransactionId' => $transactionMfsTransactionId,
                'createdOn' => $transactionCreatedOn,
                'status' => $transactionStatus,
                'completedOn' => $transactionCompletedOn
            ),
            'MasterMerchant' => array(
                'id' => $masterMerchantId,
                'account' => $masterMerchantAccount
            ),
            'Merchant' => array(
                'currencyCode' => $merchantCurrencyCode,
                'reference' => $merchantReference,
                'fee' => $merchantFee
            ),
            'Subscriber' => array(
                'emailId' => $subscriberEmail,
                'account' => $subscriberAccount,
                'countryCode' => $subscriberCountryCode,
                'country' => $subscriberCountry,
                'firstName' => $subscriberFirstName,
                'lastName' => $subscriberLastName
            ),
            'redirectUri' => $redirectUri,
            'callbackUri' => $callbackUri,
            'language' => $language,
            'terminalId' => $terminalId,
            'exchangeRate' => $exchangeRate,
            'OriginPayment' => array(
                'amount' => $originPaymentAmount,
                'currencyCode' => $originPaymentCurrencyCode,
                'tax' => $originPaymentTax,
                'fee' => $originPaymentFee
            ),
            'LocalPayment' => array(
                'amount' => $localPaymentAmount,
                'currencyCode' => $localPaymentCurrencyCode
            )
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(200));

        $return = $this
            ->subject
            ->getTransactionStatus($this->transactionStatusRequest);

        $this->assertEquals(
            $transactionMerchantTransactionId,
            $return->getTransactionMerchantTransactionId()
        );

        $this->assertEquals(
            $transactionMfsTransactionId,
            $return->getTransactionMfsTransactionId()
        );

        $this->assertEquals(
            $transactionCreatedOn,
            $return->getTransactionCreatedOn()
        );

        $this->assertEquals(
            $transactionStatus,
            $return->getTransactionStatus()
        );

        $this->assertEquals(
            $transactionCompletedOn,
            $return->getTransactionCompletedOn()
        );

        $this->assertEquals(
            $masterMerchantAccount,
            $return->getMasterMerchantAccount()
        );

        $this->assertEquals(
            $masterMerchantId,
            $return->getMasterMerchantId()
        );

        $this->assertEquals(
            $merchantReference,
            $return->getMerchantReference()
        );

        $this->assertEquals(
            $merchantFee,
            $return->getMerchantFee()
        );

        $this->assertEquals(
            $merchantCurrencyCode,
            $return->getMerchantCurrencyCode()
        );

        $this->assertEquals(
            $subscriberAccount,
            $return->getSubscriberAccount()
        );

        $this->assertEquals(
            $subscriberCountryCode,
            $return->getSubscriberCountryCode()
        );

        $this->assertEquals(
            $subscriberFirstName,
            $return->getSubscriberFirstName()
        );

        $this->assertEquals(
            $subscriberLastName,
            $return->getSubscriberLastName()
        );

        $this->assertEquals(
            $subscriberEmail,
            $return->getSubscriberEmail()
        );

        $this->assertEquals(
            $subscriberCountry,
            $return->getSubscriberCountry()
        );

        $this->assertEquals(
            $redirectUri,
            $return->getRedirectUri()
        );

        $this->assertEquals(
            $callbackUri,
            $return->getCallbackUrl()
        );

        $this->assertEquals(
            $language,
            $return->getLanguage()
        );

        $this->assertEquals(
            $terminalId,
            $return->getTerminalId()
        );

        $this->assertEquals(
            $exchangeRate,
            $return->getExchangeRate()
        );

        $this->assertEquals(
            $originPaymentAmount,
            $return->getOriginPaymentAmount()
        );

        $this->assertEquals(
            $originPaymentCurrencyCode,
            $return->getOriginPaymentCurrencyCode()
        );

        $this->assertEquals(
            $originPaymentTax,
            $return->getOriginPaymentTax()
        );

        $this->assertEquals(
            $originPaymentFee,
            $return->getOriginPaymentFee()
        );

        $this->assertEquals(
            $localPaymentAmount,
            $return->getLocalPaymentAmount()
        );

        $this->assertEquals(
            $localPaymentCurrencyCode,
            $return->getLocalPaymentCurrencyCode()
        );
    }


    public function testReverseTransactionRequestsWhenValidationPasses()
    {
        $status = 'success';
        $transactionMerchantTransactionId = '10009382';
        $transactionCorrelationId = '00930930.039093093.090909309';
        $transactionMfsTransactionId = '234209283092';
        $transactionMfsReverseTransactionId = '39393939393';
        $transactionStatus = 'failed';
        $transactionMessage = 'The transaction failed';

        $this
            ->reverseTransactionRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'status' => $status,
            'Transaction' => array(
                'merchantTransactionId' => $transactionMerchantTransactionId,
                'correlationId' => $transactionCorrelationId,
                'mfsTransactionId' => $transactionMfsTransactionId,
                'mfsReverseTransactionId' => $transactionMfsReverseTransactionId,
                'status' => $transactionStatus,
                'message' => $transactionMessage
            )
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(200));

        $return = $this
            ->subject
            ->reverseTransaction($this->reverseTransactionRequest);

        $this->assertEquals(
            $status,
            $return->getStatus()
        );

        $this->assertEquals(
            $transactionMerchantTransactionId,
            $return->getTransactionMerchantTransactionId()
        );

        $this->assertEquals(
            $transactionCorrelationId,
            $return->getTransactionCorrelationId()
        );

        $this->assertEquals(
            $transactionMfsTransactionId,
            $return->getTransactionMfsTransactionId()
        );

        $this->assertEquals(
            $transactionStatus,
            $return->getTransactionStatus()
        );

        $this->assertEquals(
            $transactionMessage,
            $return->getTransactionMessage()
        );

        $this->assertEquals(
            $transactionMfsReverseTransactionId,
            $return->getTransactionMfsReverseTransactionId()
        );
    }

    public function testGetAccessTokenRequestsWhenValidationPassesAndReturnsErrorWhenRequestFails()
    {
        $errorDescription = 'An error occurred';

        $this
            ->generateTokenRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'error_description' => $errorDescription
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(503));

        $return = $this
            ->subject
            ->getAccessToken($this->generateTokenRequest);

        $this->assertContains(
            $errorDescription,
            $return->getErrors()
        );
    }

    public function testGetRedirectUriRequestsWhenValidationPassesAndReturnsErrorWhenRequestFails()
    {
        $errorDescription = 'An error occurred';

        $this
            ->authorizationRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'error_description' => $errorDescription
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(503));

        $return = $this
            ->subject
            ->getRedirectUri($this->authorizationRequest);

        $this->assertContains(
            $errorDescription,
            $return->getErrors()
        );
    }

    public function testGetTransactionStatusRequestsWhenValidationPassesAndReturnsErrorWhenRequestFails()
    {
        $errorDescription = 'An error occurred';

        $this
            ->transactionStatusRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'error_description' => $errorDescription
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(503));

        $return = $this
            ->subject
            ->getTransactionStatus($this->transactionStatusRequest);

        $this->assertContains(
            $errorDescription,
            $return->getErrors()
        );
    }

    public function testReverseTransactionRequestsWhenValidationPassesAndReturnsErrorWhenRequestFails()
    {
        $status = 'failure';
        $transactionMerchantTransactionId = '10009382';
        $transactionCorrelationId = '00930930.039093093.090909309';
        $transactionMfsTransactionId = '234209283092';
        $transactionStatus = 'failed';
        $transactionMessage = 'The transaction failed';
        $errorType = 'Warning';
        $error = '123';
        $errorDescription = 'Could not connect to the database';

        $this
            ->reverseTransactionRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'status' => $status,
            'Transaction' => array(
                'merchantTransactionId' => $transactionMerchantTransactionId,
                'correlationId' => $transactionCorrelationId,
                'mfsTransactionId' => $transactionMfsTransactionId,
                'status' => $transactionStatus,
                'message' => $transactionMessage
            ),
            'error' => $error,
            'error_type' => $errorType,
            'error_description' => $errorDescription
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(503));

        $return = $this
            ->subject
            ->reverseTransaction($this->reverseTransactionRequest);

        $this->assertContains(
            $errorDescription,
            $return->getErrors()
        );

        $this->assertEquals(
            $status,
            $return->getStatus()
        );

        $this->assertEquals(
            $transactionMerchantTransactionId,
            $return->getTransactionMerchantTransactionId()
        );

        $this->assertEquals(
            $transactionCorrelationId,
            $return->getTransactionCorrelationId()
        );

        $this->assertEquals(
            $transactionMfsTransactionId,
            $return->getTransactionMfsTransactionId()
        );

        $this->assertEquals(
            $transactionStatus,
            $return->getTransactionStatus()
        );

        $this->assertEquals(
            $transactionMessage,
            $return->getTransactionMessage()
        );

        $this->assertEquals(
            $errorType,
            $return->getErrorType()
        );

        $this->assertEquals(
            $error,
            $return->getError()
        );
    }

    /**
     * @loadFixture testModeOn
     */
    public function testApiUsesSandboxUrlWhenTestModeOn()
    {
        $this
            ->generateTokenRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'accessToken' => 'lslsl2r23jrn'
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(200));

        $this
            ->varienHttpClient
            ->expects($this->once())
            ->method('setUri')
            ->with($this->callback(function($endpoint) {
                return (
                    strpos(
                        trim($endpoint),
                        Tigo_TigoMoney_Model_Payment_Redirect_Api::TEST_ENVIRONMENT_DOMAIN
                    ) === 0
                );
            }));

        $this
            ->subject
            ->getAccessToken($this->generateTokenRequest);
    }

    /**
     * @loadFixture testModeOff
     */
    public function testApiUsesProductionUrlWhenTestModeOff()
    {
        $this
            ->generateTokenRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'accessToken' => 'lslsl2r23jrn'
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(200));

        $this
            ->varienHttpClient
            ->expects($this->once())
            ->method('setUri')
            ->with($this->callback(function($endpoint) {
                return (
                    strpos(
                        trim($endpoint),
                        Tigo_TigoMoney_Model_Payment_Redirect_Api::PROD_ENVIRONMENT_DOMAIN
                    ) === 0
                );
            }));

        $this
            ->subject
            ->getAccessToken($this->generateTokenRequest);
    }

    /**
     * @loadFixture testModeOff
     */
    public function testFetchResponseValueReturnsNullWhenKeyAndSubkeyNotFound()
    {
        $this
            ->transactionStatusRequest
            ->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->varienHttpClient
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->zendHttpResponse));

        $response = array(
            'Transaction' => array(
                'merchantTransactionId' => 'exists',
            ),
            'redirectUri' => 'exists2'
        );

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue(json_encode($response)));

        $this
            ->zendHttpResponse
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(200));

        $return = $this
            ->subject
            ->getTransactionStatus($this->transactionStatusRequest);

        $this->assertEmpty(
            $return->getOriginPaymentCurrencyCode()
        );

        $this->assertEmpty(
            $return->getCallbackUrl()
        );

        $this->assertNotNull(
            $return->getRedirectUri()
        );

        $this->assertNotNull(
            $return->getTransactionMerchantTransactionId()
        );
    }
}

