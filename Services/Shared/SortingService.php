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

    /**
     * This function makes sure that a value is set and a string, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool
     */
    public function checkString(string $type, $value): bool
    {
        $check = true;
        if (!isset($value)) {
            $check = "No value for $type given";
        } elseif (!is_string($value)) {
            $check = "No valid value given for $value";
        }

        return $check;
    }

    /**
     * This function makes sure that a value is set and an int, if it isn't it creates an error message
     * @param string $type
     * @param        $value
     * @return bool|string
     */
    public function checkNumber(string $type, $value)
    {
        $check = true;
        if (!isset($value)) {
            $check = "No value for $type given";
        } elseif (!is_int($value)) {
            $check = "No valid value type given for $value";
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
    public function checkDescriptions(string $enDescription = null, string $vnDescription = null)
    {
        $check = true;
        if (isset($enDescription, $vnDescription)) {
            if (!(is_string($enDescription) && is_string($vnDescription))) {
                $check = 'English and Vietnamese descriptions need to be strings';
            } else {
                if (strlen($enDescription) < 4) {
                    $check = 'English description is too short';
                }
                if (strlen($vnDescription) < 4) {
                    $check = 'Vietnamese description is too short';
                }
            }
        } elseif (!isset($enDescription) && isset($vnDescription)) {
            $check = 'Only got a value for Vietnamese description, not English description';
        } elseif (!isset($vnDescription) && isset($enDescription)) {
            $check =  'Only got a value for English description, not Vietnamese description';
        }

        return $check;
    }

    /**
     * This function checks menu category type
     * @param string|null $type
     * @return bool|string
     */
    public function checkMenuCategoryType(string $type = null) {
        $check = true;

        if (isset($type)) {
            if (is_string($type)) {
                if($type !== 'food' && $type !== 'drink') {
                    $check = 'Invalid value given for category type';
                }
            } else {
                $check = 'Category type isn\'t a string variable';
            }
        } else {
            $check = 'Category type wasn\'t set';
        }

        return $check;
    }
}