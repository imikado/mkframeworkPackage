<?php
class fakeSgbdXml extends sgbd_xml
{
    protected $_sConfig='';
    protected $_tConfig=array();

    public function testui_Connect()
    {
        $this->connect();
    }
    public function testui_setConfig($tConfig_)
    {
        $this->_tConfig=$tConfig_;
    }

    public function getConfig()
    {
        return $this->_sConfig;
    }

    public function erreur($sText)
    {
        throw new Exception($sText);
    }
}
