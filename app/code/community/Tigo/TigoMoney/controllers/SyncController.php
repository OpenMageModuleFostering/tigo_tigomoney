<?php

/**
 * Class Tigo_TigoMoney_ReturnController
 */
class Tigo_TigoMoney_SyncController extends Mage_Core_Controller_Front_Action
{
    /**
     * Sync Model Instance
     * @var null|Tigo_TigoMoney_Model_Payment_Redirect_Sync
     */
    protected $_sync = null;

    /**
     * Sync Model Instance Getter
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
     * Handles the request, if any information received regarding the order
     * @return void
     */
    public function indexAction()
    {
        $requestParams = $this->getRequest()->getParams();
        $this->_getSync()->handleRequest($requestParams);
    }
}