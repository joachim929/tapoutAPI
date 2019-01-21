<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization');
header('Access-Control-Allow-Methods: GET, POST');

require_once './DeleteMenu.php';

$menu = new DeleteMenu();

$menu->returnStatement();