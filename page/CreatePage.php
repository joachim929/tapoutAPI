<?php
require_once './../ConnectDb.php';

//Repos
require_once './../Repository/Page/PageItemRepository.php';
require_once './../Repository/Page/PageRepository.php';

//Objects
require_once './../Objects/Page/PageItem.php';
require_once './../Objects/Page/BilingualItem.php';

//Services
require_once './../Services/Page/PageItemsService.php';

class CreatePage
{
    /**
     * @var ConnectDb|null
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    private $connectDb;

    //Repos
    private $pageRepo;
    private $pageItemRepo;

    //Services
    private $pageItemsService;

    //Class variables
    private $page = null;
    private $task = null;

    /**
     * @var BilingualItem
     */
    private $pageItem = null;

    function __construct()
    {
        $this->connectDb = new ConnectDb();
        $this->conn = $this->connectDb->getInstance();
        $this->mysqli = $this->conn->getConnection();

        //Repos
        $this->pageRepo = new PageRepository();
        $this->pageItemRepo = new PageItemRepository();

        //Services
        $this->pageItemsService = new PageItemsService();
    }

    /**
     * This function is the entry point of the class
     */
    public function returnStatement()
    {
        $result = false;
        if ($this->checkParams()) {
            $result = $this->createPageItem();
        }
        echo json_encode($result);
    }

    /**
     * This function creates a new item tag
     * @return string
     */
    private function createNewTag()
    {
        $lastId = $this->pageItemRepo->getLastId();
        return dechex($lastId + 1);
    }

    /**
     * This function creates a new page item
     * @return BilingualItem|bool
     */
    private function createPageItem()
    {
        $check = false;
        $tag = $this->createNewTag();
        $pageId = $this->pageRepo->getPageId($this->page);

        $enItem = $this->createEnItem($tag, $pageId);
        $vnItem = $this->createVnItem($tag, $pageId);

        if($this->insertItems($enItem, $vnItem)) {
            $check = $this->pageItemsService->reorderPagePositions($pageId);
        }
        return $check;
    }

    /**
     * This function makes calls to insert individual page items and on success returns a
     * bilingual item for the front end
     * @param PageItem $enItem
     * @param PageItem $vnItem
     * @return BilingualItem|bool
     */
    private function insertItems(PageItem $enItem, PageItem $vnItem)
    {
        $result = false;
        $enCheck = $this->createItem($enItem);
        $vnCheck = $this->createItem($vnItem);
        if ($enCheck && $vnCheck) {
            $result = $this->mergeNewItems($enItem->getTag());
        } else {
            $this->pageItemRepo->deleteByTag($enItem->getTag());
        }
        if($result !== false) {
            $result = true;
        }

        return $result;
    }

    /**
     * This function merges the 2 newly created page items and returns them as a bilingual item
     * @param $tag
     * @return BilingualItem|bool
     */
    private function mergeNewItems($tag)
    {
        $result = false;
        $newEntries = $this->pageItemRepo->getItemsByTag($tag);
        if ($newEntries !== null && count($newEntries) === 2 && isset($newEntries[0]['language'])) {
            $result = new BilingualItem();
            if ($newEntries[0]['language'] === 'en') {
                $en = 0;
                $vn = 1;
            } else {
                $en = 1;
                $vn = 0;
            }
            $result->setPageId($newEntries[$en]['pageId']);
            $result->setCreatedAt($newEntries[$en]['createdAt']);
            $result->setEditedAt($newEntries[$en]['editedAt']);
            $result->setTag($newEntries[$en]['tag']);
            $result->setPagePosition($newEntries[$en]['pagePosition']);

            $result->setEnItemId($newEntries[$en]['id']);
            $result->setEnHeading($newEntries[$en]['heading']);
            $result->setEnContent($newEntries[$en]['content']);

            $result->setVnItemId($newEntries[$vn]['id']);
            $result->setVnHeading($newEntries[$vn]['heading']);
            $result->setVnContent($newEntries[$vn]['content']);
        }

        return $result;
    }

