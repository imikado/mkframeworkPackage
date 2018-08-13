<?php class _cacheVar{

	public static $testui_isCachedWillReturn;
	public static $testui_getCachedWillReturn;


	public static function testui_isCachedWillReturn($bReturn_){
		self::$testui_isCachedWillReturn=$bReturn_;
	}
	public static function testui_getCachedWillReturn($uReturn_){
		self::$testui_getCachedWillReturn=$uReturn_;
	}

	public function isCached(){
		return self::$testui_isCachedWillReturn;
	}
	public function getCached(){
		return self::$testui_getCachedWillReturn;
	}
}
