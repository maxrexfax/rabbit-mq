<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
require "tomatoGenerator.php";
$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'bitnami');
$channel = $connection->channel();

$channel->exchange_declare('tomato', 'topic', false, false, false);

$arrayOfObjects = getRandomObjects();
//var_dump($arrayOfObjects);

foreach($arrayOfObjects as $tomato) {

    $msg = new AMQPMessage('Message: tomato.' . $tomato->tomatoColor);
    
    $channel->basic_publish($msg, 'tomato', $tomato->tomatoColor);
}




echo " [x] Sent few objects\n";

$channel->close();
$connection->close();
?>