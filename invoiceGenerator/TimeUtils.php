<?php
    trait TimeUtils
    {    
        public function getCurrentDateTime()
        {
            date_default_timezone_set('Africa/Johannesburg');
            return date('d F Y H:i:s', time());
        }
        
        public function getCurrentDate()
        {
            date_default_timezone_set('Africa/Johannesburg');
            return date('d F Y', time());
        }
        
        public function addDays($days)
        {
            date_default_timezone_set('Africa/Johannesburg');
            $currentDate = date('d F Y', time());
            
            return date('d F Y', strtotime($currentDate. ' + '.$days.' days'));
            
        }
        
        public function getMonth()
        {
            date_default_timezone_set('Africa/Johannesburg');
            return date('F', time());
        }
        
        public function getNextMonth()
        {
            date_default_timezone_set('Africa/Johannesburg');
            return date('F',strtotime('first day of +1 month'));
        }
        
        public function getCurrentDay()
        {
            date_default_timezone_set('Africa/Johannesburg');
            return date('d', time());
        }
        
        public function isDatePassed($date)
        {
            if (strtotime($date) < strtotime('now'))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
?>