<?php

/**
 * Class Tigo_TigoMoney_Adminhtml_OrderController
 */
class Tigo_TigoMoney_Adminhtml_Tigomoney_OrderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Adminhtml Session
     * @var null|Mage_Adminhtml_Model_Session
     */
    protected $_adminhtmlSession = null;

    /**
     * Sync Model
     * @var null|Tigo_TigoMoney_Model_Payment_Redirect_Sync
     */
    protected $_sync = null;

    /**
     * Adminhtml Session Getter
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getAdminhtmlSession()
    {
        if ($this->_adminhtmlSession === null) {
            $this->_adminhtmlSession = Mage::getSingleton('adminhtml/session');
        }
        return $this->_adminhtmlSession;
    }

    /**
     * Sync Model Getter
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
     * Is current user allowed?
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/order');
    }

    /**
     * Instantiates and loads an order
     * @param int $orderId
     * @return Mage_Sales_Model_Order
     */
    protected function _loadOrder($orderId)
    {
        return Mage::getModel('sales/order')->load($orderId);
    }

    /**
     *
     */
    public function syncAction()
    {
        $orderId = $this->getRequest()->getParam('order_id');

        $order = $this->_loadOrder($orderId);

        if ($order->getId()) {
            try {
                $this->_getSync()->syncOrder($order);
            } catch (Exception $e) {
                $this->_getAdminhtmlSession()->addError($this->__(
                    'There was an error while trying to sync your order.'
                ));
            }
        } else {
            $this->_getAdminhtmlSession()->addError($this->__('Specified order could not be found'));
        }

       return $this->_redirectReferer();
    }
}