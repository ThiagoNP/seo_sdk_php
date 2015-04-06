<?php

require_once 'bvseosdk.php';
require_once 'test/config.php';

/**
 * Test BV class;
 */
class BVTest extends PHPUnit_Framework_testCase
{
    var $params_old = array(
        'deployment_zone_id' => 'test',
        //'bv_root_folder' => 'test',
        //'subject_id' => 'test',
        'product_id' => 'test',
        'cloud_key' => 'test',
    );
    var $params_new = array(
        //'deployment_zone_id' => 'test',
        'bv_root_folder' => 'test',
        'subject_id' => 'test',
        //'product_id' => 'test',
        'cloud_key' => 'test',
    );

    protected static function getMethod($obj, $name)
    {
        $class = new ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function test_getCurrentUrl()
    {
        $_SERVER = array(
            'HTTPS' => 1,
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => '80',
            'REQUEST_URI' => '/index.php?bvreveal=debug',
            'HTTP_USER_AGENT' => 'google',
        );
        $obj = new BV($this->params_old);
        $getCurrentUrl = self::getMethod($obj, '_getCurrentUrl');
        $res = $getCurrentUrl->invokeArgs($obj, array());
        //echo $res;

        $this->assertEquals('https://localhost:80/index.php?bvreveal=debug', $res);

        $_SERVER = array(
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => '80',
            'REQUEST_URI' => '/index.php?bvreveal=debug',
            'HTTP_USER_AGENT' => 'google',
        );
        $obj = new BV($this->params_old);
        $getCurrentUrl = self::getMethod($obj, '_getCurrentUrl');
        $res = $getCurrentUrl->invokeArgs($obj, array());
        //echo $res;

        $this->assertEquals('http://localhost/index.php?bvreveal=debug', $res);

        $_SERVER = array(
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => '88',
            'REQUEST_URI' => '/index.php?bvreveal=debug',
            'HTTP_USER_AGENT' => 'google',
        );
        $obj = new BV($this->params_old);
        $getCurrentUrl = self::getMethod($obj, '_getCurrentUrl');
        $res = $getCurrentUrl->invokeArgs($obj, array());
        //echo $res;

        $this->assertEquals('http://localhost:88/index.php?bvreveal=debug', $res);
    }

}