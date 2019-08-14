<?php

/**
 * Class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Failure
 */
class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Failure extends Mage_Checkout_Block_Onepage_Failure
{
    /**
     * Data Helper
     * @var Tigo_TigoMoney_Helper_Data|null
     */
    protected $_dataHelper = null;

    /**
     * Overriding Continue Shopping Url from failure page, to make it
     * possible for the admin to configure a different page from the admin area
     * @return string
     */
    public function getContinueShoppingUrl()
    {
        $return = parent::getContinueShoppingUrl();
        if ($this->_isTigoMoneyOrder() && $this->_getDataHelper()->getFailureContinueShoppingUrl()) {
            $return = $this->_getDataHelper()->getFailureContinueShoppingUrl();
        }
        return $return;
    }

    /**
     * Data Helper Getter
     * @return Mage_Core_Helper_Abstract|null|Tigo_TigoMoney_Helper_Data
     */
    protected function _getDataHelper()
    {
        if ($this->_dataHelper === null) {
            $this->_dataHelper = Mage::helper('tigo_tigomoney/data');
        }
        return $this->_dataHelper;
    }

    /**
     * Retrieves last order from checkout session
     * @return Mage_Sales_Model_Order
     */
    protected function _getLastOrder()
    {
        $lastOrderId = $this->getRealOrderId();
        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order');
        return $order->loadByIncrementId($lastOrderId);
    }

    /**
     * Checks whether the last order placed was placed using tigo money
     * @return bool
     */
    protected function _isTigoMoneyOrder()
    {
        $lastOrder = $this->_getLastOrder();
        return ($lastOrder->getPayment()->getMethod() == Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE);
    }
}
