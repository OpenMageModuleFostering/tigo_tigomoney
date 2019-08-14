<?php

/**
 * Class Tigo_TigoMoney_Helper_Data
 */
class Tigo_TigoMoney_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Config Path - Client Id
     */
    const CONFIG_PATH_CLIENT_ID = 'payment/tigo_tigomoney/client_id';

    /**
     * Config Path - Client Secret
     */
    const CONFIG_PATH_CLIENT_SECRET = 'payment/tigo_tigomoney/client_secret';

    /**
     * Config Path - Debug Mode
     */
    const CONFIG_PATH_DEBUG_MODE = 'payment/tigo_tigomoney/debug_mode';

    /**
     * Config Path - Description
     */
    const CONFIG_PATH_DESCRIPTION = 'payment/tigo_tigomoney/description';

    /**
     * Config Path - Failure Continue Shopping URL
     */
    const CONFIG_PATH_FAILURE_CONTINUE_SHOPPING_URL = 'payment/tigo_tigomoney/failure_continue_shopping_url';

    /**
     * Config Path - Merchant Account
     */
    const CONFIG_PATH_MERCHANT_ACCOUNT = 'payment/tigo_tigomoney/merchant_account';

    /**
     * Config Path - Merchant ID
     */
    const CONFIG_PATH_MERCHANT_ID = 'payment/tigo_tigomoney/merchant_id';

    /**
     * Config Path - Merchant Pin
     */
    const CONFIG_PATH_MERCHANT_PIN = 'payment/tigo_tigomoney/merchant_pin';

    /**
     * Config Path - Merchant Reference
     */
    const CONFIG_PATH_MERCHANT_REFERENCE = 'payment/tigo_tigomoney/merchant_reference';

    /**
     * Config Path - Success Continue Shopping URL
     */
    const CONFIG_PATH_SUCCESS_CONTINUE_SHOPPING_URL = 'payment/tigo_tigomoney/success_continue_shopping_url';

    /**
     * Config Path - Test Mode
     */
    const CONFIG_PATH_TEST_MODE = 'payment/tigo_tigomoney/test_mode';

    /**
     * Adminhtml Helper
     * @var null|Mage_Adminhtml_Helper_Data
     */
    protected $_adminhtmlHelper = null;

    /**
     * Retrieves current order from registry
     * @return Mage_Adminhtml_Helper_Data
     */
    protected function _getAdminhtmlHelper()
    {
        if ($this->_adminhtmlHelper === null) {
            $this->_adminhtmlHelper = Mage::helper('adminhtml');
        }
        return $this->_adminhtmlHelper;
    }

    /**
     * Returns module's Callback URI
     * @return string
     */
    public function getCallbackUri()
    {
        return $this->_getUrl('tigomoney/sync');
    }

    /**
     * Retrieves Client Id from configuration
     * @return string
     */
    public function getClientId()
    {
        return (string) $this->_getStoreConfig(self::CONFIG_PATH_CLIENT_ID);
    }

    /**
     * Retrieves Client Secret from configuration
     * @return string
     */
    public function getClientSecret()
    {
        return (string) $this->_getStoreConfig(self::CONFIG_PATH_CLIENT_SECRET);
    }

    /**
     * Retrieves Checkout Description from configuration
     * @return string
     */
    public function getDescription()
    {
        return (string) $this->_getStoreConfig(self::CONFIG_PATH_DESCRIPTION);
    }

    /**
     * Retrieves Checkout Failure Continue Shopping Url from configuration
     * @return string
     */
    public function getFailureContinueShoppingUrl()
    {
        return trim($this->_getStoreConfig(self::CONFIG_PATH_FAILURE_CONTINUE_SHOPPING_URL));
    }

    /**
     * Retrieves internal redirect url
     * @return string
     */
    public function getInternalRedirectUri()
    {
        return $this->_getUrl('tigomoney/redirect/index', array('_secure' => true));
    }

    /**
     * Retrieves Merchant Account from configuration
     * @return string
     */
    public function getMerchantAccount()
    {
        return (string) $this->_getStoreConfig(self::CONFIG_PATH_MERCHANT_ACCOUNT);
    }

    /**
     * Retrieves Merchant Id from configuration
     * @return string
     */
    public function getMerchantId()
    {
        return (string) $this->_getStoreConfig(self::CONFIG_PATH_MERCHANT_ID);
    }

    /**
     * Retrieves Merchant Pin from configuration
     * @return string
     */
    public function getMerchantPin()
    {
        return (string) $this->_getStoreConfig(self::CONFIG_PATH_MERCHANT_PIN);
    }

    /**
     * Retrieves Merchant Reference from configuration
     * @return string
     */
    public function getMerchantReference()
    {
        return (string) $this->_getStoreConfig(self::CONFIG_PATH_MERCHANT_REFERENCE);
    }

    /**
     * Returns module's Redirect URI
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->_getUrl('tigomoney/return');
    }

    /**
     * Retrieves info from configuration
     * @param $path string
     * @param $storeId int
     * @return mixed
     */
    protected function _getStoreConfig($path, $storeId = null) {
        return Mage::getStoreConfig($path, $storeId);
    }

    /**
     * Retrieves Checkout Success Continue Shopping Url from configuration
     * @return string
     */
    public function getSuccessContinueShoppingUrl()
    {
        return trim($this->_getStoreConfig(self::CONFIG_PATH_SUCCESS_CONTINUE_SHOPPING_URL));
    }

    /**
     * Returns Admin Sync Order Url
     * @param Mage_Sales_Model_Order $order
     * @return string
     */
    public function getSyncOrderUrl(Mage_Sales_Model_Order $order) {
        $orderId = $order->getId();
        return $this->_getAdminhtmlHelper()->getUrl(
            'adminhtml/tigomoney_order/sync',
            array('order_id' => $orderId)
        );
    }

    /**
     * Is debug mode enabled?
     * @return bool
     */
    public function isDebugModeEnabled()
    {
        return (bool) $this->_getStoreConfig(self::CONFIG_PATH_DEBUG_MODE);
    }

    /**
     * Is test mode enabled?
     * @return bool
     */
    public function isTestModeEnabled()
    {
        return (bool) $this->_getStoreConfig(self::CONFIG_PATH_TEST_MODE);
    }
}