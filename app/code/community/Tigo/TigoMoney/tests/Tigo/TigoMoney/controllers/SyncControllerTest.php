<?php

/**
 * Class Tigo_TigoMoney_ReturnControllerTest
 */
class Tigo_TigoMoney_SyncControllerTest extends EcomDev_PHPUnit_Test_Case_Controller
{
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
            ->getMockBuilder(Tigo_TigoMoney_Model_Payment_Redirect_Sync::class)
            ->setMethods(array('handleRequest'))
            ->getMock();
        $this->replaceByMock('model', 'tigo_tigomoney/payment_redirect_sync', $this->sync);
    }

    /**
     * @loadFixture default
     */
    public function testCallbackIsDeliveredCorrectlyToSyncModel()
    {
        $merchantOrderId = '10001023';
        $mfsTransactionId = '38382934293842384';
        $transactionCode = '039303930.039303928372.84772737';
        $transactionStatus = Tigo_TigoMoney_Model_Payment_Redirect_Sync::PARAM_VALUE_TRANSACTION_STATUS_SUCCESS;

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
            );

        $this->dispatch('tigomoney/sync/index');

        $this->assertResponseHttpCode(200);
        $this->assertResponseBody($this->isEmpty());
    }
}

