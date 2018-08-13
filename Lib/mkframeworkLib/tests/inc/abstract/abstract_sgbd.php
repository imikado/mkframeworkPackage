<?php
class abstract_sgbd{

	public static $_tInstance;

	protected static function _getInstance($class,$sConfig) {
		if ( !isset(self::$_tInstance[$class][$sConfig]) ){
			$oSgbd = new $class();
			$oSgbd->chooseConfig($sConfig);
			self::$_tInstance[$class][$sConfig]=$oSgbd;

		}
		return self::$_tInstance[$class][$sConfig];
	}

	public function chooseConfig(){

	}

	public function bind($tReq){
		$sReq='';

		if(is_array($tReq)){
			$sReq=$tReq[0];
			if(isset($tReq[1]) and is_array($tReq[1])){
				$tParam=$tReq[1];
			}else{
				unset($tReq[0]);
				$tParam=array_values($tReq);
			}

			foreach($tParam as $sVal){
				$sVal=$this->quote($sVal);
				$sReq=preg_replace('/[?]/',$sVal,$sReq,1);
			}
		}else{
			return $tReq;
		}

		return $sReq;
	}
}
