<?php
require_once(__DIR__.'/../../../class_root.php');

require_once(__DIR__.'/../../inc/abstract/abstract_sgbd.php');
require_once(__DIR__.'/../../../sgbd/sgbd_xml.php');
require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');
require_once(__DIR__.'/../../inc/sgbd/fakeSgbdXml.php');



class row_xml
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
class sgbd_xmlTest extends PHPUnit_Framework_TestCase
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

        $tExpectedColumns=array('id','Nom','Prenom','Langue');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $tColumn=$oPdo->getListColumn('myTable');

        $this->assertEquals($tExpectedColumns, $tColumn);
    }

    public function test_getListTableShouldFinishOk()
    {
        require_once(__DIR__.'/../../inc/class_file.php');
        require_once(__DIR__.'/../../inc/class_dir.php');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>'myDir'));

        _dir::$testui_getList=array(new _dir('myTable1'),new _dir('myTable2') );

        $this->assertEquals(array('myTable1','myTable2'), $oPdo->getListTable());
    }


    public function test_getWhereAllShouldFinishOk()
    {
        $oPdo=new fakeSgbdXml();

        $this->assertEquals('1=1', $oPdo->getWhereAll());
    }

    public function test_getInstanceShouldFinishOk()
    {
        $oPdo=new fakeSgbdXml();

        $this->assertEquals('1=1', fakeSgbdXml::getInstance('myConfig')->getWhereAll());
    }

    public function test_quoteShouldFinishOk()
    {
        $oPdo=new fakeSgbdXml();

        $this->assertEquals('val1', $oPdo->quote('val1'));
    }

    public function test_insertShouldFinishOk()
    {
        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>'myDir'));

        $sException=null;
        try {
            $oPdo->insert('myTable', array('Field1'=>'val1','Field2'=>'val2'));
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/max/', $sException);
    }

    public function test_updateShouldFinishOk()
    {
        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>'myDir/'));

        $sException=null;
        try {
            $oPdo->update('myTable', array('Field1'=>'val31','Field2'=>'val32'), array(2));
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/myDir\/myTable\/2\.xml/', $sException);
    }

    public function test_deleteShouldFinishOk()
    {
        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>'myDir/'));

        $sException=null;
        try {
            $oPdo->delete('myTable', array(2));
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/myDir\/myTable\/2\.xml/', $sException);
    }

    public function test_findOneShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE id=?',2);

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findOne($tSql, 'row_xml');

        $oExpectedRow=new row_xml(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais'));

        $this->assertEquals($oExpectedRow, $oRow);

        $oRowSimple=$oPdo->findOneSimple($tSql, 'row_xml');

        $this->assertEquals($oExpectedRow, $oRowSimple);
    }

    public function test_findOneAndShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Nom=? AND Prenom=?','Asimov','Isaac');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findOne($tSql, 'row_xml');

        $oExpectedRow=new row_xml(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais'));

        $this->assertEquals($oExpectedRow, $oRow);
    }

    public function test_findOneNullShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE id=?',999);

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findOne($tSql, 'row_xml');

        $oExpectedRow=null;

        $this->assertEquals($oExpectedRow, $oRow);
    }

    public function test_findManyShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable  ORDER BY id ASC');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $tRow=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedRow=array(
                new row_xml(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
                new row_xml(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
                new row_xml(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais'))
            );

        $this->assertEquals($tExpectedRow, $tRow);

        $tRowSimple=$oPdo->findManySimple($tSql, 'row_xml');

        $this->assertEquals($tExpectedRow, $tRowSimple);
    }

    public function test_findManyShouldFinishKo()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE id=2 or id=3  ORDER BY id ASC');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $sException=null;
        try {
            $tRow=$oPdo->findMany($tSql, 'row_xml');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }
        $this->assertRegExp('/Requete non supportee/', $sException);
    }

    public function test_findManyOrderBYShouldFinishKo()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable ORDER BY id ');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $sException=null;
        try {
            $tRow=$oPdo->findMany($tSql, 'row_xml');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }
        $this->assertRegExp('/Il faut definir un sens de tri/', $sException);
    }


    public function test_findManyShouldFinishNull()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE id=9999');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findMany($tSql, 'row_xml');

        $this->assertEquals(null, $oRow);
    }

    public function test_findManyOrderByShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable ORDER BY Nom ASC');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedRow=array(

                new row_xml(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
                new row_xml(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais')),
                new row_xml(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
            );

        $this->assertEquals($tExpectedRow, $oRow);
    }

    public function test_findManyOrderByDescShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable ORDER BY Nom DESC');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedRow=array(
                new row_xml(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
                new row_xml(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais')),
                new row_xml(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
            );

        $this->assertEquals($tExpectedRow, $oRow);
    }

    public function test_findManyWhereNotEqualShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Langue!=? ORDER BY id ASC','Anglais');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedRow=array(
                new row_xml(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
                new row_xml(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais')),
                //new row_xml(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
            );

        $this->assertEquals($tExpectedRow, $oRow);
    }

    public function test_findManyWhereAndNotEqualShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT * FROM myTable WHERE Prenom=? AND Langue!=? ORDER BY id ASC','Albert','Anglais');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $oRow=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedRow=array(
                //new row_xml(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
                new row_xml(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais')),
                //new row_xml(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
            );

        $this->assertEquals($tExpectedRow, $oRow);
    }

    public function test_findManyCountShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        $tSql=array('SELECT count(*) FROM myTable');

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/xml/'));

        $iCount=$oPdo->findMany($tSql, 'row_xml');

        $iExpectedRow=array(3);

        $this->assertEquals($iExpectedRow, $iCount);
    }

    public function test_inserShouldFinishOk()
    {
        require_once(__DIR__.'/../../../class_file.php');
        require_once(__DIR__.'/../../../class_dir.php');

        //preparation
        $sDbTmp='/tmp/dbXml'.date('YmdHis').'/';

        mkdir($sDbTmp);
        $sDirTableTmp=$sDbTmp.'myTable';
        mkdir($sDirTableTmp);

        $sStructureContent='<?xml version="1.0" encoding="UTF-8"?>
				<structure>
				<colonne primaire="true">id</colonne>
				<colonne>titre</colonne>

				</structure>';

        file_put_contents($sDirTableTmp.'/structure.xml', $sStructureContent);

        $sStructureMax='<?xml version="1.0" encoding="ISO-8859-1"?>
				<main>
				<max><![CDATA[1]]></max>
				</main>';

        file_put_contents($sDirTableTmp.'/max.xml', $sStructureMax);

        $oPdo=new fakeSgbdXml();
        $oPdo->testui_setConfig(array('.database'=>$sDbTmp));

        //--insert
        $tProperty=array(
                    'titre'=>'titre 1'
                );
        $oPdo->insert('myTable', $tProperty);


        $tSql=array('SELECT * FROM myTable  ORDER BY id ASC');

        $tRow=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedRow=array(
                new row_xml(array('id'=>'1','titre'=>'titre 1')),
          );


        $this->assertEquals($tExpectedRow, $tRow);

        //--update
        $tPropertyToUpdate=array(
                    'titre'=>'titre 1 new'
                );

        $oPdo->update('myTable', $tPropertyToUpdate, array('id'=>1));

        $tRowUpdated=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedRowUpdated=array(
                new row_xml(array('id'=>'1','titre'=>'titre 1 new')),
          );

        $this->assertEquals($tExpectedRowUpdated, $tRowUpdated);

        //--delete
        $oPdo->delete('myTable', array('id'=>1));

        $tPropertyInsertForDelete=array(
                    'titre'=>'titre 2'
                );
        $oPdo->insert('myTable', $tPropertyInsertForDelete);

        $tRowAfterDelete=$oPdo->findMany($tSql, 'row_xml');

        $tExpectedAfterDelete=array(
                        new row_xml(array('id'=>'2','titre'=>'titre 2')),
          );

        $this->assertEquals($tExpectedAfterDelete, $tRowAfterDelete);

        unlink($sDirTableTmp.'/structure.xml');
        unlink($sDirTableTmp.'/max.xml');
        unlink($sDirTableTmp.'/2.xml');
        rmdir($sDirTableTmp);
        rmdir($sDbTmp);
    }
    public function test_executeShouldFinishException()
    {
        $oPdo=new fakeSgbdXml();

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
        $oPdo=new fakeSgbdXml();

        $sException=null;
        try {
            $oPdo->findManySimple(array('SELECT * '), null);
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/Requete non supportee/', $sException);
    }
}
