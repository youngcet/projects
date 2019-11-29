<?php

    # this class will be used to handle all the HTML substitutions
    class HTMLTemplateBuilder
    {
        private $_data;
        
        public function __construct($data)
        {
            $this->_data = $data;

            try
            {
                # validate the data recieved
                # ensure that it meets all the requirements
                $this->validateData();
            }
            catch (Exception $e)
            {
                # if an exception is thrown, die
                die('Caught exception: '.  $e->getMessage()); 
            }
        }
        
        public function substituteTemplate()
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

        public function validateData()
        {
            # check that array is an associative array
            if(array_keys($this->_data) == range(0, count($this->_data) - 1))
            {
                throw new Exception('Array missing keys.');
            }
            
            # check that data is not empty
            if (empty($this->_data))
            {
                throw new Exception('Data cannot be empty.');
            }

            # check that the actual template exists
            if (!file_exists($this->_data['INVOICE_TEMPLATE']))
            {
                throw new Exception($this->_data['INVOICE_TEMPLATE'] .'does not exist');
            }

            # check that the key TEMPLATE exists
            if (array_key_exists($this->_data['INVOICE_TEMPLATE'], $this->_data))
            {
                throw new Exception('template is not defined.');
            }
        }
    }

    # this is dummy data
    # this data will be coming from a database
    $data = array('INVOICE_TEMPLATE' => 'invoice.html', 'BILL_TO_DETAILS' => 'Cedric Maenetja<br/>Address', 
                    'ACCOUNT_NUMBER' => '0000000', 'INVOICE_DATE' => '29/11/2019', 'INVOICE_DUE_DATE' => '29/11/2019',
                    'QUANTITY' => 1, 'QUNITPRICE' => 'R0.50', 'LINEAMOUNT' => 'R0.50', 'UNIT_SUB_TOTAL' => 'R0.50', 'UNIT_TOTAL' => 'R0.50',
                    'BILL_FROM' => 'Mr XX', 'ADDRESS_DETAILS' => '000 000 0000<br/>username@somedomain.co.za');
    
    # initialze the class
    $htmlBuilder = new HTMLTemplateBuilder($data);

    # get the substituted data.
    $substitutedHTML = $htmlBuilder->substituteTemplate();
    echo $substitutedHTML;
?>
