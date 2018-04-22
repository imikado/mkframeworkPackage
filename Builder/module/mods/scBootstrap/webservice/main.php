<?php

class module_mods_scBootstrap_webservice extends abstract_moduleBuilder {

	protected $sModule = 'mods_scBootstrap_webservice';
	protected $sModuleView = 'mods/scBootstrap/webservice';
	protected $tSource = array(
	    'business/business_businessName.php',
		'public/webservice.php',
		'tests/business_businessNameTest.php',
		'webservice/main.php',
	);
	private $msg = null;
	private $detail = null;
	private $tError = null;

	public function _index() {

		$oModule = new module_builderForm();
		$oModule->load($this->sModuleView);
		$oModule->loadParams(_root::getRequest()->getParams());
		$oModule->loadEngine(new module_mods_scBootstrap_webserviceEngine());
		$oModule->loadSource($this->tSource);

		return $oModule->run();
	}

}

class module_mods_scBootstrap_webserviceEngine {

	public function getApplicationPath() {
		$oTools = new module_builderTools();
		return $oTools->getRootWebsite();
	}

	public function getLinkToFile($sFile) {

		return '<a href="' . _root::getLink('code::index', array('project' => _root::getParam('id'), 'file' => $sFile)) . '">' . $sFile . '</a>';
	}

	public function preProcess($iStep, $tParam) {

		if ($iStep === '1') {

		} else if ($iStep == '2') {

		}


		return array('status' => true, 'tParam' => $tParam);
	}

}
