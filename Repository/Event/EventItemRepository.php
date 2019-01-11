<?php
require_once __DIR__ . '/../../ConnectDb.php';

require_once __DIR__ . '/../../Objects/Events/EventItem.php';

class EventItemRepository extends ConnectDb
{
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
        ConnectDb::__construct();
        $this->conn = ConnectDb::getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * @todo: Not in use yet!
     * This function gets category items by id makes sure it has a later start date than the one passed if its set
     * @param int $catId
     * @param null $minDate
     * @return array|null
     */
    public function getItemsByCategoryId(int $catId, $minDate = null)
    {
        $items = array();

        if($minDate === null) {
            $minDate = 0;
        }

        $stmt = $this->mysqli->prepare(
            'SELECT * 
            FROM event_item
            WHERE category_id = ?
            AND start_date > ?
            ORDER BY category_position ASC'
        );

        $stmt->bind_param('ii', $catId, $minDate);

        $stmt->execute();

        $stmt->bind_result($id, $categoryId, $heading, $description, $language, $tag, $startTime, $endTime,
            $createdAt, $startDate, $editedAt, $categoryPosition);

        while($stmt->fetch()) {
            $items[] = new EventItem($categoryId, $heading, $description, $language, $tag, $categoryPosition, $startDate,
                $id, $createdAt, $editedAt, $startTime, $endTime);
        }

        if($stmt->errno) {
            $items = null;
        }

        $stmt->close();

        return $items;
    }
}