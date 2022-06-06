<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'bitnami');
$channel = $connection->channel();

$channel->exchange_declare('tomato', 'topic', false, false, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$channel->queue_bind($queue_name, 'tomato', $argv[1]);

echo 'Getting tomato of color:' . $argv[1] . "\n";
echo " [*] Waiting for messages. To exit press CTRL+C\n";


$callback = function ($msg) {      
      echo ' [x] Received ', $msg->body, "\n";    
  };
  
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

  while ($channel->is_open()) {
      $channel->wait();
  }

?>