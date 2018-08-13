<?php
/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class abstract_modelVirtualTest extends PHPUnit_Framework_TestCase
{
	public function run(PHPUnit_Framework_TestResult $result = null)
	{
	    $this->setPreserveGlobalState(false);
	    return parent::run($result);
	}

	public function test_findManyShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable');

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';

		$ExpectedRow=array(
			$oObject,
			$oObject2

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

	}

	public function test_findManyShouldFinishNotFound()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE type=15');

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';

		$ExpectedRow=array(
			$oObject,
			$oObject2

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertNull($tRow);

		$tRowSimple=$oModelVirtual->findManySimple($tSql);

		$this->assertNull($tRowSimple);

	}

	public function test_findManyAndShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE type=? AND priority=?',1,1);

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;
		$oObject->priority=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';
		$oObject2->type=2;
		$oObject2->priority=1;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 3';
		$oObject3->type=1;
		$oObject3->priority=1;

		$ExpectedRow=array(
			$oObject,
			//$oObject2,
			$oObject3

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type','priority'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

	}

	public function test_findManyAndNotShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE type=? AND priority!=?',1,2);

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;
		$oObject->priority=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';
		$oObject2->type=2;
		$oObject2->priority=1;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 3';
		$oObject3->type=1;
		$oObject3->priority=1;

		$ExpectedRow=array(
			$oObject,
			//$oObject2,
			$oObject3

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type','priority'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

	}

	public function test_findManyWhereShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE type=?',1);

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';
		$oObject2->type=2;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 3';
		$oObject3->type=1;

		$ExpectedRow=array(
			$oObject,
	//		$oObject2
			$oObject3
		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);

		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

		$tRowSimple=$oModelVirtual->findManySimple($tSql);

		$this->assertEquals($ExpectedRow,$tRowSimple);

	}

	public function test_findManyWhereArrayShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE type=?',array(1));

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';
		$oObject2->type=2;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 3';
		$oObject3->type=1;

		$ExpectedRow=array(
			$oObject,
	//		$oObject2
			$oObject3
		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);

		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

		$tRowSimple=$oModelVirtual->findManySimple($tSql);

		$this->assertEquals($ExpectedRow,$tRowSimple);

	}

	public function test_findManyWhereNotShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE type!=?',2);

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';
		$oObject2->type=2;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 3';
		$oObject3->type=1;

		$ExpectedRow=array(
			$oObject,
	//		$oObject2
			$oObject3
		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);

		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

		$tRowSimple=$oModelVirtual->findManySimple($tSql);

		$this->assertEquals($ExpectedRow,$tRowSimple);

	}

	public function test_findOneShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE id=?',2);

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';

		$oExpectedRow=$oObject2;

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);

		$oRow=$oModelVirtual->findOne($tSql);

		$this->assertEquals($oExpectedRow,$oRow);


		$oRowSimple=$oModelVirtual->findOneSimple($tSql);

		$this->assertEquals($oExpectedRow,$oRowSimple);

	}

	public function test_findOneShouldFinishNotFound()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable WHERE id=?',12);

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 2';

		$oExpectedRow=$oObject2;

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);

		$oRow=$oModelVirtual->findOne($tSql);

		$this->assertNull($oRow);


		$oRowSimple=$oModelVirtual->findOneSimple($tSql);

		$this->assertNull($oRowSimple);

	}

	public function test_findManyOrderByAscShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable ORDER by title ASC');

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;
		$oObject->priority=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 3';
		$oObject2->type=2;
		$oObject2->priority=1;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 2';
		$oObject3->type=1;
		$oObject3->priority=1;

		$ExpectedRow=array(
			$oObject,
			$oObject3,
			$oObject2

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type','priority'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

	}

	public function test_findManyOrAscShouldFinishException()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type','priority'));

		$sException=null;

		$tSql=array('SELECT * FROM myTable WHERE type=? OR priority=?',1,1);
		try{
			$tRow=$oModelVirtual->findMany($tSql);
		}catch(Exception $e){
			$sException=$e->getMessage();
		}

		$this->assertRegExp('/Requete non supportee/',$sException);

		$tSql=array('SELECT * FROM myTable ORDER by id',1,1);
		try{
			$tRow=$oModelVirtual->findMany($tSql);
		}catch(Exception $e){
			$sException=$e->getMessage();
		}

		$this->assertRegExp('/faut definir un sens de tri/',$sException);

	}

	public function test_findManyOrderByDescShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;
		$oObject->priority=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 3';
		$oObject2->type=2;
		$oObject2->priority=1;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 2';
		$oObject3->type=1;
		$oObject3->priority=1;

		$ExpectedRow=array(
			$oObject2,
			$oObject3,
			$oObject

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type','priority'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);

		$tSql=array('SELECT * FROM myTable ORDER by title DESC');
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

		$tSql='SELECT * FROM myTable ORDER by title DESC';
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

		$tSql=array('SELECT COUNT(*) FROM myTable');
		$iCount=$oModelVirtual->findOne($tSql);

		$oRowCount=new stdclass();
		$oRowCount->total=3;

		$this->assertEquals($oRowCount,$iCount);

	}

	public function test_findManyOrderByDescLimitShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable ORDER by title DESC LIMIT 2,1');

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;
		$oObject->priority=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 3';
		$oObject2->type=2;
		$oObject2->priority=1;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 2';
		$oObject3->type=1;
		$oObject3->priority=1;

		$ExpectedRow=array(
			//$oObject2,
		//	$oObject3,
		$oObject

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type','priority'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);
		$tRow=$oModelVirtual->findMany($tSql);

		$this->assertEquals($ExpectedRow,$tRow);

	}

	public function test_findManyOrderByDescShouldFinishException()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$tSql=array('SELECT * FROM myTable ORDER by fieldNotFound DESC');

		$oObject=new stdclass();
		$oObject->id=1;
		$oObject->title='title 1';
		$oObject->type=1;
		$oObject->priority=1;

		$oObject2=new stdclass();
		$oObject2->id=2;
		$oObject2->title='title 3';
		$oObject2->type=2;
		$oObject2->priority=1;

		$oObject3=new stdclass();
		$oObject3->id=3;
		$oObject3->title='title 2';
		$oObject3->type=1;
		$oObject3->priority=1;

		$ExpectedRow=array(
			$oObject2,
			$oObject3,
			$oObject

		);

		$oModelVirtual=new fakeModelVirtual();
		$oModelVirtual->setColumns(array('id','title','type','priority'));
		$oModelVirtual->addObject($oObject);
		$oModelVirtual->addObject($oObject2);
		$oModelVirtual->addObject($oObject3);

		$sException=null;

		try{
			$tRow=$oModelVirtual->findMany($tSql);
		}catch(Exception $e){
			$sException=$e->getMessage();
		}

		$this->assertRegExp('/Champ /',$sException);
		$this->assertRegExp('/fieldNotFound /',$sException);
		$this->assertRegExp('/ inexistant /',$sException);
	}

	public function test_getInstanceShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_modelVirtual.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModelVirtual.php');

		$oModelVirtual=new fakeModelVirtual();

		$oInstanceModel=$oModelVirtual->getInstance();

		$this->assertEquals(new fakeModelVirtual(),$oInstanceModel);

	}

}
