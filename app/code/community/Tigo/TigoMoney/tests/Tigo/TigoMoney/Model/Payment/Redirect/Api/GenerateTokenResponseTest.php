<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponseTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponseTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenResponse::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->setConstructorArgs(array(new Varien_Object()))
            ->getMock();

    }

    public function testAccessTokenGetterSetter()
    {
        $value = '393mas0932mam09maslk';
        $this
            ->subject
            ->setAccessToken($value);
        $this->assertEquals(
            $value,
            $this->subject->getAccessToken()
        );
    }

}

