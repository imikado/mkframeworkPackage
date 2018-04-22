<?php
require_once(__DIR__ . '/../autoload_unitaire.php');

//fake i18n class
require_once(__DIR__ . '/../../business/business_VARbusinessNameENDVAR.php');

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class business_VARbusinessNameENDVARTest extends PHPUnit_Framework_TestCase {

	public function run(PHPUnit_Framework_TestResult $result = NULL) {
		$this->setPreserveGlobalState(false);
		return parent::run($result);
	}

	VARbusinessTestListMethodENDVAR
}
