<?php

class fakePdoFetch{
	protected $i=-1;
	protected $tData=array();

	public function __construct($tData_){
		$this->tData=$tData_;
	}

	public function execute(){}

	public function fetch(){
		$this->i++;

		if(!isset($this->tData[$this->i])){
			return false;
		}

		return $this->tData[$this->i];


	}
}
