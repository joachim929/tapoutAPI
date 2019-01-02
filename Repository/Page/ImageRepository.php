<?php
require_once __DIR__ . '/../../ConnectDb.php';

require_once __DIR__ . '/../../Objects/Image/ImageList.php';

class ImageRepository
{
    /**
     * @var ConnectDb
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    private $connectDb;

    function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();
    }

    /**
     * @return array|null
     */
    public function getImageList()
    {
        $imageList = array();

        $stmt = $this->mysqli->prepare(
            'SELECT id, imgUrl, created_at
            FROM image_list
            WHERE active = 1'
        );

        $stmt->execute();

        $stmt->bind_result($id, $imgUrl, $createdAt);

        while($stmt->fetch()) {
            $imageList[] = new ImageList($id, $imgUrl, $createdAt);
        }

        if($stmt->errno) {
            $imageList = null;
        }

        $stmt->close();

        return $imageList;
    }
}