<?php

require_once(__DIR__.'/../../class_root.php');
require_once(__DIR__.'/../../class_file.php');

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classFileTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    private function getFilename()
    {
        return __DIR__.'/../data/file_test.txt';
    }

    private function resetFile($sFilename_)
    {
        file_put_contents($sFilename_, '');
    }

    private function setContentFile($sFilename_, $sContent_)
    {
        file_put_contents($sFilename_, $sContent_);
    }

    public function test_isDirShouldFinishOk()
    {

                /*
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');
                */

        $oFile=new _file();

        $this->assertEquals(false, $oFile->isDir());
    }

    public function test_isFileShouldFinishOk()
    {
        $oFile=new _file();

        $this->assertEquals(true, $oFile->isFile());
    }

    public function test_setAdresseShouldFinishOk()
    {
        $oFile=new _file();
        $oFile->setAdresse('myPath');

        $this->assertEquals('myPath', $oFile->getAdresse());
    }

    public function test_setContentShouldFinishOk()
    {
        $oFile=new _file($this->getFilename());
        $oFile->setContent('myContent');
        $oFile->save();

        $this->assertEquals('myContent', $oFile->getContent());
    }

    public function test_addContentShouldFinishOk()
    {
        $this->resetFile($this->getFilename());

        $oFile=new _file($this->getFilename());

        $oFile->addContent('a');
        $oFile->addContent('b');
        $oFile->save();

        $this->assertEquals('ab', $oFile->getContent());
    }

    public function test_cleanShouldFinishOk()
    {
        $this->resetFile($this->getFilename());

        $oFile=new _file($this->getFilename());

        $oFile->clean();

        $this->assertEquals('', $oFile->getAdresse());
    }

    public function test_getNameShouldFinishOk()
    {
        $this->resetFile($this->getFilename());

        $oFile=new _file($this->getFilename());

        $this->assertEquals('file_test.txt', $oFile->getName());
    }

    public function test_loadShouldFinishOk()
    {
        $this->resetFile($this->getFilename());
        $this->setContentFile($this->getFilename(), 'contentInFile');

        $oFile=new _file($this->getFilename());
        $oFile->load();

        $this->assertEquals('contentInFile', $oFile->getContent());
    }

    public function test_getTabShouldFinishOk()
    {
        $ret="\n";

        $this->resetFile($this->getFilename());
        $this->setContentFile($this->getFilename(), implode($ret, array('line1','line2')));

        $oFile=new _file($this->getFilename());
        $oFile->load();

        $this->assertEquals(array('line1'.$ret,'line2'), $oFile->getTab());
    }

    public function test_getExtensionShouldFinishOk()
    {
        $oFile=new _file($this->getFilename());

        $this->assertEquals('txt', $oFile->getExtension());
    }

    public function test_verifShouldFinishOk()
    {
        require_once(__DIR__.'/../../tests/inc/fakeFile.php');

        $oFile=new fakeFile($this->getFilename());

        $this->assertEquals(true, $oFile->testunit_verif());
    }

    public function test_verifShouldFinishKo()
    {
        require_once(__DIR__.'/../../tests/inc/fakeFile.php');

        $oFile=new fakeFile('pathDoesnotExist');

        $sException=null;
        try {
            $oFile->testunit_verif();
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }
        $this->assertEquals('pathDoesnotExist n\'existe pas', $sException);
    }

    public function test_writeShouldFinishOk()
    {
        $this->resetFile($this->getFilename());
        $oFile=new _file($this->getFilename());

        $oFile->write('');

        $this->assertEquals('', $oFile->getContent());
    }

    public function test_filemtimeShouldFinishOk()
    {
        $oFile=new _file($this->getFilename());

        $this->assertEquals(filemtime($this->getFilename()), $oFile->filemtime());
    }

    public function test_chmodShouldFinishOk()
    {
        $sFilenameChmod=__DIR__.'/../data/file_testChmod.txt';

        $oFile=new _file($sFilenameChmod);
        $oFile->save();
        $oFile->chmod(0777);

        $this->assertEquals('0777', decoct(fileperms($sFilenameChmod)& 0777));
    }

    public function test_deleteShouldFinishOk()
    {
        $sFilenameDelete=__DIR__.'/../data/file_testToDelete.txt';

        $this->assertFalse(file_exists($sFilenameDelete));

        $oFile=new _file($sFilenameDelete);
        $oFile->save();

        $this->assertTrue(file_exists($sFilenameDelete));

        $oFile->delete();

        $this->assertFalse(file_exists($sFilenameDelete));
    }
}
