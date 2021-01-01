<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class abstract_modelNosqlTest extends TestCase
{
	public function run( $result = null)
	{
	    $this->setPreserveGlobalState(false);
	    return parent::run($result);
	}

	public function test_updateShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_rownosql.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRowNoSql.php');


		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql update:myTable'.
			print_r(array(
				'title'=>'title new 1'
			),true).
			print_r(array(
				'id'=>'2'
			),true)

	));

		$oRow=new fakeExtAbstractRowNoSql(array('id'=>2,'title'=>'title 1'));
		$oRow->title='title new 1';

		$oRoot=new _root();
		$oRoot->setConfigVar('db',array(
			'mysqlConfig.sgbd'=>'pdo_mysql',
		));
		$oRoot->setConfigVar('path.lib',__DIR__.'/../../../');
		$oRoot->testui_setLog($oMoockLog);

		$sSql='SELECT * FROM myTable';

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('mysqlConfig');
		$oFakeModel->testui_setTable('myTable');

		$oFakeModel->update($oRow);

	}

	public function test_insertShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_rownosql.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRowNoSql.php');


		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql insert:myTable'.
			print_r(array(
				'title'=>'title new 1'
			),true)

	));

		$oRow=new fakeExtAbstractRowNoSql(array('id'=>2,'title'=>'title 1'));
		$oRow->title='title new 1';

		$oRoot=new _root();
		$oRoot->setConfigVar('db',array(
			'mysqlConfig.sgbd'=>'pdo_mysql',
		));
		$oRoot->setConfigVar('path.lib',__DIR__.'/../../../');
		$oRoot->testui_setLog($oMoockLog);

		$sSql='SELECT * FROM myTable';

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('mysqlConfig');
		$oFakeModel->testui_setTable('myTable');

		$oFakeModel->insert($oRow);


	}

	public function test_deleteShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_rownosql.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRowNoSql.php');


		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql delete:myTable'.
			print_r(array(
				'id'=>2
			),true)

	));

		$oRow=new fakeExtAbstractRowNoSql(array('id'=>2,'title'=>'title 1'));
		$oRow->title='title new 1';

		$oRoot=new _root();
		$oRoot->setConfigVar('db',array(
			'mysqlConfig.sgbd'=>'pdo_mysql',
		));
		$oRoot->setConfigVar('path.lib',__DIR__.'/../../../');
		$oRoot->testui_setLog($oMoockLog);

		$sSql='SELECT * FROM myTable';

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('mysqlConfig');
		$oFakeModel->testui_setTable('myTable');

		$oFakeModel->delete($oRow);

		$this->assertEquals(	'myTable'.
			print_r(array(
				'id'=>2
			),true),$oFakeModel->getRequete());

	}
}
