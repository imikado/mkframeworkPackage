<?php
class _root
{
		public static $tConfig=array();

		public static $testui_getLog=null;
		public static $testui_getRequest=null;

    public static function redirect($uNav, $tParam=null)
    {
        return array($uNav,$tParam);
    }

		public static function getConfigVar($sVar,$default=null){
			if(isset(self::$tConfig[$sVar])){
				return self::$tConfig[$sVar];
			}else{
				return $default;
			}
		}

		public static function setConfigVar($sVar,$sValue){
			self::$tConfig[$sVar]=$sValue;
		}

		public function getLog(){
			return self::$testui_getLog;
		}

		public function testui_setLog($oLog_){
			self::$testui_getLog=$oLog_;
		}

		public function testui_getRequestWillReturn($uReturn_){
			self::$testui_getRequest=$uReturn_;
		}

		public function startSession(){

		}
		public function getRequest(){
			return self::$testui_getRequest;
		}

		public function getAuth(){
			return new fakeAuth();
		}


}
