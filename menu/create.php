<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization');

require_once './CreateMenu.php';

$menu = new CreateMenu();

$menu->returnStatement();