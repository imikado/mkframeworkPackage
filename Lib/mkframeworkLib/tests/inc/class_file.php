<?php
class _file
{
    public static $testui_getTab=null;
    public static $testui_written=null;
    public static $testui_exist=null;
    public static $testui_filemtime=null;
    public static $testui_hasCalledDelete=false;

    protected static $sContent;

    protected $sFilename;

    public function __construct($sFilename_)
    {
        $this->sFilename=$sFilename_;
    }

    public function getName()
    {
        return $this->sFilename;
    }

    public function getAdresse()
    {
        return $this->sFilename;
    }

    public static function reset()
    {
        self::$testui_getTab=null;
        self::$testui_written=null;
        self::$testui_exist=null;
        self::$testui_filemtime=null;
        self::$testui_hasCalledDelete=false;
    }

    public function exist()
    {
        return self::$testui_exist;
    }
    public function write($sText)
    {
        self::$testui_written=$sText;
    }
    public function getTab()
    {
        if (self::$testui_getTab) {
            return self::$testui_getTab;
        }
    }

    public function filemtime()
    {
        return self::$testui_filemtime;
    }

    public function setContent($sText_)
    {
        self::$sContent=$sText_;
    }

    public function save()
    {
    }

    public function delete()
    {
        self::$testui_hasCalledDelete=true;
    }

    public function getContent()
    {
        return self::$sContent;
    }

    public function testui_getContent()
    {
        return self::$sContent;
    }
}
