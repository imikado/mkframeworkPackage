<?php
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_mysql.php');




/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_syntax_mysqlTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

		private function trimString($sString_){
			return str_replace(array("\n","\r","\r","\t","\s",' '),'',$sString_);
		}

    public function test_getListColumnShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn='SHOW COLUMNS FROM `'.$sTable.'`';

        $oSgbdSyntax=new sgbd_syntax_mysql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListColumn($sTable)));
    }

		public function test_getStructureShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn='SHOW COLUMNS FROM `'.$sTable.'`';

        $oSgbdSyntax=new sgbd_syntax_mysql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getStructure($sTable)));
    }

		public function test_getListTableShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn= 'SHOW TABLES';

        $oSgbdSyntax=new sgbd_syntax_mysql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListTable($sTable)));
    }

		public function test_getLimitShouldFinishOk()
    {
        $sRequete='SELECT myField From myTable WHERE myField=N';
				$iOffset=30;
				$iLimit=10;
        $sExpectedReturn= $sRequete.' LIMIT '.$iOffset.','.$iLimit;

        $oSgbdSyntax=new sgbd_syntax_mysql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getLimit($sRequete,$iOffset,$iLimit)));
    }

		public function test_getLastInsertIdShouldFinishOk()
    {
        $sExpectedReturn= 'SELECT LAST_INSERT_ID()';

        $oSgbdSyntax=new sgbd_syntax_mysql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getLastInsertId()));
    }


}
