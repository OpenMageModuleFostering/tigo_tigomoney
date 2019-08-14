<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequestTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequestTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->getMock();

    }

    public function testAccessTokenGetterSetter()
    {
        $value = 'asdff9kokasdf';
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
        $value = Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::COUNTRY_CODE_EL_SALVADOR;
        $this
            ->subject
            ->setCountry($value);
        $this->assertEquals(
            $value,
            $this->subject->getCountry()
        );
    }

    public function testLocalPaymentAmountGetterSetter()
    {
        $value = 108.39;
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
        $value = Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::CURRENCY_CODE_USD;
        $this
            ->subject
            ->setLocalPaymentCurrencyCode($value);
        $this->assertEquals(
            $value,
            $this->subject->getLocalPaymentCurrencyCode()
        );
    }

    public function testMasterAccountAccountGetterSetter()
    {
        $value = '938298329830283';
        $this
            ->subject
            ->setMasterAccountAccount($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterAccountAccount()
        );
    }

    public function testMasterAccountIdGetterSetter()
    {
        $value = '3939393';
        $this
            ->subject
            ->setMasterAccountId($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterAccountId()
        );
    }

    public function testMasterAccountPinGetterSetter()
    {
        $value = 'mcosd09msd8fms98n';
        $this
            ->subject
            ->setMasterAccountPin($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterAccountPin()
        );
    }

    public function testMerchantTransactionIdGetterSetter()
    {
        $value = '10009839';
        $this
            ->subject
            ->setMerchantTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getMerchantTransactionId()
        );
    }

    public function testMfsTransactionIdGetterSetter()
    {
        $value = '392282089329832982';
        $this
            ->subject
            ->setMfsTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getMfsTransactionId()
        );
    }

    public function testSubscriberAccountGetterSetter()
    {
        $value = '50792839283';
        $this
            ->subject
            ->setSubscriberAccount($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberAccount()
        );
    }

    public function testEndpointPathGetter()
    {
        $country = Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::COUNTRY_CODE_EL_SALVADOR;
        $mfsTransactionId = '39398293823';
        $merchantTransactionId = '3929382392vdfvdfs09093';
        $endpoint = Tigo_TigoMoney_Model_Payment_Redirect_Api_ReverseTransactionRequest::ENDPOINT_PATH . $country
            . '/' . $mfsTransactionId . '/' . $merchantTransactionId;

        $this->subject->setCountry($country);
        $this->subject->setMfsTransactionId($mfsTransactionId);
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
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ),
            $this->subject->getHeaders()
        );
    }

    public function testMethodGetter()
    {
        $this->assertEquals(
            Varien_Http_Client::DELETE,
            $this->subject->getMethod()
        );
    }

    public function testValidateDataProvider()
    {
        return array(
            array('92imoim92', 'SLV', '128391823019823', '100000932', '11ms09202039', '39230293asdf', 'asdf234234asdf', '938992892', 2093.32, 'USD', true),
            array(null, 'SLV', '128391823019823', '100000932', '11ms09202039', '39230293asdf', 'asdf234234asdf', '938992892', 2093.32, 'USD', false),
            array('92imoim92', null, '128391823019823', '100000932', '11ms09202039', '39230293asdf', 'asdf234234asdf', '938992892', 2093.32, 'USD', false),
            array('92imoim92', 'SLV', null, '100000932', '11ms09202039', '39230293asdf', 'asdf234234asdf', '938992892', 2093.32, 'USD', false),
            array('92imoim92', 'SLV', '128391823019823', null, '11ms09202039', '39230293asdf', 'asdf234234asdf', '938992892', 2093.32, 'USD', false),
            array('92imoim92', 'SLV', '128391823019823', '100000932', null, '39230293asdf', 'asdf234234asdf', '938992892', 2093.32, 'USD', false),
            array('92imoim92', 'SLV', '128391823019823', '100000932', '11ms09202039', null, 'asdf234234asdf', '938992892', 2093.32, 'USD', true),
            array('92imoim92', 'SLV', '128391823019823', '100000932', '11ms09202039', '39230293asdf', null, '938992892', 2093.32, 'USD', false),
            array('92imoim92', 'SLV', '128391823019823', '100000932', '11ms09202039', '39230293asdf', 'asdf234234asdf', null, 2093.32, 'USD', false),
            array('92imoim92', 'SLV', '128391823019823', '100000932', '11ms09202039', '39230293asdf', 'asdf234234asdf', '938992892', null, 'USD', false),
            array('92imoim92', 'SLV', '128391823019823', '100000932', '11ms09202039', '39230293asdf', 'asdf234234asdf', '938992892', 2093.32, null, false)
        );
    }

    /**
     * @param $accessToken
     * @param $country
     * @param $mfsTransactionId
     * @param $merchantTransactionId
     * @param $masterAccountAccount
     * @param $masterAccountId
     * @param $masterAccountPin
     * @param $subscriberAccount
     * @param $localPaymentAmount
     * @param $localPaymentCurrencyCode
     * @param $result
     * @dataProvider testValidateDataProvider
     */
    public function testValidate(
        $accessToken,
        $country,
        $mfsTransactionId,
        $merchantTransactionId,
        $masterAccountAccount,
        $masterAccountId,
        $masterAccountPin,
        $subscriberAccount,
        $localPaymentAmount,
        $localPaymentCurrencyCode,
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
            ->setMfsTransactionId($mfsTransactionId);
        $this
            ->subject
            ->setMerchantTransactionId($merchantTransactionId);
        $this
            ->subject
            ->setMasterAccountAccount($masterAccountAccount);
        $this
            ->subject
            ->setMasterAccountId($masterAccountId);
        $this
            ->subject
            ->setMasterAccountPin($masterAccountPin);
        $this
            ->subject
            ->setSubscriberAccount($subscriberAccount);
        $this
            ->subject
            ->setLocalPaymentAmount($localPaymentAmount);
        $this
            ->subject
            ->setLocalPaymentCurrencyCode($localPaymentCurrencyCode);
        $this->assertEquals(
            $result,
            $this->subject->validate()
        );
    }
    public function testGetBodyDataProvider()
    {
        return array(
            array('384398', '29382983', '23982938', '92839823', 38392.3900, 'USD'),
        );
    }

    /**
     * @param $masterAccountAccount
     * @param $masterAccountId
     * @param $masterAccountPin
     * @param $subscriberAccount
     * @param $localPaymentAmount
     * @param $localPaymentCurrencyCode
     * @dataProvider testGetBodyDataProvider
     */
    public function testGetBody(
        $masterAccountAccount,
        $masterAccountId,
        $masterAccountPin,
        $subscriberAccount,
        $localPaymentAmount,
        $localPaymentCurrencyCode
    ) {
        $this->subject->setMasterAccountAccount($masterAccountAccount);
        $this->subject->setMasterAccountId($masterAccountId);
        $this->subject->setMasterAccountPin($masterAccountPin);
        $this->subject->setSubscriberAccount($subscriberAccount);
        $this->subject->setLocalPaymentAmount($localPaymentAmount);
        $this->subject->setLocalPaymentCurrencyCode($localPaymentCurrencyCode);

        $requestBody = $this->subject->getBody();

        $requestBodyJsonArr = json_decode($requestBody, true);

        $this->assertEquals(
            $requestBodyJsonArr['MasterAccount']['account'],
            $masterAccountAccount
        );

        $this->assertEquals(
            $requestBodyJsonArr['MasterAccount']['id'],
            $masterAccountId
        );

        $this->assertEquals(
            $requestBodyJsonArr['MasterAccount']['pin'],
            $masterAccountPin
        );

        $this->assertEquals(
            $requestBodyJsonArr['subscriberAccount'],
            $subscriberAccount
        );

        $this->assertEquals(
            $requestBodyJsonArr['LocalPayment']['amount'],
            number_format($localPaymentAmount, 2, '.', '')
        );

        $this->assertEquals(
            $requestBodyJsonArr['LocalPayment']['currencyCode'],
            $localPaymentCurrencyCode
        );
    }
}

