<?php

require_once __DIR__ . '/../../ConnectDb.php';

require_once __DIR__ . '/../../Objects/Events/AdminEventCategory.php';
require_once __DIR__ . '/../../Objects/Events/AdminEventItem.php';
require_once __DIR__ . '/../../Objects/Events/EventCategory.php';
require_once __DIR__ . '/../../Objects/Events/EventItem.php';

class EventInsertRepository
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

    public function __construct ()
    {

        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    public function insertItemDetails(AdminEventItem $item)
    {

    }

    public function insertItem(AdminEventItem $item)
    {
        $stmt = $this->mysqli->prepare(
            'INSERT INTO event_item 
            (category_id, event_start, event_end, category_position, uses_start_time, uses_end_time, uses_end_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->bind_param('issiiii', $item->categoryId, $item->start, $item->end, $item->position,
            $item->usesStartTime, $item->usesEndTime, $item->usesEndDate);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        } else {
            $result = $stmt->insert_id;
        }

        $stmt->close();

        return $result;
    }
}
