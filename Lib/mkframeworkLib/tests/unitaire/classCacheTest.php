<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classCacheTest extends TestCase
{
    public function run( $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_isCachedShouldFinishTrue()
    {
        require_once(__DIR__.'/../../class_cache.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;

        $oCache=new _cache();

        $this->assertEquals(true, $oCache->isCached('testId'));
    }

    public function test_isCachedShouldFinishFalse()
    {
        require_once(__DIR__.'/../../class_cache.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=false;

        $oCache=new _cache();

        $this->assertEquals(false, $oCache->isCached('testId'));
    }

    public function test_isCachedWithMtimeShouldFinishTrue()
    {
        require_once(__DIR__.'/../../class_cache.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;
        _file::$testui_filemtime=time();

        $oCache=new _cache();

        $this->assertEquals(true, $oCache->isCached('testId', 2));
    }

    public function test_isCachedWithMtimeShouldFinishFalse()
    {
        require_once(__DIR__.'/../../class_cache.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;
        _file::$testui_filemtime=2;

        $oCache=new _cache();

        $this->assertEquals(false, $oCache->isCached('testId', 2));
    }

    public function test_setCacheShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cache.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');
        require_once(__DIR__.'/../inc/class_view.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::myView');

        $oCache=new _cache();

        $oCache->setCache('myId', $oView);

        $this->assertRegExp('/myViewContent/', _file::testui_getContent());
    }

    public function test_getCachedShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cache.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');
        require_once(__DIR__.'/../inc/class_view.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        _root::setConfigVar('path.cache', __DIR__.'/../data/cache/');

        $oCache=new _cache();

        $oViewCached=$oCache->getCached('myView');

        $this->assertRegExp('/cache\/myView.cache/', $oViewCached->getPath());
    }

    public function test_clearCacheShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cache.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');
        require_once(__DIR__.'/../inc/class_view.php');

        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        _root::setConfigVar('path.cache', __DIR__.'/../data/cache/');

        $oCache=new _cache();

        $this->assertEquals(false, _file::$testui_hasCalledDelete);

        $oViewCached=$oCache->clearCache('myView');

        $this->assertEquals(true, _file::$testui_hasCalledDelete);
    }
}
