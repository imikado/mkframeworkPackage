<?php

require_once(__DIR__.'/../../../../abstract/abstract_sgbd_pdo.php');
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_oracle.php');
require_once(__DIR__.'/../../../../sgbd/pdo/sgbd_pdo_oracle.php');

require_once(__DIR__.'/../../../inc/sgbd/pdo/fakePdoFetch.php');


class fakeSgbdPdooracle extends sgbd_pdo_oracle{

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
		if($sRequete_==sgbd_syntax_oracle::getListColumn('myTable')){
			return new fakePdoFetch(array(
				array('myField1'),
				array('myField2'))
			);
		}else if($sRequete_==sgbd_syntax_oracle::getListColumn('myTableEmpty')){
			return null;
		}else if($sRequete_==sgbd_syntax_oracle::getListTable()){
			return new fakePdoFetch(array(
				array('myTable1'),
				array('myTable2'))
			);
		}
	}
}

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_pdo_oracleTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

		private function trimString($sString_){
			return str_replace(array("\n","\r","\r","\t","\s",' '),'',$sString_);
		}

		public function test_getListColumnShouldFinishOk(){
			$oPdo=new fakeSgbdPdooracle();

			$this->assertEquals(array('myField1','myField2'),$oPdo->getListColumn('myTable'));

		}

		public function test_getListColumnShouldFinishNull(){
			$oPdo=new fakeSgbdPdooracle();

			$this->assertEquals(null,$oPdo->getListColumn('myTableEmpty'));

		}

		public function test_getListTableShouldFinishOk(){
			$oPdo=new fakeSgbdPdooracle();

			$this->assertEquals(array('myTable1','myTable2'),$oPdo->getListTable());

		}

		public function test_getLastInsertIdShouldFinishOk(){
			$oPdo=new fakeSgbdPdooracle();

			$this->assertEquals(null,$oPdo->getLastInsertId());
		}

		public function test_getWhereAllShouldFinishOk(){
			$oPdo=new fakeSgbdPdooracle();

			$this->assertEquals('1=1',$oPdo->getWhereAll());
		}

		public function test_getInstanceShouldFinishOk(){
			$oPdo=new fakeSgbdPdooracle();

			$this->assertEquals('1=1',fakeSgbdPdooracle::getInstance('myConfig')->getWhereAll() );
		}

		public function test_connecShouldFinishOk(){
			$oPdo=new fakeSgbdPdooracle();

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
