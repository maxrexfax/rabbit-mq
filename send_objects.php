<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
require "tomatoGenerator.php";

$host = 'localhost';
$port = 5672;
$username = 'user';
$password = 'bitnami';

$connection = new AMQPStreamConnection($host, $port, $username, $password);

$channel = $connection->channel();

$channel->exchange_declare('tomato',
                            'topic',
                            false,
                            true,
                            false,
                            false);

$countOfObjects = 5;

if (isset($argv[1])) {
    $countOfObjects = $argv[1];
}
$arrayOfObjects = getRandomObjects($countOfObjects);
//var_dump($arrayOfObjects);

foreach($arrayOfObjects as $tomato) {

    $msg = new AMQPMessage(serialize($tomato));
    
    $channel->basic_publish($msg, 'tomato', $tomato->tomatoColor);
    echo serialize($tomato) . "\n";
    echo 'Sending tomato with color:'  . $tomato->tomatoColor . "\n";
}

echo " [x] Sent few objects\n";

$channel->close();
$connection->close();
?>