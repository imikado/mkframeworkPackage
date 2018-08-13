<?php

class module_fakeModule
{
    public static $testui_testWillReturn=null;

    public static function testui_testWillReturn($uReturn_)
    {
        self::$testui_testWillReturn=$uReturn_;
    }

    public function _test()
    {
        return self::$testui_testWillReturn;
    }
}
