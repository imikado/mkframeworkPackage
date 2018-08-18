<?php

require_once(__DIR__.'/../../class_root.php');




class RootToTest extends _root
{
    public function testuGet_tConfigVar()
    {
        return self::$tConfigVar;
    }

    public function testuGet_tConfigFilename()
    {
        return self::$_tConfigFilename;
    }

    public function testuGet_tRequestTab()
    {
        return self::$_tRequestTab;
    }

    public function testuGet_bSessionStarted()
    {
        return self::$_bSessionStarted;
    }
}

class FakeException extends Exception
{
}

class fakeI18n
{
    protected $var='val1';
}

class fakeAuth
{
    public function enable()
    {
    }
}

class fakeAcl
{
}

class fakeUrlrewriting
{
    public function getLink($sNav, $tParam)
    {
        return $sNav.'|'.implode(',', $tParam).'|'.'URLREWRITING';
    }

    public function parseUrl()
    {
    }
}





class module_fake
{
    public static $tLog=array();

    public function before()
    {
        self::$tLog[]='module_fake::before()';
    }

    public function before_index()
    {
        self::$tLog[]='module_fake::before_index()';
    }

    public function _index()
    {
        self::$tLog[]='module_fake::_index()';
    }

    public function after_index()
    {
        self::$tLog[]='module_fake::after_index()';
    }

    public function after()
    {
        self::$tLog[]='module_fake::after()';
    }
}




