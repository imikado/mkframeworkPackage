<?php

require_once(__DIR__.'/../../inc/abstract/abstract_sgbd.php');
require_once(__DIR__.'/../../../sgbd/sgbd_csv.php');
require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');
require_once(__DIR__.'/../../inc/sgbd/fakeSgbdCsv.php');

class row_csv
{
    protected $tData=array();
    public function __construct($tData)
    {
        $this->tData=$tData;
    }

    public function __get($var)
    {
        return $this->tData[$var];
    }
}



/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_csvTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
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
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('myField1;myField2','myField1;myField2');

        $this->assertEquals(array('myField1','myField2'), $oPdo->getListColumn('myTable'));

        _file::reset();
    }

    public function test_getListTableShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));

        _dir::$testui_getList=array(new _file('myTable1.csv'),new _file('myTable2.csv') );

        $this->assertEquals(array('myTable1','myTable2'), $oPdo->getListTable());
    }


    public function test_getWhereAllShouldFinishOk()
    {
        $oPdo=new fakeSgbdCsv();

        $this->assertEquals('1=1', $oPdo->getWhereAll());
    }

    public function test_getInstanceShouldFinishOk()
    {
        $oPdo=new fakeSgbdCsv();

        $this->assertEquals('1=1', fakeSgbdCsv::getInstance('myConfig')->getWhereAll());
    }

    public function test_quoteShouldFinishOk()
    {
        $oPdo=new fakeSgbdCsv();

        $this->assertEquals('val1', $oPdo->quote('val1'));
    }

    public function test_encodeShouldFinishOk()
    {
        $oPdo=new fakeSgbdCsv();

        $this->assertEquals('val1##retour_chariot_fmk##val2', $oPdo->encode('val1'."\n".'val2'));
    }

    public function test_decodeShouldFinishOk()
    {
        $oPdo=new fakeSgbdCsv();

        $this->assertEquals('val1'."\n".'val2', $oPdo->decode('val1##retour_chariot_fmk##val2'));
    }

    public function test_getTabFromFileShouldFinishOk()
    {
        $tContent=array(
                '1',
                'Header1;header2',
                'Val1;val2'
            );

        $tExpectedContent=array(
                array('Header1'=>'Val1','header2'=>'val2')
            );

        $oPdo=new fakeSgbdCsv();

        $this->assertEquals($tExpectedContent, $oPdo->getTabFromFile($tContent));
    }

    public function test_insertShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2');

        $this->assertEquals(5, $oPdo->insert('myTable', array('Field1'=>'val1','Field2'=>'val2')));

        _file::reset();
    }

    public function test_updateShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $r="\n";
        $sExpectedContent=implode("\n", array(
                '3;',
                'id;Field1;Field2',
                '1;Val1;Val2',
                '2;val31;val32;',
                ''
            ));

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('3;','id;Field1;Field2','1;Val1;Val2','2;Val11;Val12');

        $oPdo->update('myTable', array('Field1'=>'val31','Field2'=>'val32'), array(2));

        $sContent=_file::$testui_written;

        $this->assertEquals($sExpectedContent, $sContent);

        _file::reset();
    }

    public function test_deleteShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $r="\n";
        $sExpectedContent=implode("\n", array(
                '3;',
                'id;Field1;Field2',
                '1;Val1;Val2',
                //'2;val11;val12;',
                '3;Val21;Val22',
                ''
            ));

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('3;','id;Field1;Field2','1;Val1;Val2','2;Val11;Val12','3;Val21;Val22');

        $oPdo->delete('myTable', array(2));

        $sContent=_file::$testui_written;

        $this->assertEquals($sExpectedContent, $sContent);

        _file::reset();
    }

    public function test_findOneShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable',array('Field1'=>'25'));
        $oExpectedObj=new stdclass();

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2','Val1;Val2');

        $this->assertEquals($oExpectedObj, $oPdo->findOne($tSql, 'stdclass'));
        $this->assertEquals($oExpectedObj, $oPdo->findOneSimple($tSql, 'stdclass'));

        _file::reset();
    }

    public function test_findOneWhereShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE id=?',2);
        $oExpectedObj=new stdclass();

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','id;Field1;Field2','1;Val1;Val2','2;Val11;Val12');

        $this->assertEquals($oExpectedObj, $oPdo->findOne($tSql, 'stdclass'));
        _file::reset();
    }

    public function test_findOneNullShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Field=notFound',array('Field1'=>'25'));
        $oExpectedObj=null;

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2','Val1;Val2');

        $this->assertEquals($oExpectedObj, $oPdo->findOne($tSql, 'stdclass'));

        _file::reset();
    }

    public function test_findManyShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable',array('Field1'=>'25'));
        $oExpectedObj=new stdclass();
        $tExpectedObj=array();
        $tExpectedObj[]=$oExpectedObj;

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2','Val1;Val2');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'stdclass'));
        $this->assertEquals($tExpectedObj, $oPdo->findManySimple($tSql, 'stdclass'));

        _file::reset();
    }

    public function test_findManyOrderByShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT Field1,Field2 FROM myTable ORDER BY priority ASC',array('Field1'=>'25'));

        $tExpectedObj=array();
        $oExpectedObj=new row_csv(array('id'=>2,'Field1'=>'Val11','Field2'=>'Val12','priority'=>2));
        $tExpectedObj[]=$oExpectedObj;

        $oExpectedObj=new row_csv(array('id'=>1,'Field1'=>'Val1','Field2'=>'Val2','priority'=>4));
        $tExpectedObj[]=$oExpectedObj;


        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','id;Field1;Field2;priority','1;Val1;Val2;4','2;Val11;Val12;2');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_findManyOrderDescByShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT Field1,Field2 FROM myTable ORDER BY priority DESC',array('Field1'=>'25'));

        $tExpectedObj=array();


        $oExpectedObj=new row_csv(array('id'=>1,'Field1'=>'Val1','Field2'=>'Val2','priority'=>4));
        $tExpectedObj[]=$oExpectedObj;

        $oExpectedObj=new row_csv(array('id'=>2,'Field1'=>'Val11','Field2'=>'Val12','priority'=>2));
        $tExpectedObj[]=$oExpectedObj;


        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','id;Field1;Field2;priority','1;Val1;Val2;4','2;Val11;Val12;2');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_findManyCountShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT COUNT(*) as total FROM myTable ORDER BY Field1 ASC',array('Field1'=>'25'));

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2','Val1;Val2','Val12;Val22');

        $this->assertEquals(array(2), $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_findManySelectOrShouldFinishKo()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Field1=1 OR Field1=2',array('Field1'=>'25'));

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2','Val1;Val2','Val12;Val22');

        $sException='';
        try {
            $oPdo->findMany($tSql, 'row_csv');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/Requete non supportee/i', $sException);

        _file::reset();
    }

    public function test_findManySelectOrderByShouldFinishKo()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable ORDER BY Field1',array('Field1'=>'25'));

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2','Val1;Val2','Val12;Val22');

        $sException='';
        try {
            $oPdo->findMany($tSql, 'row_csv');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/il faut definir un SENS de tri: ASC ou DESC/i', $sException);

        _file::reset();
    }

    public function test_findManySelectGroupByShouldFinishKo()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * ',array('Field1'=>'25'));

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('5;','Field1;Field2','Val1;Val2','Val12;Val22');

        $sException='NO_EXCEPTION';
        try {
            $oPdo->findMany($tSql, 'row_csv');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/Le driver xml gere les requetes de typ/i', $sException);

        _file::reset();
    }

    public function test_findManyWhereShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Field1=?',array('Val1'));
        $oExpectedObj=new row_csv(array('Field1'=>'Val1','Field2'=>'Val2'));
        $tExpectedObj=array();
        $tExpectedObj[]=$oExpectedObj;


        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('2;','Field1;Field2','Val1;Val2','Val11;Val12');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_findManyWhereNullShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Field1=?',array('2'));
        $tExpectedObj=null;

        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('2;','1;Field1;Field2','2;Val1;Val2','3;Val11;Val12');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_findManyWhereAndShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Field1=? and Field2=?',array('Val1','Val2'));
        $oExpectedObj=new row_csv(array('id'=>1,'Field1'=>'Val1','Field2'=>'Val2'));
        $tExpectedObj=array();
        $tExpectedObj[]=$oExpectedObj;
        $oExpectedObj=new row_csv(array('id'=>2,'Field1'=>'Val1','Field2'=>'Val2'));
        $tExpectedObj[]=$oExpectedObj;


        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('2;','id;Field1;Field2','1;Val1;Val2','2;Val1;Val2','3;ValNot;Val2not');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_findManyWhereNotShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Field1!=? ',array('ValNot'));
        $oExpectedObj=new row_csv(array('id'=>1,'Field1'=>'Val1','Field2'=>'Val2'));
        $tExpectedObj=array();
        $tExpectedObj[]=$oExpectedObj;
        $oExpectedObj=new row_csv(array('id'=>2,'Field1'=>'Val1','Field2'=>'Val2'));
        $tExpectedObj[]=$oExpectedObj;


        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('2;','id;Field1;Field2','1;Val1;Val2','2;Val1;Val2','3;ValNot;Val2not');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_findManyWhereEqualAndNotShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Field1=? AND Field2!=? ',array('Val1','Val2'));
        $oExpectedObj=new row_csv(array('id'=>'1','Field1'=>'Val1','Field2'=>'Val4'));
        $tExpectedObj=array();
        $tExpectedObj[]=$oExpectedObj;
        $oExpectedObj=new row_csv(array('id'=>'2','Field1'=>'Val1','Field2'=>'Val4'));
        $tExpectedObj[]=$oExpectedObj;


        $oPdo=new fakeSgbdCsv();
        $oPdo->testui_setConfig(array('.database'=>'myFile'));
        _file::$testui_getTab=array('2;','id;Field1;Field2','1;Val1;Val4','2;Val1;Val4','3;ValNot;Val2not');

        $this->assertEquals($tExpectedObj, $oPdo->findMany($tSql, 'row_csv'));

        _file::reset();
    }

    public function test_executeShouldFinishException()
    {
        $oPdo=new fakeSgbdCsv();

        $sException=null;
        try {
            $oPdo->execute(array());
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/method execute not available for this driver/', $sException);
    }

    public function test_findManyShouldFinishException()
    {
        $oPdo=new fakeSgbdCsv();

        $sException=null;
        try {
            $oPdo->findManySimple(array('SELECT * '), null);
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/Requete non supportee/', $sException);
    }
}
