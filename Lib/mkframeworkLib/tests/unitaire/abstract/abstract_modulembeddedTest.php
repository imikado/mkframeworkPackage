<?php
declare(strict_types=1);

require_once(__DIR__.'/../../../abstract/abstract_moduleembedded.php');


class fakeModuleembedded extends abstract_moduleembedded
{
}

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class abstract_moduleembeddedTest extends TestCase
{
    public function run( $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    private function trimString($sString_)
    {
        return str_replace(array("\n","\r","\r","\t","\s",' '), '', $sString_);
    }

    public function test_setShouldFinishOk()
    {
        $oModule=new fakeModuleembedded();
        $oModule->var1='val1';

        $this->assertEquals('val1', $oModule->var1);
    }

    public function test_getShouldFinishKo()
    {
        $oModule=new fakeModuleembedded();

        $sException=null;
        try {
            $var1NotFound=$oModule->var1NotFound;
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }


        $this->assertRegExp('/Propriete var1NotFound/', $sException);
    }

    public function test_getParamShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_root.php');
        require_once(__DIR__.'/../../../class_request.php');

        $oRoot=new _root();
        $oRoot->addRequest(array());
        $oRoot->loadRequest();


        $oModule=new fakeModuleembedded();
        $oModule->_setParam('monModule', 'var1', 'val1');

        $this->assertEquals('val1', $oModule->_getParam('monModule', 'var1'));
    }

    public function test_getLinkShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_root.php');
        require_once(__DIR__.'/../../../class_request.php');

        $oRoot=new _root();
        $oRoot->addRequest(array());
        $oRoot->loadRequest();


        $oModule=new fakeModuleembedded();
        $sLink=$oModule->_getLink('monRootModule', array('var1'=> 'val1'), 'monModule', 'monAction');

        $this->assertEquals('?=monRootModule&amp;var1=val1&amp;monModuleAction=monAction', $sLink);
    }

    /**
    * @dataProvider dataProvider_getLinkShouldFinishList
    */
    public function test_getLinkShouldFinishList($tRootParams_, $sModuleName_, $sAction_, $tParam_, $sExpectedLink)
    {
        require_once(__DIR__.'/../../../class_root.php');
        require_once(__DIR__.'/../../../class_request.php');

        $oRoot=new _root();
        $oRoot->addRequest(array());
        $oRoot->loadRequest();


        $oModule=new fakeModuleembedded();
        $sLink=$oModule->_getLink('monRootModule', $tRootParams_, $sModuleName_, $sAction_, $tParam_);

        $this->assertEquals($sExpectedLink, $sLink);
    }
    public function dataProvider_getLinkShouldFinishList()
    {
        return array(
            array( array('var1'=> 'val1'), 'monModule', 'monAction',null,'?=monRootModule&amp;var1=val1&amp;monModuleAction=monAction'),
            array( array('var1'=> 'val1'), 'monModule', 'monAction',array('sousVar1'=>'sousVal1'),'?=monRootModule&amp;var1=val1&amp;monModuleAction=monAction&amp;monModulesousVar1=sousVal1'),

        );
    }

    public function test_redirectShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/fakeClassRoot.php');

        $sException=null;

        $oModule=new fakeModuleembedded();

        $tLinkArray=$oModule->_redirect('monRootModule', array('var1'=> 'val1'), 'monModule', 'monAction');

        $this->assertEquals(array('monRootModule',array('var1'=>'val1','monModuleAction'=>'monAction')), $tLinkArray);
    }

    public function test_redirectShouldFinishOk2()
    {
        require_once(__DIR__.'/../../inc/fakeClassRoot.php');

        $sException=null;

        $oModule=new fakeModuleembedded();

        $tLinkArray=$oModule->_redirect('monRootModule', array('var1'=> 'val1'), 'monModule', 'monAction', array('var2'=>'val2'));


        $this->assertEquals(array('monRootModule',array('var1'=>'val1','monModuleAction'=>'monAction','monModulevar2'=>'val2')), $tLinkArray);
    }
}
