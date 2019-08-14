<?php

/**
 * Class Tigo_TigoMoney_Adminhtml_Tigomoney_OrderControllerTest
 */
class Tigo_TigoMoney_Adminhtml_Tigomoney_OrderControllerTest extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @var Mage_Adminhtml_Model_Session|PHPUnit_Framework_MockObject_MockObject
     */
    protected $adminhtmlSession = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject
     */
    protected $sync = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        parent::setUp();

        $this->mockAdminUserSession();

        $this->adminhtmlSession = $this
            ->getMockBuilder(Mage_Adminhtml_Model_Session::class)
            ->setMethods(array('addError'))
            ->getMock();
        $this->replaceByMock('singleton', 'adminhtml/session', $this->adminhtmlSession);

        $this->sync = $this
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Sync::class)
            ->setMethods(array('syncOrder'))
            ->getMock();
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_sync', $this->sync);

        $this->order = $this
            ->getMockBuilder(Mage_Sales_Model_Order::class)
            ->setMethods(array('getId'))
            ->getMock();

        $this->replaceByMock('model', 'sales/order', $this->order);

    }

    /**
     * @loadFixture default
     */
    public function testSyncActionAddsErrorRedirectsToOrderViewOnNoOrderSpecified()
    {
        $params = array();
        $referer = $this->getUrlModel('adminhtml/sales_order/view', $params)->getUrl('adminhtml/sales_order/view');
        $this->getRequest()->setMethod('GET');
        $this->getRequest()->setParam(Mage_Core_Controller_Varien_Action::PARAM_NAME_REFERER_URL, $referer);

        $this
            ->order
            ->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(null));

        $this
            ->adminhtmlSession
            ->expects($this->once())
            ->method('addError');

        $this->dispatch('adminhtml/tigomoney_order/sync');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($referer);
    }

    /**
     * @loadFixture default
     */
    public function testSyncActionAddsErrorRedirectsToOrderViewOnSpecifiedOrderDoesntExist()
    {
        $params = array();
        $referer = $this->getUrlModel('adminhtml/sales_order/view', $params)->getUrl('adminhtml/sales_order/view');
        $orderId = 123123;

        $this->getRequest()->setMethod('GET');
        $this->getRequest()->setParam(Mage_Core_Controller_Varien_Action::PARAM_NAME_REFERER_URL, $referer);
        $this->getRequest()->setParam('order_id', $orderId);

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(null));

        $this
            ->adminhtmlSession
            ->expects($this->once())
            ->method('addError');

        $this->dispatch('adminhtml/tigomoney_order/sync');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($referer);
    }

    /**
     * @loadFixture default
     */
    public function testSyncActionCallsSyncOrderRedirectsToGrid()
    {
        $params = array();
        $referer = $this->getUrlModel('adminhtml/sales_order/view', $params)->getUrl('adminhtml/sales_order/view');
        $orderId = 123123;

        $this->getRequest()->setMethod('GET');
        $this->getRequest()->setParam(Mage_Core_Controller_Varien_Action::PARAM_NAME_REFERER_URL, $referer);
        $this->getRequest()->setParam('order_id', $orderId);

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->sync
            ->expects($this->once())
            ->method('syncOrder')
            ->with($this->order);

        $this->dispatch('adminhtml/tigomoney_order/sync');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($referer);
    }

    /**
     * @loadFixture default
     */
    public function testSyncActionCallsSyncOrderReceivesExceptionAddsErrorRedirectsToGrid()
    {
        $params = array();
        $referer = $this->getUrlModel('adminhtml/sales_order/view', $params)->getUrl('adminhtml/sales_order/view');
        $orderId = 123123;

        $this->getRequest()->setMethod('GET');
        $this->getRequest()->setParam(Mage_Core_Controller_Varien_Action::PARAM_NAME_REFERER_URL, $referer);
        $this->getRequest()->setParam('order_id', $orderId);

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->sync
            ->expects($this->once())
            ->method('syncOrder')
            ->with($this->order)
            ->will($this->throwException(new Mage_Core_Exception));

        $this->dispatch('adminhtml/tigomoney_order/sync');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($referer);
    }
}

