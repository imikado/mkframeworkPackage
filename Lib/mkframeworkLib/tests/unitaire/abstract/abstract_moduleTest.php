<?php
declare(strict_types=1);

require_once(__DIR__.'/../../../abstract/abstract_module.php');


class fakeModule extends abstract_module
{
}

use PHPUnit\Framework\TestCase;


/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class abstract_moduleTest extends TestCase
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
        $oModule=new fakeModule();
        $oModule->var1='val1';

        $this->assertEquals('val1', $oModule->var1);
    }

    public function test_getShouldFinishKo()
    {
        $oModule=new fakeModule();

        $sException=null;
        try {
            $var1NotFound=$oModule->var1NotFound;
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }


        $this->assertRegExp('/Propriete var1NotFound/', $sException);
    }
}
