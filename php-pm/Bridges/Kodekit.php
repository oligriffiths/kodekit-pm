<?php

namespace PHPPM\Bridges;

class Kodekit implements BridgeInterface
{
    /**
     * @var \Kodekit\Component\Application\Dispatcher
     */
    private $application;
    
    public function bootstrap($appBootstrap, $appenv, $debug)
    {
//        $class = '\\PHPPM\\Bootstraps\\' . $appBootstrap;
//
//        /* @var $bootstrap \PHPPM\Bootstraps\Kodekit */
//        $bootstrap = new $class($appenv, $debug);
//        $this->application = $bootstrap->getApplication();
    }

    public function getStaticDirectory()
    {

    }

    public function onRequest(\React\Http\Request $request, \PHPPM\React\HttpResponse $response)
    {
//        $this->application->dispatch();

        $response->writeHead(200);
        $response->end('foo');
    }
}