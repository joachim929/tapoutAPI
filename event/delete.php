<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
require_once './DeleteEvent.php';

//@todo: decide on what params/body to expect, just an item en category id? -
//@todo - Deleting a category should be possible wit the current database design