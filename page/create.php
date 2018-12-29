<?php
header("Access-Control-Allow-Origin: *");
require_once './CreatePage.php';

$page = new CreatePage();

$page->returnStatement();