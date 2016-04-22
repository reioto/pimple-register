<?php
namespace PimpleRegister;

use Pimple\Container;

class RecursivePsr4Loader implements LoaderInterface
{
    private $_baseDir;
    private $_prefix = '';

    /**
     * @param string $dir
     * @param string $prefix Prefix NameSpace
     */
    function __construct($dir, $prefix)
    {
        $this->_baseDir = new \SplFileInfo($dir);
        $this->_prefix = $prefix;
    }

    /**
     * @return \SplFileInfo
     */
    protected function getBaseDir() { return $this->_baseDir; }

    /**
     * @return string
     */
    protected function getBaseNameSpace()
    { 
        $pre = $this->_prefix;

        if (substr($pre, 0, 1) !== '\\') {
            $pre = '\\' . $pre;
        }

        if (substr($pre, -1) !== '\\') {
            $pre .= '\\';
        }

        return $pre;
    }

    function register(Container $container)
    {
        $base = $this->getBaseDir();
        $dir = new \RecursiveDirectoryIterator($base->getRealPath());
        $ite = new \RecursiveIteratorIterator(
            $dir, \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($ite as $file) {
            if ($file->isFile() === false || $file->getExtension() !== 'php') {
                continue;
            }

            $path = str_replace(
                $base->getRealPath(),
                '',
                dirname($file->getRealPath())
            );
            $path = trim($path, '/');
            $path = str_replace('/', '\\', $path);

            if ($path === '') {
                $loadName = $this->getBaseNameSpace() .
                    $file->getBasename('.php');
            }else {
                $loadName = $this->getBaseNameSpace() . $path . '\\' .
                    $file->getBasename('.php');
            }

            if (class_exists($loadName)) {
                $container->register(new $loadName);
            } else {
                throw new \DomainException("${loadName} is not Autoloading");
            }
        }
        return $container;
    }
}