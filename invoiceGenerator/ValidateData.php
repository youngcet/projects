<?php
    trait ValidateData
    {
        public function arrayKeysExists($array)
        {
            if(array_keys($array) == range(0, count($array) - 1))
            {
                throw new Exception('Array missing keys.');
            }
        }

        public function isArrayEmpty($array)
        {
            if (empty($array))
            {
                throw new Exception('Array is empty.');
            }
        }

        public function keyExists($array, $key)
        {
            if (array_key_exists($array[$key], $array))
            {
                throw new Exception('key is not defined.');
            }
        }
    }
?>