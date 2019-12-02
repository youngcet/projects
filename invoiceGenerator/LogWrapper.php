<?php
    trait LogWrapper
    {
        public function __construct()
        {
            error_log('The log has been initiated...', 0);
        }

        protected function logEvent($logName, $event)
        {
            if (!file_exists($logName)) mkdir(dirname($logName), 0777, true);

            $event = $event.PHP_EOL;
            error_log(date('d/m/Y H:m:s') . ' '. $event, 3, $logName);
        }
    }
?>