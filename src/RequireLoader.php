<?php
namespace PimpleRegister;

use Pimple\Container;

class RequireLoader implements LoaderInterface
{
    private $_baseDir;

    /**
     * @param string $dir
     */
    function __construct($dir)
    {
        $this->_baseDir = new \SplFileInfo($dir);
    }

    /**
     * @return \SplFileInfo
     */
    protected function getBaseDir() { return $this->_baseDir; }

    function register(Container $container)
    {
        $base = $this->getBaseDir();
        $dir = new \DirectoryIterator($base->getRealPath());
        foreach ($dir as $file) {
            if ($file->isFile() === false || $file->getExtension() !== 'php') {
                continue;
            }

            require_once $file->getRealPath();
            $loadName = '\\' . $file->getBasename('.php');
            if (class_exists($loadName)) {
                $container->register(new $loadName);
            } else {
                throw new \DomainException("${loadName} cannot be call new");
            }
        }
        return $container;
    }
}