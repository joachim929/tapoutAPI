<?php
header("Access-Control-Allow-Origin: *");
require_once './UpdateMenu.php';

$menu = new UpdateMenu();
$menu->returnStatement();