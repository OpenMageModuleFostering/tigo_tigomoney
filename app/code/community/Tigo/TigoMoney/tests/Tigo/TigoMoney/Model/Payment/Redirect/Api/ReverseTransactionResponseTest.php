<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponseTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponseTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionResponse::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->setConstructorArgs(array(new Varien_Object()))
            ->getMock();

    }

    public function testErrorGetterSetter()
    {
        $value = '3938';
        $this
            ->subject
            ->setError($value);
        $this->assertEquals(
            $value,
            $this->subject->getError()
        );
    }

    public function testErrorDescriptionGetterSetter()
    {
        $value = '3938';
        $this
            ->subject
            ->setErrorDescription($value);
        $this->assertEquals(
            $value,
            $this->subject->getErrorDescription()
        );
    }

    public function testErrorTypeGetterSetter()
    {
        $value = 'warning';
        $this
            ->subject
            ->setErrorType($value);
        $this->assertEquals(
            $value,
            $this->subject->getErrorType()
        );
    }

    public function testStatusGetterSetter()
    {
        $value = 'success';
        $this
            ->subject
            ->setStatus($value);
        $this->assertEquals(
            $value,
            $this->subject->getStatus()
        );
    }

    public function testTransactionCorrelationIdGetterSetter()
    {
        $value = '02390293';
        $this
            ->subject
            ->setTransactionCorrelationId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionCorrelationId()
        );
    }

    public function testTransactionMerchantTransactionIdGetterSetter()
    {
        $value = '1000023423';
        $this
            ->subject
            ->setTransactionMerchantTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionMerchantTransactionId()
        );
    }

    public function testTransactionMessageGetterSetter()
    {
        $value = 'Transaction Refunded';
        $this
            ->subject
            ->setTransactionMessage($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionMessage()
        );
    }

    public function testTransactionMfsTransactionIdGetterSetter()
    {
        $value = '0209283029834';
        $this
            ->subject
            ->setTransactionMfsTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionMfsTransactionId()
        );
    }

    public function testTransactionMfsReverseTransactionIdGetterSetter()
    {
        $value = '020928302983434343';
        $this
            ->subject
            ->setTransactionMfsReverseTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getTransactionMfsReverseTransactionId()
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

