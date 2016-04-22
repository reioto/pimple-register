<?php
namespace Test;

use PimpleRegister\RequireLoader;
use Pimple\Container;

class RequireLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group Loader
     * @group RequireLoader
     */
    function testRegister()
    {
        $instance = new RequireLoader(__DIR__ . '/NoSpace');
        $container = new Container;
        $instance->register($container);

        $ext = array(
            'NReg1',
            'NReg2',
        );

        $keys = $container->keys();
        sort($ext);
        sort($keys);

        $this->assertEquals($ext, $keys);
    }

    /**
     * @group Loader
     * @group RequireLoader
     */
    function testRegister_EmptyDir()
    {
        $instance = new RequireLoader(__DIR__ . '/Sample/EmptyDir');
        $container = new Container;
        $instance->register($container);

        $ext = array();

        $this->assertSame($ext, $container->keys());
    }
}
