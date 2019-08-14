<?php

class Tigo_TigoMoney_Model_Cron_SyncOldPendingOrders
{
    /**
     * @var Tigo_TigoMoney_Helper_Data|null
     */
    protected $_dataHelper = null;

    /**
     * @var Tigo_TigoMoney_Model_Debug|null
     */
    protected $_debug = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|null
     */
    protected $_sync = null;

    /**
     * Data Helper getter
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
     * Debug Model getter
     * @return Tigo_TigoMoney_Model_Debug
     */
    protected function _getDebug()
    {
        if ($this->_debug === null) {
            $this->_debug = Mage::getModel('tigo_tigomoney/debug');
        }
        return $this->_debug;
    }

    /**
     * Retrieves Pending Orders paid with Tigo Money payment method
     * @return Mage_Sales_Model_Order[]
     */
    protected function _getPendingOrders()
    {
        /** @var Mage_Sales_Model_Entity_Order_Collection $orderCollection */
        $orderCollection = Mage::getModel('sales/order')
            ->getCollection()
            ->join(
                array('payment' => 'sales/order_payment'),
                'main_table.entity_id=payment.parent_id',
                array('payment_method' => 'payment.method')
            )
            ->addAttributeToSelect('*')
            ->addFieldToFilter('payment.method', array(array('like' => Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE)))
            ->addFieldToFilter('main_table.state', array(array('nin' => array('complete', 'closed', 'canceled'))));
        return $orderCollection->getItems();
    }

    /**
     * Sync model getter
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Sync
     */
    protected function _getSync()
    {
        if ($this->_sync === null) {
            $this->_sync = Mage::getModel('tigo_tigomoney/payment_redirect_sync');
        }
        return $this->_sync;
    }

    /**
     * Syncs orders which haven't yet been paid
     * @return void
     */
    public function run()
    {
        foreach($this->_getPendingOrders() as $order)
        {
            if (!$order->hasInvoices() && !$order->isCanceled()) {
                try {
                    $this->_getSync()->syncOrder($order);
                } catch (Exception $e) {
                    $this->_getDebug()->debug(
                        $this->_getDataHelper()->__(
                            'There was an error while trying to sync current order with Tigo Money. Order: ' .
                            $order->getIncrementId() . '. Error: ' . $e->getMessage()
                        )
                    );
                }
            }
        }
    }
}