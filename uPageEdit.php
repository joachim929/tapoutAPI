<?php
require_once 'ConnectDb.php';
require_once 'GetPageToEdit.php';


checkParams();

function checkParams()
{
    $item = new GetPageToEdit();

    returnStatement($item->pageCall());
}

/**
 * This function returns either null or data
 * @param $results
 */
function returnStatement($results)
{
    if ($results !== []) {
        echo json_encode((array)$results);
    } else {
        echo json_encode(null);
    }
}