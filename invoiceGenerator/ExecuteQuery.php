<?php

    include ("QueryDatabase.php");
    
    class ExecuteQuery extends QueryDatabase
    {
        public function execute($query)
        {
            return $this->executeQuery($query);
        }
    }
?>