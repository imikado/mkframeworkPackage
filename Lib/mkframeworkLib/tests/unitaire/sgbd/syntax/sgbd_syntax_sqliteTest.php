<?php
declare(strict_types=1);

require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_sqlite.php');


use PHPUnit\Framework\TestCase;


/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_syntax_sqliteTest extends TestCase
{
    public function run( $result = null)
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
        $sExpectedReturn='PRAGMA table_info(\''.$sTable.'\');';

        $oSgbdSyntax=new sgbd_syntax_sqlite();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListColumn($sTable)));
    }

		public function test_getStructureShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn='PRAGMA table_info('.$sTable.')';

        $oSgbdSyntax=new sgbd_syntax_sqlite();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getStructure($sTable)));
    }

		public function test_getListTableShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn= 'SELECT name FROM sqlite_master
				WHERE type=\'table\'
				ORDER BY name;';

        $oSgbdSyntax=new sgbd_syntax_sqlite();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListTable($sTable)));
    }

		public function test_getLimitShouldFinishOk()
    {
        $sRequete='SELECT myField From myTable WHERE myField=N';
				$iOffset=30;
				$iLimit=10;
        $sExpectedReturn= $sRequete.' LIMIT '.$iOffset.' , '.$iLimit;

        $oSgbdSyntax=new sgbd_syntax_sqlite();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getLimit($sRequete,$iOffset,$iLimit)));
    }


}
