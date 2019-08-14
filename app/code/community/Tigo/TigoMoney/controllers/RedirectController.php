<?php

/**
 * Class Tigo_TigoMoney_RedirectController
 */
class Tigo_TigoMoney_RedirectController extends Mage_Core_Controller_Front_Action
{
    /**
     * Retrieves Checkout Session
     * @return Mage_Checkout_Model_Session
     */
    protected function _getCheckoutSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Retrieves last order from checkout session
     * @return Mage_Sales_Model_Order
     */
    protected function _getLastOrder()
    {
        return $this->_getCheckoutSession()->getLastRealOrder();
    }

    /**
     * Redirects customer to Tigo Payment Server
     */
    public function indexAction()
    {
        $lastOrder = $this->_getLastOrder();
        if (
            $lastOrder->getId() &&
            $lastOrder->getPayment()->getMethod() == Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE
        ) {
            $redirectUri = $lastOrder
                ->getPayment()
                ->getAdditionalInformation(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_REDIRECT_URI);

            if (!$redirectUri) {
                $redirectUri = Mage::getBaseUrl();
            }
        } else {
            $redirectUri = Mage::getBaseUrl();
        }

        return $this->_redirectUrl($redirectUri);
    }
}