<?php
header("Access-Control-Allow-Origin: *");
require_once './ReadMenu.php';

$menu = new ReadMenu();
$menu->returnStatement();