    /**
     * This function inserts a new page item with given params
     * @param PageItem $item
     * @return bool
     */
    private function createItem(PageItem $item)
    {
        $result = true;

        $stmt = $this->mysqli->prepare(
            'INSERT INTO page_item
            (page_id, heading, content, language, tag, page_position)
            VALUES
            (?, ?, ?, ?, ?, ?)'
        );

        $stmt->bind_param('issssi',
            $item->pageId,
            $item->heading,
            $item->content,
            $item->language,
            $item->tag,
            $item->pagePosition);

        $stmt->execute();

        if ($stmt->errno) {
            $result = false;
        }

        $stmt->close();

        return $result;
    }

    /**
     * This function creates an object for english page item from post params
     * @param $tag
     * @param $pageId
     * @return PageItem
     */
    private function createEnItem($tag, $pageId)
    {
        $enItem = new PageItem(
            $pageId,
            $this->pageItem->enHeading,
            $this->pageItem->enContent,
            'en',
            $tag,
            $this->pageItem->pagePosition
        );

        return $enItem;
    }

    /**
     * This function creates an object for vietnamese page item from post params
     * @param $tag
     * @param $pageId
     * @return PageItem
     */
    private function createVnItem($tag, $pageId)
    {
        $vnItem = new PageItem(
            $pageId,
            $this->pageItem->vnHeading,
            $this->pageItem->vnContent,
            'vn',
            $tag,
            $this->pageItem->pagePosition
        );

        return $vnItem;
    }

    /**
     * This function calls functions and checks all post params, and returns a boolean value on it's findings
     * @return bool
     */
    private function checkParams()
    {
        $check = true;
        if (isset($_POST, $_POST['page'], $_POST['task'], $_POST['pageItem'])) {
            if ($this->checkPage()) {
                $this->page = $_POST['page'];
            } else {
                $check = false;
            }

            if ($this->checkTask() === false || $this->checkPageItem() === false) {
                $check = false;
            }

        } else {
            $check = false;
        }
        return $check;
    }

    /**
     * This function checks a passed param is a string with length between 1 and 254
     * @param $heading
     * @return bool
     */
    private function checkHeading($heading)
    {
        $check = false;
        if ($this->checkContents($heading) && strlen($heading) < 255) {
            $check = true;
        }
        return $check;
    }

    /**
     * This function checks that passed param is a string with a string length greater than 0
     * @param $contents
     * @return bool
     */
    private function checkContents($contents)
    {
        $check = false;
        if (is_string($contents) && strlen($contents) > 0) {
            $check = true;
        }
        return $check;
    }

    /**
     * * This function checks that the post param pageItem is valid
     * @return bool
     */
    private function checkPageItem()
    {
        $check = true;
        $this->pageItem = json_decode($_POST['pageItem']);
        if ($this->checkPageItemIsSet($this->pageItem)) {
            if ($this->controlHeading() === false) {
                $check = false;
            }
            if ($this->controlContents() === false) {
                $check = false;
            }

            if ($this->controlPagePosition() === false) {
                $check = false;
            }
        } else {
            $check = false;
        }
        return $check;
    }

    /**
     * This function checks that the post param page position is a number and greater than 0
     * @return bool
     */
    private function controlPagePosition()
    {
        return is_int($this->pageItem->pagePosition) && $this->pageItem->pagePosition > 0;
    }

    /**
     * @return bool
     */
    private function controlContents()
    {
        return $this->checkContents($this->pageItem->enContent) && $this->checkContents($this->pageItem->vnContent);
    }

    /**
     * @return bool
     */
    private function controlHeading()
    {
        return $this->checkHeading($this->pageItem->enHeading) && $this->checkHeading($this->pageItem->vnHeading);
    }

    /**
     * This function loops through the page item and checks all variables are set
     * @param $pageItem
     * @return bool
     */
    private function checkPageItemIsSet($pageItem)
    {
        $check = true;
        foreach ($pageItem as $value) {
            if (!isset($value) || $value === null || $value === '' || $value === 0 || $value === '0') {
                $check = false;
            }
        }
        return $check;
    }

    /**
     * This function checks that the post param task is valid
     * @return bool
     */
    private function checkTask()
    {
        return $_POST['task'] === 'createPageItem';
    }

    /**
     * This function checks that the post param page is valid
     * @return bool
     */
    private function checkPage()
    {
        return
            $_POST['page'] === 'About' ||
            $_POST['page'] === 'Home' ||
            $_POST['page'] === 'Contact' ||
            $_POST['page'] === 'Gallery';
    }
}