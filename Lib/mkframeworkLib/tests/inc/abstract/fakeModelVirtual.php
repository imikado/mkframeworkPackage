<?php
class fakeModelVirtual extends abstract_modelVirtual{

	protected $sConfig;
	protected $sClassRow;

	protected $bCacheEnabled=false;
	protected $sCacheId='fakeModelVirtual';
	protected $iCacheLifetime=0;

	public function testui_setConfig($sConfig_){
		$this->sConfig=$sConfig_;
	}
	public function testui_setTable($sTable_){
		$this->sTable=$sTable_;
	}

	public function testui_setIsCached($bCacheEnabled_){
		$this->bCacheEnabled=$bCacheEnabled_;
	}

	public function quote($var){
		return $var;
	}

	public function getInstance(){
		return $this->_getInstance('fakeModelVirtual');
	}

}
