<?php class fakeExtAbstractModel{

	public static $_oInstance=null;
	protected $tId=array('id');

	public static function getInstance(){
		if(self::$_oInstance==null){
			self::$_oInstance=new fakeExtAbstractModel();
		}
		return self::$_oInstance;
	}

	public function getIdTab(){
		return $this->tId;
	}
}
