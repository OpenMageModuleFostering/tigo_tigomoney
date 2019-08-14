<?php

/**
 * Class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Success
 */
class Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Success extends Mage_Checkout_Block_Onepage_Success
{
    /**
     * Data Helper
     * @var Tigo_TigoMoney_Helper_Data|null
     */
    protected $_dataHelper = null;

    /**
     * Overriding Continue Shopping Url from Success page, to make it
     * possible for the admin to configure a different page from the admin area
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = array())
    {
        $return = parent::getUrl($route, $params);
        if ($this->_isTigoMoneyOrder() && $this->_getDataHelper()->getSuccessContinueShoppingUrl()) {
            $return = $this->_getDataHelper()->getSuccessContinueShoppingUrl();
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
        $lastOrderId = $this->_getLastOrderId();
        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order');
        $order->load($lastOrderId);
        return $order;
    }

    /**
     * Retrieves Last Order Id From Checkout Session
     * @return int
     */
    protected function _getLastOrderId()
    {
        /** @var Mage_Checkout_Model_Session $session */
        $session = Mage::getSingleton('checkout/session');
        return $session->getLastOrderId();
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
