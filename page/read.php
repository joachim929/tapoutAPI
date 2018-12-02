<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET');
require_once './ReadPage.php';

$page = new ReadPage();

return $page->returnStatement();