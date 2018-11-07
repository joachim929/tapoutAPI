<?php

require_once './ConnectDb.php';
require_once './GetMenuClass.php';

checkParams();

function checkParams()
{
    $result = null;
    if (isset($_GET['page']) && $_GET['page'] === 'Menu' && isset($_GET['lang']) &&
        ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn')) {
        $result = getMenu();
    }

    returnStatement($result);
}

function getMenu() {
    $item = new GetMenu();

    return sortMenuItems($item->sortCategories($item->cgetMenu($_GET['lang'])));
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

function sortMenuItems($results) {

    foreach ($results['category'] as $i => $categories) {
        $temp = [];

        foreach ($categories['items'] as $key => $items) {
            $temp[$items['categoryPosition'] . "oldkey" . $key] = $items;
        }

        ksort($temp, SORT_NUMERIC);

        $results['category'][$i]['items'] = array_values($temp);
    }
    // @todo why does this work and not with items, I feel like I tried every combination
    usort ($results['category'], "comparisonPagePosition");
    return $results;
}

function comparisonPagePosition($a, $b) {
    if ($a['pagePosition'] === $b['pagePosition']) {
        return 0;
    }
    return ($a['pagePosition'] < $b['pagePosition']) ? -1 : 1;
}


