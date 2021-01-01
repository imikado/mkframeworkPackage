<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class abstract_authTest extends TestCase
{
	public function run( $result = null)
	{
	    $this->setPreserveGlobalState(false);
	    return parent::run($result);
	}

	public function test_enableShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../../class_request.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		$oMookRequest=$this->createMock('_request');

		fakeAuth::testui_isConnectedWillReturn(true);

		$oFakeRoot=new _root();
		$oFakeRoot->testui_getRequestWillReturn($oMookRequest);

		$oFakeAuth=new fakeAuth();

		$this->assertEquals(null,$oFakeAuth->enable());

	}

	public function test_enableAuthModuleShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../../class_request.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		$oMookRequest=$this->createMock('_request');

		$oFakeRoot=new _root();
		$oFakeRoot->setConfigVar('auth.module','auth::login');
		$oFakeRoot->testui_getRequestWillReturn($oMookRequest);

		fakeAuth::testui_isConnectedWillReturn(true);

		$oFakeAuth=new fakeAuth();

		$this->assertEquals(null,$oFakeAuth->enable());

	}

	public function test_enableRedirectShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../../class_request.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		$oMookRequest=$this->createMock('_request');
		$oMookRequest->method('getModule')->willReturn('default');

		$oFakeRoot=new _root();
		$oFakeRoot->setConfigVar('auth.module','auth::login');
		$oFakeRoot->testui_getRequestWillReturn($oMookRequest);
		fakeAuth::testui_isConnectedWillReturn(false);

		$oFakeAuth=new fakeAuth();

		$this->assertEquals(null,$oFakeAuth->enable());

	}

	public function test_connectShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SERVER['REMOTE_ADDR']='MonIp';
		//$_SERVER['HTTP_USER_AGENT']='myUserAgent';

		$oFakeAuth=new fakeAuth();

		$oFakeAuth->_connect();

		$this->assertEquals(sha1('noUserAgent'),$_SESSION['userAgent']);

	}

	public function test_connect2ShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SERVER['REMOTE_ADDR']='MonIp';
		$_SERVER['HTTP_USER_AGENT']='myUserAgent';

		$oFakeAuth=new fakeAuth();
		$oFakeAuth->_connect();

		$this->assertEquals(sha1('myUserAgent'),$_SESSION['userAgent']);
	}
	public function test_connect3ShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SERVER['REMOTE_ADDR']='MonIp';
		$_SERVER['HTTP_USER_AGENT']='myUserAgent';

		$oFakeAuth=new fakeAuth();

		_root::setConfigVar('auth.session.timeout.enabled',1);
		_root::setConfigVar('auth.session.timeout.lifetime',3654);

		$oFakeAuth->_connect();

		$iTimeOut=time()+3654;

		$this->assertEquals($iTimeOut,$_SESSION['timeout']);

	}

	public function test_isConnectedShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SERVER['REMOTE_ADDR']='MonIp';
		$_SERVER['HTTP_USER_AGENT']='myUserAgent';

		$oFakeAuth=new fakeAuth();

		_root::setConfigVar('auth.session.timeout.enabled',1);
		_root::setConfigVar('auth.session.timeout.lifetime',3654);


		$this->assertEquals(false,$oFakeAuth->_isConnected());

	}

	public function test_isConnected2ShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SESSION['ip']=sha1('myIp');
		$_SERVER['REMOTE_ADDR']='myIp';
		_root::setConfigVar('auth.session.timeout.enabled',1);
		$_SERVER['HTTP_USER_AGENT']='myUserAgent';
		$_SESSION['userAgent']=sha1('myUserAgent');

		$oFakeAuth=new fakeAuth();

		$this->assertEquals(false,$oFakeAuth->_isConnected());

	}

	public function test_isConnected3ShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SESSION['ip']=sha1('myIp');
		$_SERVER['REMOTE_ADDR']='myIp';
		_root::setConfigVar('auth.session.timeout.enabled',1);
		$_SERVER['HTTP_USER_AGENT']='myUserAgent';
		$_SESSION['userAgent']=sha1('myUserAgent');

		$_SESSION['timeout']=time()+300;

		$oFakeAuth=new fakeAuth();

		$this->assertEquals(true,$oFakeAuth->_isConnected());

	}

	public function test_isConnected4ShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SESSION['ip']=sha1('myIp');
		$_SERVER['REMOTE_ADDR']='myIp';
		_root::setConfigVar('auth.session.timeout.enabled',1);
		$_SERVER['HTTP_USER_AGENT']='myUserAgent';
		$_SESSION['userAgent']=sha1('myUserAgent');

		$_SESSION['timeout']=time()+300;

		_root::setConfigVar('security.xsrf.checkReferer.enabled',1);
		$_SERVER['HTTP_REFERER']='myReferer';

		$_SERVER['SERVER_NAME']='mydomain.fr';

		$oFakeAuth=new fakeAuth();

		$this->assertEquals(false,$oFakeAuth->_isConnected());

	}

	public function test_isConnected5ShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();

		$_SESSION['ip']=sha1('myIp');
		$_SERVER['REMOTE_ADDR']='myIp';
		_root::setConfigVar('auth.session.timeout.enabled',1);
		$_SERVER['HTTP_USER_AGENT']='myUserAgent';
		$_SESSION['userAgent']=sha1('myUserAgent');

		$_SESSION['timeout']=time()+3000;

		_root::setConfigVar('security.xsrf.checkReferer.enabled',1);
		$_SERVER['HTTP_REFERER']='https://mydomain.fr';

		$_SERVER['SERVER_NAME']='mydomain.fr';

		$_SERVER['HTTPS']=1;

		$oFakeAuth=new fakeAuth();

		$this->assertEquals(true,$oFakeAuth->_isConnected());

	}

	public function test_disconnectShouldFinishOk()
	{
		require_once(__DIR__.'/../../../abstract/abstract_auth.php');
		require_once(__DIR__.'/../../inc/abstract/fakeAuth.php');

		require_once(__DIR__.'/../../inc/fakeClassRoot.php');

		session_start();

		$_SERVER=array();
		$_SESSION=array();


		$oFakeAuth=new fakeAuth();

		$oFakeAuth->_disconnect();

	}





}
