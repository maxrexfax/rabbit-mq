<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
require "Tomato.php";

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
                            false);


$binding_keys = array_slice($argv, 1);

if (empty($binding_keys)) {
    echo "Usage: $argv[0] [binding_key]\n";
    exit(1);
}

list($queue_name, ,) = $channel->queue_declare("total_data",
    false,
    true,
    false,
    false);
foreach ($binding_keys as $binding_key) {
    //$channel->queue_bind($queue_name, 'tomato', $binding_key);
    $channel->queue_bind($queue_name, 'tomato', $binding_key);
}


echo " [*] Waiting for messages. To exit press CTRL+C\n";


$callback = function ($msg) {
    $tomato = unserialize($msg->body);
      //echo ' [x] Received string: ', $msg->body, "\n";
      echo ' [x] Received $tomato->tomatoColor: ', $tomato->tomatoColor, "\n";
  };
  
$channel->basic_consume($queue_name,
                        '',
                        false,
                        true,
                        false,
                        false,
                        $callback);

  while ($channel->is_open()) {
      $channel->wait();
  }

?>