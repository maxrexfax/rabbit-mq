<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$host = 'localhost';
$port = 5672;
$username = 'user';
$password = 'bitnami';

$connection = new AMQPStreamConnection($host, $port, $username, $password);
$channel = $connection->channel();

$channel->exchange_declare('tomato', 'topic', false, false, false);

$sessionId = uniqid($argv[1] . '_', true);
echo "Session ID:" . $sessionId . "\n";

list($queue_name, ,) = $channel->queue_declare($sessionId, false, false, true, false);

$channel->queue_bind($queue_name, 'tomato', $argv[1]);

echo " [*] Waiting for messages. To exit press CTRL+C\n";


$callback = function ($msg) {      
      echo ' [x] Received ', $msg->body, "\n";
  };
  
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

  while ($channel->is_open()) {
      $channel->wait();
  }

?>