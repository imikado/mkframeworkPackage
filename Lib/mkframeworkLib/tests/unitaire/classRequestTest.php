<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classRequestTest extends TestCase
{
    public function run( $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_setShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');

        $oRequest=new _request();

        $oRequest->var1='val1';

        $this->assertEquals('val1', $oRequest->var1);
    }

    public function test_isGetShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');

        $_SERVER['REQUEST_METHOD']='GET';

        $oRequest=new _request();

        $this->assertEquals(true, $oRequest->isGet());

        $_SERVER['REQUEST_METHOD']='POST';

        $this->assertEquals(false, $oRequest->isGet());
    }

    public function test_isPostShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');

        $_SERVER['REQUEST_METHOD']='POST';

        $oRequest=new _request();

        $this->assertEquals(true, $oRequest->isPost());

        $_SERVER['REQUEST_METHOD']='GET';

        $this->assertEquals(false, $oRequest->isPost());
    }

    public function test_getParamsPOSTShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/functionCustomHtmlentities.php');

        $_POST=array('var1'=>'val1');
        $_GET=array('var2'=>'val2');

        $oRequest=new _request();

        _root::setConfigVar('security.xss.enabled', 1);

        $this->assertEquals(array('var1'=>'CUSTOMHTMLval1'), $oRequest->getParamsPOST());

        _root::setConfigVar('security.xss.enabled', 0);

        $this->assertEquals(array('var1'=>'val1'), $oRequest->getParamsPOST());
    }

    public function test_getParamsGETShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/functionCustomHtmlentities.php');

        $_POST=array('var1'=>'val1');
        $_GET=array('var2'=>'val2');

        $oRequest=new _request();

        _root::setConfigVar('security.xss.enabled', 1);

        $this->assertEquals(array('CUSTOMHTMLvar2'=>'CUSTOMHTMLval2'), $oRequest->getParamsGET());

        _root::setConfigVar('security.xss.enabled', 0);

        $this->assertEquals(array('var2'=>'val2'), $oRequest->getParamsGET());
    }

    public function test_getParamsShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/functionCustomHtmlentities.php');

        $_POST=array('var1'=>'val1');
        $_GET=array('var2'=>'val2');

        $oRequest=new _request();
        $oRequest->var1='val1';
        $oRequest->var2='val2';

        _root::setConfigVar('security.xss.enabled', 1);

        $this->assertEquals(array('var1'=>'CUSTOMHTMLval1','var2'=>'CUSTOMHTMLval2'), $oRequest->getParams());

        $this->assertEquals('CUSTOMHTMLval1', $oRequest->getParam('var1'));
    }

    public function test_getParamArrayShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/functionCustomHtmlentities.php');

        $_POST=array('var1'=>'val1');
        $_GET=array('var2'=>'val2');

        $oRequest=new _request();
        $oRequest->var1='val1';
        $oRequest->var2=array('val21','val22');

        _root::setConfigVar('security.xss.enabled', 1);

        $this->assertEquals(array('CUSTOMHTMLval21','CUSTOMHTMLval22'), $oRequest->getParam('var2'));
    }

    public function test_loadModuleAndActionShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');

        $oRequest=new _request();

        $oRequest->loadModuleAndAction('myModule::myAction');

        $this->assertEquals('myModule', $oRequest->getModule());
        $this->assertEquals('myAction', $oRequest->getAction());

        $oRequest->loadModuleAndAction('myModuleAlone');

        $this->assertEquals('myModuleAlone', $oRequest->getModule());
        $this->assertEquals('index', $oRequest->getAction());

        $oRequest->loadModuleAndAction('');

        $this->assertEquals('index', $oRequest->getModule());
        $this->assertEquals('index', $oRequest->getAction());
    }

    public function test_stripslashes_deepShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/functionStripslashes_deep.php');

        $oRequest=new _request();

        $sValueConverted=$oRequest->stripslashes_deep('val1');

        $this->assertEquals('val1', $sValueConverted);

        $tValueConverted=$oRequest->stripslashes_deep(array('val1','val2'));

        $this->assertEquals(array('STRIPSLASHESval1', 'STRIPSLASHESval2'), $tValueConverted);
    }

    public function test_magic_quoteShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/functionStripslashes_deep.php');

        $oRequest=new _request();
        $oRequest->var1='val1';
        $oRequest->var2='val2';

        $this->assertEquals('val1', $oRequest->var1);
        $this->assertEquals('val2', $oRequest->var2);

        $oRequest->magic_quote();

        $this->assertEquals('STRIPSLASHESval1', $oRequest->var1);
        $this->assertEquals('STRIPSLASHESval2', $oRequest->var2);
    }
}
