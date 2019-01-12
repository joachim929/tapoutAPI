<?php

require_once __DIR__ . '/../../Objects/Shared/Message.php';

class SortingService
{
    /**
     * This function removes array keys and returns said array
     * @param $array
     * @return array
     */
    public function removeArrayKeys($array)
    {
        $noKeysArray = array();

        foreach ($array as $item) {
            $noKeysArray[] = $item;
        }

        return $noKeysArray;
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    public function comparisonPosition($a, $b)
    {
        if ($a->position === $b->position) {
            return 0;
        }
        return ($a->position < $b->position) ? -1 : 1;
    }
}