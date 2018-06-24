<?php
class model_#maTable# extends abstract_model{

	protected $sClassRow=null;

	protected $sTable='#maTable#';
	protected $sConfig=null;

	protected $tId=null;

	protected $tData=array();

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function __construct(){
		$this->tData=array(
			#data#
		);
	}

	public function findById($uId){
		return $this->tData[$uId];
	}
	public function findAll(){
		return $this->tData;
	}

	public function getSelect(){
		return $this->tData;
	}


}
