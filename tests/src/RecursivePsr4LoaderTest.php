<?php
namespace Test;

use PimpleRegister\RecursivePsr4Loader;
use Pimple\Container;

class RecursivePsr4LoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group Loader
     * @group RecursivePsr4Loader
     */
    function testRegister()
    {
        $instance = new RecursivePsr4Loader(__DIR__ . '/Sample', 'Test\\Sample');
        $container = new Container;
        $instance->register($container);

        $ext = array(
            'Test\\Sample\\Reg1',
            'Test\\Sample\\Reg2',
            'Test\\Sample\\SubDir\\SubReg1',
            'Test\\Sample\\SubDir\\SubReg2'
        );
        sort($ext);
        $keys = $container->keys();
        sort($keys);
        $this->assertEquals($ext, $keys);
    }

    /**
     * @group Loader
     * @group RecursivePsr4Loader
     */
    function testRegister_absolute_prefix()
    {
        $instance = new RecursivePsr4Loader(__DIR__ . '/Sample', '\\Test\\Sample');
        $container = new Container;
        $instance->register($container);

        $ext = array(
            'Test\\Sample\\Reg1',
            'Test\\Sample\\Reg2',
            'Test\\Sample\\SubDir\\SubReg1',
            'Test\\Sample\\SubDir\\SubReg2'
        );
        sort($ext);
        $keys = $container->keys();
        sort($keys);
        $this->assertEquals($ext, $keys);
    }

    /**
     * @group Loader
     * @group RecursivePsr4Loader
     */
    function testRegister_EmptyDir()
    {
        $instance = new RecursivePsr4Loader(
            __DIR__ . '/Sample/EmptyDir', 'Test\\Sample'
        );
        $container = new Container;
        $instance->register($container);

        $ext = array();

        $this->assertSame($ext, $container->keys());
    }
}
