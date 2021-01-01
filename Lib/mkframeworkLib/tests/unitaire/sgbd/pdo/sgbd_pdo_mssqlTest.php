<?php

require_once(__DIR__.'/../../../../abstract/abstract_sgbd_pdo.php');
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_mssql.php');
require_once(__DIR__.'/../../../../sgbd/pdo/sgbd_pdo_mssql.php');

require_once(__DIR__.'/../../../inc/sgbd/pdo/fakePdoFetch.php');

class fakeSgbdPdoMssql extends sgbd_pdo_mssql
{
    public $testui_willReturnNull=false;

    public function testui_Connect()
    {
        $this->connect();
    }

    public function getConfig()
    {
        return $this->_sConfig;
    }

    public function query($sRequete_, $tParam_=null)
    {
        if ($sRequete_==sgbd_syntax_mssql::getListColumn('myTable')) {
            return new fakePdoFetch(
                array(
                array('myField1'),
                array('myField2'))
            );
        } elseif ($sRequete_==sgbd_syntax_mssql::getListColumn('myTableEmpty')) {
            return null;
        } elseif ($sRequete_==sgbd_syntax_mssql::getListTable()) {
            if ($this->testui_willReturnNull) {
                return null;
            } else {
                return new fakePdoFetch(
                array(
                array('myTable1'),
                array('myTable2'))
            );
            }
        } elseif ($sRequete_==sgbd_syntax_mssql::getLastInsertId()) {
            if ($this->testui_willReturnNull) {
                return null;
            } else {
                return new fakePdoFetch(
                    array(
                        array(22)
                    )
                );
            }
        }
    }
}
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_pdo_mssqlTest extends TestCase
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

    public function test_getListColumnShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdoMssql();

        $this->assertEquals(array('myField1','myField2'), $oPdo->getListColumn('myTable'));
    }

    public function test_getListColumnShouldFinishNull()
    {
        $oPdo=new fakeSgbdPdoMssql();

        $this->assertEquals(null, $oPdo->getListColumn('myTableEmpty'));
    }

    public function test_getListTableShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdoMssql();

        $this->assertEquals(array('myTable1','myTable2'), $oPdo->getListTable());
    }

    public function test_getListTableShouldFinishNull()
    {
        $oPdo=new fakeSgbdPdoMssql();
        $oPdo->testui_willReturnNull=true;

        $this->assertEquals(null, $oPdo->getListTable());
    }

    public function test_getLastInsertIdShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdoMssql();

        $this->assertEquals(22, $oPdo->getLastInsertId());
    }

    public function test_getLastInsertIdShouldFinishNull()
    {
        $oPdo=new fakeSgbdPdoMssql();
        $oPdo->testui_willReturnNull=true;

        $this->assertEquals(null, $oPdo->getLastInsertId());
    }

    public function test_getWhereAllShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdoMssql();

        $this->assertEquals('1=1', $oPdo->getWhereAll());
    }

    public function test_getInstanceShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdoMssql();

        $this->assertEquals('1=1', fakeSgbdPdoMssql::getInstance('myConfig')->getWhereAll());
    }

    public function test_connecShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdoMssql();

        $sException=null;

        try {
            $oPdo->testui_Connect();
            $oPdo->getPdo();
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegexp('/invalid/', $sException);
    }
}
