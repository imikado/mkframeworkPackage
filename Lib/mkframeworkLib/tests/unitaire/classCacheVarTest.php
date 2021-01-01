<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classCacheVarTest extends TestCase
{
    public function run( $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_isCachedShouldFinishTrue()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;

        $oCache=new _cacheVar();

        $this->assertEquals(true, $oCache->isCached('testId'));
    }

    public function test_isCachedShouldFinishFalse()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=false;

        $oCache=new _cacheVar();

        $this->assertEquals(false, $oCache->isCached('testId'));
    }

    public function test_isCachedWithMtimeShouldFinishTrue()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;
        _file::$testui_filemtime=time();

        $oCache=new _cacheVar();

        $this->assertEquals(true, $oCache->isCached('testId', 2));
    }

    public function test_isCachedWithMtimeShouldFinishFalse()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;
        _file::$testui_filemtime=2;

        $oCache=new _cacheVar();

        $this->assertEquals(false, $oCache->isCached('testId', 2));
    }

    public function test_isCachedMultipleShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;
        _file::$testui_filemtime=2;

        $oCache=new _cacheVar();
        $oCache->isCached('testId', 2);

        $this->assertEquals(false, $oCache->isCached('testId', 2));
    }

    public function test_setCachedShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;
        _file::$testui_filemtime=2;

        $oCache=new _cacheVar();
        $oCache->setCache('myId', array('id'=>2));

        $this->assertEquals(array('id'=>2), $oCache->getCached('myId'));
    }
    public function test_clearCachedShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');
        require_once(__DIR__.'/../inc/fakeClassRoot.php');
        require_once(__DIR__.'/../inc/class_file.php');

        _file::reset();
        _file::$testui_exist=true;
        _file::$testui_filemtime=2;

        $oCache=new _cacheVar();
        $oCache->setCache('myId', array('id'=>2));

        $this->assertEquals(array('id'=>2), $oCache->getCached('myId'));

        $this->assertEquals(false, _file::$testui_hasCalledDelete);

        $oCache->clearCache('myId');

        $this->assertEquals(true, _file::$testui_hasCalledDelete);
    }
}
