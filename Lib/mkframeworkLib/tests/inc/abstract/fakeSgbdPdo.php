<?php
class fakePdoSth{
	protected $tParam=array();
	protected $sReq=null;

	public static $testui_fetchAllWillReturn=null;
	public static $testui_fetchWillReturn=null;

	public function __construct(){
	}

	public function execute($tParam){
		$this->tParam=$tParam;
	}
	public function fetchAll(){
		return self::$testui_fetchAllWillReturn;
	}
	public function fetch(){
		return self::$testui_fetchWillReturn;
	}
}
class fakePdo{

	public static $testui_prepareWillReturn=null;

	public function setAttribute(){}
	public function prepare($sRequete){
		return self::$testui_prepareWillReturn;
	}
}
class fakeSgbdPdo extends abstract_sgbd_pdo
{

		protected $testui_getLastInsertId;

		public function testui_reset(){
			$this->testui_sth_fetchAllWillReturn(null);
			$this->testui_sth_fetchWillReturn(null);
			$this->testui_pdo_prepareWillReturn(null);
		}

		public function testui_sth_fetchAllWillReturn($uReturn_){
			fakePdoSth::$testui_fetchAllWillReturn=$uReturn_;
		}
		public function testui_sth_fetchWillReturn($uReturn_){
			fakePdoSth::$testui_fetchWillReturn=$uReturn_;
		}

		public function testui_pdo_prepareWillReturn($uReturn_){
			fakePdo::$testui_prepareWillReturn=$uReturn_;
		}

		public function testui_getLastInsertIdWillReturn($uReturn_){
			$this->testui_getLastInsertId=$uReturn_;
		}


    public function testui_getClassRow()
    {
        return $this->_sClassRow;
    }

    public function testui_getChosenConfig()
    {
        return $this->_sConfig;
    }

    public function testui_getConfig()
    {
        return $this->_tConfig;
    }

    public function quote($var)
    {
        return "'$var'";
    }

    public function testui_getId()
    {
        return $this->_tId;
    }

    public function testui_setRequete($sRequest)
    {
        $this->_sReq=$sRequest;
    }

		public function testui_getInstance(){
			return $this->_getInstance('fakeSgbdPdo',$this->_tConfig);
		}

		public function testui_getRequestAndParam($tReq){
			return $this->getRequestAndParam($tReq);
		}

		public function connect(){
			$this->_pDb=new fakePdo();
		}

		public function getLastInsertId(){
			return $this->testui_getLastInsertId;
		}

}
