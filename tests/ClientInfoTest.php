<?php
/**
 * PHPUnit tests for Cxj\Http\ClientInfo.
 *
 * @package     cxj/http-client-info
 * @author      Chris Johnson <cxjohnson@gmail.com>
 * @copyright   2016, Chris Johnson
 * @license     MIT
 */

/*
 * Namespace to allow mocking global PHP functions.
 */
namespace Cxj\Http {

    $headers = array(
        'HTTP_X_FORWARDED_FOR' => '127.0.0.1',
        'X-Forwarded-For'      => '::0'
    );

    function apache_request_headers()
    {
        global $headers;

        return $headers;
    }

    /**
     * Class ClientInfoTest
     * @package Cxj\Http
     */
    class ClientInfoTest extends \PHPUnit\Framework\TestCase
    {
        public function testConstructor()
        {
            $classname = 'Cxj\Http\ClientInfo';

            // Get mock, without the constructor being called
            $mock = $this->getMockBuilder($classname)
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();

            // now call the constructor
            $reflectedClass = new \ReflectionClass($classname);
            $constructor    = $reflectedClass->getConstructor();
            $class = $constructor->invoke($mock, array());

            $this->assertTrue(true);
        }

        public function testGetHeaders()
        {
            global $headers;

            $this->assertEquals(apache_request_headers(), $headers);
        }
    }
}
