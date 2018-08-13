<?php class fakeRow{

	protected $_tData;
	protected $_tToUpdate=array();

	public function __construct($tData_){
		$this->_tData=$tData_;
	}

	public function __get($key){
		return $this->_tData[$key];
	}


}
