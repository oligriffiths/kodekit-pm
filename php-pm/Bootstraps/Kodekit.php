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
        error_log($this->appenv);
    }

    /**
     * @return 
     */
    public function getApplication()
    {
        require_once __DIR__ . '/../../public/bootstrap.php';
        
        return \Kodekit\Library\ObjectManager::getInstance()->getObject('application');
    }
}