<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_RedirectTest
 */
class Tigo_TigoMoney_Model_Payment_RedirectTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $authorizationResponse = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $authorizationRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api|PHPUnit_Framework_MockObject_MockObject
     */
    protected $api = null;

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
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $generateTokenResponse = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Mage_Sales_Model_Order_Payment|PHPUnit_Framework_MockObject_MockObject
     */
    protected $payment = null;

    /**
     * @var Mage_Payment_Model_Info|PHPUnit_Framework_MockObject_MockObject
     */
    protected $paymentInfo = null;
    
    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder|PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestBuilder = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $reverseTransactionRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $reverseTransactionResponse = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect::class;

        $this->subject = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect',
                array('nonExistentMethod')
            );

        $this->paymentInfo = $this
            ->getModelMock(
                'payment/info',
                array('nonExistentMethod')
            );
        $this
            ->subject
            ->setInfoInstance($this->paymentInfo);

        $this->dataHelper = $this
            ->getHelperMock(
                'tigo_tigomoney/data',
                array('nonExistentMethod')
            );
        $this->replaceByMock(
            'helper',
            'tigo_tigomoney/data',
            $this->dataHelper
        );
        $this->replaceByMock(
            'helper',
            'tigo_tigomoney',
            $this->dataHelper
        );

        $this->payment = $this
            ->getModelMock(
                'sales/order_payment',
                array(
                    'save',
                    'getOrder',
                    'setAmount',
                    'setStatus',
                    'setIsTransactionPending',
                    'setIsTransactionClosed',
                    'setTransactionId',
                    'addTransaction'
                )
            );
        $this->order = $this
            ->getModelMock(
                'sales/order',
                array('save', 'getPayment')
            );
        $this->payment
            ->expects($this->any())
            ->method('getOrder')
            ->will($this->returnValue($this->order));
        $this->order
            ->expects($this->any())
            ->method('getPayment')
            ->will($this->returnValue($this->payment));

        $this->generateTokenResponse = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_generateTokenResponse',
                array('isSuccess'),
                false,
                array(new Varien_Object())
            );
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_generateTokenResponse',
            $this->generateTokenResponse
        );

        $this->authorizationResponse = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_authorizationResponse',
                array('isSuccess'),
                false,
                array(new Varien_Object())
        );
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_authorizationResponse',
            $this->authorizationResponse
        );

        $this->reverseTransactionResponse = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_reverseTransactionResponse',
                array('isSuccess'),
                false,
                array(new Varien_Object())
            );
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_reverseTransactionResponse',
            $this->reverseTransactionResponse
        );

        $this->generateTokenRequest = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_generateTokenRequest',
                array('nonExistentMethod')
            );
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_generateTokenRequest',
            $this->generateTokenRequest
        );

        $this->authorizationRequest = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_authorizationRequest',
                array('nonExistentMethod')
        );
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_authorizationRequest',
            $this->authorizationRequest
        );

        $this->reverseTransactionRequest = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_reverseTransactionRequest',
                array('nonExistentMethod')
            );
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_reverseTransactionRequest',
            $this->reverseTransactionRequest
        );

        $this->requestBuilder = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_requestBuilder',
                array('buildAuthorizationRequest', 'buildReverseTransactionRequest', 'buildGenerateAccessTokenRequest')
            );
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api_requestBuilder',
            $this->requestBuilder
        );

        $this->api = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api',
                array('getAccessToken', 'getRedirectUri', 'reverseTransaction')
            );
        $this->api
            ->expects($this->any())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateTokenResponse));
        $this->api
            ->expects($this->any())
            ->method('getRedirectUri')
            ->will($this->returnValue($this->authorizationResponse));
        $this->api
            ->expects($this->any())
            ->method('reverseTransaction')
            ->will($this->returnValue($this->reverseTransactionResponse));
        $this->replaceByMock(
            'model',
            'tigo_tigomoney/payment_redirect_api',
            $this->api
        );
    }

    public function testMethodCodeValue()
    {
        $expectedMethodCode = 'tigo_tigomoney';
        $this
            ->assertEquals(
                $this->subject->getCode(),
                $expectedMethodCode
            );
    }

    public function testAssignData()
    {
        $phoneNumber = '748372837';
        $phoneNumberDataKey = Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '_phone_number';
        $phoneNumberAdditionalInfoKey = Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_PHONE_NUMBER;
        $data = array(
            'method' => Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE,
            $phoneNumberDataKey => $phoneNumber
        );
        $dataObj = new Varien_Object($data);

        $this->subject
            ->assignData(
                $dataObj
            );

        $this->assertEquals(
            $phoneNumber,
            $this->paymentInfo->getAdditionalInformation($phoneNumberAdditionalInfoKey)
        );
    }

    public function testAssignDataNonTigoMoney()
    {
        $phoneNumber = '748372837';
        $phoneNumberDataKey = Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '_phone_number';
        $phoneNumberAdditionalInfoKey = Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_PHONE_NUMBER;
        $data = array(
            'method' => 'checkmo',
            $phoneNumberDataKey => $phoneNumber
        );
        $dataObj = new Varien_Object($data);

        $this->subject
            ->assignData(
                $dataObj
            );

        $this->assertNull(
            $this->paymentInfo->getAdditionalInformation($phoneNumberAdditionalInfoKey)
        );
    }

    public function testAssignDataWorksWithArrays()
    {
        $phoneNumber = '748372837';
        $phoneNumberDataKey = Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '_phone_number';
        $phoneNumberAdditionalInfoKey = Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_PHONE_NUMBER;
        $data = array(
            'method' => 'checkmo',
            $phoneNumberDataKey => $phoneNumber
        );

        $this->subject
            ->assignData(
                $data
            );

        $this->assertNull(
            $this->paymentInfo->getAdditionalInformation($phoneNumberAdditionalInfoKey)
        );
    }

    public function testGetOrderPlaceUrl()
    {
        $expectedUrl = $this->getModelMock(
                'core/url',
                array('nonExistendMethod')
            )
            ->getUrl('tigomoney/redirect/index', array('_secure' => true));
        $this
            ->assertEquals(
                $expectedUrl,
                $this->subject->getOrderPlaceRedirectUrl()
            );
    }

    public function testIsActiveDataProvider()
    {
        return array(
            array('123123', 'asdfasdf', '123123321', '2321', true),
            array(null, 'asdfasdf', '123123321', '2321', false),
            array('123123', null, '123123321', '2321', false),
            array('123123', 'asdfasdf', null, '2321', false),
            array('123123', 'asdfasdf', '123123321', null, false),
        );
    }

    /**
     * @param $clientId
     * @param $clientSecret
     * @param $merchantAccount
     * @param $merchantPin
     * @param $clientId
     * @param $shouldBeActive
     * @dataProvider testIsActiveDataProvider
     * @loadFixtures default
     */
    public function testIsActive(
        $clientId,
        $clientSecret,
        $merchantAccount,
        $merchantPin,
        $shouldBeActive
    ) {
        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_getDataHelper', 'getConfigData'))
            ->getMock();

        $this
            ->subject
            ->expects($this->any())
            ->method('getConfigData')
            ->will($this->returnValue(true));

        $dataHelper = $this
            ->getHelperMock('tigo_tigomoney/data');

        $this
            ->subject
            ->expects($this->any())
            ->method('_getDataHelper')
            ->will($this->returnValue($dataHelper));
        $dataHelper
            ->expects($this->any())
            ->method('getClientId')
            ->will($this->returnValue($clientId));
        $dataHelper
            ->expects($this->any())
            ->method('getClientSecret')
            ->will($this->returnValue($clientSecret));
        $dataHelper
            ->expects($this->any())
            ->method('getMerchantAccount')
            ->will($this->returnValue($merchantAccount));
        $dataHelper
            ->expects($this->any())
            ->method('getMerchantPin')
            ->will($this->returnValue($merchantPin));

        $this
            ->assertEquals(
                $shouldBeActive,
                $this->subject->isAvailable()
            );
    }

    public function testCapture() {
        $transactionId = '123123123';
        $amount = 837.93;

        /** @var Mage_Sales_Model_Order_Payment $payment */
        $payment = $this->getMockBuilder(Mage_Sales_Model_Order_Payment::class)
            ->setMethods(array('save'))
            ->getMock();

        $payment->setTransactionId($transactionId);

        $this
            ->subject
            ->capture($payment, $amount);

        $this
            ->assertEquals(
                $amount,
                $payment->getAmount()
            );

        $this
            ->assertEquals(
                Tigo_TigoMoney_Model_Payment_Redirect::STATUS_SUCCESS,
                $payment->getStatus()
            );

        $this
            ->assertEquals(
                $transactionId,
                $payment->getTransactionId()
            );

        $this
            ->assertTrue(
                $payment->getIsTransactionClosed()
            );
    }

    /**
     * @loadFixture authorize
     */
    public function testAuthorizeSuccess()
    {
        $amount = 1883.38;
        $authCode = '94949';
        $accessToken = 'kmdkmdkmd';
        $redirectUrl = 'http://google.com/redirect';

        $this
            ->generateTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->generateTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenRequest));

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildAuthorizationRequest')
            ->with($accessToken, $this->order)
            ->will($this->returnValue($this->authorizationRequest));

        $this
            ->authorizationResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->authorizationResponse
            ->setAuthCode($authCode);

        $this
            ->authorizationResponse
            ->setRedirectUri($redirectUrl);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->with($this->generateTokenRequest)
            ->will($this->returnValue($this->generateTokenResponse));

        $this
            ->api
            ->expects($this->once())
            ->method('getRedirectUri')
            ->with($this->authorizationRequest)
            ->will($this->returnValue($this->authorizationResponse));

        $this
            ->payment
            ->expects($this->once())
            ->method('setAmount')
            ->with($amount)
            ->will($this->returnValue($this->payment));

        $this
            ->payment
            ->expects($this->once())
            ->method('setStatus')
            ->with(Tigo_TigoMoney_Model_Payment_Redirect::STATUS_APPROVED)
            ->will($this->returnValue($this->payment));

        $this
            ->payment
            ->expects($this->once())
            ->method('setIsTransactionPending')
            ->with(false)
            ->will($this->returnValue($this->payment));

        $this
            ->payment
            ->expects($this->once())
            ->method('setIsTransactionClosed')
            ->with(false)
            ->will($this->returnValue($this->payment));

        $this
            ->payment
            ->expects($this->once())
            ->method('setTransactionId')
            ->with($authCode)
            ->will($this->returnValue($this->payment));

        $this
            ->payment
            ->expects($this->once())
            ->method('save')
            ->will($this->returnValue($this->payment));


        $this->assertEquals(
            $this->subject,
            $this->subject->authorize($this->payment, $amount)
        );

        $this
            ->assertEquals(
                $accessToken,
                $this->payment->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_ACCESS_TOKEN)
            );

        $this
            ->assertEquals(
                $redirectUrl,
                $this->payment->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_REDIRECT_URI)
            );

        $this
            ->assertEquals(
                $authCode,
                $this->payment->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_AUTH_CODE)
            );
    }

    /**
     * @loadFixture authorize
     */
    public function testAuthorizeAddsAuthorizationErrorsToPaymentOnAuthError()
    {
        $amount = 1883.38;
        $accessToken = 'kmdkmdkmd';

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenRequest));

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildAuthorizationRequest')
            ->with($accessToken, $this->order)
            ->will($this->returnValue($this->authorizationRequest));

        $this
            ->generateTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->generateTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->authorizationResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->authorizationResponse
            ->addError('Error 1');

        $this
            ->authorizationResponse
            ->addError('Error 2');

        $this
            ->api
            ->expects($this->once())
            ->method('getRedirectUri')
            ->will($this->returnValue($this->authorizationResponse));

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this->assertEquals(
            $this->subject,
            $this->subject->authorize($this->payment, $amount)
        );

        $this
            ->assertEquals(
                "Error 1\n Error 2",
                $this->payment->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_AUTHORIZATION_ERRORS)
            );
    }

    /**
     * @loadFixture authorize
     */
    public function testAuthorizeAddsAccessTokenErrorsToPaymentOnAccessTokenError()
    {
        $amount = 1883.38;

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenRequest));

        $this
            ->generateTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->requestBuilder
            ->expects($this->never())
            ->method('buildAuthorizationRequest');

        $this
            ->api
            ->expects($this->never())
            ->method('getRedirectUri');

        $this
            ->generateTokenResponse
            ->addError('Error 1');

        $this
            ->generateTokenResponse
            ->addError('Error 2');

        $this
            ->generateTokenResponse
            ->addError('Error 3');

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this->assertEquals(
            $this->subject,
            $this->subject->authorize($this->payment, $amount)
        );

        $this
            ->assertEquals(
                "Error 1\nError 2\nError 3",
                $this->payment->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_ACCESS_TOKEN_ERRORS)
            );
    }

    /**
     * @loadFixture refund
     */
    public function testRefundSuccess()
    {
        $amount = 783.38;
        $accessToken = 'nininini';
        $mfsReverseTransactionId = '838383';

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenRequest));

        $this
            ->generateTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->generateTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->reverseTransactionResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->reverseTransactionResponse
            ->setTransactionMfsReverseTransactionId($mfsReverseTransactionId);


        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenResponse));

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildReverseTransactionRequest')
            ->with($accessToken, $this->order)
            ->will($this->returnValue($this->reverseTransactionRequest));

        $this
            ->api
            ->expects($this->once())
            ->method('reverseTransaction')
            ->will($this->returnValue($this->reverseTransactionResponse));

        $this
            ->payment
            ->expects($this->once())
            ->method('setTransactionId')
            ->with($mfsReverseTransactionId)
            ->will($this->returnValue($this->payment));

        $this
            ->payment
            ->expects($this->once())
            ->method('addTransaction')
            ->with(Mage_Sales_Model_Order_Payment_Transaction::TYPE_REFUND)
            ->will($this->returnValue($this->payment));

        $this->assertEquals(
            $this->subject,
            $this->subject->refund($this->payment, $amount)
        );
    }

    /**
     * @loadFixture refund
     */
    public function testRefundThrowsExceptionOnReverseError()
    {
        $amount = 783.38;
        $accessToken = 'nininini';

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenRequest));

        $this
            ->generateTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->generateTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->reverseTransactionResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(false));


        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenResponse));

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildReverseTransactionRequest')
            ->with($accessToken, $this->order)
            ->will($this->returnValue($this->reverseTransactionRequest));

        $this
            ->api
            ->expects($this->once())
            ->method('reverseTransaction')
            ->will($this->returnValue($this->reverseTransactionResponse));

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this->assertEquals(
            $this->subject,
            $this->subject->refund($this->payment, $amount)
        );
    }

    /**
     * @loadFixture refund
     */
    public function testRefundThrowsExceptionOnAccessTokenError()
    {
        $amount = 783.38;

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenRequest));

        $this
            ->generateTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->requestBuilder
            ->expects($this->once())
            ->method('buildGenerateAccessTokenRequest')
            ->will($this->returnValue($this->generateTokenResponse));

        $this
            ->requestBuilder
            ->expects($this->never())
            ->method('buildReverseTransactionRequest');

        $this
            ->api
            ->expects($this->never())
            ->method('reverseTransaction');

        $this
            ->setExpectedException('Mage_Core_Exception');

        $this->assertEquals(
            $this->subject,
            $this->subject->refund($this->payment, $amount)
        );
    }
}

