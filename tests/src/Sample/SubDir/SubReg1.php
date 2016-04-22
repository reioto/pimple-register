<?php
namespace Test\Sample\SubDir;

use Pimple;

class SubReg1 implements Pimple\ServiceProviderInterface
{
    function register(Pimple\Container $pimple)
    {
        $name = __CLASS__;
        $pimple[$name] = function ($c) use ($name){
            return $name;
        };
    }
}