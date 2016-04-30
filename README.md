# pimple-register
[![Build Status](https://travis-ci.org/reioto/pimple-register.svg?branch=master)](https://travis-ci.org/reioto/pimple-register)


PimpleRegister is Loader for Pimple\\ServiceProviderInterface

How to use it?
-------------

There are Pimple\\ServiceProvider files in one directory:

```
Sample
|-- EmptyDir
|-- Reg1.php
|-- Reg2.php
`-- SubDir
    |-- SubReg1.php
    `-- SubReg2.php
```

Reg1.php:

```
<?php
class Reg1 implements Pimple\ServiceProviderInterface
{
    function register(Pimple\Container $pimple)
	{
		$pimple['reg1'] = function ($c) {
			return __CLASS__;
		};
	}
}
```

## RequireLoader

this Loader uses require_once and new Class

```
</php
$dir = './Sample';
$register = new \PimpleRegister\RequireLoader($dir);

$pimple = new \Pimple\Container();
$register->register($pimple);

var_dump($pimple->keys()); // ["reg1", "reg2"]
var_dump($pimple['reg1']); // "Reg1"
//Loaded PHP Files in the directory of one depth

```

## Psr4Loader

this Loader uses composer-autoload

Reg1.php:

```
<?php
namespace Sample;

use Pimple;
class Reg1 implements Pimple\ServiceProviderInterface
{
    function register(Pimple\Container $pimple)
	{
		$pimple['reg1'] = function ($c) {
			return __CLASS__;
		};
	}
}
```

```
<?php

$dir = './Sample';
$psr_prefix = 'Sample';
$register = new \PimpleRegister\Psr4Loader($dir, $psr_prefix);

$pimple = new \Pimple\Container();
$register->register($pimple);

var_dump($pimple->keys()); // ["reg1", "reg2"]
var_dump($pimple['reg1']); // "Sample\Reg1"
//Loaded PHP Files in directory one depth

```
