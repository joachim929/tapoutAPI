<?php
header("Access-Control-Allow-Origin: *");
require_once './DeletePage.php';

$delete = new DeletePage();

$delete->returnStatement();