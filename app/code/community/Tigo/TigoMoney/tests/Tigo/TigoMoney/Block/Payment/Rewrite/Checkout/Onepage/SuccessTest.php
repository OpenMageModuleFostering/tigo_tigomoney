<?php

/**
 * Class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_SuccessTest
 */
class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_SuccessTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Mage_Checkout_Model_Session|PHPUnit_Framework_MockObject_MockObject
     */
    protected $checkoutSession = null;

    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Helper_Data|PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataHelper = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Mage_Sales_Model_Order_Payment|PHPUnit_Framework_MockObject_MockObject
     */
    protected $payment = null;

    /**
     * @var Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Success|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Success::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('nonExistentMethod'))
            ->getMock();

        $this->dataHelper = $this
            ->getHelperMock(
                'tigo_tigomoney/data',
                array('getSuccessContinueShoppingUrl')
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

        $this->checkoutSession = $this
            ->getMockBuilder(Mage_Checkout_Model_Session::class)
            ->setMethods(array('getLastOrderId'))
            ->getMock();
        $this->replaceByMock(
            'singleton',
            'checkout/session',
            $this->checkoutSession
        );

        $this->payment = $this
            ->getModelMock(
                'sales/order_payment',
                array('nonExistentMethod')
            );
        $this->order = $this
            ->getModelMock(
                'sales/order',
                array('load', 'getPayment')
            );
        $this->order
            ->expects($this->any())
            ->method('getPayment')
            ->will($this->returnValue($this->payment));
        $this->replaceByMock('model', 'sales/order', $this->order);

    }

    public function testSuccessUrlIsChangedWhenOrderIsTigoMoneyAndSuccessContinueShoppingUrlNotEmpty()
    {
        $orderId = '234';
        $successContinueShoppingUrl = 'http://nasa.gov/';

        $this
            ->payment
            ->setMethod(Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE);

        $this
            ->checkoutSession
            ->expects($this->once())
            ->method('getLastOrderId')
            ->will($this->returnValue($orderId));

        $this
            ->order
            ->expects($this->once())
            ->method('load')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->dataHelper
            ->expects($this->atLeastOnce())
            ->method('getSuccessContinueShoppingUrl')
            ->will($this->returnValue($successContinueShoppingUrl));

        $this->assertEquals($successContinueShoppingUrl, $this->subject->getUrl());
    }

    public function testSuccessUrlDoesNotChangeWhenOrderIsNotTigoMoney()
    {

        $orderId = '234';
        $successContinueShoppingUrl = Mage::getModel('core/url')->getUrl('');

        $this
            ->payment
            ->setMethod('checkmo');

        $this
            ->checkoutSession
            ->expects($this->once())
            ->method('getLastOrderId')
            ->will($this->returnValue($orderId));

        $this
            ->order
            ->expects($this->once())
            ->method('load')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->dataHelper
            ->expects($this->never())
            ->method('getSuccessContinueShoppingUrl');

        $this->assertEquals($successContinueShoppingUrl, $this->subject->getUrl());
    }

    public function testSuccessUrlDoesNotChangeWhenContinueShoppingSuccessUrlEmpty()
    {
        $orderId = '432';
        $configSuccessContinueShoppingUrl = '';
        $successContinueShoppingUrl = Mage::getModel('core/url')->getUrl('');

        $this
            ->payment
            ->setMethod(Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE);

        $this
            ->checkoutSession
            ->expects($this->once())
            ->method('getLastOrderId')
            ->will($this->returnValue($orderId));

        $this
            ->order
            ->expects($this->once())
            ->method('load')
            ->with($orderId)
            ->will($this->returnValue($this->order));

        $this
            ->dataHelper
            ->expects($this->atLeastOnce())
            ->method('getSuccessContinueShoppingUrl')
            ->will($this->returnValue($configSuccessContinueShoppingUrl));

        $this->assertEquals($successContinueShoppingUrl, $this->subject->getUrl());
    }
}

