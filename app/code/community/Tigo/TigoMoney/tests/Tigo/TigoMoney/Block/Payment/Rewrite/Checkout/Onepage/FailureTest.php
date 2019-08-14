<?php

/**
 * Class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_FailureTest
 */
class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_FailureTest extends EcomDev_PHPUnit_Test_Case
{
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
     * @var Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Failure|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Failure::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('getRealOrderId'))
            ->getMock();


        $this->dataHelper = $this
            ->getHelperMock(
                'tigo_tigomoney/data',
                array('getFailureContinueShoppingUrl')
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
                array('nonExistentMethod')
            );
        $this->order = $this
            ->getModelMock(
                'sales/order',
                array('loadByIncrementId', 'getPayment')
            );
        $this->order
            ->expects($this->any())
            ->method('getPayment')
            ->will($this->returnValue($this->payment));
        $this->replaceByMock('model', 'sales/order', $this->order);

    }

    public function testFailureUrlIsChangedWhenOrderIsTigoMoneyAndFailureContinueShoppingUrlNotEmpty()
    {
        $orderIncrementId = '1000000232';
        $failureContinueShoppingUrl = 'http://nasa.gov/';

        $this
            ->payment
            ->setMethod(Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE);

        $this
            ->subject
            ->expects($this->once())
            ->method('getRealOrderId')
            ->will($this->returnValue($orderIncrementId));

        $this
            ->order
            ->expects($this->once())
            ->method('loadByIncrementId')
            ->with($orderIncrementId)
            ->will($this->returnValue($this->order));

        $this
            ->dataHelper
            ->expects($this->atLeastOnce())
            ->method('getFailureContinueShoppingUrl')
            ->will($this->returnValue($failureContinueShoppingUrl));

        $this->assertEquals($failureContinueShoppingUrl, $this->subject->getContinueShoppingUrl());
    }

    public function testFailureUrlDoesNotChangeWhenOrderIsNotTigoMoney()
    {
        $orderIncrementId = '1000000232';
        $failureContinueShoppingUrl = Mage::getModel('core/url')->getUrl('checkout/cart');

        $this
            ->payment
            ->setMethod('checkmo');

        $this
            ->subject
            ->expects($this->once())
            ->method('getRealOrderId')
            ->will($this->returnValue($orderIncrementId));

        $this
            ->order
            ->expects($this->once())
            ->method('loadByIncrementId')
            ->with($orderIncrementId)
            ->will($this->returnValue($this->order));

        $this
            ->dataHelper
            ->expects($this->never())
            ->method('getFailureContinueShoppingUrl');

        $this->assertEquals($failureContinueShoppingUrl, $this->subject->getContinueShoppingUrl());
    }

    public function testFailureUrlDoesNotChangeWhenContinueShoppingFailureUrlEmpty()
    {
        $orderIncrementId = '1000000232';
        $configFailureContinueShoppingUrl = '';
        $failureContinueShoppingUrl = Mage::getModel('core/url')->getUrl('checkout/cart');

        $this
            ->payment
            ->setMethod(Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE);

        $this
            ->subject
            ->expects($this->once())
            ->method('getRealOrderId')
            ->will($this->returnValue($orderIncrementId));

        $this
            ->order
            ->expects($this->once())
            ->method('loadByIncrementId')
            ->with($orderIncrementId)
            ->will($this->returnValue($this->order));

        $this
            ->dataHelper
            ->expects($this->atLeastOnce())
            ->method('getFailureContinueShoppingUrl')
            ->will($this->returnValue($configFailureContinueShoppingUrl));

        $this->assertEquals($failureContinueShoppingUrl, $this->subject->getContinueShoppingUrl());
    }
}

