<?php
    
    trait GeneratePage
    {
        public function render($html_page, $data)
        {
    		// perform some checks
    		if (!file_exists($html_page)) throw new Exception("$html_page does not exists.");
    		if (array_keys($data) == range(0, count($data) - 1)) throw new Exception("Array needs to be a key value pair");
    
            # convert the file contents to string
            $htmlTemplate = file_get_contents($html_page);
    
            foreach ($data as $key => $value)
                {
                    $htmlTemplate = str_replace($key, $value, $htmlTemplate);
                }
    
            # return the substituted string
            return $htmlTemplate;
        }
    }
?>