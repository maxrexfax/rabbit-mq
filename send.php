<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'bitnami');
$channel = $connection->channel();

//$channel->queue_declare('hello', false, false, false, false);
$channel->exchange_declare('hello', 'fanout', false, false, false);

$numberOfMessages = 1;
$messageKey = 'hello';

if (isset($argc)) {
	echo '$argc=' . $argc;
	if($argc > 2) {
			$numberOfMessages = $argv[1];
			$messageKey = $argv[2];
	}
	
}



if($argc > 3) {		
	echo "message CUSTOM!\n";
	$msg = new AMQPMessage($argv[3]);
	//$msg->set('application_headers', $headers);
	$channel->basic_publish($msg, '', $messageKey);
} else {
	for ($i = 0; $i < $numberOfMessages; $i++) {
		$msg = new AMQPMessage('Message N' . $i + 1 . ' Hello World!');
		//$msg->set('application_headers', $headers);
		$channel->basic_publish($msg, '', $messageKey);
	}
}

echo " [x] Sent some data\n";

$channel->close();
$connection->close();
?>