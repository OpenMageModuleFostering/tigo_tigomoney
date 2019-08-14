<?php

/**
 * Class Tigo_TigoMoney_Model_Cron_SyncRecentPendingOrdersTest
 */
class Tigo_TigoMoney_Model_Cron_SyncRecentPendingOrdersTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Tigo_TigoMoney_Model_Debug|PHPUnit_Framework_MockObject_MockObject
     */
    protected $debug = null;

    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Mage_Sales_Model_Resource_Order_Collection|PHPUnit_Framework_MockObject_MockObject
     */
    protected $orderCollection = null;

    /**
     * @var Tigo_TigoMoney_Model_Cron_SyncRecentPendingOrders|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject
     */
    protected $sync = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Cron_SyncRecentPendingOrders::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->getMock();

        $this->debug = $this->getModelMock(
            'tigo_tigomoney/debug',
            array('debug')
        );
        $this->replaceByMock('model', 'tigo_tigomoney/debug', $this->debug);


        $this->orderCollection = $this->getResourceModelMock(
            'sales/order_collection',
            array('addFieldToFilter', 'getItems')
        );
        $this->replaceByMock('resource_model', 'sales/order_collection', $this->orderCollection);


        $this->sync = $this->getModelMock(
            'tigo_tigomoney/payment_redirect_sync',
            array('syncOrder')
        );
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_sync', $this->sync);
    }

    public function testRunSyncsOnlyTigoMoneyPendingOrdersWithNoInvoicesAndNotCanceled()
    {
        $this
            ->orderCollection
            ->expects($this->exactly(3))
            ->method('addFieldToFilter')
            ->with(
                $this->callback(
                function($param) {
                    $return = false;
                    if ($param == 'payment.method' || $param == 'main_table.state' || $param == 'main_table.created_at')  {
                        $return = true;
                    }
                    return $return;
                }),
                $this->callback(
                    function ($param) {
                        $return = false;
                        if (
                            ($param == array(array('like' => Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE))) ||
                            ($param == array(array('nin' => array('complete', 'closed', 'canceled')))) ||
                            (array_key_exists('from', $param) && array_key_exists('to', $param))
                        ) {
                            $return = true;
                        }
                        return $return;
                    }))
            ->will($this->returnValue($this->orderCollection));

        $order1 = $this->getModelMock('sales/order', array('hasInvoices', 'isCanceled'));
        $order2 = $this->getModelMock('sales/order', array('hasInvoices', 'isCanceled'));
        $order3 = $this->getModelMock('sales/order', array('hasInvoices', 'isCanceled'));
        $order4 = $this->getModelMock('sales/order', array('hasInvoices', 'isCanceled'));

        $order1
            ->expects($this->any())
            ->method('hasInvoices')
            ->will($this->returnValue(false));
        $order1
            ->expects($this->any())
            ->method('isCanceled')
            ->will($this->returnValue(true));

        $order2
            ->expects($this->any())
            ->method('hasInvoices')
            ->will($this->returnValue(true));
        $order2
            ->expects($this->any())
            ->method('isCanceled')
            ->will($this->returnValue(false));

        $order3
            ->expects($this->any())
            ->method('hasInvoices')
            ->will($this->returnValue(true));
        $order3
            ->expects($this->any())
            ->method('isCanceled')
            ->will($this->returnValue(true));

        $order4
            ->expects($this->any())
            ->method('hasInvoices')
            ->will($this->returnValue(false));
        $order4
            ->expects($this->any())
            ->method('isCanceled')
            ->will($this->returnValue(false));

        $this
            ->orderCollection
            ->expects($this->any())
            ->method('getItems')
            ->will($this->returnValue(array($order1, $order2, $order3, $order4)));

        $this
            ->sync
            ->expects($this->once())
            ->method('syncOrder')
            ->with($order4);

        $this->subject->run();
    }

    public function testRunWritesExceptionsToLog()
    {
        $this
            ->orderCollection
            ->expects($this->any())
            ->method('addFieldToFilter')
            ->will($this->returnValue($this->orderCollection));

        $order1 = $this->getModelMock(
            'sales/order',
            array('hasInvoices', 'isCanceled')
        );

        $order1
            ->expects($this->any())
            ->method('hasInvoices')
            ->will($this->returnValue(false));
        $order1
            ->expects($this->any())
            ->method('isCanceled')
            ->will($this->returnValue(false));

        $this
            ->orderCollection
            ->expects($this->any())
            ->method('getItems')
            ->will($this->returnValue(array($order1)));

        $this
            ->sync
            ->expects($this->once())
            ->method('syncOrder')
            ->will($this->throwException(new Mage_Core_Exception('Error')));

        $this
            ->debug
            ->expects($this->once())
            ->method('debug');

        $this->subject->run();
    }
}

