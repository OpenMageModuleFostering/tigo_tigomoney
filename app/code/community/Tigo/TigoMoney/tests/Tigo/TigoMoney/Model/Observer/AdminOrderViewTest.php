<?php

/**
 * Class Tigo_TigoMoney_Model_Observer_AdminOrderViewTest
 */
class Tigo_TigoMoney_Model_Observer_AdminOrderViewTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Helper_Data
     */
    protected $dataHelper = null;

    /**
     * @var Mage_Core_Model_Observer|PHPUnit_Framework_MockObject_MockObject
     */
    protected $observer = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Mage_Sales_Model_Order_Payment|PHPUnit_Framework_MockObject_MockObject
     */
    protected $payment = null;

    /**
     * @var Mage_Adminhtml_Block_Sales_Order_View|PHPUnit_Framework_MockObject_MockObject
     */
    protected $salesOrderViewBlock = null;

    /**
     * @var Tigo_TigoMoney_Model_Observer_AdminOrderView|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Observer_AdminOrderView::class;

        $this->subject = $this
            ->getModelMock(
                'tigo_tigomoney/observer_adminOrderView',
                array('_getSalesOrderEditBlock', '_getCurrentOrder')
            );

        $this->salesOrderViewBlock = $this->getBlockMock(
            'adminhtml/sales_order_view',
            array('addButton'),
            null,
            array(),
            null,
            false
        );


        $this->payment = $this
            ->getModelMock(
                'sales/order_payment',
                array('getMethod')
            );

        $this->order = $this
            ->getModelMock(
                'sales/order',
                array('getId', 'getPayment', 'getStatus')
            );

        $this->order
            ->expects($this->any())
            ->method('getPayment')
            ->will($this->returnValue($this->payment));

        $this->replaceByMock('model', 'sales/order', $this->order);

        $this->dataHelper = $this
            ->getHelperMock(
                'tigo_tigomoney/data',
                array()
            );

        $this->replaceByMock('helper', 'tigo_tigomoney', $this->dataHelper);

        $this
            ->subject
            ->expects($this->any())
            ->method('_getCurrentOrder')
            ->will($this->returnValue($this->order));

        $this->observer = $this
            ->getModelMock(
                'core/observer',
                null
            );

        $this->replaceByMock('model', 'core/observer', $this->observer);
    }

    public function testAddSyncButtonDoesNotAddButtonWhenSalesOrderEditNotFound()
    {
        $this
            ->subject
            ->expects($this->any())
            ->method('_getSalesOrderEditBlock')
            ->will($this->returnValue(null));

        $this
            ->salesOrderViewBlock
            ->expects($this->never())
            ->method('addButton');

        $this->assertEquals(
            $this->subject,
            $this->subject->addSyncButton($this->observer)
        );
    }

    public function testAddSyncButtonDoesNotAddButtonWhenOrderHasNoId()
    {
        $orderId = null;

        $this
            ->subject
            ->expects($this->any())
            ->method('_getSalesOrderEditBlock')
            ->will($this->returnValue($this->salesOrderViewBlock));

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->salesOrderViewBlock
            ->expects($this->never())
            ->method('addButton');

        $this->assertEquals(
            $this->subject,
            $this->subject->addSyncButton($this->observer)
        );
    }

    public function testAddSyncButtonDoesNotAddButtonWhenPaymentMethodNotTigoMoney()
    {
        $orderId = 123123;
        $paymentMethod = 'checkmo';

        $this
            ->subject
            ->expects($this->any())
            ->method('_getSalesOrderEditBlock')
            ->will($this->returnValue($this->salesOrderViewBlock));

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->payment
            ->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue($paymentMethod));

        $this
            ->salesOrderViewBlock
            ->expects($this->never())
            ->method('addButton');

        $this->assertEquals(
            $this->subject,
            $this->subject->addSyncButton($this->observer)
        );
    }

    public function testAddSyncButtonDoesNotAddButtonWhenOrderStatusNotPending()
    {
        $orderId = 123123;
        $paymentMethod = Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE;
        $status = 'processing';

        $this
            ->subject
            ->expects($this->any())
            ->method('_getSalesOrderEditBlock')
            ->will($this->returnValue($this->salesOrderViewBlock));

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->payment
            ->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue($paymentMethod));

        $this
            ->order
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue($status));

        $this
            ->salesOrderViewBlock
            ->expects($this->never())
            ->method('addButton');

        $this->assertEquals(
            $this->subject,
            $this->subject->addSyncButton($this->observer)
        );
    }

    public function testAddSyncButtonAddsButtonSuccessfully()
    {
        $orderId = 123123;
        $paymentMethod = Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE;
        $status = 'pending';

        $this
            ->subject
            ->expects($this->any())
            ->method('_getSalesOrderEditBlock')
            ->will($this->returnValue($this->salesOrderViewBlock));

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->payment
            ->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue($paymentMethod));

        $this
            ->order
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue($status));

        $this
            ->salesOrderViewBlock
            ->expects($this->once())
            ->method('addButton')
            ->with(
                $this->equalTo('tigo_tigomoney_sync'),
                array(
                    'label' => $this->dataHelper->__(Tigo_TigoMoney_Model_Observer_AdminOrderView::BUTTON_LABEL),
                    'onclick' => 'setLocation(\'' . $this->dataHelper->getSyncOrderUrl($this->order) . '\')',
                    'class' => Tigo_TigoMoney_Model_Observer_AdminOrderView::BUTTON_CLASS
                )
            );

        $this->assertEquals(
            $this->subject,
            $this->subject->addSyncButton($this->observer)
        );
    }
}
