<?php

require_once __DIR__ . '/../../ConnectDb.php';

require_once __DIR__ . '/../../Objects/Events/BilingualEventCategory.php';
require_once __DIR__ . '/../../Objects/Events/BilingualEventItem.php';
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

    public function getMenuByLanguage($language)
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
