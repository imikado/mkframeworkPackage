<?php
class _dir{

	public static $testui_getList=null;
	public static $testui_getListFile=null;

	protected $sFilename;

	public function __construct($sFilename_){
		$this->sFilename=$sFilename_;
	}

	public static function reset(){
		self::$testui_getList=null;
		self::$testui_getListFile=null;
	}

	public function getName(){
		return $this->sFilename;
	}

	public function getAdresse(){
		return $this->getName();
	}

	public function exist(){}

	public function getListFile(){
		if(self::$testui_getListFile){
			return self::$testui_getListFile;
		}
	}

	public function getList(){
		if(self::$testui_getList){
			return self::$testui_getList;
		}
	}
}
