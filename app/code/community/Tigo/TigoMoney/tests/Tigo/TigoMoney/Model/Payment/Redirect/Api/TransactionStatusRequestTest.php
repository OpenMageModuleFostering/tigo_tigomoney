<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequestTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequestTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->getMock();

    }

    public function testAccessTokenGetterSetter()
    {
        $value = 'ASDmfiemasd39432';
        $this
            ->subject
            ->setAccessToken($value);
        $this->assertEquals(
            $value,
            $this->subject->getAccessToken()
        );
    }

    public function testCountryGetterSetter()
    {
        $value = Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR;
        $this
            ->subject
            ->setCountry($value);
        $this->assertEquals(
            $value,
            $this->subject->getCountry()
        );
    }

    public function testMasterMerchantIdGetterSetter()
    {
        $value = '1238712938712';
        $this
            ->subject
            ->setMasterMerchantId($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterMerchantId()
        );
    }

    public function testMerchantTransactionIdGetterSetter()
    {
        $value = '100009823';
        $this
            ->subject
            ->setMerchantTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getMerchantTransactionId()
        );
    }


    public function testEndpointPathGetter()
    {
        $country = Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR;
        $masterMerchantId = '39398293823';
        $merchantTransactionId = '3929382392vdfvdfs09093';
        $endpoint = Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::ENDPOINT_PATH . $country
            . '/' . $masterMerchantId . '/' . $merchantTransactionId;

        $this->subject->setCountry($country);
        $this->subject->setMasterMerchantId($masterMerchantId);
        $this->subject->setMerchantTransactionId($merchantTransactionId);

        $this->assertEquals(
            $endpoint,
            $this->subject->getEndpointPath()
        );
    }

    public function testHeaderGetter()
    {
        $accessToken = 'lmflsdkmf9mp';
        $this->subject->setAccessToken($accessToken);
        $this->assertEquals(
            array(
                'Authorization' => 'Bearer ' . $accessToken
            ),
            $this->subject->getHeaders()
        );
    }

    public function testMethodGetter()
    {
        $this->assertEquals(
            Varien_Http_Client::GET,
            $this->subject->getMethod()
        );
    }

    public function testValidateDataProvider()
    {
        return array(
            array('oieomosadoivdvd98', Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR, '1234324234', '10000023', true),
            array(null, Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR, '1234324234', '10000023', false),
            array('oieomosadoivdvd98', null, '1234324234', '10000023', false),
            array('oieomosadoivdvd98', Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR, null, '10000023', false),
            array('oieomosadoivdvd98', Tigo_TigoMoney_Model_Payment_Redirect_Api_TransactionStatusRequest::COUNTRY_CODE_EL_SALVADOR, '1234324234', null, false),
        );
    }

    /**
     * @param $accessToken
     * @param $country
     * @param $merchantId
     * @param $transactionId
     * @param $result
     * @dataProvider testValidateDataProvider
     */
    public function testValidate(
        $accessToken,
        $country,
        $merchantId,
        $transactionId,
        $result
    ) {
        $this
            ->subject
            ->setAccessToken($accessToken);
        $this
            ->subject
            ->setCountry($country);
        $this
            ->subject
            ->setMasterMerchantId($merchantId);
        $this
            ->subject
            ->setMerchantTransactionId($transactionId);

        $this->assertEquals(
            $result,
            $this->subject->validate()
        );
    }

    public function testGetBody() {

        $requestBody = $this->subject->getBody();

        $this->assertEquals(
            '',
            $requestBody
        );

    }
}

