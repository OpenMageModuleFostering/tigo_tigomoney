<?php

/**
 * Class Tigo_TigoMoney_SyncControllerTest
 */
class Tigo_TigoMoney_ReturnControllerTest extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @var Mage_Core_Model_Url|PHPUnit_Framework_MockObject_MockObject
     */
    protected $coreUrl = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Sync|PHPUnit_Framework_MockObject_MockObject
     */
    protected $sync = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        parent::setUp();

        $this->sync = $this
            ->getModelMock('tigo_tigomoney/payment_redirect_sync', array('handleRequest'));
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_sync', $this->sync);

        $this->coreUrl = $this->getModelMock('core/url', array('nonExistentMethod'));
        $this->coreUrl->setUseSession(false);
        $this->replaceByMock('model', 'core/url', $this->coreUrl);
    }

    /**
     * @return array
     */
    public function testCallbackIsDeliveredCorrectlyToSyncModelAndRedirectsToRightRouteDataProvider()
    {
        # Preg Replaces below were necessary. There was an Adminhtml controller test being
        # executed before this one, and it was setting the base url cache in the store model,
        # adding 'index.php' in the url regardless of the seo_rewrites value.
        $params = array('_secure' => true);
        $successRoute = $this->getUrlModel('checkout/onepage/success/', $params)->getUrl('checkout/onepage/success/', $params);
        $failureRoute = $this->getUrlModel('checkout/onepage/failure/', $params)->getUrl('checkout/onepage/failure/', $params);
        return array(
            array(
                Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS,
                true,
                preg_replace('/checkout\//', 'index.php/checkout/', $successRoute)
            ),
            array(
                Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_CANCEL,
                false,
                preg_replace('/checkout\//', 'index.php/checkout/', $failureRoute)
            ),
            array(
                Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_FAILURE,
                false,
                preg_replace('/checkout\//', 'index.php/checkout/', $failureRoute)
            )
        );
    }

    /**
     * @param string $status
     * @param bool $handleRequestReturnValue
     * @param string $expectedRoute
     * @dataProvider testCallbackIsDeliveredCorrectlyToSyncModelAndRedirectsToRightRouteDataProvider
     */
    public function testCallbackIsDeliveredCorrectlyToSyncModelAndRedirectsToRightRoute(
        $status,
        $handleRequestReturnValue,
        $expectedRoute
    )
    {
        $redirectUrl = $expectedRoute;
        $merchantOrderId = '10001023';
        $mfsTransactionId = '38382934293842384';
        $transactionCode = '039303930.039303928372.84772737';
        $transactionStatus = $status;

        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost(
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MERCHANT_TRANSACTION_ID,
            $merchantOrderId
        );
        $this->getRequest()->setPost(
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MFS_TRANSACTION_ID,
            $mfsTransactionId
        );
        $this->getRequest()->setPost(
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_CODE,
            $transactionCode
        );
        $this->getRequest()->setPost(
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_STATUS,
            $transactionStatus
        );

        $this
            ->sync
            ->expects($this->once())
            ->method('handleRequest')
            ->with(
                $this->callback(
                    function ($params) use ($merchantOrderId, $mfsTransactionId, $transactionCode, $transactionStatus) {
                        $return = false;
                        if (
                            (
                                $params[Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MERCHANT_TRANSACTION_ID] == $merchantOrderId
                            ) &&
                            (
                                $params[Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MFS_TRANSACTION_ID] == $mfsTransactionId
                            ) &&
                            (
                                $params[Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_CODE] == $transactionCode
                            ) &&
                            (
                                $params[Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_STATUS] == $transactionStatus
                            ) &&
                            array_key_exists(
                                Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MERCHANT_TRANSACTION_ID,
                                $params
                            ) &&
                            array_key_exists(
                                Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_MFS_TRANSACTION_ID,
                                $params
                            ) &&
                            array_key_exists(
                                Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_CODE,
                                $params
                            ) &&
                            array_key_exists(
                                Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_KEY_TRANSACTION_STATUS,
                                $params
                            )
                        ) {
                            $return = true;
                        }
                        return $return;
                    }
                )
            )->will($this->returnValue($handleRequestReturnValue));

        $this->dispatch('tigomoney/return/index');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($redirectUrl);
    }
}

