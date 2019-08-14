<?php

/**
 * Class Tigo_TigoMoney_Block_Payment_Redirect_FormTest
 */
class Tigo_TigoMoney_Block_Payment_Redirect_FormTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Helper_Data|PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataHelper = null;

    /**
     * @var Tigo_TigoMoney_Block_Payment_Redirect_Form|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        parent::setUp();

        $this->className = Tigo_TigoMoney_Block_Payment_Redirect_Form::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_isAdmin', 'getInfo'))
            ->getMock();

        $this->dataHelper = $this
            ->getMockBuilder(Tigo_TigoMoney_Helper_Data::class)
            ->setMethods(array('getDescription'))
            ->getMock();
        $this->replaceByMock('helper', 'tigo_tigomoney/data', $this->dataHelper);
    }

    public function testGetTemplateReturnsRightTemplatePath()
    {
        $this->assertEquals(
            $this->subject->getTemplate(),
            Tigo_TigoMoney_Block_Payment_Redirect_Form::TEMPLATE_PATH
        );
    }

    public function testGetDescriptionGetsItFromDataHelper()
    {
        $expectedReturn = 'Checkout Description Message';
        $this
            ->dataHelper
            ->expects($this->any())
            ->method('getDescription')
            ->will($this->returnValue($expectedReturn));
        $return = $this->subject->getDescription();
        $this->assertEquals($expectedReturn, $return);
    }
}

