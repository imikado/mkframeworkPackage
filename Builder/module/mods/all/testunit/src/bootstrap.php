<?php

date_default_timezone_set('Europe/Paris');

chdir(dirname(__FILE__));
if (file_exists('../conf/path.ini.php')) {
	$tIni = parse_ini_file('../conf/path.ini.php', true);
} else {
	$tIni = parse_ini_file('../conf/site.ini.php', true);
}
$sLib = $tIni['path']['builder'] . '/module/mods/all/testunit/lib';

$tUnitTestClass = array(
	'class_layout.php',
	'class_view.php',
	'class_unitTest.php',
	'abstract/abstract_module.php',
	'abstract/abstract_model.php',
	'abstract/abstract_row.php'
);

foreach ($tUnitTestClass as $sClass) {
	include $sLib . '/' . $sClass;
}

include ($tIni['path']['lib'] . '/class_root.php');

//enregistrement de l'autoloader
include($tIni['path']['plugin'] . '/plugin_autoload.php');
spl_autoload_register(array('plugin_autoload', 'autoload'));

$oRoot = new _root();
$oRoot->setConfigVar('path', $tIni['path']);
$oRoot->addConf('../conf/mode.ini.php');
$oRoot->addConf('../conf/connexion.ini.php');
$oRoot->addConf('../conf/site.ini.php');
$oRoot->loadConf();
