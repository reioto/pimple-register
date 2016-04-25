<?php
namespace PimpleRegister;

use Pimple\Container;

class Psr4Loader implements LoaderInterface
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
        $this->_setBaseNameSpace($prefix);
    }

    /**
     * @return \SplFileInfo
     */
    protected function getBaseDir() { return $this->_baseDir; }

    /**
     * @return string
     */
    public function getBaseNameSpace() { return $this->_prefix; }

    /**
     * @param string $pre
     * @return $this
     */
    private function _setBaseNameSpace($pre)
    { 
        if (substr($pre, 0, 1) !== '\\') {
            $pre = '\\' . $pre;
        }

        if (substr($pre, -1) !== '\\') {
            $pre .= '\\';
        }

        $this->_prefix = $pre;

        return $this;
    }

    function register(Container $container)
    {
        $base = $this->getBaseDir();
        $dir = new \DirectoryIterator($base->getRealPath());
        foreach ($dir as $file) {
            if ($file->isFile() === false || $file->getExtension() !== 'php') {
                continue;
            }

            $loadName = $this->getBaseNameSpace() . $file->getBasename('.php');
            if (class_exists($loadName)) {
                $container->register(new $loadName);
            } else {
                throw new \DomainException("${loadName} is not Autoloading");
            }
        }
        return $container;
    }
}