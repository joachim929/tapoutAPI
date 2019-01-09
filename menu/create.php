<?php
header("Access-Control-Allow-Origin: *");
require_once './CreateMenu.php';

$menu = new CreateMenu();

$menu->returnStatement();