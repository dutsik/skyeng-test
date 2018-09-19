<?php
/**
 * Created by PhpStorm.
 * User: DUTSIK
 * Date: 9/19/2018
 * Time: 12:12
 */

require_once __DIR__ . './../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use phpFastCache\CacheManager;

use Integration\AwesomeDataProvider;
use Integration\SomeServiceAdapter;


$logger = new Logger('my_logger',[new StreamHandler(__DIR__.'/../tmp/log.log', Logger::DEBUG)]);

$service = new SomeServiceAdapter('host','user','password');


CacheManager::setDefaultConfig([
    "path" => './tmp',
]);

$cache = CacheManager::getInstance('files');
$dataProvider = new AwesomeDataProvider($service,$cache,$logger);
echo $dataProvider->getResponse([1,2,3,3,5,6]);

