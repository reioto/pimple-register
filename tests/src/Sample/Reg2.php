<?php
namespace Test\Sample;

use Pimple;

class Reg2 implements Pimple\ServiceProviderInterface
{
    function register(Pimple\Container $pimple)
    {
        $name = __CLASS__;
        $pimple[$name] = function ($c) use ($name){
            return $name;
        };
    }
}