/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classRootTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_ShoulFinishOk()
    {
        $this->assertEquals(true, true);
    }

    public function test_addConfShouldFinishOk()
    {
        //arrange
        $tListExpected=array(
            array('fichierDeConf.ini',null),
        );

        $oRoot = new RootToTest();
        $oRoot->addConf('fichierDeConf.ini');

        //act
        $tListLoaded=$oRoot->testuGet_tConfigFilename();

        //assert
        $this->assertEquals($tListExpected, $tListLoaded);
    }

    public function test_arrayMergeRecursiveShouldFinishOk()
    {

        //arrange
        $tArray=array(
            'key1' => array(
                'sKey1.1' => 'sValue1.1',
                'sKey1.2' => 'sValue1.2',
            )
        );
        $tNewArray=array(
            'key1'=>array(
                'sKey1.3' => 'sValue1.3',
            ),

            'key2' => array(
                'sKey2.1' => 'sValue2.1'
            ),
        );

        $tExpectedArrayMerged=array(
            'key1'=>array(
                'sKey1.1' => 'sValue1.1',
                'sKey1.2' => 'sValue1.2',
                'sKey1.3' => 'sValue1.3',
            ),
            'key2' => array(
                'sKey2.1' => 'sValue2.1'
            ),

        );

        $oRoot = new RootToTest();
        //act
        $tArrayMerged=$oRoot->arrayMergeRecursive($tArray, $tNewArray);

        //assert
        $this->assertEquals($tExpectedArrayMerged, $tArrayMerged);
    }

    /**
    @dataProvider dataProvider_nullbyteprotectShouldFinishList
    */
    public function test_nullbyteprotectShouldFinishList($string_, $stringExpected_)
    {
        $oRoot = new RootToTest();

        //act
        $stringReplaced=$oRoot->nullbyteprotect($string_);

        //assert
        $this->assertEquals($stringExpected_, $stringReplaced);
    }
    public function dataProvider_nullbyteprotectShouldFinishList()
    {
        return array(
            'nullByte1' => array("A\x00B",'AB'),
            'nullByte2' => array("A\0B",'AB'),
                        'antislash' => array('2017\07','2017\07'),
                        'x00' => array('x00','x00'),

        );
    }

    public function test_showExceptionShouldFinishOk()
    {

        //arrange
        try {
            throw new Exception('monTest');
        } catch (Exception $e) {
        }

        $oRoot = new RootToTest();

        //act
        $stringException=$oRoot->showException($e);

        //assert
        $this->assertRegExp('/test_showExceptionShouldFinishOk/', $stringException);
    }

    public function test_setParamShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');

        //arrange
        $stringParamExpected='val1';

        $oRoot = new RootToTest();
        $oRoot->addRequest(array());
        $oRoot->loadRequest();

        //act
        $oRoot->setParam('var1', 'val1');

        $sParam=$oRoot->getParam('var1');

        //assert
        $this->assertEquals($stringParamExpected, $sParam);
    }

    public function test_getParamNavShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');

        //arrange
        $tParam=array(':nav'=>'default::index');
        $sNavExpected='default::index';

        $oRoot = new RootToTest();

        $oRoot->setConfigVar('navigation.var', ':nav');

        $oRoot->addRequest($tParam);
        $oRoot->loadRequest();

        //act
        $sNav=$oRoot->getParamNav();

        //assert
        $this->assertEquals($sNavExpected, $sNav);
    }

    public function test_setParamNavShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');

        //arrange
        $sNavExpected='default::index';

        $oRoot = new RootToTest();

        $oRoot->addRequest(array());
        $oRoot->loadRequest();


        $oRoot->setParamNav('default::index');

        //act
        $sNav=$oRoot->getParamNav();

        //assert
        $this->assertEquals($sNavExpected, $sNav);
    }

    public function test_getModuleShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');

        //arrange
        $sModuleExpected='default';

        $oRoot = new RootToTest();

        $oRoot->addRequest(array());
        $oRoot->loadRequest();


        $oRoot->setParamNav('default::index');

        //act
        $sModule=$oRoot->getModule();

        //assert
        $this->assertEquals($sModuleExpected, $sModule);
    }

    public function test_getActionShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');

        //arrange
        $sActionExpected='index';

        $oRoot = new RootToTest();

        $oRoot->addRequest(array());
        $oRoot->loadRequest();


        $oRoot->setParamNav('default::index');

        //act
        $sAction=$oRoot->getAction();

        //assert
        $this->assertEquals($sActionExpected, $sAction);
    }

    public function test_setConfigVarShouldFinishOk()
    {
        //arrange
        $stringConfigExpected='val1';

        $oRoot = new RootToTest();

        //act
        $oRoot->setConfigVar('var1', 'val1');

        $sConfig=$oRoot->getConfigVar('var1');

        //assert
        $this->assertEquals($stringConfigExpected, $sConfig);
    }

    public function test_getConfigVarShouldFinishOk()
    {
        //arrange
        $stringConfigExpected='lib/framework/sgbd/';

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('path.lib', 'lib/framework/');

        //act
        $oRoot->setConfigVar('path.sgbd', 'val1');

        $sConfig=$oRoot->getConfigVar('path.sgbd');

        //assert
        $this->assertEquals($stringConfigExpected, $sConfig);
    }

    public function test_getConfigVarShouldFinishOk_2()
    {
        //arrange
        $stringConfigExpected='lib/framework/sgbd/syntax/';

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('path.lib', 'lib/framework/');

        //act
        $oRoot->setConfigVar('path.sgbd_syntax', 'val1');

        $sConfig=$oRoot->getConfigVar('path.sgbd_syntax');

        //assert
        $this->assertEquals($stringConfigExpected, $sConfig);
    }

    public function test_getGlobalVarShouldFinishOk()
    {
        //arrange
        $stringConfigExpected='val1';

        $oRoot = new RootToTest();

        //act
        $oRoot->setGlobalVar('var1', 'val1');

        $sConfig=$oRoot->getGlobalVar('var1');

        //assert
        $this->assertEquals($stringConfigExpected, $sConfig);
    }

    public function test_getGlobalVarShouldFinishOk_default()
    {
        //arrange
        $stringConfigExpected='val2';

        $oRoot = new RootToTest();

        //$oRoot->setGlobalVar('var1','val1');

        //act
        $sConfig=$oRoot->getGlobalVar('var1', 'val2');

        //assert
        $this->assertEquals($stringConfigExpected, $sConfig);
    }

    public function test_setInstanceOfShouldFinishOk()
    {
        //arrange
        $object=new stdclass();
        $object->property='val1';

        $objectExpected=new stdclass();
        $objectExpected->property='val1';

        $oRoot = new RootToTest();

        $oRoot->setInstanceOf('objectVal1', $object);

        //act
        $objectStocked=$oRoot->getObject('objectVal1');

        //assert
        $this->assertEquals($objectExpected, $objectStocked);
    }

    public function test_setInstanceOfShouldFinishOk_default()
    {
        //arrange
        $object=new stdclass();
        $object->property='val1';

        $objectExpected=new stdclass();
        $objectExpected->property='val1';

        $oRoot = new RootToTest();

        //$oRoot->setInstanceOf('objectVal1',$object);

        //act
        $objectStocked=$oRoot->getObject('objectVal1', $object);

        //assert
        $this->assertEquals($objectExpected, $objectStocked);
    }

    /**
    @dataProvider dataProvider_getLinkStringShouldFinishList
    */
    public function test_getLinkStringShouldFinishList($sNav_, $tParam_, $bAmp_, $stringExpected_)
    {
        $oRoot = new RootToTest();
        $oRoot->setConfigVar('navigation.var', ':nav');
        $stringReplaced=$oRoot->getLinkString($sNav_, $tParam_, $bAmp_);

        $this->assertEquals($stringExpected_, $stringReplaced);
    }
    public function dataProvider_getLinkStringShouldFinishList()
    {
        return array(
            array(
                'default::index',
                array('var'=>'val'),
                false,
                '?:nav=default::index&var=val',
            ),
            array(
                'default::index',
                array('var'=>'val'),
                true,
                '?:nav=default::index&amp;var=val',
            ),
            array(
                'default::index',
                array('var'=>'val','#'=>'ancre'),
                false,
                '?:nav=default::index&var=val#ancre',
            ),
        );
    }

    public function test_getI18nShouldFinishOk()
    {

        //arrange
        $oI18nExpected=new fakeI18n();

        $oRoot = new RootToTest();

        $oRoot->setConfigVar('language.class', 'fakeI18n');

        //act
        $oI18n=$oRoot->getI18n();

        //assert
        $this->assertEquals($oI18nExpected, $oI18n);
    }

    public function test_resetRequestShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');

        //arrange
        $oExpectedRequest=new _request();
        $oExpectedRequest->setParam('var1', 'val1');

        $tExpectedRequestArray=array(array('var1'=>'val1'));

        $oRoot = new RootToTest();

        $oRoot->addRequest(array('var1'=>'val1'));
        $oRoot->loadRequest();

        //$oRoot->resetRequest();

        $oRequest=$oRoot->getRequest();
        $tRequest=$oRoot->testuGet_tRequestTab();

        $this->assertEquals($oExpectedRequest, $oRequest);
        $this->assertEquals($tExpectedRequestArray, $tRequest);

        //arrange
        $oExpectedRequestReseted=null;
        $tExpectedRequestArrayReseted=array();


        //act
        $oRoot->resetRequest();

        $oRequestReseted=$oRoot->getRequest();
        $tRequestReseted=$oRoot->testuGet_tRequestTab();



        $this->assertEquals($oExpectedRequestReseted, $oRequestReseted);
        $this->assertEquals($tExpectedRequestArrayReseted, $tRequestReseted);
    }

    public function test_loadConfShouldFinishOk()
    {

        //arrange
        $tExpectedConfig=array(
            'path' => array(
                'lib' => 'lib/framework/',
                'conf' => 'conf/',
                'module' => 'module/',
                'plugin' => 'plugin/',
                'model' => 'model/',
                'img' => 'data/img/',
                'i18n' => 'data/i18n/',
                'cache' => 'data/cache/',
                'layout' => 'site/layout/',
            ),
            'cache'=>array(
                'conf.enabled'=>0
            ),
            'tab' => array(
                'var1'=>'val1'
            ),
            'tabFiltered' => array(
                'var2'=>'val2'
            ),
        );

        $oRoot = new RootToTest();

        $oRoot->setConfigVar('cache.conf.enabled', 0);

        $oRoot->addConf(__DIR__.'/../data/config.ini');

        //act
        $oRoot->loadConf();

        $tConfig=$oRoot->testuGet_tConfigVar();

        $this->assertEquals($tExpectedConfig, $tConfig, print_r($tConfig, 1));
    }

    public function test_loadConfShouldFinishOk_filter()
    {

        //arrange
        $tExpectedConfig=array(
            'path' => array(
                'lib' => 'lib/framework/',
                'conf' => 'conf/',
                'module' => 'module/',
                'plugin' => 'plugin/',
                'model' => 'model/',
                'img' => 'data/img/',
                'i18n' => 'data/i18n/',
                'cache' => 'data/cache/',
                'layout' => 'site/layout/',
            ),
            'cache'=>array(
                'conf.enabled'=>0
            ),
            'tabFiltered' => array(
                'var2'=>'val2'
            ),
        );

        $oRoot = new RootToTest();

        $oRoot->setConfigVar('cache.conf.enabled', 0);

        $oRoot->addConf(__DIR__.'/../data/config.ini', 'tabFiltered');

        //act
        $oRoot->loadConf();

        $tConfig=$oRoot->testuGet_tConfigVar();

        $this->assertEquals($tExpectedConfig, $tConfig, print_r($tConfig, 1));
    }

    public function test_startSessionShouldFinishOk()
    {
        $bExpectedSessionStarted=true;

        $oRoot = new RootToTest();
        $oRoot->startSession();

        $bSessionStarted=$oRoot->testuGet_bSessionStarted();

        $this->assertEquals($bExpectedSessionStarted, $bSessionStarted);

        $oRoot->startSession();

        $bSessionStarted=$oRoot->testuGet_bSessionStarted();

        $this->assertEquals($bExpectedSessionStarted, $bSessionStarted);
    }

    public function test_startSessionShouldFinishOk_cookie()
    {
        $bHttpOnly=1;
        $bSecure=1;
        $iLifetime=60;
        $sPath='/';
        $sDomain='myDomain';

        $tExpectedCookieParam=array(
            'lifetime'=>60,
            'path'=>'/',
            'domain'=>'myDomain',
            'secure'=>false,
            'httponly'=>true,
        );

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('auth.session.use_cookies', 1);

        $oRoot->setConfigVar('auth.session.cookie_httponly', $bHttpOnly);
        $oRoot->setConfigVar('auth.session.cookie_secure', $bSecure);
        $oRoot->setConfigVar('auth.session.cookie_lifetime', $iLifetime);
        $oRoot->setConfigVar('auth.session.cookie_path', $sPath);
        $oRoot->setConfigVar('auth.session.cookie_domain', $sDomain);
        $oRoot->startSession();

        $tCookieParam=session_get_cookie_params();


        $this->assertEquals($tExpectedCookieParam, $tCookieParam);
    }

    public function test_startSessionShouldFinishOk_cookieHttps()
    {
        $bHttpOnly=1;
        $bSecure=1;
        $iLifetime=60;
        $sPath='/';
        $sDomain='myDomain';

        $tExpectedCookieParam=array(
            'lifetime'=>60,
            'path'=>'/',
            'domain'=>'myDomain',
            'secure'=>true,
            'httponly'=>true,
        );

        $_SERVER['HTTPS']=1;

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('auth.session.use_cookies', 1);

        $oRoot->setConfigVar('auth.session.cookie_httponly', $bHttpOnly);
        $oRoot->setConfigVar('auth.session.cookie_secure', $bSecure);
        $oRoot->setConfigVar('auth.session.cookie_lifetime', $iLifetime);
        $oRoot->setConfigVar('auth.session.cookie_path', $sPath);
        $oRoot->setConfigVar('auth.session.cookie_domain', $sDomain);
        $oRoot->startSession();

        $tCookieParam=session_get_cookie_params();


        $this->assertEquals($tExpectedCookieParam, $tCookieParam);
    }

    public function test_getCacheShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cache.php');

        //arrange
        $oExpectedCache=new _cache();

        $oRoot = new RootToTest();

        //act
        $oCache=$oRoot->getCache();

        //assert
        $this->assertEquals($oExpectedCache, $oCache);
    }

    public function test_getCacheVarShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_cacheVar.php');

        //arrange
        $oExpectedCacheVar=new _cacheVar();

        $oRoot = new RootToTest();

        //act
        $oCacheVar=$oRoot->getCacheVar();

        //assert
        $this->assertEquals($oExpectedCacheVar, $oCacheVar);
    }

    public function test_getAuthShouldFinishOk()
    {

        //arrange
        $oExpectedAuth=new fakeAuth();

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('auth.class', 'fakeAuth');

        //act
        $oAuth=$oRoot->getAuth();

        //assert
        $this->assertEquals($oExpectedAuth, $oAuth);
    }

    public function test_getAclShouldFinishOk()
    {

        //arrange
        $oExpectedAcl=new fakeAcl();

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('acl.class', 'fakeAcl');

        //act
        $oAcl=$oRoot->getAcl();

        //assert
        $this->assertEquals($oExpectedAcl, $oAcl);
    }

    public function test_getUrlRewritingShouldFinishOk()
    {

        //arrange
        $oExpectedUrlrewriting=new fakeUrlrewriting();

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('urlrewriting.class', 'fakeUrlrewriting');

        //act
        $oUrlrewriting=$oRoot->getUrlRewriting();

        //assert
        $this->assertEquals($oExpectedUrlrewriting, $oUrlrewriting);
    }

    public function test_getLogShouldFinishOk()
    {
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        //arrange
        $oExpectedLog=new fakeLog();

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('log.class', 'fakeLog');

        //act
        $oLog=$oRoot->getLog();

        //assert
        $this->assertEquals($oExpectedLog, $oLog);
    }

    /**
    @dataProvider dataProvider_getLinkShouldFinishList
    */
    public function test_getLinkShouldFinishList($sNav_, $tParam_, $bAmp_, $stringExpected_)
    {
        $oRoot = new RootToTest();
        $oRoot->setConfigVar('navigation.var', ':nav');
        $string=$oRoot->getLink($sNav_, $tParam_, $bAmp_);

        $this->assertEquals($stringExpected_, $string);
    }
    public function dataProvider_getLinkShouldFinishList()
    {
        return array(
            array(
                'default::index',
                array('var'=>'val'),
                false,
                '?:nav=default::index&var=val',
            ),
            array(
                'default::index',
                array('var'=>'val'),
                true,
                '?:nav=default::index&amp;var=val',
            ),
            array(
                'default::index',
                array('var'=>'val','#'=>'ancre'),
                false,
                '?:nav=default::index&var=val#ancre',
            ),
            array(
                array('default::index','var'=>'val'),
                null,
                false,
                '?:nav=default::index&var=val',
            ),
        );
    }

    public function test_getLinkShouldFinishOk_urlrewriting()
    {
        $sNav='default::index';
        $tParam=array('var1'=>'val1');
        $bAmp=false;

        $stringExpected='default::index|val1|URLREWRITING';

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('navigation.var', ':nav');
        $oRoot->setConfigVar('urlrewriting.enabled', 1);
        $oRoot->setConfigVar('urlrewriting.class', 'fakeUrlrewriting');

        $string=$oRoot->getLink($sNav, $tParam, $bAmp);

        $this->assertEquals($stringExpected, $string);
    }

    /**
    @dataProvider dataProvider_getLinkWithCurrentShouldFinishList
    */
    public function test_getLinkWithCurrentShouldFinishList($tParam_, $bAmp_, $stringExpected_)
    {
        require_once(__DIR__.'/../../class_request.php');

        $_GET=array(':nav'=>'default::index','var4'=>'val4');

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('navigation.var', ':nav');
        $oRoot->addRequest($_GET);
        $oRoot->loadRequest();

        $string=$oRoot->getLinkWithCurrent($tParam_, $bAmp_);

        $this->assertEquals($stringExpected_, $string);
    }
    public function dataProvider_getLinkWithCurrentShouldFinishList()
    {
        return array(
            array(array('var2'=>'val2'),false,'?:nav=default::index&var4=val4&var2=val2'),
        );
    }

    public function test_runShouldFinishOk()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        $tLogExpected=array(
            'module_fake::before()',
            'module_fake::before_index()',
            'module_fake::_index()',
            'module_fake::after_index()',
            'module_fake::after()',

        );

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('urlrewriting.enabled', 1);
        $oRoot->setConfigVar('urlrewriting.class', 'fakeUrlrewriting');

        $oRoot->setConfigVar('navigation.var', ':nav');
        $oRoot->setConfigVar('log.class', 'fakeLog');
        $oRoot->setConfigVar('log.information', 0);
        $oRoot->addRequest(array(':nav'=>'fake::index'));

        $oException=null;


        $oRoot->run();


        $this->assertEquals($tLogExpected, module_fake::$tLog);
    }

    public function test_runShouldFinishOk_authDev()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        $tLogExpected=array(
            'module_fake::before()',
            'module_fake::before_index()',
            'module_fake::_index()',
            'module_fake::after_index()',
            'module_fake::after()',

        );

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('auth.enabled', 1);

        $oRoot->setConfigVar('path.layout', __DIR__.'/../inc/');

        $oRoot->setConfigVar('auth.class', 'fakeAuth');

        $oRoot->setConfigVar('urlrewriting.enabled', 1);
        $oRoot->setConfigVar('urlrewriting.class', 'fakeUrlrewriting');

        $oRoot->setConfigVar('navigation.var', ':nav');
        $oRoot->setConfigVar('log.class', 'fakeLog');
        $oRoot->setConfigVar('log.information', 0);
        $oRoot->addRequest(array(':nav'=>'fake::index'));

        $oException=null;

        try {
            $oRoot->run();
        } catch (Exception $e) {
            $oException=$e;
        }

        //$this->assertEquals($tLogExpected,module_fake::$tLog );

        $this->assertEquals('erreur.php', $oException->getMessage());
    }

    public function test_runShouldFinishOk_auth()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');

        $tLogExpected=array(
            'module_fake::before()',
            'module_fake::before_index()',
            'module_fake::_index()',
            'module_fake::after_index()',
            'module_fake::after()',

        );

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('auth.enabled', 1);

        $oRoot->setConfigVar('path.layout', __DIR__.'/../inc/');

        $oRoot->setConfigVar('auth.class', 'fakeAuth');

        $oRoot->setConfigVar('urlrewriting.enabled', 1);
        $oRoot->setConfigVar('urlrewriting.class', 'fakeUrlrewriting');

        $oRoot->setConfigVar('navigation.var', ':nav');
        $oRoot->setConfigVar('log.class', 'fakeLog');
        $oRoot->setConfigVar('log.information', 0);
        $oRoot->addRequest(array(':nav'=>'fake::index'));

        $oException=null;


        $oRoot->run();


        $this->assertEquals($tLogExpected, module_fake::$tLog);
    }

    public function test_runShouldFinishOk_authCache()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../../tests/inc/class_file.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');


        $tLogExpected=array(
            'module_fake::before()',
            'module_fake::before_index()',
            'module_fake::_index()',
            'module_fake::after_index()',
            'module_fake::after()',

        );

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('auth.enabled', 1);
        $oRoot->setConfigVar('cache.enabled', 1);

        $oRoot->setConfigVar('path.layout', __DIR__.'/../inc/');

        $oRoot->setConfigVar('auth.class', 'fakeAuth');

        $oRoot->setConfigVar('urlrewriting.enabled', 1);
        $oRoot->setConfigVar('urlrewriting.class', 'fakeUrlrewriting');

        $oRoot->setConfigVar('navigation.var', ':nav');
        $oRoot->setConfigVar('log.class', 'fakeLog');
        $oRoot->setConfigVar('log.information', 0);
        $oRoot->addRequest(array(':nav'=>'fake::index'));

        $oException=null;


        $oRoot->run();


        $this->assertEquals($tLogExpected, module_fake::$tLog);
    }

    public function test_runShouldFinishKoMethodNotFound()
    {
        require_once(__DIR__.'/../../class_request.php');
        require_once(__DIR__.'/../../tests/inc/fakeLog.php');
        require_once(__DIR__.'/../../tests/inc/fakeDebug.php');

        $tLogExpected=array(
            'module_fake::before()',
            'module_fake::before_index()',
            'module_fake::_index()',
            'module_fake::after_index()',
            'module_fake::after()',

        );

        $oRoot = new RootToTest();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');
        $oRoot->setConfigVar('site.timezone', 'Europe/Paris');

        $oRoot->setConfigVar('navigation.var', ':nav');
        $oRoot->setConfigVar('log.class', 'fakeLog');
        $oRoot->setConfigVar('log.information', 0);
        $oRoot->addRequest(array(':nav'=>'fake::indexNotFound'));

        $oException=null;

        try {
            $oRoot->run();
        } catch (Exception $e) {
            $oException=$e;
        }


        $this->assertRegexp('/Erreur dans module/', $oException->getMessage());
    }
}
