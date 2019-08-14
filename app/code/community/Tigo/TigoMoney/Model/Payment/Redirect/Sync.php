<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Sync
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Sync
{
    /**
     * Parameter Key - Merchant Transaction Id
     */
    const PARAM_KEY_MERCHANT_ACCESS_TOKEN = 'accessToken';

    /**
     * Parameter Key - Merchant Transaction Id
     */
    const PARAM_KEY_MERCHANT_TRANSACTION_ID = 'merchantTransactionId';

    /**
     * Parameter Key - MFS Transaction Id
     */
    const PARAM_KEY_MFS_TRANSACTION_ID = 'mfsTransactionId';

    /**
     * Parameter Key - Transaction Code
     */
    const PARAM_KEY_TRANSACTION_CODE = 'transactionCode';

    /**
     * Parameter Key - Transaction Description
     */
    const PARAM_KEY_TRANSACTION_DESCRIPTION = 'transactionDescription';

    /**
     * Parameter Key - Transaction Status
     */
    const PARAM_KEY_TRANSACTION_STATUS = 'transactionStatus';

    /**
     * Parameter Value - Transaction Status Cancel
     */
    const PARAM_VALUE_TRANSACTION_STATUS_CANCEL = 'cancel';

    /**
     * Parameter Value - Transaction Status Failure
     */
    const PARAM_VALUE_TRANSACTION_STATUS_FAILURE = 'fail';

    /**
     * Parameter Value - Transaction Status Initiated
     */
    const PARAM_VALUE_TRANSACTION_STATUS_INITIATED = 'initiated';

    /**
     * Parameter Value - Transaction Status Success
     */
    const PARAM_VALUE_TRANSACTION_STATUS_SUCCESS = 'success';

    /**
     * Api
     * @var null|Tigo_TigoMoney_Model_Payment_Redirect_Api
     */
    protected $_api = null;

    /**
     * Data Helper
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_dataHelper = null;

    /**
     * Debug Model
     * @var null|Tigo_TigoMoney_Helper_Data
     */
    protected $_debug = null;

    /**
     * Request Builder
     * @var null|Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder
     */
    protected $_requestBuilder = null;

    /**
     * Sets Request Info as Additional Information on the order payment instance and saves it
     * @param string $mfsTransactionId
     * @param string $transactionCode
     * @param string $transactionDescription
     * @param string $transactionStatus
     * @param Mage_Sales_Model_Order $order
     * @return $this
     */
    protected function _addTransactionInfoToOrder(
        $mfsTransactionId,
        $transactionCode,
        $transactionDescription,
        $transactionStatus,
        Mage_Sales_Model_Order $order
    ) {
        $payment = $order->getPayment();

        if ($mfsTransactionId) {
            $payment->setAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID,
                $mfsTransactionId
            );
        }

        if ($transactionCode) {
            $payment->setAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_CODE,
                $transactionCode
            );
        }

        if ($transactionDescription) {
            $payment->setAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_DESCRIPTION,
                $transactionDescription
            );
        }

        if ($transactionStatus) {
            $payment->setAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_STATUS,
                $transactionStatus
            );
        }

        $payment->save();

        return $this;
    }

    /**
     * Cancels an order
     * @param Mage_Sales_Model_Order $order
     * @return $this
     */
    public function _cancelOrder(Mage_Sales_Model_Order $order)
    {
        if ($order->canCancel()) {
            $order
                ->cancel()
                ->save();
        }
        return $this;
    }

    /**
     * Creates an invoice for an order
     * @param Mage_Sales_Model_Order $order
     * @return $this
     */
    public function _createInvoice(Mage_Sales_Model_Order $order)
    {
        if ($order->canInvoice()) {
            $invoice = $order->prepareInvoice();
            $invoice
                ->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE)
                ->register();

            $transaction = $this->_getResourceTransactionInstance();
            $transaction
                ->addObject($invoice)
                ->addObject($invoice->getOrder())
                ->save();
        }
        return $this;
    }

    /**
     * Writes info to debug file
     * @param string $requestBody
     */
    protected function _debugRequest($requestBody)
    {
        $request = Mage::app()->getRequest();
        $this->_getDebug()->debug('---- Callback from Tigo Payment Server ---');
        $this->_getDebug()->debug('Route: ' .
            $request->getRequestedRouteName() . '/' .
            $request->getControllerName() . '/' .
            $request->getActionName() . '/'
        );
        $this->_getDebug()->debug($requestBody);
    }

    /**
     * Extracts info from request
     * @param array $requestArray
     * @return Varien_Object
     */
    protected function _extractRequest($requestArray)
    {
        $this->_debugRequest($requestArray);

        $return = $this->_getVarienObjectInstance();

        foreach($requestArray as $key => $value) {
            $value = trim($value);
            if ($value && $value != 'undefined') {
                $return->setData(trim($key), $value);
            }
        }

        return $return;
    }

    /**
     * Api Getter
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api
     */
    protected function _getApi()
    {
        if ($this->_api === null) {
            $this->_api = Mage::getModel('tigo_tigomoney/payment_redirect_api');
        }
        return $this->_api;
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
     * Debug Model Getter
     * @return Tigo_TigoMoney_Model_Debug
     */
    protected function _getDebug()
    {
        if ($this->_debug === null) {
            $this->_debug = Mage::getModel('tigo_tigomoney/debug');
        }
        return $this->_debug;
    }

    /**
     * Request Builder Getter
     * @return Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder
     */
    protected function _getRequestBuilder()
    {
        if ($this->_requestBuilder === null) {
            $this->_requestBuilder = Mage::getModel('tigo_tigomoney/payment_redirect_api_requestBuilder');
        }
        return $this->_requestBuilder;
    }

    /**
     * Returns new Mage_Core_Model_Resource_Transaction instance
     * @return Mage_Core_Model_Resource_Transaction
     */
    protected function _getResourceTransactionInstance()
    {
        return Mage::getModel('core/resource_transaction');
    }

    /**
     * Returns new Mage_Sales_Model_Order instance
     * @return Mage_Sales_Model_Order
     */
    protected function _getSalesOrderInstance()
    {
        return Mage::getModel('sales/order');
    }

    /**
     * Returns new Varien_Object instance
     * @return Varien_Object
     */
    protected function _getVarienObjectInstance()
    {
        return new Varien_Object();
    }

    /**
     * Handles a status update callback
     * @param array $requestParams
     * @return bool
     */
    public function handleRequest($requestParams)
    {
        $return = false;
        $request = $this->_extractRequest($requestParams);
        $order = $this->_loadRequestOrder($request);
        if ($order->getId()) {
            $this->_addTransactionInfoToOrder(
                $request->getData(self::PARAM_KEY_MFS_TRANSACTION_ID),
                $request->getData(self::PARAM_KEY_TRANSACTION_CODE),
                $request->getData(self::PARAM_KEY_TRANSACTION_DESCRIPTION),
                $request->getData(self::PARAM_KEY_TRANSACTION_STATUS),
                $order
            );
            if ($this->_isTransactionSuccessful($request)) {
                if ($this->_isValidRequest(
                        $order,
                        array(self::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS)
                    )
                ) {
                    $this->_createInvoice($order);
                    $return = true;
                }
            } else {
                if ($this->_isValidRequest(
                        $order,
                        array(self::PARAM_VALUE_TRANSACTION_STATUS_FAILURE, self::PARAM_VALUE_TRANSACTION_STATUS_CANCEL)
                    )
                ) {
                    $this->_cancelOrder($order);
                }
            }
        }
        return $return;
    }

    /**
     * Checks whether a request is valid for a specific order
     * @param Mage_Sales_Model_Order $order
     * @param array $status
     * @return bool
     */
    protected function _isValidRequest(Mage_Sales_Model_Order $order, $status)
    {
        $return = false;

        $accessTokenRequest = $this->_getRequestBuilder()->buildGenerateAccessTokenRequest();
        $accessTokenResponse = $this->_getApi()->getAccessToken($accessTokenRequest);

        if ($accessTokenResponse->isSuccess()) {
            $transactionStatusRequest = $this->_getRequestBuilder()->buildTransactionStatusRequest(
                $accessTokenResponse->getAccessToken(),
                $order
            );
            $transactionStatusResponse = $this->_getApi()->getTransactionStatus($transactionStatusRequest);

            $mfsTransactionId = $order->getPayment()->getAdditionalInformation(
                Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID
            );

            # The following if checks:
            # 1 - If the transaction status with the tigo payment server is the same informed in the request
            # 2 - If the MFS transaction ID received during the authorization process is the same we are seeing now
            # 3 - If the amount paid is equal or higher the one we received in the store
            if (
                ($transactionStatusResponse->isSuccess()) &&
                (in_array($transactionStatusResponse->getTransactionStatus(), $status)) &&
                ($transactionStatusResponse->getTransactionMfsTransactionId() == $mfsTransactionId) &&
                ($transactionStatusResponse->getLocalPaymentAmount() >= $order->getBaseGrandTotal())
            ) {
                $return = true;
            }
        }

        return $return;
    }

    /**
     * Checks if the request is informing of a successful transaction
     * @param Varien_Object $request
     * @return bool
     */
    protected function _isTransactionSuccessful(Varien_Object $request)
    {
        $return = false;

        $status = $request->getData(self::PARAM_KEY_TRANSACTION_STATUS);
        if ($status == self::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS) {
            $return = true;
        }

        return $return;
    }

    /**
     * Loads the order referred to by the incoming request
     * @param Varien_Object $request
     * @return Mage_Sales_Model_Order
     */
    protected function _loadRequestOrder(Varien_Object $request)
    {
        $order = $this->_getSalesOrderInstance();

        $orderIncrementId = $request->getData(self::PARAM_KEY_MERCHANT_TRANSACTION_ID);
        $order->loadByIncrementId($orderIncrementId);

        return $order;
    }

    /**
     * Should we cancel this order?
     * @param Mage_Sales_Model_Order $order
     * @return bool
     */
    protected function _shouldInitiatedOrderBeCanceled(Mage_Sales_Model_Order $order)
    {
        $return = false;

        $fiveDaysAgo = strtotime('-5 days');
        $orderCreatedAt = strtotime($order->getCreatedAt());

        if (
            $order->canCancel() &&
            ($orderCreatedAt < $fiveDaysAgo)
        ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Handles a status update callback
     * @param Mage_Sales_Model_Order $order
     * @return null|
     */
    public function syncOrder($order)
    {
        $accessTokenRequest = $this->_getRequestBuilder()->buildGenerateAccessTokenRequest();
        $accessTokenResponse = $this->_getApi()->getAccessToken($accessTokenRequest);

        if ($accessTokenResponse->isSuccess()) {
            $transactionStatusRequest = $this->_getRequestBuilder()->buildTransactionStatusRequest(
                $accessTokenResponse->getAccessToken(),
                $order
            );
            $transactionStatusResponse = $this->_getApi()->getTransactionStatus($transactionStatusRequest);

            if ($transactionStatusResponse->isSuccess()) {
                $status = $transactionStatusResponse->getTransactionStatus();

                if ($status == self::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS) {
                    /**
                     * Order has been paid
                     */
                    $this->_addTransactionInfoToOrder(
                        $transactionStatusResponse->getTransactionMfsTransactionId(),
                        null,
                        null,
                        $transactionStatusResponse->getTransactionStatus(),
                        $order
                    );
                    $this->_createInvoice($order);
                } else if (
                    in_array(
                        $status,
                        array(self::PARAM_VALUE_TRANSACTION_STATUS_FAILURE, self::PARAM_VALUE_TRANSACTION_STATUS_CANCEL)
                    )
                ) {
                    /**
                     * There was an error while the user tried to pay for the order
                     */
                    $this->_cancelOrder($order);
                } else if ($status == self::PARAM_VALUE_TRANSACTION_STATUS_INITIATED) {
                    /**
                     * Order has been initiated, but not paid nor canceled
                     * In this case, orders will be canceled five days after placed
                     */
                    if ($this->_shouldInitiatedOrderBeCanceled($order)) {
                        $this->_getDebug()->debug(
                            $this->_getDataHelper()->__('Canceling initiated order #' . $order->getIncrementId())
                        );
                        $this->_cancelOrder($order);
                    }
                }

            } else {
                Mage::throwException($this->_getDataHelper()->__(
                    'An error happened while trying to retrieve the transaction status.'
                ));
            }
        } else {
            Mage::throwException($this->_getDataHelper()->__(
                'An error happened while trying to retrieve the access token.'
            ));
        }
        return $this;
    }
}