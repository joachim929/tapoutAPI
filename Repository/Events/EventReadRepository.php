<?php

require_once __DIR__ . '/../../ConnectDb.php';

require_once __DIR__ . '/../../Objects/Events/AdminEventCategory.php';
require_once __DIR__ . '/../../Objects/Events/AdminEventItem.php';
require_once __DIR__ . '/../../Objects/Events/EventCategory.php';
require_once __DIR__ . '/../../Objects/Events/EventItem.php';

class EventReadRepository
{

    /**
     * @var
     */
    private $connectDb;
    /**
     * @var ConnectDb|null
     */
    private $conn;
    /**
     * @var mysqli
     */
    private $mysqli;

    public function __construct()
    {

        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * This function gets an event item with a given provided itemId, if one isn't found false is returned
     * @param int $itemId
     * @return AdminEventItem|false
     */
    public function getEventItem(int $itemId)
    {
        $stmt = $this->mysqli->prepare(
            'SELECT item.category_id AS catId, item.id AS itemId, item.event_start AS start, item.event_end AS end,
            item.category_position AS catPosition, item.uses_start_time AS usesStartTime, 
            item.uses_end_time AS usesEndTime, item.uses_end_date AS usesEndDate, item.created_at AS itemCreatedAt,
            item.edited_at AS itemEditedAt, item.active AS itemActive,
            enDetails.id AS enId, enDetails.title AS enTitle, enDetails.description AS enDescripton, 
            enDetails.created_at AS enCreatedAt, enDetails.edited_at AS enEditedAt,
            vnDetails.id AS vnId, vnDetails.title AS vnTitle, vnDetails.description AS vnDescripton, 
            vnDetails.created_at AS vnCreatedAt, vnDetails.edited_at AS vnEditedAt
            FROM event_item AS item
            LEFT JOIN event_item_details AS enDetails ON item.id = enDetails.item_id AND enDetails.language = "en"
            LEFT JOIN event_item_details AS vnDetails ON item.id = vnDetails.item_id AND vnDetails.language = "vn"
            WHERE item.id = ?'
        );

        $stmt->bind_param('i', $itemId);

        $stmt->execute();

        $stmt->bind_result($catId, $itemId, $start, $end, $catPosition, $usesStartTime, $usesEndTime, $usesEndDate, $itemCreatedAt,
            $itemEditedAt, $itemActive, $enId, $enTitle, $enDescription, $enCreatedAt, $enEditedAt, $vnId, $vnTitle,
            $vnDescription, $vnCreatedAt, $vnEditedAt);

        $stmt->fetch();

        $result = new AdminEventItem(
            $catId, $catPosition, $itemId, new DateTime($itemCreatedAt), new DateTime($itemEditedAt),
            $enId, $enTitle, $enDescription, new DateTime($enCreatedAt), new DateTime($enEditedAt), $vnId,
            $vnTitle, $vnDescription, new DateTime($vnCreatedAt), new DateTime($vnEditedAt), new DateTime($start),
            new DateTime($end), $usesStartTime, $usesEndTime, $usesEndDate, $itemActive
        );

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function gets an event category with a given provided categoryId, if one isn't found false is returned
     * @param int $categoryId
     * @return AdminEventCategory|false
     */
    public function getEventCategory(int $categoryId)
    {

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName,
            cat.type AS catType, cat.page_position AS pagePosition, cat.active AS catActive, cat.created_at AS catCreatedAt, 
            cat.edited_at AS catEditedAt
            FROM event_category AS cat
            WHERE cat.id = ?'
        );
        $stmt->bind_param('i', $categoryId);

        $stmt->execute();

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition, $catActive, $catCreatedAt,
            $catEditedAt);

        $stmt->fetch();

        $result = new AdminEventCategory(
            $catId, $catEnName, $catVnName, $catType, $pagePosition,
            new DateTime($catCreatedAt), new DateTime($catEditedAt), $catActive
        );



        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function gets all event categories and items, if none are found it returns false
     * @return array|false
     */
    public function getAllEvents()
    {
        $results = [];

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName,
            cat.type AS catType, cat.page_position AS pagePosition, cat.active AS catActive, cat.created_at AS catCreatedAt, 
            cat.edited_at AS catEditedAt, item.id AS itemId, item.event_start AS start, item.event_end AS end,
            item.category_position AS catPosition, item.uses_start_time AS usesStartTime, 
            item.uses_end_time AS usesEndTime, item.uses_end_date AS usesEndDate, item.created_at AS itemCreatedAt,
            item.edited_at AS itemEditedAt, item.active AS itemActive,
            enDetails.id AS enId, enDetails.title AS enTitle, enDetails.description AS enDescripton, 
            enDetails.created_at AS enCreatedAt, enDetails.edited_at AS enEditedAt,
            vnDetails.id AS vnId, vnDetails.title AS vnTitle, vnDetails.description AS vnDescripton, 
            vnDetails.created_at AS vnCreatedAt, vnDetails.edited_at AS vnEditedAt
            FROM event_category AS cat
            LEFT JOIN event_item AS item ON cat.id = item.category_id
            LEFT JOIN event_item_details AS enDetails ON item.id = enDetails.item_id AND enDetails.language = "en"
            LEFT JOIN event_item_details AS vnDetails ON item.id = vnDetails.item_id AND vnDetails.language = "vn"
            ORDER BY pagePosition, catPosition'
        );

        $stmt->execute();

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition, $catActive, $catCreatedAt,
            $catEditedAt, $itemId, $start, $end, $catPosition, $usesStartTime, $usesEndTime, $usesEndDate, $itemCreatedAt,
            $itemEditedAt, $itemActive, $enId, $enTitle, $enDescription, $enCreatedAt, $enEditedAt, $vnId, $vnTitle,
            $vnDescription, $vnCreatedAt, $vnEditedAt);

