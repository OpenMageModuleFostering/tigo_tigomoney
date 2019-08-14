<?php

/**
 * Class Tigo_TigoMoney_Model_DebugTest
 */
class Tigo_TigoMoney_Model_DebugTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var String
     */
    protected $className = null;

    /**
     * @var Tigo_TigoMoney_Model_Debug|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Debug::class;

        $this->subject = $this
            ->getMockBuilder($this->className)
            ->setMethods(array('_writeLog'))
            ->getMock();

    }

    /**
     * @loadFixture debugModeOff
     */
    public function testDoesNotWriteToLogWhenDebugModeOff()
    {
        $this
            ->subject
            ->expects($this->never())
            ->method('_writeLog');

        $this
            ->subject
            ->debug('Test');
    }

    /**
     * @loadFixture debugModeOn
     */
    public function testWritesCorrectStringValueToLogWhenDebugModeOn()
    {
        $debugValue = 'Test Test Test 123';
        $this
            ->subject
            ->expects($this->once())
            ->method('_writeLog')
            ->with($debugValue);

        $this
            ->subject
            ->debug($debugValue);
    }

    /**
     * @loadFixture debugModeOn
     */
    public function testWritesCorrectArrayValueToLogWhenDebugModeOn()
    {
        $debugValue = array(1 => '234', 5 => '6789');
        $this
            ->subject
            ->expects($this->once())
            ->method('_writeLog')
            ->with(print_r($debugValue, true));

        $this
            ->subject
            ->debug($debugValue);
    }
}

