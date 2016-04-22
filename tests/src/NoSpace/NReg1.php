<?php

class NReg1 implements Pimple\ServiceProviderInterface
{
    function register(Pimple\Container $pimple)
    {
        $name = __CLASS__;
        $pimple[$name] = function ($c) use ($name){
            return $name;
        };
    }
}