        while ($stmt->fetch()) {
            $item = new AdminEventItem(
                $catId, $catPosition, $itemId, new DateTime($itemCreatedAt), new DateTime($itemEditedAt),
                $enId, $enTitle, $enDescription, new DateTime($enCreatedAt), new DateTime($enEditedAt), $vnId,
                $vnTitle, $vnDescription, new DateTime($vnCreatedAt), new DateTime($vnEditedAt), new DateTime($start),
                new DateTime($end), $usesStartTime, $usesEndTime, $usesEndDate, $itemActive
            );

            if (!isset($results[$catId])) {
                $results[$catId] = new AdminEventCategory(
                    $catId, $catEnName, $catVnName, $catType, $pagePosition,
                    new DateTime($catCreatedAt), new DateTime($catEditedAt), $catActive
                );
            }
            $results[$catId]->addItem($item);
        }

        if ($stmt->errno) {
            $results = false;
        }

        $stmt->close();

        return $results;
    }

    /**
     * This function gets all event categories and items with a given language where the category and items are active
     * If none are found false will be returned
     * @param $language
     * @return array|false
     */
    public function getEventsByLanguage($language)
    {
        $results = [];

        $stmt = $this->mysqli->prepare(
            'SELECT cat.id AS catId, cat.en_name AS catEnName, cat.vn_name AS catVnName,
            cat.type AS catType, cat.page_position AS pagePosition,
            item.id AS itemId, item.event_start AS start, item.event_end AS end, item.uses_start_time, item.uses_end_time, 
            item.uses_end_date, item.category_position AS catPosition,
            detail.id AS detailId, detail.title AS detailTitle, detail.description AS detailDescription
            FROM event_category AS cat
            LEFT JOIN event_item AS item ON cat.id = item.category_id
            LEFT JOIN event_item_details AS detail ON item.id = detail.item_id
            AND detail.language = ?
            WHERE cat.active = 1
            AND item.active = 1
            ORDER BY pagePosition, catPosition'
        );

        $stmt->bind_param('s', $language);

        $stmt->execute();

        $stmt->bind_result($catId, $catEnName, $catVnName, $catType, $pagePosition,
            $itemId, $start, $end, $usesStartTime, $usesEndTime, $usesEndDate, $catPosition,
            $detailId, $detailTitle, $detailDescription);

        while ($stmt->fetch()) {
            $results[] = [
                'categoryId' => $catId,
                'categoryEnName' => $catEnName,
                'categoryVnName' => $catVnName,
                'categoryType' => $catType,
                'pagePosition' => $pagePosition,
                'itemId' => $itemId,
                'start' => new DateTime($start),
                'end' => new DateTime($end),
                'usesStartTime' => $usesStartTime,
                'usesEndTime' => $usesEndTime,
                'usesEndDate' => $usesEndDate,
                'categoryPosition' => $catPosition,
                'detailId' => $detailId,
                'title' => $detailTitle,
                'description' => $detailDescription
            ];
        }

        if ($stmt->errno) {
            $results = false;
        }

        $stmt->close();

        return $results;
    }
}
