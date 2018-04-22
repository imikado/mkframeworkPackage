<?php

class _root{
	public static function getConfigVar(){

	}
}

include '../../lib/framework/abstract/abstract_moduleBuilder.php';

$tModule=array(
	'scBootstrap'=>array(
		'auth',
		'authInscription',
		'crud',

	)

);

foreach($tModule as $sType => $tSModule){

	foreach($tSModule as $sSModule){

		system('php ./checkModule.php '.$sType.' '.$sSModule);


		continue;

 

	}

}
