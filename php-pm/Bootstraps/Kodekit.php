<?php

namespace PHPPM\Bootstraps;

class Kodekit implements BootstrapInterface
{
    /**
     * @var string
     */
    protected $appenv;
    
    protected $debug;

    /**
     * Instantiate the bootstrap
     *
     * @param string $appenv
     * @param bool $debug
     */
    public function __construct($appenv, $debug)
    {
        $this->appenv = $appenv;
        $this->debug = $debug;
    }

    /**
     * @return 
     */
    public function getApplication()
    {
        // This is a hack due to bugs in DispatcherRequestAbstract
        if (empty($_SERVER['PHP_SELF'])) {
            $_SERVER['PHP_SELF'] = 'index.php';
        }

        if (empty($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = '/';
        }

        require_once __DIR__ . '/../../public/bootstrap.php';
        
        return \Kodekit::getObject('application');
    }
}