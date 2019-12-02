<?php

    require_once('LogWrapper.php');
    require_once('ValidateData.php');

    trait Utils
    {
        use LogWrapper;
        use ValidateData;

        public function fileExists($file)
        {
            if (!file_exists($file))
            {
                throw new Exception($file.' file does not exist');
            }
        }
    }
?>