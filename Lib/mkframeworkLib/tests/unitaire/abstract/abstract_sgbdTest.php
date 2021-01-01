<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class abstract_sgbdTest extends TestCase
{
    public function run( $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_setClassRowShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');


        $sExpectedClass='myClass';

        $oSgbd=new fakeSgbd();
        $oSgbd->setClassRow('myClass');

        $this->assertEquals($sExpectedClass, $oSgbd->testui_getClassRow());
    }

    public function test_chooseConfigShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');


        $sExpectedConfig='myConfig';

        $oSgbd=new fakeSgbd();
        $oSgbd->chooseConfig('myConfig');

        $this->assertEquals($sExpectedConfig, $oSgbd->testui_getChosenConfig());
    }

    public function test_setConfigShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');


        $tExpectedConfig=array('db'=>'config');

        $oSgbd=new fakeSgbd();
        $oSgbd->setConfig(array('db'=>'config'));

        $this->assertEquals($tExpectedConfig, $oSgbd->testui_getConfig());
    }

    public function test_bindShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');


        $tExpectedReqBinded="UPDATE myTable SET var1='val1',var2='val2'";

        $tReq=array('UPDATE myTable SET var1=?,var2=?',array('val1','val2'));

        $oSgbd=new fakeSgbd();
        $tReqBinded=$oSgbd->bind($tReq);

        $this->assertEquals($tExpectedReqBinded, $tReqBinded);
    }

    public function test_bindStringShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');


        $sExpectedReqBinded='SELECT * FROM myTable';

        $sReq='SELECT * FROM myTable';

        $oSgbd=new fakeSgbd();
        $sReqBinded=$oSgbd->bind($sReq);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }

    public function test_bindArrayShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');


        $sExpectedReqBinded='SELECT * FROM myTable';

        $tReq=array('SELECT * FROM myTable');

        $oSgbd=new fakeSgbd();
        $sReqBinded=$oSgbd->bind($tReq);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }

    public function test_getInsertFromTabShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');

        $sExpectedReqBinded="(nom,prenom) VALUES ('Hugo','Victor') ";

        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd=new fakeSgbd();
        $sReqBinded=$oSgbd->getInsertFromTab($tProperty);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }

    public function test_getUpdateFromTabShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');

        $sExpectedReqBinded="nom='Hugo',prenom='Victor'";

        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd=new fakeSgbd();
        $sReqBinded=$oSgbd->getUpdateFromTab($tProperty);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }


    public function test_getWhereFromTabShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');

        $sExpectedReqBinded="nom='Hugo' AND prenom='Victor'";

        $tProperty=array('nom'=>'Hugo','prenom'=>'Victor');

        $oSgbd=new fakeSgbd();
        $sReqBinded=$oSgbd->getWhereFromTab($tProperty);

        $this->assertEquals($sExpectedReqBinded, $sReqBinded);
    }


    public function test_setIdShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');

        $tExpectedId=array('id'=>2);

        $oSgbd=new fakeSgbd();
        $oSgbd->setId(array('id'=>2));

        $this->assertEquals($tExpectedId, $oSgbd->testui_getId());
    }

    public function test_erreurShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');

        $sExpectedException='myException';

        $sException=null;

        $oSgbd=new fakeSgbd();
        try {
            $oSgbd->erreur('myException');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertEquals($sExpectedException, $sException);
    }

    public function test_getRequeteShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');

        $oSgbd=new fakeSgbd();
        $oSgbd->testui_setRequete('myRequest');

        $this->assertEquals('myRequest', $oSgbd->getRequete());
    }

		public function test_getInstanceShouldFinishOk()
    {
        require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');
        require_once(__DIR__.'/../../inc/abstract/fakeSgbd.php');

        $oSgbd=new fakeSgbd();
        $oUniqSgbd=$oSgbd->testui_getInstance('myRequest');

        $this->assertEquals($oSgbd, $oUniqSgbd);
    }
}
