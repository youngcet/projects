<?php

    require_once('LogWrapper.php');
    require_once('ValidateData.php');
    require_once('TimeUtils.php');

    class Utils
    {
        use LogWrapper;
        use ValidateData;
        use TimeUtils;

        public function fileExists($file)
        {
            if (!file_exists($file))
            {
                throw new Exception($file.' file does not exist');
            }
        }
        
        public function getEncryptedPassword($pwd)
        {
            return md5($pwd);
        }
    }
?>