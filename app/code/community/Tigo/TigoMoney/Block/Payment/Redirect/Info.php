<?php

/**
 * Class Tigo_TigoMoney_Block_Payment_Redirect_Info
 */
class Tigo_TigoMoney_Block_Payment_Redirect_Info extends Mage_Payment_Block_Info
{

    /**
     * Additional Info Return Key - Access Token Errors
     */
    const ADDITIONAL_INFO_RETURN_KEY_ACCESS_TOKEN_ERRORS = 'Access Token Generation Error(s)';

    /**
     * Additional Info Return Key - Auth Code
     */
    const ADDITIONAL_INFO_RETURN_KEY_AUTH_CODE = 'Auth Code';

    /**
     * Additional Info Return Key - Authorization Errors
     */
    const ADDITIONAL_INFO_RETURN_KEY_AUTHORIZATION_ERRORS = 'Authorization Error(s)';

    /**
     * Additional Info Return Key - MFS Transaction Id
     */
    const ADDITIONAL_INFO_RETURN_KEY_MFS_TRANSACTION_ID = 'MFS Transaction ID';

    /**
     * Additional Info Return Key - Transaction Code
     */
    const ADDITIONAL_INFO_RETURN_KEY_TRANSACTION_CODE = 'Transaction Code';

    /**
     * Template Path for the info block
     */
    const TEMPLATE_PATH = 'tigo_tigomoney/payment/redirect/info.phtml';

    /**
     * Sets new template path
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate(self::TEMPLATE_PATH);
    }

    /**
     * Adds transaction information to order view on the Admin page
     * @return array
     */
    public function getSpecificInformation() {
        $return = parent::getSpecificInformation();

        if ($this->_isAdmin()) {
            $info = $this->getInfo();

            if ($value = $info->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID
            )) {
                $return[$this->__(self::ADDITIONAL_INFO_RETURN_KEY_MFS_TRANSACTION_ID)] = $value;
            }

            if ($value = $info->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_AUTH_CODE
            )) {
                $return[$this->__(self::ADDITIONAL_INFO_RETURN_KEY_AUTH_CODE)] = $value;
            }

            if ($value = $info->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_CODE
            )) {
                $return[$this->__(self::ADDITIONAL_INFO_RETURN_KEY_TRANSACTION_CODE)] = $value;
            }

            if ($value = $info->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_ACCESS_TOKEN_ERRORS
            )) {
                $return[$this->__(self::ADDITIONAL_INFO_RETURN_KEY_ACCESS_TOKEN_ERRORS)] = $value;
            }

            if ($value = $info->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_AUTHORIZATION_ERRORS
            )) {
                $return[$this->__(self::ADDITIONAL_INFO_RETURN_KEY_AUTHORIZATION_ERRORS)] = $value;
            }

        }

        return $return;
    }

    /**
     * Are we on the admin?
     * @return bool
     */
    protected function _isAdmin()
    {
        return (bool) Mage::app()->getStore()->isAdmin();
    }
}