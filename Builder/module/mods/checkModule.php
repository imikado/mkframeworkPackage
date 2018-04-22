<?php

$sType=$argv[1];
$sSModule=$argv[2];

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

//foreach($tModule as $sType => $tSModule){

	//foreach($tSModule as $sSModule){

		include(''.$sType.'/'.$sSModule.'/main.php');

		$sClass='module_mods_'.$sType.'_'.$sSModule.'';


		print 'check module  '.$sType.'/ '.$sSModule."\n";

		$oModule=new $sClass();

		$sPathModule=$sType.'/'.$sSModule;

		$oForm=simplexml_load_file($sPathModule.'/view/form.xml');

		$tVar=array();
		foreach($oForm->step as $oStep){
			foreach($oStep->form->row as $oRow )

			$tVar[ (string)$oRow['name'] ]=1;
		}

		$tParam=array();

		$tPhpFile=file($sPathModule.'/main.php');
		foreach($tPhpFile as $sLine){
			if(preg_match('/\$tParam/',$sLine) and preg_match('/=/',$sLine)){

				list($sDeclaParam,$foo)=explode('=',$sLine);

				$sDeclaParam=trim($sDeclaParam);

				if(preg_match('/\$tParam/',$sDeclaParam) and   preg_match('/^([a-zA-Z_\'\[\]\$]*)$/',$sDeclaParam)  ){

					eval( $sDeclaParam.'=1;');


				}
			}
		}

		$bOk=true;

		$tFile=$oModule->getListSource();
		if($tFile){
		foreach($tFile as $sSource){

			$sFileContent=file_get_contents($sPathModule.'/src/'.$sSource);

			preg_match_all('/VAR([a-zA-Z]*)ENDVAR/',$sFileContent,$tMatch);
			$tTagToReplaceRaw=$tMatch[1];

			$tTagToReplace=array();
			foreach($tTagToReplaceRaw as $sPattern){
				$tTagToReplace[$sPattern]=1;
			}

			$tError=array();
			foreach(array_keys($tTagToReplace) as $sTag){

				if(false===isset( $tVar[$sTag]) and false===isset($tParam[$sTag]) ){
					$tError[]=$sTag;
				}

			}

			if($tError){
				$bOk=false;


				print "\n";
				print ' Error on '.$sSource."\n";
				print ' Tag not replace: '.implode(',',$tError);
			}

		}
		}

		if(false===$bOk){
			print "OK \n";
		}
		print "\n\n";


	//}

//}
