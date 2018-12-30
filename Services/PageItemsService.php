<?php

require_once '../ConnectDb.php';

require_once '../Repository/PageItemRepository.php';

require_once '../Objects/PageItem.php';
require_once '../Objects/PageImage.php';
require_once '../Objects/BilingualItem.php';
require_once '../Objects/BilingualImage.php';

class PageItemsService extends ConnectDb
{
    /**
     * @var ConnectDb|null
     */
    private $conn;

    /**
     * @var mysqli
     */
    private $mysqli;

    private $pageItemRepo;

    function __construct()
    {
        ConnectDb::__construct();
        $this->conn = ConnectDb::getInstance();
        $this->mysqli = $this->conn->getConnection();
        $this->pageItemRepo = new PageItemRepository();
    }

    public function reorderPagePositions(int $pageId)
    {
        $pageItems = $this->matchPageItemsByTag($this->pageItemRepo->getPageItemsByPage($pageId));
        $pageImages = $this->matchPageImagesByTag($this->pageItemRepo->getPageImagesByPage($pageId));
        $mergedItems =  $this->sortResults($pageItems, $pageImages);
        return $this->checkPagePositions($mergedItems);
    }

    /**
     * This function merges page items and page images and sorts them by page position
     * @param $pageItems
     * @param $pageImages
     * @return array
     */
    public function sortResults($pageItems, $pageImages)
    {
        $sortedResults = $pageItems;
        foreach ($pageImages as $pageImage) {
            $sortedResults[] = $pageImage;
        }
        usort($sortedResults, array('PageItemsService', 'comparisonPagePosition'));

        return $sortedResults;
    }

    /**
     * @param array() $mergedItems
     * @return mixed
     */
    private function checkPagePositions($mergedItems)
    {
        $i = 1;
        foreach ($mergedItems as $key => $item) {

            if($item->getPagePosition() !== $i) {
                $item->setPagePosition($i);
                if(get_class($item) === 'BilingualItem'){

                    $this->pageItemRepo->updateItemPagePosition($item->getEnItemId(),
                        $i, $item->getPageId());
                    $this->pageItemRepo->updateItemPagePosition($item->getVnItemId(),
                        $i, $item->getPageId());
                }
                else {
                    $this->pageItemRepo->updateImagePagePosition($item->getEnImageId(),
                        $i, $item->getPageId());
                    $this->pageItemRepo->updateImagePagePosition($item->getVnImageId(),
                        $i, $item->getPageId());
                }
            }
            $i++;
        }

        return $mergedItems;
    }

    /**
     * This function loops through page items and creates an array of bilingual items which it then returns
     * @param PageItem[] $pageItems
     * @return array
     */
    private function matchPageItemsByTag(array $pageItems)
    {
        $sortedItems = array();

        foreach ($pageItems as $pageItem) {
            if (isset($sortedItems[$pageItem->getTag()])) {
                $sortedItems[$pageItem->getTag()] = $this->setPageItem($pageItem, $sortedItems[$pageItem->getTag()]);
            } else {
                $sortedItems[$pageItem->getTag()] = $this->setPageItem($pageItem);
            }
        }

        return $this->removeArrayKeys($sortedItems);
    }

    /**
     * This function sets BilingualItem variables
     * @param PageItem $pageItem
     * @param BilingualItem|null $sortedItem
     * @return BilingualItem
     */
    private function setPageItem(PageItem $pageItem, BilingualItem $sortedItem = null)
    {
        if($sortedItem === null) {
            $sortedItem = new BilingualItem();
            $sortedItem->setPageId($pageItem->getPageId());
            $sortedItem->setTag($pageItem->getTag());
            $sortedItem->setPagePosition($pageItem->getPagePosition());
            $sortedItem->setCreatedAt($pageItem->getCreatedAt());
            $sortedItem->setEditedAt($pageItem->getEditedAt());
        }
        if($pageItem->getLanguage() === 'en') {
            $sortedItem->setEnItemId($pageItem->getId());
            $sortedItem->setEnHeading($pageItem->getHeading());
            $sortedItem->setEnContent($pageItem->getContent());
        } else {
            $sortedItem->setVnItemId($pageItem->getId());
            $sortedItem->setVnHeading($pageItem->getHeading());
            $sortedItem->setVnContent($pageItem->getContent());
        }

        return $sortedItem;
    }


    /**
     * This function loops through page images and creates an array of bilingual images which it then returns
     * @param array $pageImages
     * @return array
     */
    public function matchPageImagesByTag(array $pageImages)
    {
        $sortedImages = array();

        foreach ($pageImages as $pageImage) {
            if (isset($sortedImages[$pageImage->getTag()])) {
                $sortedImages[$pageImage->getTag()] = $this->setPageImage($pageImage, $sortedImages[$pageImage->getTag()]);
            } else {
                $sortedImages[$pageImage->getTag()] = $this->setPageImage($pageImage);
            }
        }

        return $this->removeArrayKeys($sortedImages);
    }

    /**
     * This function sets BilingualImage variables
     * @param PageImage $pageImage
     * @param BilingualImage|null $sortedImage
     * @return BilingualImage
     */
    private function setPageImage(PageImage $pageImage, BilingualImage $sortedImage = null)
    {
        if($sortedImage === null) {
            $sortedImage = new BilingualImage();
            $sortedImage->setPageId($pageImage->getPageId());
            $sortedImage->setPagePosition($pageImage->getPagePosition());
            $sortedImage->setImgUrl($pageImage->getImgUrl());
            $sortedImage->setHeight($pageImage->getHeight());
            $sortedImage->setWidth($pageImage->getWidth());
            $sortedImage->setTag($pageImage->getTag());
            $sortedImage->setCreatedAt($pageImage->getCreatedAt());
        }
        if($pageImage->getLanguage() === 'en') {
            $sortedImage->setEnImageId($pageImage->getId());
            $sortedImage->setEnCaption($pageImage->getCaption());
            $sortedImage->setEnAlt($pageImage->getAlt());
        } else {
            $sortedImage->setVnImageId($pageImage->getId());
            $sortedImage->setVnCaption($pageImage->getCaption());
            $sortedImage->setVnAlt($pageImage->getAlt());
        }

        return $sortedImage;
    }

    /**
     * This function removes array keys and returns said array
     * @param $array
     * @return array
     */
    private function removeArrayKeys($array)
    {
        $noKeysArray = array();

        foreach ($array as $item) {
            $noKeysArray[] = $item;
        }

        return $noKeysArray;
    }

    /**
     * @param BilingualImage|BilingualItem $a
     * @param BilingualImage|BilingualItem $b
     * @return int
     */
    private function comparisonPagePosition($a, $b)
    {
        if ($a->getPagePosition() === $b->getPagePosition()) {
            return 0;
        }
        return ($a->getPagePosition() < $b->getPagePosition()) ? -1 : 1;
    }
}