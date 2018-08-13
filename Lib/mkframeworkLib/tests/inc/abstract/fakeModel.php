<?php
class fakeModel extends abstract_model{

	protected $sConfig;
	protected $sClassRow;

	public function testui_setConfig($sConfig_){
		$this->sConfig=$sConfig_;
	}
	public function testui_setTable($sTable_){
		$this->sTable=$sTable_;
	}

	public function quote($var){
		return $var;
	}

	public function getInstance(){
		return $this->_getInstance('fakeModel');
	}

}
