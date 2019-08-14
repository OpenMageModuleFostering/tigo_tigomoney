<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse extends
    Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse
{

    /**
     * Response data key - Callback Uri
     */
    const RESPONSE_DATA_KEY_CALLBACK_URI = 'callback_uri';

    /**
     * Response data key - Exchange Rate
     */
    const RESPONSE_DATA_KEY_EXCHANGE_RATE = 'exchange_rate';

    /**
     * Response data key - Language
     */
    const RESPONSE_DATA_KEY_LANGUAGE = 'language';

    /**
     * Response data key - Local Payment - Amount
     */
    const RESPONSE_DATA_KEY_LOCAL_PAYMENT_AMOUNT = 'local_payment_amount';

    /**
     * Response data key - Local Payment - Currency Code
     */
    const RESPONSE_DATA_KEY_LOCAL_PAYMENT_CURRENCY_CODE = 'local_payment_currency_code';

    /**
    * Response data key - Master Merchant - Account
    */
    const RESPONSE_DATA_KEY_MASTER_MERCHANT_ACCOUNT = 'master_merchant_account';

    /**
     * Response data key - Master Merchant - Id
     */
    const RESPONSE_DATA_KEY_MASTER_MERCHANT_ID = 'master_merchant_id';

    /**
     * Response data key - Merchant - Currency Code
     */
    const RESPONSE_DATA_KEY_MERCHANT_CURRENCY_CODE = 'merchant_currency_code';

    /**
     * Response data key - Merchant - Fee
     */
    const RESPONSE_DATA_KEY_MERCHANT_FEE = 'merchant_fee';

    /**
     * Response data key - Merchant - Reference
     */
    const RESPONSE_DATA_KEY_MERCHANT_REFERENCE = 'merchant_reference';

    /**
     * Response data key - Origin Payment - Amount
     */
    const RESPONSE_DATA_KEY_ORIGIN_PAYMENT_AMOUNT = 'origin_payment_amount';

    /**
     * Response data key - Origin Payment - Currency Code
     */
    const RESPONSE_DATA_KEY_ORIGIN_PAYMENT_CURRENCY_CODE = 'origin_payment_currency_code';

    /**
     * Response data key - Origin Payment - Fee
     */
    const RESPONSE_DATA_KEY_ORIGIN_PAYMENT_FEE = 'origin_payment_fee';

    /**
     * Response data key - Origin Payment - Tax
     */
    const RESPONSE_DATA_KEY_ORIGIN_PAYMENT_TAX = 'origin_payment_tax';

    /**
     * Response data key - Redirect Uri
     */
    const RESPONSE_DATA_KEY_REDIRECT_URI = 'redirect_uri';

    /**
     * Response data key - Subscriber - Account
     */
    const RESPONSE_DATA_KEY_SUBSCRIBER_ACCOUNT = 'subscriber_account';

    /**
     * Response data key - Subscriber - Country
     */
    const RESPONSE_DATA_KEY_SUBSCRIBER_COUNTRY = 'subscriber_country';

    /**
     * Response data key - Subscriber - Country Code
     */
    const RESPONSE_DATA_KEY_SUBSCRIBER_COUNTRY_CODE = 'subscriber_country_code';

    /**
     * Response data key - Subscriber - Email
     */
    const RESPONSE_DATA_KEY_SUBSCRIBER_EMAIL = 'subscriber_email';

    /**
     * Response data key - Subscriber - First Name
     */
    const RESPONSE_DATA_KEY_SUBSCRIBER_FIRST_NAME = 'subscriber_first_name';

    /**
     * Response data key - Subscriber - Last Name
     */
    const RESPONSE_DATA_KEY_SUBSCRIBER_LAST_NAME = 'subscriber_last_name';

    /**
     * Response data key - Terminal Id
     */
    const RESPONSE_DATA_KEY_TERMINAL_ID = 'terminal_id';

    /**
     * Response data key - Transaction - Completed On
     */
    const RESPONSE_DATA_KEY_TRANSACTION_COMPLETED_ON = 'transaction_completed_on';

    /**
     * Response data key - Transaction - Correlation Id
     */
    const RESPONSE_DATA_KEY_TRANSACTION_CORRELATION_ID = 'transaction_correlation_id';

    /**
     * Response data key - Transaction - Created On
     */
    const RESPONSE_DATA_KEY_TRANSACTION_CREATED_ON = 'transaction_created_on';

    /**
     * Response data key - Transaction - Merchant Transaction Id
     */
    const RESPONSE_DATA_KEY_TRANSACTION_MERCHANT_TRANSACTION_ID = 'transaction_merchant_transaction_id';

    /**
     * Response data key - Transaction - MFS Transaction Id
     */
    const RESPONSE_DATA_KEY_TRANSACTION_MFS_TRANSACTION_ID = 'transaction_mfs_transaction_id';

    /**
     * Response data key - Transaction - Status
     */
    const RESPONSE_DATA_KEY_TRANSACTION_STATUS = 'transaction_status';

    /**
     * Gets Callback Uri from response data
     * @return string|null
     */
    public function getCallbackUrl()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_CALLBACK_URI);
    }

    /**
     * Gets Exchange rate from response data
     * @return float|null
     */
    public function getExchangeRate()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_EXCHANGE_RATE);
    }

    /**
     * Gets Language from response data
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_LANGUAGE);
    }

    /**
     * Gets Local payment amount from response data
     * @return float|null
     */
    public function getLocalPaymentAmount()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_LOCAL_PAYMENT_AMOUNT);
    }

    /**
     * Gets Local payment currency code from response data
     * @return string|null
     */
    public function getLocalPaymentCurrencyCode()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_LOCAL_PAYMENT_CURRENCY_CODE);
    }

    /**
     * Gets Master_merchant_account from response data
     * @return string|null
     */
    public function getMasterMerchantAccount()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_MASTER_MERCHANT_ACCOUNT);
    }

    /**
     * Gets Master_merchant_id from response data
     * @return string|null
     */
    public function getMasterMerchantId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_MASTER_MERCHANT_ID);
    }

    /**
     * Gets Merchant_currency_code from response data
     * @return string|null
     */
    public function getMerchantCurrencyCode()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_MERCHANT_CURRENCY_CODE);
    }

    /**
     * Gets Merchant_fee from response data
     * @return float|null
     */
    public function getMerchantFee()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_MERCHANT_FEE);
    }

    /**
     * Gets Merchant_reference from response data
     * @return string|null
     */
    public function getMerchantReference()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_MERCHANT_REFERENCE);
    }

    /**
     * Gets Origin_payment_amount from response data
     * @return float|null
     */
    public function getOriginPaymentAmount()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_AMOUNT);
    }

    /**
     * Gets Origin_payment_currency_code from response data
     * @return string|null
     */
    public function getOriginPaymentCurrencyCode()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_CURRENCY_CODE);
    }

    /**
     * Gets Origin_payment_fee from response data
     * @return float|null
     */
    public function getOriginPaymentFee()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_FEE);
    }

    /**
     * Gets Origin_payment_tax from response data
     * @return float|null
     */
    public function getOriginPaymentTax()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_TAX);
    }

    /**
     * Gets Redirect_uri from response data
     * @return string|null
     */
    public function getRedirectUri()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_REDIRECT_URI);
    }

    /**
     * Gets Subscriber_account from response data
     * @return string|null
     */
    public function getSubscriberAccount()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_ACCOUNT);
    }

    /**
     * Gets Subscriber_country from response data
     * @return string|null
     */
    public function getSubscriberCountry()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_COUNTRY);
    }

    /**
     * Gets Subscriber_country_code from response data
     * @return string|null
     */
    public function getSubscriberCountryCode()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_COUNTRY_CODE);
    }

    /**
     * Gets Subscriber_email from response data
     * @return string|null
     */
    public function getSubscriberEmail()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_EMAIL);
    }

    /**
     * Gets Subscriber_first_name from response data
     * @return string|null
     */
    public function getSubscriberFirstName()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_FIRST_NAME);
    }

    /**
     * Gets Subscriber_last_name from response data
     * @return string|null
     */
    public function getSubscriberLastName()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_LAST_NAME);
    }

    /**
     * Gets Terminal_id from response data
     * @return string|null
     */
    public function getTerminalId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TERMINAL_ID);
    }

    /**
     * Gets Transaction_completed_on from response data
     * @return string|null
     */
    public function getTransactionCompletedOn()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_COMPLETED_ON);
    }

    /**
     * Gets Transaction_correlation_id from response data
     * @return string|null
     */
    public function getTransactionCorrelationId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_CORRELATION_ID);
    }

    /**
     * Gets Transaction_created_on from response data
     * @return string|null
     */
    public function getTransactionCreatedOn()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_CREATED_ON);
    }

    /**
     * Gets Transaction_merchant_transaction_id from response data
     * @return string|null
     */
    public function getTransactionMerchantTransactionId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MERCHANT_TRANSACTION_ID);
    }

    /**
     * Gets Transaction_mfs_transaction_id from response data
     * @return string|null
     */
    public function getTransactionMfsTransactionId()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MFS_TRANSACTION_ID);
    }

    /**
     * Gets Transaction_status from response data
     * @return string|null
     */
    public function getTransactionStatus()
    {
        return $this->getResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_STATUS);
    }

    /**
     * Sets Callback_uri to response data
     * @param mixed $input
     * @return $this
     */
    public function setCallbackUri($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_CALLBACK_URI, (string) $input);
    }

    /**
     * Sets Exchange_rate to response data
     * @param mixed $input
     * @return $this
     */
    public function setExchangeRate($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_EXCHANGE_RATE, (float) $input);
    }

    /**
     * Sets Language to response data
     * @param mixed $input
     * @return $this
     */
    public function setLanguage($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_LANGUAGE, (string) $input);
    }

    /**
     * Sets Local_payment_amount to response data
     * @param mixed $input
     * @return $this
     */
    public function setLocalPaymentAmount($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_LOCAL_PAYMENT_AMOUNT, (float) $input);
    }

    /**
     * Sets Local_payment_currency_code to response data
     * @param mixed $input
     * @return $this
     */
    public function setLocalPaymentCurrencyCode($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_LOCAL_PAYMENT_CURRENCY_CODE, (string) $input);
    }

    /**
     * Sets Master_merchant_account to response data
     * @param mixed $input
     * @return $this
     */
    public function setMasterMerchantAccount($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_MASTER_MERCHANT_ACCOUNT, (string) $input);
    }

    /**
     * Sets Master_merchant_id to response data
     * @param mixed $input
     * @return $this
     */
    public function setMasterMerchantId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_MASTER_MERCHANT_ID, (string) $input);
    }

    /**
     * Sets Merchant_currency_code to response data
     * @param mixed $input
     * @return $this
     */
    public function setMerchantCurrencyCode($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_MERCHANT_CURRENCY_CODE, (string) $input);
    }

    /**
     * Sets Merchant_fee to response data
     * @param mixed $input
     * @return $this
     */
    public function setMerchantFee($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_MERCHANT_FEE, (float) $input);
    }

    /**
     * Sets Merchant_reference to response data
     * @param mixed $input
     * @return $this
     */
    public function setMerchantReference($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_MERCHANT_REFERENCE, (string) $input);
    }

    /**
     * Sets Origin_payment_amount to response data
     * @param mixed $input
     * @return $this
     */
    public function setOriginPaymentAmount($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_AMOUNT, (float) $input);
    }

    /**
     * Sets Origin_payment_currency_code to response data
     * @param mixed $input
     * @return $this
     */
    public function setOriginPaymentCurrencyCode($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_CURRENCY_CODE, (string) $input);
    }

    /**
     * Sets Origin_payment_fee to response data
     * @param mixed $input
     * @return $this
     */
    public function setOriginPaymentFee($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_FEE, (float) $input);
    }

    /**
     * Sets Origin_payment_tax to response data
     * @param mixed $input
     * @return $this
     */
    public function setOriginPaymentTax($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_ORIGIN_PAYMENT_TAX, (float) $input);
    }

    /**
     * Sets Redirect_uri to response data
     * @param mixed $input
     * @return $this
     */
    public function setRedirectUri($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_REDIRECT_URI, (string) $input);
    }

    /**
     * Sets Subscriber_account to response data
     * @param mixed $input
     * @return $this
     */
    public function setSubscriberAccount($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_ACCOUNT, (string) $input);
    }

    /**
     * Sets Subscriber_country to response data
     * @param mixed $input
     * @return $this
     */
    public function setSubscriberCountry($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_COUNTRY, (string) $input);
    }

    /**
     * Sets Subscriber_country_code to response data
     * @param mixed $input
     * @return $this
     */
    public function setSubscriberCountryCode($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_COUNTRY_CODE, (string) $input);
    }

    /**
     * Sets Subscriber_email to response data
     * @param mixed $input
     * @return $this
     */
    public function setSubscriberEmail($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_EMAIL, (string) $input);
    }

    /**
     * Sets Subscriber_first_name to response data
     * @param mixed $input
     * @return $this
     */
    public function setSubscriberFirstName($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_FIRST_NAME, (string) $input);
    }

    /**
     * Sets Subscriber_last_name to response data
     * @param mixed $input
     * @return $this
     */
    public function setSubscriberLastName($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_SUBSCRIBER_LAST_NAME, (string) $input);
    }

    /**
     * Sets Terminal_id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTerminalId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TERMINAL_ID, (string) $input);
    }

    /**
     * Sets Transaction_completed_on to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionCompletedOn($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_COMPLETED_ON, (string) $input);
    }

    /**
     * Sets Transaction_correlation_id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionCorrelationId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_CORRELATION_ID, (string) $input);
    }

    /**
     * Sets Transaction_created_on to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionCreatedOn($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_CREATED_ON, (string) $input);
    }

    /**
     * Sets Transaction_merchant_transaction_id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionMerchantTransactionId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MERCHANT_TRANSACTION_ID, (string) $input);
    }

    /**
     * Sets Transaction_mfs_transaction_id to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionMfsTransactionId($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_MFS_TRANSACTION_ID, (string) $input);
    }

    /**
     * Sets Transaction_status to response data
     * @param mixed $input
     * @return $this
     */
    public function setTransactionStatus($input)
    {
        return $this->addResponseData(self::RESPONSE_DATA_KEY_TRANSACTION_STATUS, (string) $input);
    }
}