<?php

require_once './ConnectDb.php';
require_once './GetMenuClass.php';

checkParams();

function checkParams()
{
    $result = null;
    // @todo add authentication check
    if (isset($_GET['page']) && isset($_GET['task']) &&
        $_GET['page'] === 'Menu' && $_GET['task'] === 'Edit') {
        $result = getMenu();
    }

    returnStatement($result);
}

function getMenu()
{
    $item = new GetMenu();
    $results = $item->cgetMenuToEdit();
    $sortedCategories = getCategoryTags();
    $sortedResults = matchResultsWithCategoryTags($results, $sortedCategories);
    $orderedCategories = sortMenu($sortedResults);
    return $orderedCategories;
}

function sortMenu($sortedResults) {
    foreach ($sortedResults as $key => $sortedResult) {
        usort($sortedResult['items'], "comparisonCategoryPosition");
        $sortedResults[$key] = $sortedResult;
    }
    usort ($sortedResults, "comparisonPagePosition");
    return $sortedResults;
}

function comparisonCategoryPosition($a, $b) {
    if($a['categoryPosition'] === $b['categoryPosition']) {
        return 0;
    }
    return ($a['categoryPosition'] < $b['categoryPosition']) ? -1 : 1;
}

function comparisonPagePosition($a, $b) {
    if ($a['pagePosition'] === $b['pagePosition']) {
        return 0;
    }
    return ($a['pagePosition'] < $b['pagePosition']) ? -1 : 1;
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

function sortCategoriesByLanguage($results) {

    $enCategories = array();
    $vnCategories = array();

    $sortedCategories = array();

    foreach ($results as $result) {
        if($result['categoryLanguage'] === 'en') {
            $enCategories[] = $result;
        } else {
            $vnCategories[] = $result;
        }
    }
    $sortedCategories[] = $enCategories;
    $sortedCategories[] = $vnCategories;
    return $sortedCategories;
}

function getCategoryTags() {
    $item = new GetMenu();
    $categoryTags = $item->getCategoryTags();

    foreach($categoryTags as $key => $categoryTag) {
        $categoryTags[$key] = [
            'categoryTag' => null,
            'enCategoryId' => null,
            'vnCategoryId' => null,
            'pagePosition' => null,
            'enCategoryName' => null,
            'vnCategoryName' => null,
            'categoryType' => null,
            'items' => array()
        ];
    }

    return $categoryTags;
}

function matchResultsWithCategoryTags($results, $categoryTags) {

    $sortedResults = array();
    foreach($results as $result) {
        $tag = $result['categoryTag'];
        if($result['categoryLanguage'] === 'en') {
            $categoryTags[$tag]['categoryTag'] = $result['categoryTag'];
            $categoryTags[$tag]['enCategoryId'] = $result['categoryId'];
            $categoryTags[$tag]['pagePosition'] = $result['pagePosition'];
            $categoryTags[$tag]['enCategoryName'] = $result['categoryName'];
            $categoryTags[$tag]['categoryType'] = $result['categoryType'];
            $categoryTags[$tag]['items'][$result['itemTag']]['vnItemId'] = $result['id'];
            $categoryTags[$tag]['items'][$result['itemTag']]['vnTitle'] = $result['title'];
            $categoryTags[$tag]['items'][$result['itemTag']]['vnDescription'] = $result['description'];
            $categoryTags[$tag]['items'][$result['itemTag']]['price'] = $result['price'];
            $categoryTags[$tag]['items'][$result['itemTag']]['categoryPosition'] = $result['categoryPosition'];
            $categoryTags[$tag]['items'][$result['itemTag']]['itemTag'] = $result['itemTag'];
        } else {
            $categoryTags[$tag]['categoryTag'] = $result['categoryTag'];
            $categoryTags[$tag]['vnCategoryId'] = $result['categoryId'];
            $categoryTags[$tag]['pagePosition'] = $result['pagePosition'];
            $categoryTags[$tag]['vnCategoryName'] = $result['categoryName'];
            $categoryTags[$tag]['categoryType'] = $result['categoryType'];
            $categoryTags[$tag]['items'][$result['itemTag']]['enItemId'] = $result['id'];
            $categoryTags[$tag]['items'][$result['itemTag']]['enTitle'] = $result['title'];
            $categoryTags[$tag]['items'][$result['itemTag']]['enDescription'] = $result['description'];
            $categoryTags[$tag]['items'][$result['itemTag']]['price'] = $result['price'];
            $categoryTags[$tag]['items'][$result['itemTag']]['categoryPosition'] = $result['categoryPosition'];
            $categoryTags[$tag]['items'][$result['itemTag']]['itemTag'] = $result['itemTag'];
        }
    }

    foreach($categoryTags as $categoryTag) {
        $sortedCategory = array();
        foreach($categoryTag['items'] as $item) {
            $sortedCategory[] = $item;
        }
        $categoryTag['items'] = $sortedCategory;
        $sortedResults[] = $categoryTag;
    }

    return $sortedResults;
}
