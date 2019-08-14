<?php

class Tigo_TigoMoney_ConfigTest extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testClassesAliases()
    {
        /**
         * Blocks
         */
        $this->assertBlockAlias(
            'tigo_tigomoney/payment_redirect_form',
            Tigo_TigoMoney_Block_Payment_Redirect_Form::class
        );
        $this->assertBlockAlias(
            'tigo_tigomoney/payment_redirect_info',
            Tigo_TigoMoney_Block_Payment_Redirect_Info::class
        );
        $this->assertBlockAlias(
            'tigo_tigomoney/rewrite_checkout_onepage_failure',
            Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Failure::class
        );
        $this->assertInstanceOf(
            Mage_Checkout_Block_Onepage_Failure::class,
            Mage::getModel(Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Failure::class)
        );
        $this->assertBlockAlias(
            'tigo_tigomoney/rewrite_checkout_onepage_success',
            Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Success::class
        );
        $this->assertInstanceOf(
            Mage_Checkout_Block_Onepage_Success::class,
            Mage::getModel(Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Success::class)
        );

        /**
         * Helpers
         */
        $this->assertHelperAlias(
            'tigo_tigomoney',
            Tigo_TigoMoney_Helper_Data::class
        );
        $this->assertHelperAlias(
            'tigo_tigomoney/data',
            Tigo_TigoMoney_Helper_Data::class
        );

        /**
         * Models
         */
        $this->assertModelAlias(
            'tigo_tigomoney/debug',
            Tigo_TigoMoney_Model_Debug::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/observer_adminOrderView',
            Tigo_TigoMoney_Model_Observer_AdminOrderView::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/observer_changeContinueShoppingUrlSuccess',
            Tigo_TigoMoney_Model_Observer_ChangeContinueShoppingUrlSuccess::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/cron_syncOldPendingOrders',
            Tigo_TigoMoney_Model_Cron_SyncOldPendingOrders::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/cron_syncRecentPendingOrders',
            Tigo_TigoMoney_Model_Cron_SyncRecentPendingOrders::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect',
            Tigo_TigoMoney_Model_Payment_Redirect::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api',
            Tigo_TigoMoney_Model_Payment_Redirect_Api::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_sync',
            Tigo_TigoMoney_Model_Payment_Redirect_Sync::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_authorizationRequest',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_authorizationResponse',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_generateTokenRequest',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_generateTokenResponse',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_requestBuilder',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_RequestBuilder::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_reverseTransactionRequest',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_reverseTransactionResponse',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_transactionStatusRequest',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/payment_redirect_api_transactionStatusResponse',
            Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse::class
        );
        $this->assertModelAlias(
            'tigo_tigomoney/adminhtml_configComment',
            Tigo_TigoMoney_Model_Adminhtml_ConfigComment::class
        );
    }

    public function testModuleDefinitionSetup()
    {
        $this->assertModuleCodePool('community');
        $this->assertModuleDepends('Mage_Payment');
        $this->assertModuleDepends('Mage_Sales');
    }

    public function testModuleConfig()
    {
        $this->assertConfigNodeHasChild('default/payment', Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE);
        $this->assertConfigNodeHasChild(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE,
            'description'
            );
        $this->assertConfigNodeHasChild(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE,
            'failure_continue_shopping_url'
        );
        $this->assertConfigNodeHasChild(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE,
            'success_continue_shopping_url'
        );
        $this->assertConfigNodeValue(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '/model',
            Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '/payment_redirect'
        );
        $this->assertConfigNodeValue(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '/order_status',
            'pending'
        );
        $this->assertConfigNodeValue(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '/allowspecific',
            '1'
        );
        $this->assertConfigNodeValue(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '/specificcountry',
            'SV'
        );
        $this->assertConfigNodeValue(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '/payment_action',
            'authorize'
        );
        $this->assertConfigNodeValue(
            'default/payment/' . Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE . '/after_place_redirect_url_path',
            'tigomoney/redirect/index'
        );
        $this->assertConfigNodeValue(
            'global/blocks/checkout/rewrite/onepage_failure',
            Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Failure::class
        );
        $this->assertConfigNodeValue(
            'global/blocks/checkout/rewrite/onepage_success',
            Tigo_TigoMoney_Block_Rewrite_Checkout_Onepage_Success::class
        );
        $this->assertConfigNodeHasChild(
            'crontab/jobs',
            'tigo_tigomoney_sync_old_pending_orders'
        );
        $this->assertConfigNodeValue(
            'crontab/jobs/tigo_tigomoney_sync_old_pending_orders/schedule/cron_expr',
            '0 1 * * *'
        );
        $this->assertConfigNodeValue(
            'crontab/jobs/tigo_tigomoney_sync_old_pending_orders/run/model',
            'tigo_tigomoney/cron_syncOldPendingOrders::run'
        );
        $this->assertConfigNodeHasChild(
            'crontab/jobs',
            'tigo_tigomoney_sync_recent_pending_orders'
        );
        $this->assertConfigNodeValue(
            'crontab/jobs/tigo_tigomoney_sync_recent_pending_orders/schedule/config_path',
            'payment/tigo_tigomoney/sync_recent_pending_orders_cron_schedule'
        );
        $this->assertConfigNodeValue(
            'crontab/jobs/tigo_tigomoney_sync_recent_pending_orders/run/model',
            'tigo_tigomoney/cron_syncRecentPendingOrders::run'
        );
    }

    public function testObserversAreDefined()
    {
        $this->assertEventObserverDefined(
            'adminhtml',
            'controller_action_layout_render_before_adminhtml_sales_order_view',
            'tigo_tigomoney/observer_adminOrderView',
            'addSyncButton'
        );
    }
}