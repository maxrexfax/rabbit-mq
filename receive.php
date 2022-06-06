<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'bitnami');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {  
    if (is_numeric($msg->body)) {
      echo $msg->body . " is number!\n";
    } else {
      echo ' [x] Received ', $msg->body, "\n";
    }
    try {
      $tmpHeaders = $msg->get('application_headers');
    } catch(Exception $ex) {
      $tmpHeaders = 'EMPTY!';
    }
    echo 'Headers:' . $tmpHeaders . "\n";
  };
  
$channel->basic_consume('hello', '', false, true, false, false, $callback);

  while ($channel->is_open()) {
      $channel->wait();
  }


?>