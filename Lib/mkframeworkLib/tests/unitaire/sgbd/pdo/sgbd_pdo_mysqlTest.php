<?php
declare(strict_types=1);

require_once(__DIR__.'/../../../../abstract/abstract_sgbd_pdo.php');
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_mysql.php');
require_once(__DIR__.'/../../../../sgbd/pdo/sgbd_pdo_mysql.php');

require_once(__DIR__.'/../../../inc/sgbd/pdo/fakePdoFetch.php');


class fakeSgbdPdomysql extends sgbd_pdo_mysql
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

    public function testui_setPdo($oPdo_)
    {
        $this->_pDb=$oPdo_;
    }

    public function query($sRequete_, $tParam_=null)
    {
        if ($sRequete_==sgbd_syntax_mysql::getListColumn('myTable')) {
            return new fakePdoFetch(
                array(
                array('myField1'),
                array('myField2'))
            );
        } elseif ($sRequete_==sgbd_syntax_mysql::getListColumn('myTableEmpty')) {
            return null;
        } elseif ($sRequete_==sgbd_syntax_mysql::getListTable()) {
            if ($this->testui_willReturnNull) {
                return null;
            } else {
                return new fakePdoFetch(
                array(
                array('myTable1'),
                array('myTable2'))
            );
            }
        }
    }
}

class fakeFirebirdPdo
{
    public function lastInsertId()
    {
        return 'lastInsertId';
    }
}
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_pdo_mysqlTest extends TestCase
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
        $oPdo=new fakeSgbdPdomysql();

        $this->assertEquals(array('myField1','myField2'), $oPdo->getListColumn('myTable'));
    }

    public function test_getListColumnShouldFinishNull()
    {
        $oPdo=new fakeSgbdPdomysql();

        $this->assertEquals(null, $oPdo->getListColumn('myTableEmpty'));
    }

    public function test_getListTableShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdomysql();

        $this->assertEquals(array('myTable1','myTable2'), $oPdo->getListTable());
    }

    public function test_getListTableShouldFinishNull()
    {
        $oPdo=new fakeSgbdPdomysql();
        $oPdo->testui_willReturnNull=true;
        
        $this->assertEquals(null, $oPdo->getListTable());
    }

    public function test_getLastInsertIdShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdomysql();
        $oPdo->testui_setPdo(new fakeFirebirdPdo());

        $this->assertEquals('lastInsertId', $oPdo->getLastInsertId());
    }

    public function test_getWhereAllShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdomysql();

        $this->assertEquals('1=1', $oPdo->getWhereAll());
    }

    public function test_getInstanceShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdomysql();

        $this->assertEquals('1=1', fakeSgbdPdomysql::getInstance('myConfig')->getWhereAll());
    }

    public function test_connecShouldFinishOk()
    {
        $oPdo=new fakeSgbdPdomysql();

        $sException=null;

        try {
            $oPdo->testui_Connect();
            $oPdo->getPdo();
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegexp('/invalid/', $sException);
    }

    public function test_getInsertFromTabShouldFinishOk()
    {
        $tExpectedResult='(`var1`,`var2`) VALUES (?,?) ';

        $tab=array('var1'=>'val1','var2'=>'val2');

        $oPdo=new fakeSgbdPdomysql();

        $tProperty=$oPdo->getInsertFromTab($tab);

        $this->assertEquals($tExpectedResult, $tProperty);
    }

    public function test_getUpdateFromTabShouldFinishOk()
    {
        $tExpectedResult='`var1`=?,`var2`=?';

        $tab=array('var1'=>'val1','var2'=>'val2');

        $oPdo=new fakeSgbdPdomysql();

        $tProperty=$oPdo->getUpdateFromTab($tab);

        $this->assertEquals($tExpectedResult, $tProperty);
    }
}
