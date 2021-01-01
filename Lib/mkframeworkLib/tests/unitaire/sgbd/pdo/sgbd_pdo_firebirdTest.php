<?php
declare(strict_types=1);

require_once(__DIR__.'/../../../../abstract/abstract_sgbd_pdo.php');
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_firebird.php');
require_once(__DIR__.'/../../../../sgbd/pdo/sgbd_pdo_firebird.php');

require_once(__DIR__.'/../../../inc/sgbd/pdo/fakePdoFetch.php');


class fakeSgbdPdoFirebird extends sgbd_pdo_firebird{

	public function testui_Connect(){
		$this->connect();
	}

	public function getConfig(){
		return $this->_sConfig;
	}

	public function query($sRequete_,$tParam_=null){
		if($sRequete_==sgbd_syntax_firebird::getListColumn('myTable')){
			return new fakePdoFetch(array(
				array('myField1'),
				array('myField2'))
			);
		}else if($sRequete_==sgbd_syntax_firebird::getListColumn('myTableEmpty')){
			return null;
		}else if($sRequete_==sgbd_syntax_firebird::getListTable()){
			return new fakePdoFetch(array(
				array('myTable1'),
				array('myTable2'))
			);
		}
	}
}


use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_pdo_firebirdTest extends TestCase
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
			$oPdo=new fakeSgbdPdoFirebird();

			$this->assertEquals(array('myField1','myField2'),$oPdo->getListColumn('myTable'));

		}

		public function test_getListColumnShouldFinishNull(){
			$oPdo=new fakeSgbdPdoFirebird();

			$this->assertEquals(null,$oPdo->getListColumn('myTableEmpty'));

		}

		public function test_getListTableShouldFinishOk(){
			$oPdo=new fakeSgbdPdoFirebird();

			$this->assertEquals(array('myTable1','myTable2'),$oPdo->getListTable());

		}

		public function test_getLastInsertIdShouldFinishOk(){
			$oPdo=new fakeSgbdPdoFirebird();

			$this->assertEquals(null,$oPdo->getLastInsertId());
		}

		public function test_getWhereAllShouldFinishOk(){
			$oPdo=new fakeSgbdPdoFirebird();

			$this->assertEquals('1=1',$oPdo->getWhereAll());
		}

		public function test_getInstanceShouldFinishOk(){
			$oPdo=new fakeSgbdPdoFirebird();

			$this->assertEquals('1=1',fakeSgbdPdoFirebird::getInstance('myConfig')->getWhereAll() );
		}

		public function test_connecShouldFinishOk(){
			$oPdo=new fakeSgbdPdoFirebird();

			$sException=null;

			try{
				$oPdo->testui_Connect();
				$oPdo->getPdo();
			}catch(Exception $e){
				$sException=$e->getMessage();
			}

			$this->assertRegexp('/invalid/',$sException);

		}



}
