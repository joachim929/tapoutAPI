<?php

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

    /**
     * This function makes sure that a value is set and a string, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool
     */
    public function checkString(?string $value) : bool
    {

        $check = true;
        if (!isset($value)) {
            $check = false;
        } elseif (!is_string($value)) {
            $check = false;
        }

        return $check;
    }

    /**
     * This function makes sure that a value is set and an int, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool|string
     */
    public function checkNumber(?int $value)
    {

        $check = true;
        if (!isset($value)) {
            $check = false;
        } elseif (!is_int($value)) {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks that the type of english/vietnamese descriptions match, if its a string it needs to
     * be >= 4 in length, creates error messages describing what went wrong if anything did go wrong
     * @param string|null $enDescription
     * @param string|null $vnDescription
     * @return bool|string
     */
    public function checkDescriptions(?string $enDescription, ?string $vnDescription)
    {

        $check = true;
        if (isset($enDescription, $vnDescription)) {
            if (!(is_string($enDescription) && is_string($vnDescription))) {
                $check = false;
            } else {
                if (strlen($enDescription) < 4) {
                    $check = false;
                }
                if (strlen($vnDescription) < 4) {
                    $check = false;
                }
            }
        } elseif (!isset($enDescription) && isset($vnDescription)) {
            $check = false;
        } elseif (!isset($vnDescription) && isset($enDescription)) {
            $check = false;
        }

        return $check;
    }

    /**
     * This function checks menu category type
     * @param string|null $type
     * @return bool|string
     */
    public function checkMenuCategoryType(?string $type)
    {

        $check = true;

        if (isset($type)) {
            if (is_string($type)) {
                if ($type !== 'food' && $type !== 'drink') {
                    $check = false;
                }
            } else {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    public function checkPage(?string $page): bool
    {
        $check = true;

        if (isset($page) && is_string($page)) {
            if(!($page !== 'Home' || $page === 'Menu' || $page === 'Gallery' ||
                $page === 'Events' || $page === 'Contact' ||
                $page === 'About' || $page === 'Delivery') ){
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }

    public function checkForAdminModule(?string $module): bool
    {
        $check = false;
        if (isset($module) && is_string($module) && $module === 'Admin') {
            $check = true;
        }

        return $check;
    }

    public function isValidTimeStamp(?string $timestamp)
    {
        $check = false;
        if (isset($timestamp)) {
            $check = ((string) (int) $timestamp === $timestamp)
                && ($timestamp <= PHP_INT_MAX)
                && ($timestamp >= ~PHP_INT_MAX);
        }
        return $check;
    }


}