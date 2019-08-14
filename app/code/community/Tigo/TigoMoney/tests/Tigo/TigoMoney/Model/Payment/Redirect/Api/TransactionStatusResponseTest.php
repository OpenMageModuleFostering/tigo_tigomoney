<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponseTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponseTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusResponse::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->setConstructorArgs(array(new Varien_Object()))
            ->getMock();

    }

    public function testCallbackUrlGetterSetter()
    {
        $value = 'http://amazon.com/return/test';
        $this
            ->subject
            ->setCallbackUri($value);
        $this->assertEquals(
            $value,
            $this->subject->getCallbackUrl()
        );
    }

    public function testExchangeRateGetterSetter()
    {
        $value = 1.3;
        $this
            ->subject
            ->setExchangeRate($value);
        $this->assertEquals(
            $value,
            $this->subject->getExchangeRate()
        );
    }

    public function testLanguageGetterSetter()
    {
        $value = 'spa';
        $this
            ->subject
            ->setLanguage($value);
        $this->assertEquals(
            $value,
            $this->subject->getLanguage()
        );
    }

    public function testLocalPaymentAmountGetterSetter()
    {
        $value = 1231.23;
        $this
            ->subject
            ->setLocalPaymentAmount($value);
        $this->assertEquals(
            $value,
            $this->subject->getLocalPaymentAmount()
        );
    }

    public function testLocalPaymentCurrencyCodeGetterSetter()
    {
        $value = 'USD';
        $this
            ->subject
            ->setLocalPaymentCurrencyCode($value);
        $this->assertEquals(
            $value,
            $this->subject->getLocalPaymentCurrencyCode()
        );
    }

    public function testMasterMerchantAccountGetterSetter()
    {
        $value = '123123';
        $this
            ->subject
            ->setMasterMerchantAccount($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterMerchantAccount()
        );
    }

    public function testMasterMerchantIdGetterSetter()
    {
        $value = 'kmkmdfkdmf';
        $this
            ->subject
            ->setMasterMerchantId($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterMerchantId()
        );
    }

    public function testMerchantReferenceGetterSetter()
    {
        $value = 'Amazon';
        $this
            ->subject
            ->setMerchantReference($value);
        $this->assertEquals(
            $value,
            $this->subject->getMerchantReference()
        );
    }

    public function testMerchantCurrencyCodeGetterSetter()
    {
        $value = 'USD';
        $this
            ->subject
            ->setMerchantCurrencyCode($value);
        $this->assertEquals(
            $value,
            $this->subject->getMerchantCurrencyCode()
        );
    }

    public function testMerchantFeeGetterSetter()
    {
        $value = 20.38;
        $this
            ->subject
            ->setMerchantFee($value);
        $this->assertEquals(
            $value,
            $this->subject->getMerchantFee()
        );
    }

    public function testOriginPaymentAmountGetterSetter()
    {
        $value = 20.38;
        $this
            ->subject
            ->setOriginPaymentAmount($value);
        $this->assertEquals(
            $value,
            $this->subject->getOriginPaymentAmount()
        );
    }

    public function testOriginPaymentCurrencyCodeGetterSetter()
    {
        $value = 'USD';
        $this
            ->subject
            ->setOriginPaymentCurrencyCode($value);
        $this->assertEquals(
            $value,
            $this->subject->getOriginPaymentCurrencyCode()
        );
    }

    public function testOriginPaymentFeeGetterSetter()
    {
        $value = 123.23;
        $this
            ->subject
            ->setOriginPaymentFee($value);
        $this->assertEquals(
            $value,
            $this->subject->getOriginPaymentFee()
        );
    }

    public function testOriginPaymentTaxGetterSetter()
    {
        $value = 123.34;
        $this
            ->subject
            ->setOriginPaymentTax($value);
        $this->assertEquals(
            $value,
            $this->subject->getOriginPaymentTax()
        );
    }

    public function testRedirectUriGetterSetter()
    {
        $value = 'http://google.com/return/success';
        $this
            ->subject
            ->setRedirectUri($value);
        $this->assertEquals(
            $value,
            $this->subject->getRedirectUri()
        );
    }

    public function testSubscriberAccountGetterSetter()
    {
        $value = '570293823';
        $this
            ->subject
            ->setSubscriberAccount($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberAccount()
        );
    }

    public function testSubscriberCountryGetterSetter()
    {
        $value = '570293823';
        $this
            ->subject
            ->setSubscriberCountry($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberCountry()
        );
    }

    public function testSubscriberCountryCodeGetterSetter()
    {
        $value = 'SLV';
        $this
            ->subject
            ->setSubscriberCountryCode($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberCountryCode()
        );
    }

    public function testSubscriberEmailGetterSetter()
    {
        $value = 'johndoe@gmail.com';
        $this
            ->subject
            ->setSubscriberEmail($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberEmail()
        );
    }

    public function testSubscriberFirstNameGetterSetter()
    {
        $value = 'John';
        $this
            ->subject
            ->setSubscriberFirstName($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberFirstName()
        );
    }

    public function testSubscriberLastNameGetterSetter()
    {
        $value = 'Doe';
        $this
            ->subject
            ->setSubscriberLastName($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberLastName()
        );
    }

    public function testTerminalIdGetterSetter()
    {
        $value = 'Magento';
        $this
            ->subject
            ->setTerminalId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTerminalId()
        );
    }

    public function testTransactionCompletedOnGetterSetter()
    {
        $value = '2018-09-13';
        $this
            ->subject
            ->setTransactionCompletedOn($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionCompletedOn()
        );
    }

    public function testTransactionCorrelationIdGetterSetter()
    {
        $value = 'o09cdkm09lkm09';
        $this
            ->subject
            ->setTransactionCorrelationId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionCorrelationId()
        );
    }

    public function testTransactionCreatedOnGetterSetter()
    {
        $value = '2017-12-23';
        $this
            ->subject
            ->setTransactionCreatedOn($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionCreatedOn()
        );
    }

    public function testTransactionMerchantTransactionIdGetterSetter()
    {
        $value = '10000923';
        $this
            ->subject
            ->setTransactionMerchantTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionMerchantTransactionId()
        );
    }

    public function testTransactionMfsTransactionIdGetterSetter()
    {
        $value = '23092309823';
        $this
            ->subject
            ->setTransactionMfsTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionMfsTransactionId()
        );
    }

    public function testTransactionStatusGetterSetter()
    {
        $value = 'success';
        $this
            ->subject
            ->setTransactionStatus($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionStatus()
        );
    }

}

