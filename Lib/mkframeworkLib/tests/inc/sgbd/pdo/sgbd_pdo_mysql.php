<?php
class sgbd_pdo_mysql{

	protected $testui_findOneSimpleWillReturn;
	protected $_sRequete;

	public static $_oInstance=null;

	public static function getInstance(){
		if(self::$_oInstance==null){
			self::$_oInstance=new sgbd_pdo_mysql();
		}
		return self::$_oInstance;
	}

	public function setConfig(){
	}

	public function findOneSimple($tSql,$sClass){
		$this->_sRequete=print_r($tSql,1);
	}
	public function findOne($tSql,$sClass){
		$this->_sRequete=print_r($tSql,1);
	}
	public function findManySimple($tSql,$sClass){
		$this->_sRequete=print_r($tSql,1);
	}
	public function findMany($tSql,$sClass){
		$this->_sRequete=print_r($tSql,1);
	}

	public function execute($tSql){
		$this->_sRequete=print_r($tSql,1);
	}

	public function update($sTable,$tToUpdate,$tWhere){
		$this->_sRequete=$sTable.print_r($tToUpdate,1).print_r($tWhere,1);
	}

	public function insert($sTable,$tToUpdate){
		$this->_sRequete=$sTable.print_r($tToUpdate,1);
	}

	public function delete($sTable,$tWhere){
		$this->_sRequete=$sTable.print_r($tWhere,1);
	}

	public function getRequete(){
		return $this->_sRequete;
	}

	public function getListColumn($sTable){
		return 'listColumn:'.$sTable;
	}

	public function getListTable(){
		return 'listTable';
	}

	public function testui_findOneSimpleWillReturn($uReturn_){
		$this->testui_findOneSimpleWillReturn=$uReturn_;
	}
}
