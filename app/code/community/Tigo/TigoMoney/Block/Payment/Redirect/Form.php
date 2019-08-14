<?php

/**
 * Class Tigo_TigoMoney_Block_Payment_Redirect_Form
 */
class Tigo_TigoMoney_Block_Payment_Redirect_Form extends Mage_Payment_Block_Form
{
    /**
     * Template Path for the info block
     */
    const TEMPLATE_PATH = 'tigo_tigomoney/payment/redirect/form.phtml';

    /**
     * Data Helper
     * @var Tigo_TigoMoney_Helper_Data|null
     */
    protected $_dataHelper = null;

    /**
     * Template path
     * @var string
     */
    protected $_template = self::TEMPLATE_PATH;

    /**
     * Data Helper Getter
     * @return Tigo_TigoMoney_Helper_Data
     */
    protected function _getDataHelper()
    {
        if ($this->_dataHelper === null) {
            $this->_dataHelper = Mage::helper('tigo_tigomoney/data');
        }
        return $this->_dataHelper;
    }

    /**
     * Returns Description
     * @return string
     */
    public function getDescription()
    {
        return $this->_getDataHelper()->getDescription();
    }
}