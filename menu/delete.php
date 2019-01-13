<?php
header("Access-Control-Allow-Origin: *");
require_once './DeleteMenu.php';

$menu = new DeleteMenu();

$menu->returnStatement();