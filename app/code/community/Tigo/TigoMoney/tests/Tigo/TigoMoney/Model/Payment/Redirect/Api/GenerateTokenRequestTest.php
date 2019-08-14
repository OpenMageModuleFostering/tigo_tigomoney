<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequestTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequestTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->getMock();

    }

    public function testClientIdGetterSetter()
    {
        $value = '12314123';
        $this
            ->subject
            ->setClientId($value);
        $this->assertEquals(
            $value,
            $this->subject->getClientId()
        );
    }

    public function testClientSecretGetterSetter()
    {
        $value = 'mkdkmsdmf093asdfasdfas23';
        $this
            ->subject
            ->setClientSecret($value);
        $this->assertEquals(
            $value,
            $this->subject->getClientSecret()
        );
    }

    public function testEndpointPathGetter()
    {
        $value = Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest::ENDPOINT_PATH;
        $this->assertEquals(
            $value,
            $this->subject->getEndpointPath()
        );
    }

    public function testHeaderGetter()
    {
        $clientId = '12314123';
        $clientSecret = 'mkdkmsdmf093asdfasdfas23';
        $this
            ->subject
            ->setClientId($clientId);
        $this
            ->subject
            ->setClientSecret($clientSecret);
        $this->assertEquals(
            array(
                Varien_Http_Client::CONTENT_TYPE => Varien_Http_Client::ENC_URLENCODED,
                'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret)
            ),
            $this->subject->getHeaders()
        );
    }

    public function testMethodGetter()
    {
        $this->assertEquals(
            Varien_Http_Client::POST,
            $this->subject->getMethod()
        );
    }

    public function testValidateDataProvider()
    {
        return array(
            array('231231', 'asmsdafsdfln', true),
            array('231231', null, false),
            array(null, 'asmsdafsdfln', false),
        );
    }

    /**
     * @param $clientId
     * @param $clientSecret
     * @param $result
     * @dataProvider testValidateDataProvider
     */
    public function testValidate(
        $clientId,
        $clientSecret,
        $result
    ) {
        $this
            ->subject
            ->setClientId($clientId);
        $this
            ->subject
            ->setClientSecret($clientSecret);

        $this->assertEquals(
            $result,
            $this->subject->validate()
        );
    }

    public function testGetBody() {

        $requestBody = $this->subject->getBody();

        $this->assertEquals(
            Tigo_TigoMoney_Model_Payment_Redirect_Api_GenerateTokenRequest::REQUEST_BODY,
            $requestBody
        );

    }
}

