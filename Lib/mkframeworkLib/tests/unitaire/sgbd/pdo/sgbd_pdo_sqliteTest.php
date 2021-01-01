<?php
declare(strict_types=1);

require_once(__DIR__.'/../../../../abstract/abstract_sgbd_pdo.php');
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_sqlite.php');
require_once(__DIR__.'/../../../../sgbd/pdo/sgbd_pdo_sqlite.php');

require_once(__DIR__.'/../../../inc/sgbd/pdo/fakePdoFetch.php');


class fakeSgbdPdosqlite extends sgbd_pdo_sqlite{

	public function testui_Connect(){
		$this->connect();
	}

	public function getConfig(){
		return $this->_sConfig;
	}

	public function testui_setPdo($oPdo_){
		$this->_pDb=$oPdo_;
	}

	public function query($sRequete_,$tParam_=null){
		if($sRequete_==sgbd_syntax_sqlite::getListColumn('myTable')){
			return new fakePdoFetch(array(
				array(null,'myField1'),
				array(null,'myField2'))
			);
		}else if($sRequete_==sgbd_syntax_sqlite::getListColumn('myTableEmpty')){
			return null;
		}else if($sRequete_==sgbd_syntax_sqlite::getListTable()){
			return new fakePdoFetch(array(
				array('myTable1'),
				array('myTable2'))
			);
		}
	}
}

class fakeSqlitedPdo{
	public function lastInsertId(){
		return 'lastInsertId';
	}
}
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_pdo_sqliteTest extends TestCase
{
    public function run( $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

		private function trimString($sString_){
			return str_replace(array("\n","\r","\r","\t","\s",' '),'',$sString_);
		}

		public function test_getListColumnShouldFinishOk(){
			$oPdo=new fakeSgbdPdosqlite();

			$this->assertEquals(array('myField1','myField2'),$oPdo->getListColumn('myTable'));

		}

		public function test_getListColumnShouldFinishNull(){
			$oPdo=new fakeSgbdPdosqlite();

			$this->assertEquals(null,$oPdo->getListColumn('myTableEmpty'));

		}

		public function test_getListTableShouldFinishOk(){
			$oPdo=new fakeSgbdPdosqlite();

			$this->assertEquals(array('myTable1','myTable2'),$oPdo->getListTable());

		}

		public function test_getLastInsertIdShouldFinishOk(){
			$oPdo=new fakeSgbdPdosqlite();
			$oPdo->testui_setPdo(new fakeSqlitedPdo());

			$this->assertEquals('lastInsertId',$oPdo->getLastInsertId());
		}

		public function test_getWhereAllShouldFinishOk(){
			$oPdo=new fakeSgbdPdosqlite();

			$this->assertEquals('1=1',$oPdo->getWhereAll());
		}

		public function test_getInstanceShouldFinishOk(){
			$oPdo=new fakeSgbdPdosqlite();

			$this->assertEquals('1=1',fakeSgbdPdosqlite::getInstance('myConfig')->getWhereAll() );
		}

		public function test_connecShouldFinishOk(){
			$oPdo=new fakeSgbdPdosqlite();

			$sException='null';

			try{
				$oPdo->testui_Connect();
				$oPdo->getPdo();
			}catch(Exception $e){
				$sException=$e->getMessage();
			}

			$this->assertRegexp('/invalid/',$sException);

		}



}
