<?php
class fakeAuth extends abstract_auth{

	public static $testui_isConnectedWillReturn;

	public static function testui_isConnectedWillReturn($bReturn_){
		self::$testui_isConnectedWillReturn=$bReturn_;
	}


	public function isConnected(){
		return self::$testui_isConnectedWillReturn;
	}

}
