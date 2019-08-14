<?php

/**
 * Class Tigo_TigoMoney_Model_Debug
 */
class Tigo_TigoMoney_Model_Debug
{
    /**
     * Debug file name. Will be available in <magento_root>/var/log/tigomoney.log
     */
    const DEBUG_FILE_NAME = 'tigomoney.log';

    /**
     * Data Helper
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_dataHelper = null;

    /**
     * Debug Mode On?
     * @var null|bool
     */
    protected $_debugMode= null;

    /**
     * Writes info to debug file
     * @param string|array $value
     */
    public function debug($value) {
        if ($this->_isDebugMode()) {
            if (is_array($value)) {
                $this->debug(print_r($value, true));
            } else if (!is_object($value)) {
                $this->_writeLog($value);
            }
        }
    }

    /**
     * Data Helper Getter
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
     * Are we in debug mode?
     * @return boolean
     */
    protected function _isDebugMode()
    {
        if ($this->_debugMode === null) {
            $this->_debugMode = (bool) $this->_getDataHelper()->isDebugModeEnabled();
        }
        return $this->_debugMode;
    }

    /**
     * Writes value to log
     * @param $value
     */
    protected function _writeLog($value)
    {
        Mage::log((string) $value, null, self::DEBUG_FILE_NAME);
    }
}