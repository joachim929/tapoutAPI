<?php

require_once './ConnectDb.php';

checkParams();

function checkParams()
{
    $result = null;
    if (isset($_GET['lang']) && !isset($_GET['task'])) {
        if (isset($_GET['page'])) {
            $result = getPageCase();
        }
    }
    returnStatement($result);
}

function getPageCase()
{
    $pageId = getPageId();
    $result[] = getPageData($pageId);
    $result[] = getPageImages($pageId);
    return $result;
}

/**
 * This function gets all image URLS with a given page_id
 * @param $pageId
 * @return array
 */
function getPageImages($pageId) {
    $conn = ConnectDb::getInstance();
    $mysqli = $conn->getConnection();

    $stmt = $mysqli->prepare('SELECT * FROM tapout_image WHERE page_id = ?');

    $stmt->bind_param('i', $pageId);

    $stmt->execute();

    $stmt->bind_result($id, $pageId, $imgUrl, $createdAt, $pagePosition);

    while($stmt->fetch()) {
        $results[] = [
            'id' => $id,
            'pageId' => $pageId,
            'imgUrl' => $imgUrl,
            'createdAt' => $createdAt,
            'pagePosition' => $pagePosition
        ];
    }

    return $results;
}

/**
 * This function finds a page id with a given page name
 * @return int|null
 */
function getPageId()
{
    $conn = ConnectDb::getInstance();
    $mysqli = $conn->getConnection();

    $page = $_GET['page'];

    $stmt = $mysqli->prepare('SELECT id FROM tapout_page WHERE name = ?');

    $stmt->bind_param('s', $page);

    $stmt->execute();

    $stmt->bind_result($pageId);

    $stmt->fetch();

    $stmt->close();

    return $pageId;
}

/**
 * This function gets data for a page using language and pageId as conditionals
 * @param $pageId
 * @return array
 */
function getPageData($pageId)
{
    $conn = ConnectDb::getInstance();
    $mysqli = $conn->getConnection();

    $results = array();
    $language = $_GET['lang'];

    $stmt = $mysqli->prepare('SELECT id, page_id, heading, content, created_at, edited_at, page_position 
        FROM tapout_page_item 
        WHERE language = ? 
        AND page_id = ?
        ORDER BY page_position ASC');

    $stmt->bind_param('si', $language, $pageId);

    $stmt->execute();

    $stmt->bind_result($id, $pageId, $heading, $content, $createdAt, $editedAt, $pagePosition);

    while ($stmt->fetch()) {
        $results[] = [
            'id' => $id,
            'pageId' => $pageId,
            'heading' => $heading,
            'content' => $content,
            'createdAt' => $createdAt,
            'editedAt' => $editedAt,
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


