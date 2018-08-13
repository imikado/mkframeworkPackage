<?php
class fakeDebug
{
    public function show($sText)
    {
        throw new Exception($sText);
    }
}
