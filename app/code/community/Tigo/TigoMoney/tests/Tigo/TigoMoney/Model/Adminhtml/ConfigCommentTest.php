<?php

/**
 * Class Tigo_TigoMoney_Model_Adminhtml_ConfigCommentTest
 */
class Tigo_TigoMoney_Model_Adminhtml_ConfigCommentTest extends EcomDev_PHPUnit_Test_Case
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
     * @var Tigo_TigoMoney_Model_Adminhtml_ConfigComment|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    /**
     * Sets up the unit test case
     */
    protected function setUp()
    {
        $this->className = Tigo_TigoMoney_Model_Adminhtml_ConfigComment::class;

        $this->subject = $this->getModelMock(
            'tigo_tigomoney/adminhtml_configComment',
            array('_isUrlRewriteEnabled')
        );

        $this->dataHelper = $this->getHelperMock(
            'tigo_tigomoney/data',
            array(
                'getRedirectUri',
                'getCallbackUri'
            )
        );
        $this->replaceByMock('helper', 'tigo_tigomoney/data', $this->dataHelper);
    }

    public function testGetCommentTextWillCallDataHelperMethodsForUrls()
    {
        $this
            ->dataHelper
            ->expects($this->once())
            ->method('getRedirectUri');

        $this
            ->dataHelper
            ->expects($this->once())
            ->method('getCallbackUri');

        $this->subject->getCommentText();
    }

    public function testGetCommentTextReturnNonRewrittenUrlsWhenUrlRewritesAreNotActive()
    {
        $this
            ->subject
            ->expects($this->any())
            ->method('_isUrlRewriteEnabled')
            ->will($this->returnValue(false));

        $this
            ->dataHelper
            ->expects($this->once())
            ->method('getRedirectUri')
            ->will($this->returnValue('http://google.com/index.php/test'));

        $this
            ->dataHelper
            ->expects($this->once())
            ->method('getCallbackUri')
            ->will($this->returnValue('http://microsoft.com/index.php/test'));

        $return = $this->subject->getCommentText();

        $this->assertRegExp('/http\:\/\/google\.com\/index\.php\/test/', $return);
        $this->assertRegExp('/http\:\/\/microsoft\.com\/index\.php\/test/', $return);
    }

    public function testGetCommentTextReturnRewrittenUrlsWhenUrlRewritesAreActive()
    {
        $this
            ->subject
            ->expects($this->any())
            ->method('_isUrlRewriteEnabled')
            ->will($this->returnValue(true));

        $this
            ->dataHelper
            ->expects($this->once())
            ->method('getRedirectUri')
            ->will($this->returnValue('http://google.com/index.php/test'));

        $this
            ->dataHelper
            ->expects($this->once())
            ->method('getCallbackUri')
            ->will($this->returnValue('http://microsoft.com/index.php/test'));

        $return = $this->subject->getCommentText();

        $this->assertRegExp('/http\:\/\/google\.com\/test/', $return);
        $this->assertRegExp('/http\:\/\/microsoft\.com\/test/', $return);
    }
}

