<?php
/**
 * Kodekit Platform - http://www.timble.net/kodekit
 *
 * @copyright	Copyright (C) 2011 - 2016 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license		MPL v2.0 <https://www.mozilla.org/en-US/MPL/2.0>
 * @link		https://github.com/timble/kodekit-platform for the canonical source repository
 */

/**
 * Framework loader
 *
 * @author Johan Janssens <http://github.com/johanjanssens>
 */

use Kodekit\Library;

// Max error reporting
error_reporting(E_ALL);

define( 'DS', DIRECTORY_SEPARATOR );
define('APPLICATION_ROOT' , realpath(__DIR__ . '/../'));
define('APPLICATION_BASE' , APPLICATION_ROOT.'/application/site');

// Bootstrap the framework
$config_file = APPLICATION_ROOT.'/config/bootstrapper.php';
$config = file_exists($config_file) ? require $config_file : [];

// Setup KodeKit
require_once APPLICATION_ROOT.'/vendor/timble/kodekit/code/kodekit.php';
$kodekit = Kodekit::getInstance(array(
    'root_path'       =>  APPLICATION_ROOT,
    'debug'           =>  isset($config['debug']) ? $config['debug'] : false,
    'cache'           =>  isset($config['cache']) ? $config['cache'] : false,
    'cache_namespace' =>  isset($config['cache_namespace']) ? $config['cache_namespace'] : false,
    'base_path'       =>  APPLICATION_BASE
));

// Bootstrap the application
/** @var Library\ObjectBootstrapper $bootstrapper */
$bootstrapper = Kodekit::getObject('object.bootstrapper');

// Register components
$bootstrapper->registerComponents(APPLICATION_ROOT . '/component');

// Find component.json files in /vendor
$dir_iterator = new RecursiveDirectoryIterator(__DIR__ . '/../vendor');
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

/** @var SplFileInfo $item */
foreach ($iterator as $item) {
    if ($item->getBasename() === 'component.json') {
        $bootstrapper->registerComponent(realpath($item->getPath()));
    }
}

// Load the bootstrapper config
if (file_exists($kodekit->getRootPath(). '/config/bootstrapper.php')) {
    $bootstrapper->registerFile($kodekit->getRootPath(). '/config/bootstrapper.php');
}

$bootstrapper->bootstrap();
