<?php
class fakeLog
{
    public static $tLogInfo=array();
    public static $tLogWarning=array();
    public static $tLogError=array();

    public function testui_reset()
    {
        self::$tLogInfo=array();
        self::$tLogWarning=array();
        self::$tLogError=array();
    }

    public function setInformation()
    {
    }
    public function setWarning()
    {
    }
    public function setError()
    {
    }
    public function setApplication()
    {
    }
    public function info($sText_)
    {
        self::$tLogInfo[]=$sText_;
    }
    public function error($sText_)
    {
        self::$tLogError[]=$sText_;
    }
}
