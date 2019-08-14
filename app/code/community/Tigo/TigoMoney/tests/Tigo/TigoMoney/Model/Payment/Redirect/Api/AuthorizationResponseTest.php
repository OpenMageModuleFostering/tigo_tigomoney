<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponseTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponseTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationResponse::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->setConstructorArgs(array(new Varien_Object()))
            ->getMock();

    }

    public function testAuthCodeGetterSetter()
    {
        $value = '9493230923';
        $this
            ->subject
            ->setAuthCode($value);
        $this->assertEquals(
            $value,
            $this->subject->getAuthCode()
        );
    }

    public function testRedirectUriGetterSetter()
    {
        $value = 'http://altavista.com/';
        $this
            ->subject
            ->setRedirectUri($value);
        $this->assertEquals(
            $value,
            $this->subject->getRedirectUri()
        );
    }

}

