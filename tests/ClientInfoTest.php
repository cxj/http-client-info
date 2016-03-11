<?php
/**
 * PHPUnit tests for Cxj\Http\ClientInfo.
 *
 * @package     cxj/http-client-info
 * @author      Chris Johnson <cxjohnson@gmail.com>
 * @copyright   2016, Chris Johnson
 * @license     MIT
 */

namespace Cxj\Http;

/**
 * Class ClientInfoTest
 * @package Cxj\Http
 */
class ClientInfoTest extends \PHPUnit_Framework_TestCase
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
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, array());
    }
}
