<?php

require_once(__DIR__.'/../../class_root.php');
require_once(__DIR__.'/../../class_view.php');

require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
require_once(__DIR__.'/../../tests/inc/fakeLog.php');

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classViewTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_setShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::index');

        $oView->var1='val1';

        $this->assertEquals('val1', $oView->var1);
    }

    public function test_issetShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::index');

        $oView->var1='val1';

        $this->assertEquals('val1', $oView->var1);

        $this->assertEquals(true, isset($oView->var1));

        unset($oView->var1);

        $this->assertEquals(false, isset($oView->var1));
    }

    public function test_getPathShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::index');


        $this->assertRegExp('/default\/view\/index.php/', $oView->getPath());
    }



    public function test_getLinkShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('navigation.var', ':nav');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::index');


        $this->assertEquals('?:nav=default::index&amp;id=1', $oView->getLink('default::index', array('id'=>1)));
    }


    public function test_getShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::index');

        $sException=null;

        try {
            $var1=$oView->var1;
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertEquals('Variable var1 inexistante dans le template default::index', $sException);
    }

    public function test_constructShouldFinishKo()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $sException=null;

        try {
            $oView=new _view('default::notFound');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/vue/', $sException);
        $this->assertRegExp('/inexistant/', $sException);
    }

    public function test_showShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::myView');


        $this->assertRegExp('/myViewContent/', $oView->show());
    }
}
