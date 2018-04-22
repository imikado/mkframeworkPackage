<?php
class module_VARmoduleChildENDVAR extends abstract_module{

   public function _index(){
       ini_set("soap.wsdl_cache_enabled","0");

       //creation du plugin wsdl
       $oPluginWsdl=new plugin_wsdl;
       //on indique le nom du webservice
       $oPluginWsdl->setName('business_VARbusinessNameENDVAR');
       //on indique l'url du webservice
       $oPluginWsdl->setUrl('VARurlENDVAR');
       //on indique chaque methode disponible

	   VARPluginWsdlListMethodENDVAR


       if(isset($_GET['WSDL'])) {
           //si le wsdl est demande, on l'affiche
           $oPluginWsdl->show();

       }else {

           //sinon on cree le webservice
           $oServer = new SoapServer( 'VARurlENDVAR?WSDL', array('cache_wsdl' => WSDL_CACHE_NONE));
           //on defini la classe a utiliser comme webservice (methode publiques)
           $oServer->setClass('business_VARbusinessNameENDVAR');
           $oServer->handle();

       }
       exit;
   }
}
