<?php
declare(strict_types=1);

require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_firebird.php');

use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_syntax_firebirdTest extends TestCase
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
        $sExpectedReturn='select  f.rdb$field_name from rdb$relation_fields f
		join rdb$relations r on f.rdb$relation_name = r.rdb$relation_name
		and r.rdb$view_blr is null
		and (r.rdb$system_flag is null or r.rdb$system_flag = 0)

		WHERE f.rdb$relation_name=\''.$sTable.'\' ';

        $oSgbdSyntax=new sgbd_syntax_firebird();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListColumn($sTable)));
    }

		public function test_getStructureShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn='select  f.rdb$field_name from rdb$relation_fields f
				join rdb$relations r on f.rdb$relation_name = r.rdb$relation_name
				and r.rdb$view_blr is null
				and (r.rdb$system_flag is null or r.rdb$system_flag = 0)

				WHERE f.rdb$relation_name=\''.$sTable.'\' ';

        $oSgbdSyntax=new sgbd_syntax_firebird();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getStructure($sTable)));
    }

		public function test_getListTableShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn= 'select rdb$relation_name from rdb$relations where rdb$view_blr is null and (rdb$system_flag is null or rdb$system_flag = 0);';

        $oSgbdSyntax=new sgbd_syntax_firebird();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getListTable($sTable)));
    }

		public function test_getLimitShouldFinishOk()
    {
        $sRequete='SELECT myField From myTable WHERE myField=N';
				$iOffset=30;
				$iLimit=10;
        $sExpectedReturn= $sRequete.' LIMIT '.$iOffset.','.$iLimit;

        $oSgbdSyntax=new sgbd_syntax_firebird();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getLimit($sRequete,$iOffset,$iLimit)));
    }

		public function test_getLastInsertIdShouldFinishOk()
    {
        $sExpectedReturn= 'SELECT LAST_INSERT_ID()';

        $oSgbdSyntax=new sgbd_syntax_firebird();

        $this->assertEquals( $this->trimString($sExpectedReturn), $this->trimString($oSgbdSyntax->getLastInsertId()));
    }


}
