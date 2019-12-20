<?php
/**
* @runTestsInSeparateProcesses
* @preserveGlobalState disabled
*/
class abstract_sgbd_pdo_pdoTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_setClassRowShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $sExpectedClass='myClass';

        $oSgbd=new fakeSgbdPdo();
        $oSgbd->setClassRow('myClass');

        $this->assertEquals($sExpectedClass, $oSgbd->testui_getClassRow());
    }

    public function test_chooseConfigShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');


        $sExpectedConfig='myConfig';

        $oSgbd=new fakeSgbdPdo();
        $oSgbd->chooseConfig('myConfig');

        $this->assertEquals($sExpectedConfig, $oSgbd->testui_getChosenConfig());
    }

    public function test_setConfigShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');


        $tExpectedConfig=array('db'=>'config');

        $oSgbd=new fakeSgbdPdo();
        $oSgbd->setConfig(array('db'=>'config'));

        $this->assertEquals($tExpectedConfig, $oSgbd->testui_getConfig());
    }



    public function test_getInsertFromTabShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $sExpectedReqBinded="(nom,prenom) VALUES (?,?) ";

        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd=new fakeSgbdPdo();
        $sReqBinded=$oSgbd->getInsertFromTab($tProperty);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }

    public function test_getUpdateFromTabShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $sExpectedReqBinded="nom=?,prenom=?";

        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd=new fakeSgbdPdo();
        $sReqBinded=$oSgbd->getUpdateFromTab($tProperty);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }


    public function test_getWhereFromTabShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $sExpectedReqBinded="nom=? AND prenom=?";

        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd=new fakeSgbdPdo();
        $sReqBinded=$oSgbd->getWhereFromTab($tProperty);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }


    public function test_setIdShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $tExpectedId=array('id'=>2);

        $oSgbd=new fakeSgbdPdo();
        $oSgbd->setId(array('id'=>2));

        $this->assertEquals($tExpectedId, $oSgbd->testui_getId());
    }

    public function test_erreurShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $sExpectedException='myException';

        $sException=null;

        $oSgbd=new fakeSgbdPdo();
        try {
            $oSgbd->erreur('myException');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertEquals($sExpectedException, $sException);
    }

    public function test_getRequeteShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $oSgbd=new fakeSgbdPdo();
        $oSgbd->testui_setRequete('myRequest');

        $this->assertEquals('myRequest', $oSgbd->getRequete());
    }

    public function test_getInstanceShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $oSgbd=new fakeSgbdPdo();
        $oUniqSgbd=$oSgbd->testui_getInstance('myRequest');

        $this->assertEquals($oSgbd, $oUniqSgbd);
    }

    public function test_getRequestAndParamShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $tExpectedReqAndParam=array(
          'SELECT * FROM myTable WHERE id=?',
          array(2)
        );

        $tReq=array('SELECT * FROM myTable WHERE id=?',2);

        $oSgbd=new fakeSgbdPdo();
        $tReqAndParam=$oSgbd->testui_getRequestAndParam($tReq);

        $this->assertEquals($tExpectedReqAndParam, $tReqAndParam);
    }

    public function test_getRequestAndParamWithArrayShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $tExpectedReqAndParam=array(
          'SELECT * FROM myTable WHERE id=?',
          array(2)
        );

        $tReq=array('SELECT * FROM myTable WHERE id=?',array(2));

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $tReqAndParam=$oFakeSgbdPdo->testui_getRequestAndParam($tReq);

        $this->assertEquals($tExpectedReqAndParam, $tReqAndParam);
    }

    public function test_getRequestAndParamWithStringShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        $tExpectedReqAndParam=array('SELECT * FROM myTable',null);

        $sReq='SELECT * FROM myTable';

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $tReqAndParam=$oFakeSgbdPdo->testui_getRequestAndParam($sReq);

        $this->assertEquals($tExpectedReqAndParam, $tReqAndParam);
    }

    public function test_findManySimpleShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        require_once(__DIR__.'/../../../class_root.php');

        $tExpected=array();

        $oRow=new stdclass();
        $oRow->id=1;
        $oRow->title='title 1';

        $tExpected[]=$oRow;

        $oRow=new stdclass();
        $oRow->id=2;
        $oRow->title='title 2';

        $tExpected[]=$oRow;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());
        $oFakeSgbdPdo->testui_sth_fetchAllWillReturn($tExpected);

        $tReq='SELECT * FROM myTable';

        $oSgbd=new fakeSgbdPdo();
        $tRow=$oSgbd->findManySimple($tReq, null);

        $this->assertEquals($tExpected, $tRow);
    }

    public function test_findManySimpleWithParamsShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        require_once(__DIR__.'/../../../class_root.php');


        $tExpected=array();

        $oRow=new stdclass();
        $oRow->id=1;
        $oRow->title='title 1';

        $tExpected[]=$oRow;

        $oRow=new stdclass();
        $oRow->id=2;
        $oRow->title='title 2';

        $tExpected[]=$oRow;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());
        $oFakeSgbdPdo->testui_sth_fetchAllWillReturn($tExpected);

        $tReq=array('SELECT * FROM myTable WHERE id=?',2);

        $oSgbd=new fakeSgbdPdo();
        $tRow=$oSgbd->findManySimple($tReq, null);

        $this->assertEquals($tExpected, $tRow);
    }

    public function test_findManyWithParamNullShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        require_once(__DIR__.'/../../../class_root.php');


        $tExpected=array();

        $oRow=new stdclass();
        $oRow->id=1;
        $oRow->title='title 1';

        $tExpected[]=$oRow;

        $oRow=new stdclass();
        $oRow->id=2;
        $oRow->title='title 2';

        $tExpected[]=$oRow;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());
        $oFakeSgbdPdo->testui_sth_fetchAllWillReturn($tExpected);

        $tReq=array('SELECT * FROM myTable WHERE id=?');

        $oSgbd=new fakeSgbdPdo();
        $tRow=$oSgbd->findManySimple($tReq, null);

        $this->assertEquals($tExpected, $tRow);
    }



    public function test_findManyShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $tExpected=array(
          new fakeRow(array('id'=>1,'title'=>'title 1')),
          new fakeRow(array('id'=>2,'title'=>'title 2')),
        );

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(
            array(
              array('id'=>1,'title'=>'title 1'),
              array('id'=>2,'title'=>'title 2'),
            )

        ));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq='SELECT * FROM myTable';

        $oSgbd=new fakeSgbdPdo();
        $tRow=$oSgbd->findMany($tReq, 'fakeRow');

        $this->assertEquals($tExpected, $tRow);
    }

    public function test_findManyCleanedShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../abstract/abstract_row.php');

        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        require_once(__DIR__.'/../../inc/model/testRow.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');



        $tExpected=array(
          new fakeRow(array('id'=>1,'title'=>'title 1 &eacute;&szlig;&yen;&ETH;&ntilde;&eth;&#039;&quot;')),
          new fakeRow(array('id'=>2,'title'=>'title 2')),
        );

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(
            array(
              array('id'=>1,'title'=>'title 1 éß¥Ðñð\'"'),
              array('id'=>2,'title'=>'title 2'),
            )

        ));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq='SELECT * FROM myTable';

        _root::setConfigVar('security.xss.model.enabled', 1);

        $oSgbd=new fakeSgbdPdo();
        $tRow=$oSgbd->findMany($tReq, 'testRow');

        foreach ($tExpected as $i => $rowExpected) {
            $this->assertEquals($rowExpected->id, $tRow[$i]->id);
            $this->assertEquals($rowExpected->title, $tRow[$i]->title);
        }

        //check if disable cleaning:
        $oRowGenerated=$tRow[0];
        $this->assertEquals('title 1 &eacute;&szlig;&yen;&ETH;&ntilde;&eth;&#039;&quot;', $oRowGenerated->title);

        $oRowGenerated->disableCleaning();
        $this->assertEquals('title 1 éß¥Ðñð\'"', $oRowGenerated->title);

        $oRowGenerated->enableCleaning();
        $this->assertEquals('title 1 &eacute;&szlig;&yen;&ETH;&ntilde;&eth;&#039;&quot;', $oRowGenerated->title);

        $oRowGenerated->disableCleaning();
        $this->assertEquals('title 1 éß¥Ðñð\'"', $oRowGenerated->title);
    }

    public function test_findManyNotCleanedShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../../abstract/abstract_row.php');

        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        require_once(__DIR__.'/../../inc/model/testRow.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        $tExpected=array(
          new fakeRow(array('id'=>1,'title'=>'title 1 éß¥Ðñð\'"')),
          new fakeRow(array('id'=>2,'title'=>'title 2')),
        );

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(
            array(
              array('id'=>1,'title'=>'title 1 éß¥Ðñð\'"'),
              array('id'=>2,'title'=>'title 2'),
            )

        ));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq='SELECT * FROM myTable';

        _root::setConfigVar('security.xss.model.enabled', 0);

        $oSgbd=new fakeSgbdPdo();
        $tRow=$oSgbd->findMany($tReq, 'testRow');

        foreach ($tExpected as $i => $rowExpected) {
            $this->assertEquals($rowExpected->id, $tRow[$i]->id);
            $this->assertEquals($rowExpected->title, $tRow[$i]->title);
        }
    }

    public function test_findManyWithParamsShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $tExpected=array(
          new fakeRow(array('id'=>1,'title'=>'title 1')),
          new fakeRow(array('id'=>2,'title'=>'title 2')),
        );

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(
            array(
              array('id'=>1,'title'=>'title 1'),
              array('id'=>2,'title'=>'title 2'),
            )

        ));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq=array('SELECT * FROM myTable WHERE type=?',2);

        $oSgbd=new fakeSgbdPdo();
        $tRow=$oSgbd->findMany($tReq, 'fakeRow');

        $this->assertEquals($tExpected, $tRow);
    }


    public function test_findOneWithParamsShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=new fakeRow(array('id'=>1,'title'=>'title 1'));

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(array(
        array('id'=>1,'title'=>'title 1')
        )));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq=array('SELECT * FROM myTable WHERE id=?',2);

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->findOne($tReq, 'fakeRow');

        $this->assertEquals($oExpected, $oRow);
    }

    public function test_findOneWithParamsReturnNullShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=null;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(array(
        null
        )));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq=array('SELECT * FROM myTable WHERE id=?',2);

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->findOne($tReq, 'fakeRow');

        $this->assertEquals($oExpected, $oRow);
    }

    public function test_findOneSimpleWithParamsShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=array('id'=>1,'title'=>'title 1');

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(array(
        array('id'=>1,'title'=>'title 1')
        )));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq=array('SELECT * FROM myTable WHERE id=?',2);

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->findOneSimple($tReq, 'fakeRow');

        $this->assertEquals($oExpected, $oRow);
    }

    public function test_findOneSimpleWithParamsReturnNullShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=null;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoFetch(array(
        null
        )));
        //$oFakeSgbdPdo->testui_sth_fetchWillReturn(array('id'=>2,'title'=>'title 1'));

        $tReq=array('SELECT * FROM myTable WHERE id=?',2);

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->findOneSimple($tReq, 'fakeRow');

        $this->assertEquals($oExpected, $oRow);
    }

    public function test_executeShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=null;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());

        $tReq='SELECT * FROM myTable ';

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->execute($tReq);

        $this->assertEquals(new fakePdoSth(), $oRow);
    }

    public function test_updateShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=null;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());

        $sTable='myTable';
        $tProperty=array('title'=>'title 1');
        $tWhere=array('id'=>2);

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->update($sTable, $tProperty, $tWhere);

        $this->assertEquals(null, $oRow);
    }

    public function test_insertShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=null;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());

        $oFakeSgbdPdo->testui_getLastInsertIdWillReturn(33);

        $sTable='myTable';
        $tProperty=array('title'=>'title 1');

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->insert($sTable, $tProperty);

        $this->assertEquals(null, $oRow);
    }

    public function test_deleteShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=null;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());

        $oFakeSgbdPdo->testui_getLastInsertIdWillReturn(33);

        $sTable='myTable';
        $tProperty=array('title'=>'title 1');

        $oSgbd=new fakeSgbdPdo();
        $oRow=$oSgbd->delete($sTable, $tProperty);

        $this->assertEquals(null, $oRow);
    }

    public function test_getPdoShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd_pdo.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbdPdo.php');
        require_once(__DIR__.'/../../inc/model/fakeRow.php');

        require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');

        require_once(__DIR__.'/../../../class_root.php');

        $oExpected=null;

        $oFakeSgbdPdo=new fakeSgbdPdo();
        $oFakeSgbdPdo->testui_reset();

        $oFakeSgbdPdo->testui_pdo_prepareWillReturn(new fakePdoSth());

        $oFakeSgbdPdo->testui_getLastInsertIdWillReturn(33);

        $sTable='myTable';
        $tProperty=array('title'=>'title 1');

        $oSgbd=new fakeSgbdPdo();
        $oPdo=$oSgbd->getPdo();

        $this->assertEquals(new fakePdo(), $oPdo);
    }
}
