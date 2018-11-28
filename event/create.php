<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
require_once './CreateEvent.php';

// @todo:   Decide on how to create an event item/ event category. Make sure there are checks in place that:
// @todo:       - Check that there is enough data for both languages, and that the data matches
// @todo:       - Check that the date isn't in the past, the database also NEEDS to have certain fields filled
// @todo:           but not all