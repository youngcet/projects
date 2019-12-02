<?php

    include('Utils.php');

    # this class will be used to handle all the HTML substitutions
    # extends (inherits) the Utils
    class HTMLTemplateBuilder
    {
        use Utils;

        private $_logName;
        private $_data;
        
        public function __construct($data)
        {
            $this->_data = $data;
            $this->_logName = 'logs/'. get_class($this).'.log';
            $this->prepareData();
        }
        
        public function getSubstitutedTemplate()
        {
            # convert the file contents to string
            $htmlTemplate = file_get_contents($this->_data['INVOICE_TEMPLATE']);

            # using string manipulation,
            # iterate trough the data recieved and replace key (the actual word) on the html string
            # with the value of the key in the array
            foreach ($this->_data as $key => $value)
            {
                if ($key == 'INVOICE_TEMPLATE') continue; #skip when current key is the invoice template
                $htmlTemplate = str_replace($key, $value, $htmlTemplate);
            }
            
            # return the substituted string
            return $htmlTemplate;
        }

        public function prepareData()
        {
            try
            {
                # validate the data recieved
                # ensure that it meets all the requirements
                $this->arrayKeysExists($this->_data);
                $this->isArrayEmpty($this->_data);
                $this->keyExists($this->_data, 'INVOICE_TEMPLATE');
                $this->fileExists($this->_data['INVOICE_TEMPLATE']);
            }
            catch (Exception $e)
            {
                $this->logEvent($this->_logName, 'Caught exception: '.  $e->getMessage());
                # if an exception is thrown, die
                die('Caught exception: '.  $e->getMessage()); 
            }
        }
    }
?>