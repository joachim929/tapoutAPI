<?php
header("Access-Control-Allow-Origin: *");
require_once './UpdatePage.php';

$page = new UpdatePage();

$page->returnStatement();