<?php

/**
 * Class Tigo_TigoMoney_Helper_DataTest
 */
class Tigo_TigoMoney_Helper_DataTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Mage_Adminhtml_Helper_Data|PHPUnit_Framework_MockObject_MockObject
     */
    protected $adminhtmlHelper = null;

    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Mage_Sales_Model_Order|PHPUnit_Framework_MockObject_MockObject
     */
    protected $order = null;

    /**
     * @var Tigo_TigoMoney_Helper_Data|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        parent::setUp();

        $this->subject = $this
            ->getHelperMock('tigo_tigomoney/data', null);

        $this->order = $this
            ->getMockBuilder(Mage_Sales_Model_Order::class)
            ->setMethods(array('getId'))
            ->getMock();

        $this->adminhtmlHelper = $this
            ->getMockBuilder(Mage_Adminhtml_Helper_Data::class)
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock('helper', 'adminhtml', $this->adminhtmlHelper);

    }

    /**
     * @loadFixtures default
     */
    public function testGetCallbackUriReturnsCorrectValue()
    {
        /** @var Mage_Core_Model_Url $urlModel */
        $urlModel = Mage::getModel('core/url');
        $expectedUrl = $urlModel->getUrl('tigomoney/sync');
        $this->assertEquals(
            $expectedUrl,
            $this->subject->getCallbackUri()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetClientIdReturnsCorrectValue()
    {
        $expectedId = '123';
        $this->assertEquals(
            $expectedId,
            $this->subject->getClientId()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetClientSecretReturnsCorrectValue()
    {
        $expectedSecret = 'asdf123fdsa';
        $this->assertEquals(
            $expectedSecret,
            $this->subject->getClientSecret()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetInternalRedirectUriReturnsCorrectValue()
    {
        /** @var Mage_Core_Model_Url $urlModel */
        $urlModel = Mage::getModel('core/url');
        $expectedUrl = $urlModel->getUrl('tigomoney/redirect/index', array('_secure' => true));
        $this->assertEquals(
            $expectedUrl,
            $this->subject->getInternalRedirectUri()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetMerchantAccountReturnsCorrectValue()
    {
        $expectedMerchantAccount = 'zaq1xsw2cde3';
        $this->assertEquals(
            $expectedMerchantAccount,
            $this->subject->getMerchantAccount()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetMerchantIdReturnsCorrectValue()
    {
        $expectedMerchantId = '98098098';
        $this->assertEquals(
            $expectedMerchantId,
            $this->subject->getMerchantId()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetMerchantPinReturnsCorrectValue()
    {
        $expectedMerchantPin = '6464646737373';
        $this->assertEquals(
            $expectedMerchantPin,
            $this->subject->getMerchantPin()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetMerchantReferenceReturnsCorrectValue()
    {
        $expectedMerchantReference = 'Amazon';
        $this->assertEquals(
            $expectedMerchantReference,
            $this->subject->getMerchantReference()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetDescriptionReturnsCorrectValue()
    {
        $expectedDescription = 'Test Description';
        $this->assertEquals(
            $expectedDescription,
            $this->subject->getDescription()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetRedirectUriReturnsCorrectValue()
    {
        /** @var Mage_Core_Model_Url $urlModel */
        $urlModel = Mage::getModel('core/url');
        $expectedUrl = $urlModel->getUrl('tigomoney/return');
        $this->assertEquals(
            $expectedUrl,
            $this->subject->getRedirectUri()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetFailureContinueShoppingUrlReturnsCorrectValue()
    {
        $expectedUrl = 'http://google.com/';
        $this->assertEquals(
            $expectedUrl,
            $this->subject->getFailureContinueShoppingUrl()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetSuccessContinueShoppingUrlReturnsCorrectValue()
    {
        $expectedUrl = 'http://facebook.com/';
        $this->assertEquals(
            $expectedUrl,
            $this->subject->getSuccessContinueShoppingUrl()
        );
    }

    /**
     * @loadFixture default
     */
    public function testGetSyncOrderUrlReturnsCorrectValue()
    {
        $orderId = 123928;
        $this
            ->order
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($orderId));

        /** @var Mage_Core_Model_Url $urlModel */
        $urlModel = Mage::getModel('adminhtml/url');
        $expectedUrl = $urlModel->getUrl(
            'adminhtml/tigomoney_order/sync',
            array('order_id' => $orderId)
        );
        $this->assertEquals(
            $expectedUrl,
            $this->subject->getSyncOrderUrl($this->order)
        );
    }

    /**
     * @loadFixture default
     */
    public function testIsDebugModeEnabledReturnsTrueWhenConfigTrue()
    {
        $this->assertTrue(
            $this->subject->isDebugModeEnabled()
        );
    }

    /**
     * @loadFixture default
     */
    public function testIsTestModeEnabledReturnsTrueWhenConfigTrue()
    {
        $this->assertTrue(
            $this->subject->isTestModeEnabled()
        );
    }

    /**
     * @loadFixture disabledModes
     */
    public function testIsDebugModeEnabledReturnsFalseWhenConfigFalse()
    {
        $this->assertFalse(
            $this->subject->isDebugModeEnabled()
        );
    }

    /**
     * @loadFixture disabledModes
     */
    public function testIsTestModeEnabledReturnsFalseWhenConfigFalse()
    {
        $this->assertFalse(
            $this->subject->isTestModeEnabled()
        );
    }
}

