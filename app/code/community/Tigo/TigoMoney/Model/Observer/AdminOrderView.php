<?php

/**
 * Class Tigo_TigoMoney_Model_Observer_AdminOrderView
 */
class Tigo_TigoMoney_Model_Observer_AdminOrderView
{
    /**
     * Button Label
     */
    const BUTTON_CLASS = 'go';

    /**
     * Button Label
     */
    const BUTTON_LABEL = 'Sync With Tigo Money';

    /**
     * Current Order
     * @var null|Mage_Sales_Model_Order
     */
    protected $_currentOrder = null;

    /**
     * Data Helper
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_dataHelper = null;

    /**
     * Adds a Sync With Tigo Money button to the order admin view
     * @param $observer
     * @return $this
     */
    public function addSyncButton($observer)
    {
        /** @var Mage_Adminhtml_Block_Sales_Order_View $block */
        $block = $this->_getSalesOrderEditBlock();

        if (!$block){
            return $this;
        }

        $order = $this->_getCurrentOrder();

        if ($this->_shouldShowButton($order)) {
            $url = $this->_getDataHelper()->getSyncOrderUrl($order);

            $block->addButton('tigo_tigomoney_sync', array(
                'label'     => $this->_getDataHelper()->__(self::BUTTON_LABEL),
                'onclick'   => 'setLocation(\'' . $url . '\')',
                'class'     => self::BUTTON_CLASS
            ));
        }
        return $this;
    }

    /**
     * Retrieves current order from registry
     * @return Mage_Sales_Model_Order
     */
    protected function _getCurrentOrder()
    {
        if ($this->_currentOrder === null) {
            $this->_currentOrder = Mage::registry('current_order');
        }
        return $this->_currentOrder;
    }

    /**
     * Retrieves current order from registry
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
     * Gets Sales Order Edit Block from Layout
     * @return Mage_Adminhtml_Block_Sales_Order_View
     */
    protected function _getSalesOrderEditBlock()
    {
        return Mage::app()->getLayout()->getBlock('sales_order_edit');
    }

    /**
     * Should we show the Sync Button?
     * @param mixed $order
     * @return bool
     */
    protected function _shouldShowButton($order)
    {
        return (
            $order &&
            $order instanceof Mage_Sales_Model_Order &&
            $order->getId() &&
            $order->getPayment()->getMethod() == Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE &&
            $order->getStatus() == 'pending'
        );
    }
}