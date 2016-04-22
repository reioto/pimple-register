<?php
namespace Test;

use PimpleRegister\Psr4Loader;
use Pimple\Container;

class Psr4LoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group Loader
     * @group Psr4Loader
     */
    function testRegister()
    {
        $instance = new Psr4Loader(__DIR__ . '/Sample', 'Test\\Sample');
        $container = new Container;
        $instance->register($container);

        $ext = array(
            'Test\\Sample\\Reg1',
            'Test\\Sample\\Reg2',
        );

        $this->assertEquals($ext, $container->keys());
    }

    /**
     * @group Loader
     * @group Psr4Loader
     */
    function testRegister_absolute_prefix()
    {
        $instance = new Psr4Loader(__DIR__ . '/Sample', '\\Test\\Sample\\');
        $container = new Container;
        $instance->register($container);

        $ext = array(
            'Test\\Sample\\Reg1',
            'Test\\Sample\\Reg2',
        );

        $this->assertEquals($ext, $container->keys());
    }


    /**
     * @group Loader
     * @group Psr4Loader
     */
    function testRegister_EmptyDir()
    {
        $instance = new Psr4Loader(__DIR__ . '/Sample/EmptyDir', 'Test\\Sample');
        $container = new Container;
        $instance->register($container);

        $ext = array();

        $this->assertSame($ext, $container->keys());
    }
}
