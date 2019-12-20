<?php
require_once(__DIR__.'/../../../class_root.php');

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */

class sgbd_mysqlTest extends PHPUnit_Framework_TestCase
{
    protected static $isBaseSetuped=false;

    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);

        return parent::run($result);
    }

    public function getConfig()
    {
        return array(
          'mysql.dsn'=>'mysql:dbname=baseTestUnitaire;host=localhost',
          'mysql.username'=>'userTest',
          'mysql.password'=>'pass',
          'mysql.sgbd'=>'pdo_mysql'

        );
    }

    public function setupInit()
    {
        if (false==self::$isBaseSetuped) {
            $this->setupBase();
            $this->setupTable();

            self::$isBaseSetuped=true;
        }
    }

    public function setupBase()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig(array(

          'mysql.dsn'=>'mysql:dbname=mysql;host=localhost',
          'mysql.username'=>'userTest',
          'mysql.password'=>'pass',
          'mysql.sgbd'=>'pdo_mysql'

        ));

        $oSgbd->execute('DROP SCHEMA  IF EXISTS baseTestUnitaire');

        $oSgbd->execute('CREATE DATABASE baseTestUnitaire');
    }
    public function setupTable()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');

        $oSgbd->setConfig($this->getConfig());

        $oSgbd->execute('CREATE TABLE Auteur (
				id INT NOT NULL AUTO_INCREMENT,
				nom VARCHAR(50) NULL,
				prenom VARCHAR(50) NULL,
				PRIMARY KEY id (id)
				);');
    }

    public function test_insertManyShouldFinishOk()
    {
        $this->setupInit();

        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig($this->getConfig());

        $sTable='Auteur';
        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd->insert($sTable, $tProperty);

        $oRow=$oSgbd->findOne(array('SELECT * FROM Auteur WHERE id=?',1), 'fakeRow');

        $this->assertEquals('Hugo', $oRow->nom);
    }

    public function test_updateManyShouldFinishOk()
    {
        $this->setupInit();

        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig($this->getConfig());

        $sTable='Auteur';
        $tProperty=array('nom'=>'Asimov','prenom'=>'Isaac');

        $oSgbd->insert($sTable, $tProperty);

        $oRow=$oSgbd->update($sTable, array('nom'=>'Asimov2'), array('id'=>1));

        $oRow=$oSgbd->findOne(array('SELECT * FROM Auteur WHERE id=?',1), 'fakeRow');

        $this->assertEquals('Asimov2', $oRow->nom);

        $oRow=$oSgbd->findOneSimple(array('SELECT * FROM Auteur WHERE id=?',1), null);

        $this->assertEquals('Asimov2', $oRow->nom);
    }

    public function test_findManyShouldFinishOk()
    {
        $this->setupInit();


        require_once(__DIR__.'/../../../sgbd/syntax/sgbd_syntax_mysql.php');
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        $tExpectedRow=array(
                new fakeRow(array(
                    'id'=>1,
                    'nom'=>'Hugo',
                    'prenom'=>'Victor'
                )),
                new fakeRow(array(
                    'id'=>2,
                    'nom'=>'Asimov',
                    'prenom'=>'Isaac'
                ))
            );

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig($this->getConfig());

        $sTable='Auteur';
        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');
        $oSgbd->insert($sTable, $tProperty);

        $this->assertEquals(1, $oSgbd->getLastInsertId());

        $tProperty=array('nom'=>'Asimov','prenom'=>'Isaac');
        $oSgbd->insert($sTable, $tProperty);

        $tRow=$oSgbd->findMany(array('SELECT * FROM Auteur'), 'fakeRow');

        $this->assertEquals($tExpectedRow, $tRow);

        $tRow=$oSgbd->findManySimple(array('SELECT * FROM Auteur'), null);

        $this->assertEquals('Hugo', $tRow[0]->nom);

        $tColumn=$oSgbd->getListColumn('Auteur');

        $this->assertEquals(array('id','nom','prenom'), $tColumn);

        $tTable=$oSgbd->getListTable();

        $this->assertEquals(array('Auteur'), $tTable);
    }

    public function test_deleteManyShouldFinishOk()
    {
        $this->setupInit();

        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig($this->getConfig());

        $sTable='Auteur';
        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd->insert($sTable, $tProperty);

        $oRow=$oSgbd->findOne(array('SELECT * FROM Auteur WHERE id=?',1), 'fakeRow');

        $this->assertEquals('Hugo', $oRow->nom);

        $oSgbd->delete($sTable, array('id'=>1));

        $oRowAfterDeleteSimple=$oSgbd->findOneSimple(array('SELECT * FROM Auteur WHERE id=?',1), 'fakeRow');

        $this->assertEquals(null, $oRowAfterDeleteSimple, "after delete:".print_r($oRowAfterDeleteSimple,1));

        $oRowAfterDelete=$oSgbd->findOne(array('SELECT * FROM Auteur WHERE id=?',1), 'fakeRow');

        $this->assertEquals(null, $oRowAfterDelete, print_r($oRowAfterDelete, 1));
    }

    public function test_getWhereAllShouldFinishOk()
    {
        require_once(__DIR__.'/../../../sgbd/syntax/sgbd_syntax_mysql.php');
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig($this->getConfig());

        $this->assertEquals('1=1', $oSgbd->getWhereAll());

     }

    public function test_connectShouldFinishException()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig(array(

          'mysql.dsn'=>'mysql:dbname=databaseNotFound;host=localhost',
          'mysql.username'=>'userTest',
          'mysql.password'=>'pass',
          'mysql.sgbd'=>'pdo_mysql',

        ));

        $sException=null;
        try {
            $oSgbd->findMany('SELECT * FROM myTableException', 'stdclass');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/ Unknown /', $sException);
        $this->assertRegExp('/ database/', $sException);
        $this->assertRegExp('/databaseNotFound/', $sException);

     }

    public function test_connectShouldFinishException2()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig(array(

          'mysql.dsn'=>'mysql:dbname=databaseNotFound;host=localhost',

          'mysql.username'=>'error',
          'mysql.password'=>'error',
          'mysql.sgbd'=>'pdo_mysql',

                            ));

        $sException=null;
        try {
            $oSgbd->findMany('SELECT * FROM myTableException', 'stdclass');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/Access denied/', $sException);
    }
    public function test_connectShouldFinishException3()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');
        $oSgbd->setConfig(array(

          'mysql.dsn'=>'mysql:dbname=databaseNotFound;host=hostNotFound',

          'mysql.username'=>'error',
          'mysql.password'=>'error',
          'mysql.sgbd'=>'pdo_mysql',

                            ));

        $sException=null;
        try {
            $oSgbd->findMany('SELECT * FROM myTableException', 'stdclass');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/getaddrinfo/', $sException);
        $this->assertRegExp('/hp_network_getaddresses/', $sException);
    }

    public function test_getInstanceShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../sgbd/pdo/sgbd_pdo_mysql.php');

        $oSgbd=new sgbd_pdo_mysql();
        $oSgbd->chooseConfig('mysql');

        $oInstance=$oSgbd->getInstance('mysql');

        $this->assertEquals($oSgbd, $oInstance);
    }
}
