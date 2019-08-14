<?php

/**
 * Class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequestTest
 */
class Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequestTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(null)
            ->getMock();

    }

    public function testAccessTokenGetterSetter()
    {
        $value = '23298u294asdf0';
        $this
            ->subject
            ->setAccessToken($value);
        $this->assertEquals(
            $value,
            $this->subject->getAccessToken()
        );
    }

    public function testCallbackUriGetterSetter()
    {
        $value = 'http://google.com/';
        $this
            ->subject
            ->setCallbackUri($value);
        $this->assertEquals(
            $value,
            $this->subject->getCallbackUri()
        );
    }

    public function testExchangeRateGetterSetter()
    {
        $value = 1;
        $this
            ->subject
            ->setExchangeRate($value);
        $this->assertEquals(
            $value,
            $this->subject->getExchangeRate()
        );
    }

    public function testEndpointPathGetter()
    {
        $value = Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::ENDPOINT_PATH;
        $this->assertEquals(
            $value,
            $this->subject->getEndpointPath()
        );
    }

    public function testHeaderGetter()
    {
        $accessToken = '39mvadsosm2';
        $this
            ->subject
            ->setAccessToken($accessToken);
        $this->assertEquals(
            array(
                Varien_Http_Client::CONTENT_TYPE => Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CONTENT_TYPE_JSON,
                'Authorization' => 'Bearer ' . $accessToken
            ),
            $this->subject->getHeaders()
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
        $value = 1829.39;
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
        $value = '9834938483';
        $this
            ->subject
            ->setMasterMerchantAccount($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterMerchantAccount()
        );
    }

    public function testMasterMerchantPinGetterSetter()
    {
        $value = '393938';
        $this
            ->subject
            ->setMasterMerchantPin($value);
        $this->assertEquals(
            $value,
            $this->subject->getMasterMerchantPin()
        );
    }

    public function testMasterMerchantIdGetterSetter()
    {
        $value = '1239871';
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

    public function testMerchantTransactionIdGetterSetter()
    {
        $value = '10009283';
        $this
            ->subject
            ->setMerchantTransactionId($value);
        $this->assertEquals(
            $value,
            $this->subject->getMerchantTransactionId()
        );
    }

    public function testMerchantFeeGetterSetter()
    {
        $value = 27.50;
        $this
            ->subject
            ->setMerchantFee($value);
        $this->assertEquals(
            $value,
            $this->subject->getMerchantFee()
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

    public function testMethodGetter()
    {
        $this->assertEquals(
            Varien_Http_Client::POST,
            $this->subject->getMethod()
        );
    }

    public function testOriginPaymentAmountGetterSetter()
    {
        $value = 8372.08;
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

    public function testOriginPaymentTaxGetterSetter()
    {
        $value = 9383.43;
        $this
            ->subject
            ->setOriginPaymentTax($value);
        $this->assertEquals(
            $value,
            $this->subject->getOriginPaymentTax()
        );
    }

    public function testOriginPaymentFeeGetterSetter()
    {
        $value = 87.20;
        $this
            ->subject
            ->setOriginPaymentFee($value);
        $this->assertEquals(
            $value,
            $this->subject->getOriginPaymentFee()
        );
    }

    public function testRedirectUriGetterSetter()
    {
        $value = 'http://amazon.com/';
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
        $value = '746363638';
        $this
            ->subject
            ->setSubscriberAccount($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberAccount()
        );
    }

    public function testSubscriberCountryCodeGetterSetter()
    {
        $value = '57';
        $this
            ->subject
            ->setSubscriberCountryCode($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberCountryCode()
        );
    }

    public function testSubscriberCountryGetterSetter()
    {
        $value = 'SLV';
        $this
            ->subject
            ->setSubscriberCountry($value);
        $this->assertEquals(
            $value,
            $this->subject->getSubscriberCountry()
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

    public function testValidateDataProvider()
    {
        return array(
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', true),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', null, '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', null, 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', null, 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, null, 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', null, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', null, 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', null, 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', null, 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', null, 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', null, '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', 'lkmfalsdk', null, 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', '09jasdf', null, '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', '0sdnf', null, 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array('jsndf', null, '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false),
            array(null, '0sdnf', '09jasdf', 'lkmfalsdk', '83729837', 'SLV', '570', 'John', 'Doe', 'johndoe@gmail.com', 100.38, 'USD', 'http://google.com', 'http://amazon.com', 'SPA', '10000298', false)
        );
    }

    /**
     * @param $accessToken
     * @param $masterMerchantAccount
     * @param $masterMerchantPin
     * @param $masterMerchantId
     * @param $subscriberAccount
     * @param $subscriberCountry
     * @param $subscriberCountryCode
     * @param $subscriberFirstName
     * @param $subscriberLastName
     * @param $subscriberEmail
     * @param $localPaymentAmount
     * @param $localPaymentCurrencyCode
     * @param $redirectUri
     * @param $callbackUri
     * @param $language
     * @param $merchantTransactionId
     * @param $result
     * @dataProvider testValidateDataProvider
     */
    public function testValidate(
        $accessToken,
        $masterMerchantAccount,
        $masterMerchantPin,
        $masterMerchantId,
        $subscriberAccount,
        $subscriberCountry,
        $subscriberCountryCode,
        $subscriberFirstName,
        $subscriberLastName,
        $subscriberEmail,
        $localPaymentAmount,
        $localPaymentCurrencyCode,
        $redirectUri,
        $callbackUri,
        $language,
        $merchantTransactionId,
        $result
    )
    {
        $this
            ->subject
            ->setAccessToken($accessToken);
        $this
            ->subject
            ->setMasterMerchantAccount($masterMerchantAccount);

        $this
            ->subject
            ->setMasterMerchantPin($masterMerchantPin);

        $this
            ->subject
            ->setMasterMerchantId($masterMerchantId);

        $this
            ->subject
            ->setSubscriberAccount($subscriberAccount);

        $this
            ->subject
            ->setSubscriberCountry($subscriberCountry);

        $this
            ->subject
            ->setSubscriberCountryCode($subscriberCountryCode);

        $this
            ->subject
            ->setSubscriberFirstName($subscriberFirstName);

        $this
            ->subject
            ->setSubscriberLastName($subscriberLastName);

        $this
            ->subject
            ->setSubscriberEmail($subscriberEmail);

        $this
            ->subject
            ->setLocalPaymentAmount($localPaymentAmount);

        $this
            ->subject
            ->setLocalPaymentCurrencyCode($localPaymentCurrencyCode);

        $this
            ->subject
            ->setRedirectUri($redirectUri);

        $this
            ->subject
            ->setCallbackUri($callbackUri);

        $this
            ->subject
            ->setLanguage($language);

        $this
            ->subject
            ->setMerchantTransactionId($merchantTransactionId);

        $this->assertEquals(
            $result,
            $this->subject->validate()
        );
    }

    public function testGetBodyWithMerchantInfoDataProvider()
    {
        return array(
            array('839232', '92839283', '932934', '29384234', 'Amazon', '28329823', 'Luis', 'Solano', 'luissolano@hotmail.com', 279.93, 279.93, 0, 0, 'http://google.com', 'http://amazon.com', '100009283', 1),
            array('839232', '92839283', '932934', '29384234', null, '28329823', 'Luis', 'Solano', 'luissolano@hotmail.com', 279.93, 279.93, 0, 0, 'http://google.com', 'http://amazon.com', '100009283-1', 1)
        );
    }

    /**
     * @param $accessToken
     * @param $merchantAccount
     * @param $merchantPin
     * @param $merchantId
     * @param $merchantReference
     * @param $subscriberAccount
     * @param $subscriberFirstName
     * @param $subscriberLastName
     * @param $subscriberEmail
     * @param $localPaymentAmount
     * @param $originPaymentAmount
     * @param $originPaymentTax
     * @param $originPaymentFee
     * @param $redirectUri
     * @param $callbackUri
     * @param $merchantTransactionId
     * @param $exchangeRate
     * @dataProvider testGetBodyWithMerchantInfoDataProvider
     */
    public function testGetBodyWithMerchantInfo(
        $accessToken,
        $merchantAccount,
        $merchantPin,
        $merchantId,
        $merchantReference,
        $subscriberAccount,
        $subscriberFirstName,
        $subscriberLastName,
        $subscriberEmail,
        $localPaymentAmount,
        $originPaymentAmount,
        $originPaymentTax,
        $originPaymentFee,
        $redirectUri,
        $callbackUri,
        $merchantTransactionId,
        $exchangeRate
    ) {
        # Access Token
        $this->subject->setAccessToken($accessToken);

        # Master Merchant Account Info
        $this->subject->setMasterMerchantAccount($merchantAccount);
        $this->subject->setMasterMerchantPin($merchantPin);
        $this->subject->setMasterMerchantId($merchantId);

        # Merchant Info
        $this->subject->setMerchantReference($merchantReference);
        $this->subject->setMerchantCurrencyCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD);
        $this->subject->setMerchantFee(0);

        # Subscriber
        $this->subject->setSubscriberAccount($subscriberAccount);
        $this->subject->setSubscriberCountry(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_CODE);
        $this->subject->setSubscriberCountryCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_DIAL_CODE);
        $this->subject->setSubscriberFirstName($subscriberFirstName);
        $this->subject->setSubscriberLastName($subscriberLastName);
        $this->subject->setSubscriberEmail($subscriberEmail);

        # Local Payment
        $this->subject->setLocalPaymentAmount($localPaymentAmount);
        $this->subject->setLocalPaymentCurrencyCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD);

        # Origin Payment
        $this->subject->setOriginPaymentAmount($originPaymentAmount);
        $this->subject->setOriginPaymentCurrencyCode(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD);
        $this->subject->setOriginPaymentTax($originPaymentTax);
        $this->subject->setOriginPaymentFee($originPaymentFee);

        # Additional Info
        $this->subject->setRedirectUri($redirectUri);
        $this->subject->setCallbackUri($callbackUri);
        $this->subject->setLanguage(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::LANGUAGE_CODE_SPANISH);
        $this->subject->setMerchantTransactionId($merchantTransactionId);
        $this->subject->setTerminalId(Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::TERMINAL_ID);
        $this->subject->setExchangeRate($exchangeRate);

        $requestBody = $this->subject->getBody();

        $requestBodyJsonArr = json_decode($requestBody, true);

        $this->assertEquals(
            $requestBodyJsonArr['MasterMerchant']['account'],
            $merchantAccount
        );

        $this->assertEquals(
            $requestBodyJsonArr['MasterMerchant']['pin'],
            $merchantPin
        );

        $this->assertEquals(
            $requestBodyJsonArr['MasterMerchant']['id'],
            $merchantId
        );

        if ($merchantReference) {
            $this->assertArrayHasKey('Merchant', $requestBodyJsonArr);
            if (array_key_exists('Merchant', $requestBodyJsonArr)) {
                $this->assertEquals(
                    $requestBodyJsonArr['Merchant']['reference'],
                    $merchantReference
                );
            }
        } else {
            $this->assertArrayNotHasKey('Merchant', $requestBodyJsonArr);
        }

        $this->assertEquals(
            $requestBodyJsonArr['Subscriber']['account'],
            $subscriberAccount
        );

        $this->assertEquals(
            $requestBodyJsonArr['Subscriber']['countryCode'],
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_DIAL_CODE
        );

        $this->assertEquals(
            $requestBodyJsonArr['Subscriber']['country'],
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::COUNTRY_CODE
        );

        $this->assertEquals(
            $requestBodyJsonArr['Subscriber']['firstName'],
            $subscriberFirstName
        );

        $this->assertEquals(
            $requestBodyJsonArr['Subscriber']['lastName'],
            $subscriberLastName
        );

        $this->assertEquals(
            $requestBodyJsonArr['Subscriber']['emailId'],
            $subscriberEmail
        );

        $this->assertEquals(
            $requestBodyJsonArr['OriginPayment']['amount'],
            number_format($originPaymentAmount, 2, '.', '')
        );

        $this->assertEquals(
            $requestBodyJsonArr['OriginPayment']['currencyCode'],
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD
        );

        $this->assertEquals(
            $requestBodyJsonArr['OriginPayment']['tax'],
            number_format($originPaymentFee, 2, '.', '')
        );

        $this->assertEquals(
            $requestBodyJsonArr['OriginPayment']['fee'],
            number_format($originPaymentTax, 2, '.', '')
        );

        $this->assertEquals(
            $requestBodyJsonArr['LocalPayment']['amount'],
            number_format($localPaymentAmount, 2, '.', '')
        );

        $this->assertEquals(
            $requestBodyJsonArr['LocalPayment']['currencyCode'],
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::CURRENCY_CODE_USD
        );

        $this->assertEquals(
            $requestBodyJsonArr['redirectUri'],
            $redirectUri
        );

        $this->assertEquals(
            $requestBodyJsonArr['callbackUri'],
            $callbackUri
        );

        $this->assertEquals(
            $requestBodyJsonArr['language'],
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::LANGUAGE_CODE_SPANISH
        );

        $this->assertEquals(
            $requestBodyJsonArr['terminalId'],
            Tigo_TigoMoney_Model_Payment_Redirect_Api_AuthorizationRequest::TERMINAL_ID
        );

        $this->assertEquals(
            $requestBodyJsonArr['exchangeRate'],
            number_format($exchangeRate, 2, '.', '')
        );

        $this->assertEquals(
            $requestBodyJsonArr['merchantTransactionId'],
            $merchantTransactionId
        );

    }
}

