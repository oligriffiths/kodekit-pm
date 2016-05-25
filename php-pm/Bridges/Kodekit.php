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
        $class = '\\PHPPM\\Bootstraps\\' . $appBootstrap;

        /* @var $bootstrap \PHPPM\Bootstraps\Kodekit */
        $bootstrap = new $class($appenv, $debug);
        $this->application = $bootstrap->getApplication();
    }

    public function getStaticDirectory()
    {
        return __DIR__ . '/../../public';
    }

    public function onRequest(\React\Http\Request $request, \PHPPM\React\HttpResponse $response)
    {
        // Setup request
        $krequest = $this->application->getRequest();
        $krequest->setHeaders($request->getHeaders());
        $krequest->setQuery($request->getQuery());
        $krequest->setData($request->getPost());
        if ($url = $request->getUrl()) {
            $krequest->setUrl($url);
        }
        $krequest->setMethod($request->getMethod());

        // Setup response
        $kresponse = $this->application->getResponse();

        // Add dispatcher response transport
        $transport = new \PHPPM\Kodekit\DispatcherResponseTransport();
        $kresponse->attachTransport($transport);

        // Dispatch request
        $this->application->dispatch();
        
        $code = $kresponse->getStatusCode();

        $response->writeHead($code, $kresponse->getHeaders()->all());
        $response->end($kresponse->getContent());
    }
}