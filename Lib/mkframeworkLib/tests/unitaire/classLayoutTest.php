<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classLayoutTest extends TestCase
{
    public function run( $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_setShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oLayout=new _layout('layout');

        $oLayout->var1='val1';

        $this->assertEquals('val1', $oLayout->var1);
    }

    public function test_getShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oLayout=new _layout('myLayout');

        $sException=null;

        try {
            $var1=$oLayout->var1;
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertEquals('Variable var1 inexistante dans le layout myLayout', $sException);
    }

    public function test_issetShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oLayout=new _layout('layout');
        $oLayout->var1='val1';

        $this->assertEquals(true, isset($oLayout->var1));

        unset($oLayout->var1);

        $this->assertEquals(false, isset($oLayout->var1));
    }

    public function test_addShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');
        require_once(__DIR__.'/../../class_view.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oMoockView=$this->createMock('_view');
        $oMoockView->method('getPath')->willReturn('myViewPath');
        $oMoockView->method('show')->willReturn('myViewContent');

        $oLayout=new _layout('layout');
        $oLayout->add('main', $oMoockView);

        $this->assertRegExp('/appel vue/', fakeLog::$tLogInfo[2]);
        $this->assertRegExp('/myViewPath/', fakeLog::$tLogInfo[2]);

        $sView=$oLayout->load('main');

        $this->assertRegExp('/myViewContent/', $sView);
    }

    public function test_addModuleShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');
        require_once(__DIR__.'/../../class_view.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        require_once(__DIR__.'/../../tests/inc/module/fakeModule.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');


        $oLayout=new _layout('layout');
        $oLayout->addModule('main', 'fakeModule::test');

        $this->assertRegExp('/ ajout appel module/', fakeLog::$tLogInfo[2]);
        $this->assertRegExp('/fakeModule::test/', fakeLog::$tLogInfo[2]);
    }

    public function test_showShouldFinishException()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');
        require_once(__DIR__.'/../../class_view.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        require_once(__DIR__.'/../../tests/inc/module/fakeModule.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $sException=null;

        $oLayout=new _layout('myLayout');
        try {
            $oLayout->show();
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }
        $this->assertRegExp('/layout myLayout introuvable/', $sException);
    }

    public function test_showShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');
        require_once(__DIR__.'/../../class_view.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        require_once(__DIR__.'/../../tests/inc/module/fakeModule.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');
        $oRoot->setConfigVar('path.layout', __DIR__.'/../inc/layout/');

        $oLayout=new _layout('myLayout');

        ob_start();
        $oLayout->show();
        $sSortie=ob_get_contents();
        ob_end_clean();

        $this->assertRegExp('/myLayoutContent/', $sSortie);
    }

    public function test_getOutputShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');
        require_once(__DIR__.'/../../class_view.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        require_once(__DIR__.'/../../tests/inc/module/fakeModule.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');
        $oRoot->setConfigVar('path.layout', __DIR__.'/../inc/layout/');

        $oLayout=new _layout('myLayout');

        $sSortie=$oLayout->getOutput();

        $this->assertRegExp('/myLayoutContent/', $sSortie);
    }

    public function test_getOutputShouldFinishException()
    {
        require_once(__DIR__.'/../../class_root.php');
        require_once(__DIR__.'/../../class_layout.php');
        require_once(__DIR__.'/../../class_view.php');

        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        require_once(__DIR__.'/../../tests/inc/module/fakeModule.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');
        $oRoot->setConfigVar('path.layout', __DIR__.'/../inc/layoutNotFound/');

        $oLayout=new _layout('myLayout');

        try {
            $sSortie=$oLayout->getOutput();
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }
        $this->assertRegExp('/layout myLayout introuvable/', $sException);
    }
}
