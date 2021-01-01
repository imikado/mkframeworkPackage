<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class abstract_modelTest extends TestCase
{
	public function run( $result = null)
	{
	    $this->setPreserveGlobalState(false);
	    return parent::run($result);
	}

	public function test_getConfigShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('myConfig');

		$this->assertEquals('myConfig',$oFakeModel->getConfig());
	}

	public function test_getTableShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setTable('myTable');

		$this->assertEquals('myTable',$oFakeModel->getTable());
	}

	public function test_findOneSimpleShouldFinishException()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		$tSql=array('SELECT * FROM myTable');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setTable('myTable');

		$sException=null;
		try{
			$oFakeModel->findOneSimple($tSql);
		}catch(Exception $e){
			$sException=$e->getMessage();
		}

		$this->assertRegExp('/Il vous manque un fichier de configuration/',$sException);
	}

	public function test_findOneSimpleShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql select:'.
			print_r(array(
			'SELECT * FROM myTable'
		),true)));

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

		$oFakeModel->findOneSimple($sSql);

	}

	public function test_findOneShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql select:'.
			print_r(array(
			'SELECT * FROM myTable'
		),true)));

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

		$oFakeModel->findOne($sSql);

	}

	public function test_findManySimpleShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql select:'.
			print_r(array(
			'SELECT * FROM myTable'
		),true)));

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

		$oFakeModel->findManySimple($sSql);

	}

	public function test_findManyShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql select:'.
			print_r(array(
			'SELECT * FROM myTable'
		),true)));

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

		$oFakeModel->findMany($sSql);

	}

	public function test_executeShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql execute:'.
			print_r(array(
			'SELECT * FROM myTable'
		),true)));

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

		$oFakeModel->execute($sSql);

	}

	public function test_updateShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_row.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRow.php');


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

		$oRow=new fakeExtAbstractRow(array('id'=>2,'title'=>'title 1'));
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

		require_once(__DIR__.'/../../../abstract/abstract_row.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRow.php');


		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql insert:myTable'.
			print_r(array(
				'title'=>'title new 1'
			),true)

	));

		$oRow=new fakeExtAbstractRow(array('id'=>2,'title'=>'title 1'));
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

		require_once(__DIR__.'/../../../abstract/abstract_row.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRow.php');


		$oMoockLog=$this->createMock('interface_pluginLog');
		$oMoockLog->expects($this->once())->method('info')->with($this->equalTo(
			'sql delete:myTable'.
			print_r(array(
				'id'=>2
			),true)

	));

		$oRow=new fakeExtAbstractRow(array('id'=>2,'title'=>'title 1'));
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

	public function test_getListColumnShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_row.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRow.php');

		$tExpectedColumn=array();

		$sTable='myTable';

		$oRow=new fakeExtAbstractRow(array('id'=>2,'title'=>'title 1'));
		$oRow->title='title new 1';

		$oRoot=new _root();
		$oRoot->setConfigVar('db',array(
			'mysqlConfig.sgbd'=>'pdo_mysql',
		));
		$oRoot->setConfigVar('path.lib',__DIR__.'/../../../');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('mysqlConfig');
		$oFakeModel->testui_setTable('myTable');

		$tColumn=$oFakeModel->getListColumn($sTable);

		$this->assertEquals('listColumn:myTable',$tColumn);
	}

	public function test_getListTableShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../inc/sgbd/pdo/sgbd_pdo_mysql.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_row.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRow.php');

		$tExpectedColumn=array();

		$sTable='myTable';

		$oRow=new fakeExtAbstractRow(array('id'=>2,'title'=>'title 1'));
		$oRow->title='title new 1';

		$oRoot=new _root();
		$oRoot->setConfigVar('db',array(
			'mysqlConfig.sgbd'=>'pdo_mysql',
		));
		$oRoot->setConfigVar('path.lib',__DIR__.'/../../../');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('mysqlConfig');
		$oFakeModel->testui_setTable('myTable');

		$tTable=$oFakeModel->getListTable();

		$this->assertEquals('listTable',$tTable);
	}

	public function test_getWhereFromTabShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		$sExpectedWhereGenerated='id=2 ';

		$tWhere=array(
			'id'=>2
		);

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('mysqlConfig');
		$oFakeModel->testui_setTable('myTable');

		$tWhereGenerated=$oFakeModel->getWhereFromTab($tWhere);

		$this->assertEquals($sExpectedWhereGenerated,$tWhereGenerated);
	}

	public function test_getInstanceShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('mysqlConfig');
		$oFakeModel->testui_setTable('myTable');


		$this->assertEquals(new fakeModel(),$oFakeModel->getInstance() );
	}

	public function test_getListTableSgbdXmlShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');

		require_once(__DIR__.'/../../../sgbd/sgbd_xml.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_row.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRow.php');

		require_once(__DIR__.'/../../../class_dir.php');

		$tExpectedColumn=array();


		$oRoot=new _root();
		$oRoot->setConfigVar('db',array(
			'xmlConfig.sgbd'=>'xml',
			'xmlConfig.database'=>__DIR__.'/../../data/db/xml/'
		));
		$oRoot->setConfigVar('path.lib',__DIR__.'/../../../');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('xmlConfig');
		$oFakeModel->testui_setTable('myTable');

		$tTable=$oFakeModel->getListColumn();

		$this->assertEquals(array('id','Nom','Prenom','Langue'),$tTable);
	}

	public function test_getListTableShouldFinishSgbdNotFound()
	{
		require_once(__DIR__.'/../../../abstract/abstract_model.php');
		require_once(__DIR__.'/../../inc/abstract/fakeModel.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		require_once(__DIR__.'/../../../abstract/abstract_sgbd.php');

		require_once(__DIR__.'/../../../sgbd/sgbd_xml.php');
		require_once(__DIR__.'/../../inc/interface/interface_pluginLog.php');

		require_once(__DIR__.'/../../../abstract/abstract_row.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractModel.php');
		require_once(__DIR__.'/../../inc/model/fakeExtAbstractRow.php');

		require_once(__DIR__.'/../../../class_dir.php');
		require_once(__DIR__.'/../../../class_file.php');

		$tExpectedColumn=array();


		$oRoot=new _root();
		$oRoot->setConfigVar('db',array(
			'xmlConfig.sgbd'=>'notFound',
		));
		$oRoot->setConfigVar('path.lib',__DIR__.'/../../../');

		$oFakeModel=new fakeModel();
		$oFakeModel->testui_setConfig('xmlConfig');
		$oFakeModel->testui_setTable('myTable');

		$sException=null;

		try{
			$tTable=$oFakeModel->getListColumn();
		}catch(Exception $e){
			$sException=$e->getMessage();
		}

		$this->assertRegExp('/Pas de driver sgbd_notFound/',$sException);
	}


}
