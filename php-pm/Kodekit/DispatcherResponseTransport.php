<?php

namespace PHPPM\Kodekit;

use Kodekit\Library;

class DispatcherResponseTransport implements Library\DispatcherResponseTransportInterface, Library\ObjectHandlable
{
    public function send(Library\DispatcherResponseInterface $response)
    {
        return true;
    }

    public function getPriority()
    {
        return static::PRIORITY_HIGHEST;
    }

    public function getHandle()
    {
        return 'ppm';
    }
}