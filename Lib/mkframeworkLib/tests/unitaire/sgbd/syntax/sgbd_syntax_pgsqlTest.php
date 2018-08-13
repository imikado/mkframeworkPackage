<?php
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_pgsql.php');




/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_syntax_pgsqlTest extends PHPUnit_Framework_TestCase
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
        $sExpectedReturn='SELECT column_name FROM information_schema.columns WHERE table_name =\''.$sTable.'\'';

        $oSgbdSyntax=new sgbd_syntax_pgsql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListColumn($sTable)));
    }

		public function test_getStructureShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn='SELECT column_name,data_type,is_identity FROM information_schema.columns WHERE table_name =\''.$sTable.'\'';

        $oSgbdSyntax=new sgbd_syntax_pgsql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getStructure($sTable)));
    }

		public function test_getListTableShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn= 'SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\'';

        $oSgbdSyntax=new sgbd_syntax_pgsql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListTable($sTable)));
    }

		public function test_getLimitShouldFinishOk()
    {
        $sRequete='SELECT myField From myTable WHERE myField=N';
				$iOffset=30;
				$iLimit=10;
        $sExpectedReturn= $sRequete.' LIMIT '.$iOffset.' OFFSET '.$iLimit;

        $oSgbdSyntax=new sgbd_syntax_pgsql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getLimit($sRequete,$iOffset,$iLimit)));
    }

		public function test_getLastInsertIdShouldFinishOk()
    {
        $sExpectedReturn= 'SELECT lastval()';

        $oSgbdSyntax=new sgbd_syntax_pgsql();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getLastInsertId()));
    }


}
