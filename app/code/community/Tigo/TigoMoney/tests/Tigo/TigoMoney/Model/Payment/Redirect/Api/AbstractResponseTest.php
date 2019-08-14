<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponseTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponseTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_AbstractResponse::class;

        $this->subject = $this
            ->getModelMock(
                'tigo_tigomoney/payment_redirect_api_abstractResponse',
                array(),
                true,
                array(new Varien_Object())
            );

    }

    public function testResponseDataGetterSetter()
    {
        $key = 'mfsTransactionId';
        $value = '393mas0932mam09maslk';
        $this
            ->subject
            ->addResponseData($key, $value);
        $this->assertEquals(
            $value,
            $this->subject->getResponseData($key)
        );
    }

    public function testIsSuccessInitially()
    {
        $this->assertTrue(
            $this->subject->isSuccess()
        );
    }

    public function testIsErrorWhenErrorsAdded()
    {
        $this->subject->addError(('Some Error'));
        $this->assertFalse(
            $this->subject->isSuccess()
        );
        $this->assertTrue(
            $this->subject->isError()
        );
    }

    public function testErrorGetter()
    {
        $this->subject->addError(('Some Error 1'));
        $this->subject->addError(('Some Error 1'));
        $this->subject->addError(('Some Error 2'));
        $this->subject->addError(('Some Error 3'));
        $this->assertEquals(
            array('Some Error 1', 'Some Error 2', 'Some Error 3'),
            $this->subject->getErrors()
        );
    }

}

