<?php

class fakeSgbd extends abstract_sgbd
{
    public function testui_getClassRow()
    {
        return $this->_sClassRow;
    }

    public function testui_getChosenConfig()
    {
        return $this->_sConfig;
    }

    public function testui_getConfig()
    {
        return $this->_tConfig;
    }

    public function quote($var)
    {
        return "'$var'";
    }

    public function testui_getId()
    {
        return $this->_tId;
    }

    public function testui_setRequete($sRequest)
    {
        $this->_sReq=$sRequest;
    }

		public function testui_getInstance(){
			return $this->_getInstance('fakeSgbd',$this->_tConfig);
		}
}
