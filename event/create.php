<?php
echo 'test';
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
require_once './CreateEvent.php';

$event = new CreateEvent();
$event->returnStatement();
