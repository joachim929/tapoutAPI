<?php

require_once './ConnectDb.php';

checkParams();

function checkParams()
{
    $result = null;
    if (isset($_GET['page']) && $_GET['page'] === 'Menu') {
        //Case for GET only
        if (isset($_GET['lang']) && ($_GET['lang'] === 'en' || $_GET['lang'] === 'vn') && !isset($_GET['task'])) {
            $result = getMenu();
        }
        //Case for GET for edit
        if (isset($_GET['task']) && $_GET['task'] === 'edit') {
            //@todo write all logic, including getting, sorting etc etc
            $result = 'TestEdit';
        }
    }
    returnStatement($result);
}

function getMenu() {
    $language = $_GET['lang'];
    $results = getAllWithLanguage($language);

    $results = sortData($results);
    //@todo write some functions so sort the raw data for categories and positions!!
    return $results;
}

function getAllWithLanguage($language) {
    $conn = ConnectDb::getInstance();
    $mysqli = $conn->getConnection();

    $results = array();

    $stmt = $mysqli->prepare('SELECT item.*, category.name, category.page_position 
        FROM tapout_menu_item 
        AS item 
        LEFT JOIN tapout_menu_category 
        AS category 
        ON item.category_id = category.id 
        WHERE category.language = ?');

    $stmt->bind_param('s', $language);

    $stmt->execute();

    $stmt->bind_result($itemId, $categoryId, $title, $price, $description, $categoryPosition, $categoryName, $pagePosition);

    while ($stmt->fetch()) {
        $results[] = [
            'id' => $itemId,
            'categoryId' => $categoryId,
            'title' => $title,
            'price' => $price,
            'description' => $description,
            'categoryPosition' => $categoryPosition,
            'categoryName' => $categoryName,
            'pagePosition' => $pagePosition
        ];
    }

    $stmt->close();

    return $results;
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

function sortData($results)
{
    $sortedResults = sortCategories($results);
    return $sortedResults;
}

function sortCategories($results) {
    $sortedResults = array();

    foreach ($results as $result) {
        $itemArray = [
            'id' => $result['id'],
            'title' => $result['title'],
            'price' => $result['price'],
            'description' => $result['description'],
            'categoryPosition' => $result['categoryPosition']
        ];
        if(!isset($sortedResults['category'][$result['categoryId']])){
            $sortedResults['category'][$result['categoryId']] = [
                'id' => $result['categoryId'],
                'pagePosition' => $result['pagePosition'],
                'name' => $result['categoryName'],
                'items' => [ $itemArray ]
            ];
        } else {
            $sortedResults['category'][$result['categoryId']]['items'][] = $itemArray;
        }
    }

    $sortedResults = sortMenuItems($sortedResults);
    return $sortedResults;
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
    usort ($results['category'], "comparisonPagePosition");
    return $results;
}


// Comparison function
function comparisonPagePosition($a, $b) {
    if ($a['pagePosition'] === $b['pagePosition']) {
        return 0;
    }
    return ($a['pagePosition'] < $b['pagePosition']) ? -1 : 1;
}


