<?php 
    class FileParser
    {
        public function readTextFile($file)
        {
            $myfile = fopen($file, "r") or die("Unable to open the file [$file]");
            
            $recipients = array();
            //$record = array();
            while(!feof($myfile)) 
            {
                //$recipients[] = fgets($myfile);
                $recipients[] = explode (",", fgets($myfile));  
            }

            fclose($myfile);

            //return implode(",", $recipients);
            return $recipients;
        }
        
        public function readCSVFile($file)
        {
            $myfile = fopen($file, "r") or die("Unable to open the file [$file]");
            
            $recipients = array();
            //$record = array();
            while(!feof($myfile)) 
            {
                $recipients[] = fgetcsv($myfile);  
            }

            fclose($myfile);

            //return implode(",", $recipients);
            return $recipients;
        }

        public function createJSONFile($file, $text)
        {
            $fp = fopen($file, 'w');
            fwrite($fp, json_encode($text));
            fclose($fp);
        }
        
        public function createNewFile($file, $text)
        {
            $fp = fopen($file, 'w');
            fwrite($fp, $text);
            
            fclose($fp);
        }
        
        public function deleteFiles($files)
        {
            // check if its directory
            if (is_dir($files))
            {
                // remove the files
                array_map('unlink', array_filter( 
                 (array) array_merge(glob($files."/*")))); 
            
                rmdir($files); // remove the directory
            }
            elseif (is_array($files))
            {
                foreach ($files as $file)
                {
                    if (file_exists($file))
                    {
                        unlink($file);
                    }
                }
            }
            else
            {
                if (file_exists($files))
                {
                    unlink($files);
                }
            }
            
        }
        
        public function createCSVFilefromScheduledTask($filename, $data)
        {
            $file = fopen($filename,"w");
            
            foreach ($data as $line)
            {
                fputcsv($file,explode(',',$line));
            }
            
            fclose($file);
        }
        
    }
?>