<?php

/**
 * Class Tigo_TigoMoney_Block_Payment_Redirect_InfoTest
 */
class Tigo_TigoMoney_Block_Payment_Redirect_InfoTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Block_Payment_Redirect_Info|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * @var Mage_Payment_Model_Info|PHPUnit_Framework_MockObject_MockObject
     */
    protected $info = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        parent::setUp();

        $this->className = Tigo_TigoMoney_Block_Payment_Redirect_Info::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('getInfo'))
            ->getMock();

        $this->info = $this
            ->getMockBuilder(Mage_Payment_Model_Info::class)
            ->setMethods(array('getAdditionalInformation'))
            ->getMock();

    }

    public function testGetTemplateReturnsRightTemplatePath()
    {
        $this->assertEquals(
            $this->subject->getTemplate(),
            Tigo_TigoMoney_Block_Payment_Redirect_Info::TEMPLATE_PATH
        );
    }

    public function testGetSpecificInformationReturnsNothingOnFrontend()
    {

        $this->setCurrentStore(1);

        $this->assertCount(0, $this->subject->getSpecificInformation());
    }

    public function testGetSpecificInformationReturnsRightInfoOnAdmin()
    {
        $mfsTransactionID = 'l2l2';
        $authCode = '123123';
        $transactionCode = '03930.039303.203920';
        $accessTokenErrors = array('AT Error 1', 'AT Error 2');
        $authorizationErrors = array('Auth Error 1', 'Auth Error 2', 'Auth Error 3');

        $this->setCurrentStore('admin');

        $this
            ->info
            ->expects($this->any())
            ->method('getAdditionalInformation')
            ->will(
                $this->returnValueMap(
                    array(
                        array(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_MFS_TRANSACTION_ID, $mfsTransactionID),
                        array(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_AUTH_CODE, $authCode),
                        array(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_TRANSACTION_CODE, $transactionCode),
                        array(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_ACCESS_TOKEN_ERRORS, $accessTokenErrors),
                        array(Tigo_TigoMoney_Model_Payment_Redirect::ADDITIONAL_INFO_KEY_AUTHORIZATION_ERRORS, $authorizationErrors),
                    )
                )
            );

        $this
            ->subject
            ->expects($this->any())
            ->method('getInfo')
            ->will($this->returnValue(($this->info)));

        $return = $this->subject->getSpecificInformation();

        $this->assertCount(5, $return);

        $this->assertArrayHasKey(
            Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_MFS_TRANSACTION_ID,
            $return
        );
        $this->assertEquals(
            $mfsTransactionID,
            $return[Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_MFS_TRANSACTION_ID]
        );

        $this->assertArrayHasKey(
            Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_AUTH_CODE,
            $return
        );
        $this->assertEquals(
            $authCode,
            $return[Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_AUTH_CODE]
        );

        $this->assertArrayHasKey(
            Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_TRANSACTION_CODE,
            $return
        );
        $this->assertEquals(
            $transactionCode,
            $return[Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_TRANSACTION_CODE]
        );

        $this->assertArrayHasKey(
            Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_ACCESS_TOKEN_ERRORS,
            $return
        );
        $this->assertEquals(
            $accessTokenErrors,
            $return[Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_ACCESS_TOKEN_ERRORS]
        );

        $this->assertArrayHasKey(
            Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_AUTHORIZATION_ERRORS,
            $return
        );
        $this->assertEquals(
            $authorizationErrors,
            $return[Tigo_TigoMoney_Block_Payment_Redirect_Info::ADDITIONAL_INFO_RETURN_KEY_AUTHORIZATION_ERRORS]
        );
    }
}

