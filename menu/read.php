<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization');

require_once './ReadMenu.php';

$menu = new ReadMenu();
$menu->returnStatement();