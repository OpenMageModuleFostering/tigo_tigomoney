<?php

/**
 * Class Tigo_TigoMoney_RedirectControllerTest
 */
class Tigo_TigoMoney_RedirectControllerTest extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @var Mage_Checkout_Model_Session|PHPUnit_Framework_MockObject_MockObject
     */
    protected $checkoutSession = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Mage_Sales_Model_Order_Payment|PHPUnit_Framework_MockObject_MockObject
     */
    protected $payment = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        parent::setUp();

        $this->payment = $this
            ->getMockBuilder(Mage_Sales_Model_Order_Payment::class)
            ->setMethods(array('getAdditionalInformation', 'getMethod'))
            ->getMock();

        $this->order = $this
            ->getMockBuilder(Mage_Sales_Model_Order::class)
            ->setMethods(array('getId', 'getPayment'))
            ->getMock();
        $this->order
            ->expects($this->any())
            ->method('getPayment')
            ->will($this->returnValue($this->payment));

        $this->checkoutSession = $this
            ->getMockBuilder(Mage_Checkout_Model_Session::class)
            ->setMethods(array('getLastRealOrder'))
            ->getMock();
        $this->checkoutSession
            ->expects($this->any())
            ->method('getLastRealOrder')
            ->will($this->returnValue($this->order));
        $this->replaceByMock('model', 'checkout/session', $this->checkoutSession);
    }

    /**
     * @loadFixture default
     */
    public function testIndexActionSuccessfullyRedirectsToTigoRedirectUrl()
    {
        $redirectUrl = 'http://google.com/';
        $orderId = 1928;
        $paymentMethod = Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE;

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));
        $this
            ->payment
            ->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue($paymentMethod));

        $this
            ->payment
            ->expects($this->any())
            ->method('getAdditionalInformation')
            ->with($this->equalTo(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_REDIRECT_URI))
            ->will($this->returnValue($redirectUrl));

        $this->dispatch('tigomoney/redirect/index');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($redirectUrl);
    }

    /**
     * @loadFixture default
     */
    public function testIndexActionRedirectsToHomeWhenOrderNotPresent()
    {
        $redirectUrl = Mage::getBaseUrl();
        $orderId = null;

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this->dispatch('tigomoney/redirect/index');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($redirectUrl);
    }

    /**
     * @loadFixture default
     */
    public function testIndexActionRedirectsToHomeWhenPaymentMethodNotTigomoney()
    {
        $redirectUrl = Mage::getBaseUrl();
        $orderId = 9282;
        $paymentMethod = 'checkmo';

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->payment
            ->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue($paymentMethod));

        $this->dispatch('tigomoney/redirect/index');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($redirectUrl);
    }

    /**
     * @loadFixture default
     */
    public function testIndexActionRedirectsToHomeWhenPaymentMethodIsTigomoneyButNoRedirectUrlIsFound()
    {
        $redirectUrl = Mage::getBaseUrl();
        $orderId = 9282;
        $paymentMethod = Tigo_TigoMoney_Model_Payment_Redirect::METHOD_CODE;

        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        $this
            ->payment
            ->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue($paymentMethod));

        $this
            ->payment
            ->expects($this->once())
            ->method('getAdditionalInformation')
            ->with($this->equalTo(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_REDIRECT_URI))
            ->will($this->returnValue(null));

        $this->dispatch('tigomoney/redirect/index');

        $this->assertResponseHttpCode(302);
        $this->assertRedirectToUrl($redirectUrl);
    }
}

