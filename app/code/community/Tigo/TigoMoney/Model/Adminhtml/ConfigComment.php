<?php

class Tigo_TigoMoney_Model_Adminhtml_ConfigComment
{
    /**
     * @var Tigo_TigoMoney_Helper_Data|null
     */
    protected $_dataHelper = null;

    /**
     * As we are in the admin, the urls will always be rendered without url rewriting.
     * This method will remove index.php from the URL if rewrites are enabled
     * @param string $url
     * @return string
     */
    protected function _fixRewrite($url)
    {
        $return = $url;
        if ($this->_isUrlRewriteEnabled()) {
            $return = preg_replace('/index\.php\//', '', $return);
        }
        return $return;
    }

    /**
     * Returns callback URI
     * @return string
     */
    protected function _getCallbackUrl()
    {
        return $this->_fixRewrite($this->_getDataHelper()->getCallbackUri());
    }

    /**
     * Returns comment text for admin configuration page
     * @return string
     */
    public function getCommentText()
    {
        $helper = Mage::helper('tigo_tigomoney');
        return
            $helper->__('Your store has two URIs which will be used by Tigo Payment Server. They are:') . '<br />' .
            '<strong>Redirect URI:</strong> ' . $this->_getRedirectUri() . ' <br />' .
            '<strong>Callback URI:</strong> ' . $this->_getCallbackUrl() . ' <br />';
    }

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
     * Returns redirect URI
     * @return string
     */
    protected function _getRedirectUri()
    {
        return $this->_fixRewrite($this->_getDataHelper()->getRedirectUri());
    }

    /**
     * Is url rewrite enabled?
     * @return bool
     */
    protected function _isUrlRewriteEnabled()
    {
        return Mage::getStoreConfigFlag('web/seo/use_rewrites');
    }
}