<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_SyncTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_SyncTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api|PHPUnit_Framework_MockObject_MockObject
     */
    protected $api = null;

    /**
     * @var Mage_Core_Model_Resource_Transaction|PHPUnit_Framework_MockObject_MockObject
     */
    protected $coreResourceTransaction = null;

    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $generateAccessTokenRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $generateAccessTokenResponse = null;

    /**
     * @var Mage_Sales_Model_Order_Invoice|PHPUnit_Framework_MockObject_MockObject
     */
    protected $invoice = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Mage_Sales_Model_Order_Payment|PHPUnit_Framework_MockObject_MockObject
     */
    protected $payment = null;

    /**
     * @var array
     */
    protected $requestParams = array();

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $transactionStatusRequest = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $transactionStatusResponse = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Sync::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_getResourceTransactionInstance'))
            ->getMock();

        $this->order = $this
            ->getMockBuilder(Mage_Sales_Model_Order::class)
            ->setMethods(array('loadByIncrementId', 'canCancel', 'cancel', 'prepareInvoice', 'canInvoice', 'save', 'getPayment'))
            ->getMock();
        $this->replaceByMock('model', 'sales/order', $this->order);

        $this->payment = $this
            ->getMockBuilder(Mage_Sales_Model_Order_Payment::class)
            ->setMethods(array('save'))
            ->getMock();
        $this->order
            ->expects($this->any())
            ->method('getPayment')
            ->will($this->returnValue($this->payment));

        $this->invoice = $this
            ->getMockBuilder(Mage_Sales_Model_Order_Invoice::class)
            ->setMethods(array('setRequestedCaptureCase', 'register'))
            ->getMock();

        $this->generateAccessTokenResponse = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse::class)
            ->setMethods(array('isSuccess'))
            ->setConstructorArgs(array(new Varien_Object()))
            ->getMock();
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_api_generateTokenResponse', $this->generateAccessTokenResponse);

        $this->transactionStatusResponse = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse::class)
            ->setMethods(array('isSuccess'))
            ->setConstructorArgs(array(new Varien_Object()))
            ->getMock();
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_api_transactionStatusResponse', $this->transactionStatusResponse);

        $this->generateAccessTokenRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest::class)
            ->setMethods(array('getAccessToken'))
            ->getMock();
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_api_generateTokenRequest', $this->generateAccessTokenRequest);

        $this->transactionStatusRequest = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::class)
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_api_transactionStatusRequest', $this->transactionStatusRequest);

        $this->api = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Api::class)
            ->setMethods(array('getAccessToken', 'getTransactionStatus'))
            ->getMock();
        $this->api
            ->expects($this->any())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));
        $this->api
            ->expects($this->any())
            ->method('getTransactionStatus')
            ->will($this->returnValue($this->transactionStatusResponse));
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_api', $this->api);

        $this->coreResourceTransaction = $this
            ->getMockBuilder(Mage_Core_Model_Resource_Transaction::class)
            ->setMethods(array('addObject', 'save'))
            ->getMock();
        $this
            ->subject
            ->expects($this->any())
            ->method('_getResourceTransactionInstance')
            ->will($this->returnValue($this->coreResourceTransaction));
    }

    protected function _getRequestParams(
        $merchantTransactionId = null,
        $mfsTransactionId = null,
        $transactionCode = null,
        $transactionDescription = null,
        $transactionStatus = null,
        $accessToken = null
    )
    {
        return array(
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MERCHANT_TRANSACTION_ID => $merchantTransactionId,
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MFS_TRANSACTION_ID => $mfsTransactionId,
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_CODE => $transactionCode,
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_DESCRIPTION => $transactionDescription,
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_STATUS => $transactionStatus,
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MERCHANT_ACCESS_TOKEN => $accessToken,
        );
    }

    public function testHandleRequestDoesNotFindOrder()
    {
        $this
            ->order
            ->expects($this->any())
            ->method('load')
            ->with(null)
            ->will($this->returnValue($this->order));
        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(null));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel');

        $this
            ->order
            ->expects($this->never())
            ->method('invoice');

        $this
            ->order
            ->expects($this->never())
            ->method('save');

        $this->subject->handleRequest($this->_getRequestParams());
    }

    public function testHandleRequestInvoiceOrder()
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $orderBaseGrandTotal = 2323.34;
        $mfsTransactionId = '324234234';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Paid';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS;
        $accessTokenForTransactionStatus = 'oiusdofiuasodifu';

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->setBaseGrandTotal($orderBaseGrandTotal);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel');

        $this
            ->order
            ->expects($this->once())
            ->method('canInvoice')
            ->will($this->returnValue(true));

        $this
            ->order
            ->expects($this->once())
            ->method('prepareInvoice')
            ->will($this->returnValue($this->invoice));

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->invoice
            ->expects($this->once())
            ->method('setRequestedCaptureCase')
            ->with(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE)
            ->will($this->returnValue($this->invoice));

        $this
            ->invoice
            ->expects($this->once())
            ->method('register');

        $this
            ->coreResourceTransaction
            ->expects($this->exactly(2))
            ->method('addObject')
            ->with(
                $this->callback(
                    function ($param) {
                        $return = false;
                        if (
                            $param instanceof Mage_Sales_Model_Order ||
                            $param instanceof Mage_Sales_Model_Order_Invoice
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->coreResourceTransaction));

        $this
            ->coreResourceTransaction
            ->expects($this->once())
            ->method('save')
            ->will($this->returnValue($this->coreResourceTransaction));

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS);

        $this->transactionStatusResponse
            ->setTransactionMfsTransactionId($mfsTransactionId);

        $this->transactionStatusResponse
            ->setLocalPaymentAmount($orderBaseGrandTotal);

        $this
            ->transactionStatusResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessTokenForTransactionStatus, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessTokenForTransactionStatus) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));

        $return = $this->subject->handleRequest($requestParams);

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID),
            $mfsTransactionId
        );

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_CODE),
            $transactionCode
        );

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_DESCRIPTION),
            $transactionDescription
        );

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_STATUS),
            $transactionStatus
        );

        $this->assertTrue($return);
    }

    public function testHandleRequestDoesRequestTransactionInfoWhenGenerateAccessTokenCallFails()
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $mfsTransactionId = '324234234';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Paid';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS;
        $accessTokenForTransactionStatus = null;

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->api
            ->expects($this->never())
            ->method('getTransactionStatus');

        $this
            ->order
            ->expects($this->never())
            ->method('cancel');

        $this
            ->order
            ->expects($this->never())
            ->method('canInvoice');

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this->assertFalse($this->subject->handleRequest($requestParams));
    }

    public function testHandleRequestDoesRequestTransactionInfoWhenTransactionStatusCallFails()
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $mfsTransactionId = '324234234';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Paid';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS;
        $accessTokenForTransactionStatus = null;

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessTokenForTransactionStatus, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessTokenForTransactionStatus) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));

        $this
            ->transactionStatusResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel');

        $this
            ->order
            ->expects($this->never())
            ->method('canInvoice');

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this->assertFalse($this->subject->handleRequest($requestParams));
    }

    public function testHandleRequestDoesNotInvoiceOrderWhenRequestDataInvalidDataProvider()
    {
        return array(
            array('234234234', 'success', '8373.93', 'wrong', 'success', '8373.93'),
            array('234234234', 'success', '8373.93', '234234234', 'wrong', '8373.93'),
            array('234234234', 'success', '8373.93', '234234234', 'success', '10000.93'),
        );
    }

    /**
     * @param $mfsTransactionId
     * @param $transactionStatus
     * @param $orderBaseGrandTotal
     * @param $transactionStatusResponseStatus
     * @param $transactionStatusResponseMfsTransactionIdResponse
     * @param $transactionStatusResponseOrderBaseGrandTotal
     * @dataProvider testHandleRequestDoesNotInvoiceOrderWhenRequestDataInvalidDataProvider
     */
    public function testHandleRequestDoesNotInvoiceOrderWhenRequestDataInvalid(
        $mfsTransactionId,
        $transactionStatus,
        $orderBaseGrandTotal,
        $transactionStatusResponseStatus,
        $transactionStatusResponseMfsTransactionIdResponse,
        $transactionStatusResponseOrderBaseGrandTotal
    )
    {

        $orderId = 233;
        $orderIncrementId = '10000233';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Paid';
        $accessTokenForTransactionStatus = 'oiusdofiuasodifu';

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->setBaseGrandTotal($orderBaseGrandTotal);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->transactionStatusResponse
            ->setTransactionStatus($transactionStatusResponseStatus);

        $this->transactionStatusResponse
            ->setTransactionMfsTransactionId($transactionStatusResponseMfsTransactionIdResponse);

        $this->transactionStatusResponse
            ->setLocalPaymentAmount($transactionStatusResponseOrderBaseGrandTotal);

        $this
            ->transactionStatusResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessTokenForTransactionStatus, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessTokenForTransactionStatus) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));


        $this
            ->order
            ->expects($this->never())
            ->method('cancel');

        $this
            ->order
            ->expects($this->never())
            ->method('canInvoice');

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this->assertFalse($this->subject->handleRequest($requestParams));
    }

    public function testHandleRequestDoesNotInvoiceOrderWhenOrderCanInvoiceIsFalse()
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $orderBaseGrandTotal = 2323.34;
        $mfsTransactionId = '324234234';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Paid';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS;
        $accessTokenForTransactionStatus = 'oiusdofiuasodifu';

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->setBaseGrandTotal($orderBaseGrandTotal);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel');

        $this
            ->order
            ->expects($this->once())
            ->method('canInvoice')
            ->will($this->returnValue(false));

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->invoice
            ->expects($this->never())
            ->method('setRequestedCaptureCase');

        $this
            ->invoice
            ->expects($this->never())
            ->method('register');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('addObject');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS);

        $this->transactionStatusResponse
            ->setTransactionMfsTransactionId($mfsTransactionId);

        $this->transactionStatusResponse
            ->setLocalPaymentAmount($orderBaseGrandTotal);

        $this
            ->transactionStatusResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessTokenForTransactionStatus, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessTokenForTransactionStatus) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));

        $this->assertTrue(
            $this->subject->handleRequest($requestParams)
        );
    }

    public function testHandleRequestCancelOrderDataProvider()
    {
        return array(
            array(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_FAILURE),
            array(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_CANCEL),
        );
    }

    /**
     * @param $status
     * @dataProvider testHandleRequestCancelOrderDataProvider
     */
    public function testHandleRequestCancelOrder($status)
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $orderBaseGrandTotal = 2323.34;
        $mfsTransactionId = '324234234';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Pending';
        $transactionStatus = $status;
        $accessTokenForTransactionStatus = 'oiusdofiuasodifu';

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->setBaseGrandTotal($orderBaseGrandTotal);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->once())
            ->method('canCancel')
            ->will($this->returnValue(true));

        $this
            ->order
            ->expects($this->once())
            ->method('cancel')
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->once())
            ->method('save');

        $this
            ->order
            ->expects($this->never())
            ->method('canInvoice');

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->invoice
            ->expects($this->never())
            ->method('setRequestedCaptureCase');

        $this
            ->invoice
            ->expects($this->never())
            ->method('register');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('addObject');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_FAILURE);

        $this->transactionStatusResponse
            ->setTransactionMfsTransactionId($mfsTransactionId);

        $this->transactionStatusResponse
            ->setLocalPaymentAmount($orderBaseGrandTotal);

        $this
            ->transactionStatusResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessTokenForTransactionStatus, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessTokenForTransactionStatus) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));

        $return = $this->subject->handleRequest($requestParams);

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID),
            $mfsTransactionId
        );

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_CODE),
            $transactionCode
        );

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_DESCRIPTION),
            $transactionDescription
        );

        $this->assertEquals(
            $this
                ->payment
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_STATUS),
            $transactionStatus
        );

        $this->assertFalse($return);
    }

    public function testHandleRequestDoesNotCancelOrderWhenRequestDataInvalidDataProvider()
    {
        return array(
            array('234234234', 'failure', '8373.93', 'wrong', 'failure', '8373.93'),
            array('234234234', 'failure', '8373.93', '234234234', 'initiated', '8373.93'),
            array('234234234', 'failure', '8373.93', '234234234', 'failure', '10000.93'),
        );
    }

    /**
     * @param $mfsTransactionId
     * @param $transactionStatus
     * @param $orderBaseGrandTotal
     * @param $transactionStatusResponseStatus
     * @param $transactionStatusResponseMfsTransactionIdResponse
     * @param $transactionStatusResponseOrderBaseGrandTotal
     * @dataProvider testHandleRequestDoesNotCancelOrderWhenRequestDataInvalidDataProvider
     */
    public function testHandleRequestDoesNotCancelOrderWhenRequestDataInvalid(
        $mfsTransactionId,
        $transactionStatus,
        $orderBaseGrandTotal,
        $transactionStatusResponseStatus,
        $transactionStatusResponseMfsTransactionIdResponse,
        $transactionStatusResponseOrderBaseGrandTotal
    )
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Pending';
        $accessTokenForTransactionStatus = 'oiusdofiuasodifu';

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->setBaseGrandTotal($orderBaseGrandTotal);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('canCancel')
            ->will($this->returnValue(true));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel')
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('save');

        $this
            ->order
            ->expects($this->never())
            ->method('canInvoice');

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->invoice
            ->expects($this->never())
            ->method('setRequestedCaptureCase');

        $this
            ->invoice
            ->expects($this->never())
            ->method('register');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('addObject');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this->transactionStatusResponse
            ->setTransactionStatus($transactionStatusResponseStatus);

        $this->transactionStatusResponse
            ->setTransactionMfsTransactionId($transactionStatusResponseMfsTransactionIdResponse);

        $this->transactionStatusResponse
            ->setLocalPaymentAmount($transactionStatusResponseOrderBaseGrandTotal);

        $this
            ->transactionStatusResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessTokenForTransactionStatus, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessTokenForTransactionStatus) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));

        $this->subject->handleRequest($requestParams);
    }

    public function testHandleRequestCancelOrderDoesNotCancelWhenGenerateTokenRequestFails()
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $orderBaseGrandTotal = 2323.34;
        $mfsTransactionId = '324234234';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Pending';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_FAILURE;
        $accessTokenForTransactionStatus = 'oiusdofiuasodifu';

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->setBaseGrandTotal($orderBaseGrandTotal);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('canCancel')
            ->will($this->returnValue(true));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel')
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('save');

        $this
            ->order
            ->expects($this->never())
            ->method('canInvoice');

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->invoice
            ->expects($this->never())
            ->method('setRequestedCaptureCase');

        $this
            ->invoice
            ->expects($this->never())
            ->method('register');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('addObject');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->transactionStatusResponse
            ->expects($this->never())
            ->method('isSuccess');

        $this
            ->api
            ->expects($this->never())
            ->method('getTransactionStatus');

        $this->subject->handleRequest($requestParams);
    }

    public function testHandleRequestCancelOrderDoesNotCancelWhenTransactionStatusRequestFails()
    {
        $orderId = 233;
        $orderIncrementId = '10000233';
        $orderBaseGrandTotal = 2323.34;
        $mfsTransactionId = '324234234';
        $transactionCode = '09203920394.2930429304.2039402394';
        $transactionDescription = 'Pending';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_FAILURE;
        $accessTokenForTransactionStatus = 'oiusdofiuasodifu';

        $requestParams = $this->_getRequestParams(
            $orderId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $this
            ->order
            ->setId($orderId);

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->order
            ->setBaseGrandTotal($orderBaseGrandTotal);

        $this
            ->order
            ->expects($this->any())
            ->method('loadByIncrementId')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('canCancel')
            ->will($this->returnValue(true));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel')
            ->will($this->returnValue($this->order));

        $this
            ->order
            ->expects($this->never())
            ->method('save');

        $this
            ->order
            ->expects($this->never())
            ->method('canInvoice');

        $this
            ->order
            ->expects($this->never())
            ->method('prepareInvoice');

        $this
            ->payment
            ->expects($this->once())
            ->method('save');

        $this
            ->invoice
            ->expects($this->never())
            ->method('setRequestedCaptureCase');

        $this
            ->invoice
            ->expects($this->never())
            ->method('register');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('addObject');

        $this
            ->coreResourceTransaction
            ->expects($this->never())
            ->method('save');

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessTokenForTransactionStatus);

        $this
            ->generateAccessTokenResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->transactionStatusResponse
            ->expects($this->any())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessTokenForTransactionStatus, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessTokenForTransactionStatus) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));

        $this->subject->handleRequest($requestParams);
    }

    public function testSyncOrderCreatesInvoiceWhenTransactionStatusSuccess()
    {
        $accessToken = 'maslkmsdalkfmsdf';

        /**
         * Invoice and cancel methods have been extensively tested in the previos methods
         * We'll skip them to keep this test simpler
         */
        /** @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject $subject */
        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_createInvoice', '_cancelOrder'))
            ->getMock();

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));

        $this
            ->generateAccessTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS);

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->will($this->returnValue($this->transactionStatusResponse));

        $this
            ->transactionStatusResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $subject
            ->expects($this->once())
            ->method('_createInvoice')
            ->with($this->order);

        $subject->syncOrder($this->order);
    }

    public function testSyncOrderCancelsOrderWhenTransactionStatusFailure()
    {
        $accessToken = 'maslkmsdalkfmsdf';

        /**
         * Invoice and cancel methods have been extensively tested in the previous methods
         * We'll skip them to keep this test simpler
         */
        /** @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject $subject */
        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_createInvoice', '_cancelOrder'))
            ->getMock();

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));

        $this
            ->generateAccessTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_FAILURE);

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->will($this->returnValue($this->transactionStatusResponse));

        $this
            ->transactionStatusResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $subject
            ->expects($this->once())
            ->method('_cancelOrder')
            ->with($this->order);

        $subject->syncOrder($this->order);
    }

    public function testSyncOrderCancelsOrderWhenTransactionStatusCancel()
    {
        $accessToken = 'maslkmsdalkfmsdf';

        /**
         * Invoice and cancel methods have been extensively tested in the previos methods
         * We'll skip them to keep this test simpler
         */
        /** @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject $subject */
        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_createInvoice', '_cancelOrder'))
            ->getMock();

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));

        $this
            ->generateAccessTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_CANCEL);

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->will($this->returnValue($this->transactionStatusResponse));

        $this
            ->transactionStatusResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $subject
            ->expects($this->once())
            ->method('_cancelOrder')
            ->with($this->order);

        $subject->syncOrder($this->order);
    }

    public function testSyncOrderCancelsOnlyInitiatedOrdersWhenOlderThanFiveDaysDataProvider()
    {
        $dateSixDaysAgo = date('Y-m-d h:i:s', time() - (6 * 24 * 60 * 60));
        $dateSevenDaysAgo = date('Y-m-d h:i:s', time() - (7 * 24 * 60 * 60));
        return array(
            array($dateSixDaysAgo, true),
            array($dateSevenDaysAgo, true),
        );
    }

    /**
     * @param string $orderDate
     * @param boolean $canCancelOrder
     * @dataProvider testSyncOrderCancelsOnlyInitiatedOrdersWhenOlderThanFiveDaysDataProvider
     */
    public function testSyncOrderCancelsInitiatedOrdersOlderThanFiveDays(
        $orderDate,
        $canCancelOrder
    ) {
        $accessToken = 'maslkmsdalkfmsdf';

        /**
         * Invoice and cancel methods have been extensively tested in the previous methods
         * We'll skip them to keep this test simpler
         */
        /** @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject $subject */
        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_createInvoice', '_cancelOrder'))
            ->getMock();

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));

        $this
            ->generateAccessTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_INITIATED);

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->will($this->returnValue($this->transactionStatusResponse));

        $this
            ->transactionStatusResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $subject
            ->expects($this->once())
            ->method('_cancelOrder')
            ->with($this->order);

        $this
            ->order
            ->expects($this->any())
            ->method('canCancel')
            ->will($this->returnValue($canCancelOrder));

        $this
            ->order
            ->setCreatedAt($orderDate);

        $subject->syncOrder($this->order);
    }

    public function testSyncOrderDoesNotCancelInitiatedOrdersNoOlderThanFiveDaysOrCanCancelEqualsFalseDataProvider()
    {
        $dateTwoDaysAgo = date('Y-m-d h:i:s', time() - (2 * 24 * 60 * 60));
        $dateThreeDaysAgo = date('Y-m-d h:i:s', time() - (3 * 24 * 60 * 60));
        $dateSixDaysAgo = date('Y-m-d h:i:s', time() - (6 * 24 * 60 * 60));
        $dateSevenDaysAgo = date('Y-m-d h:i:s', time() - (7 * 24 * 60 * 60));
        return array(
            array($dateTwoDaysAgo, true),
            array($dateThreeDaysAgo, true),
            array($dateSixDaysAgo, false),
            array($dateSevenDaysAgo, false),
        );
    }

    /**
     * @param string $orderDate
     * @param boolean $canCancelOrder
     * @dataProvider testSyncOrderDoesNotCancelInitiatedOrdersNoOlderThanFiveDaysOrCanCancelEqualsFalseDataProvider
     */
    public function testSyncOrderDoesNotCancelInitiatedOrdersNoOlderThanFiveDaysOrCanCancelEqualsFalse(
        $orderDate,
        $canCancelOrder
    ) {
        $accessToken = 'maslkmsdalkfmsdf';

        /**
         * Invoice and cancel methods have been extensively tested in the previous methods
         * We'll skip them to keep this test simpler
         */
        /** @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject $subject */
        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_createInvoice'))
            ->getMock();

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));

        $this
            ->generateAccessTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->transactionStatusResponse
            ->setTransactionStatus(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_INITIATED);

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->will($this->returnValue($this->transactionStatusResponse));

        $this
            ->transactionStatusResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->order
            ->expects($this->any())
            ->method('canCancel')
            ->will($this->returnValue($canCancelOrder));

        $this
            ->order
            ->expects($this->never())
            ->method('cancel')
            ->will($this->returnValue($canCancelOrder));

        $this
            ->order
            ->setCreatedAt($orderDate);

        $subject->syncOrder($this->order);
    }

    public function testSyncOrderThrowsExceptionWhenGenerateAccessTokenRequestFails()
    {
        $accessToken = 'maslkmsdalkfmsdf';

        /**
         * Invoice and cancel methods have been extensively tested in the previos methods
         * We'll skip them to keep this test simpler
         */
        /** @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject $subject */
        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_createInvoice', '_cancelOrder'))
            ->getMock();

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));

        $this
            ->generateAccessTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->api
            ->expects($this->never())
            ->method('getTransactionStatus');

        $this
            ->transactionStatusResponse
            ->expects($this->never())
            ->method('isSuccess');

        $subject
            ->expects($this->never())
            ->method('_cancelOrder');

        $subject
            ->expects($this->never())
            ->method('_createInvoice');

        $this->setExpectedException('Mage_Core_Exception');

        $subject->syncOrder($this->order);
    }

    public function testSyncOrderThrowsExceptionWhenTransactionStatusRequestFails()
    {
        $accessToken = 'maslkmsdalkfmsdf';
        $orderIncrementId = '200003982';

        /**
         * Invoice and cancel methods have been extensively tested in the previos methods
         * We'll skip them to keep this test simpler
         */
        /** @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject $subject */
        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_createInvoice', '_cancelOrder'))
            ->getMock();

        $this
            ->order
            ->setIncrementId($orderIncrementId);

        $this
            ->generateAccessTokenResponse
            ->setAccessToken($accessToken);

        $this
            ->api
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($this->generateAccessTokenResponse));

        $this
            ->generateAccessTokenResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(true));

        $this
            ->transactionStatusResponse
            ->expects($this->once())
            ->method('isSuccess')
            ->will($this->returnValue(false));

        $this
            ->api
            ->expects($this->once())
            ->method('getTransactionStatus')
            ->with(
                $this->callback(
                    function (Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest $request)
                    use ($accessToken, $orderIncrementId) {
                        $return = false;
                        if (
                            ($request->getAccessToken() == $accessToken) &&
                            ($request->getMerchantTransactionId() == $orderIncrementId)
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )
            ->will($this->returnValue($this->transactionStatusResponse));

        $subject
            ->expects($this->never())
            ->method('_cancelOrder');

        $subject
            ->expects($this->never())
            ->method('_createInvoice');

        $this->setExpectedException('Mage_Core_Exception');

        $subject->syncOrder($this->order);
    }

    public function testExtractRequestIgnoresUndefinedParameters()
    {
        $orderId = null;
        $orderIncrementId = '10000233';
        $mfsTransactionId = '324234234';
        $transactionCode = 'undefined';
        $transactionDescription = 'undefined';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_FAILURE;

        $requestParams = $this->_getRequestParams(
            $orderIncrementId,
            $mfsTransactionId,
            $transactionCode,
            $transactionDescription,
            $transactionStatus
        );

        $expectedRequestAfterParsing = new Varien_Object();
        $expectedRequestAfterParsing
            ->setData(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MERCHANT_TRANSACTION_ID, $orderIncrementId)
            ->setData(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MFS_TRANSACTION_ID, $mfsTransactionId)
            ->setData(Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_STATUS , $transactionStatus);

        $subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_loadRequestOrder'))
            ->getMock();

        $subject
            ->expects($this->once())
            ->method('_loadRequestOrder')
            ->with($expectedRequestAfterParsing)
            ->will($this->returnValue($this->order));

        $subject->handleRequest($requestParams);
    }
}

