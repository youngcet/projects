<?php
    require_once('ExecuteQuery.php');
    require_once('Utils.php');
    require_once('FileParser.php');
    require_once('SendMail.php');
    
    $execute = new ExecuteQuery;
    $timeUtils = new Utils;
    $file_parser = new FileParser;
    
    $select = "SELECT account_number, ".$timeUtils->getMonth()." FROM gn_invoice_dashboard WHERE ".$timeUtils->getMonth()." = ".$timeUtils->getMonth();
    $sql = $execute->execute($select);
    
    if ($sql['results'] == "0")
    {
        // nothing to process. exit the script
        exit('Nothing to process');
    }
    else
    {
        $index = 0;
        // there are records to process
        foreach ($sql['results'] as $record)
        {
            // select client information
            $select_client = $execute->execute("SELECT fullname, emailaddress, contact_number, address, account_type FROM gn_invoice_accounts WHERE account_type = 'business' AND account_number = ".$sql['results'][$index]['account_number']);
            
            if ($select_client['results'] == "0")
            {
                $index++;
                // if client does not exist, skip the record
                continue;
            }
            else
            {
                // set thr invoice substitution values
                $account_number = $sql['results'][$index]['account_number'];
                $client_name = $select_client['results'][0]['fullname'];
                $emailadress = $select_client['results'][0]['emailaddress'];
                $contact_number = $select_client['results'][0]['contact_number'];
                $address = $select_client['results'][0]['address'];
                $invoice_date = $timeUtils->getCurrentDate();
                $invoice_due_date = $timeUtils->addDays(10);
                $qty = $sql['results'][$index][$timeUtils->getMonth()];
                
                // if the quantity is 0, skip the record
                if ($qty == 0)
                {
                    $index++;
                    continue;    
                }
                
                $qty_unit_price = "0.40";
                $line_amount = $qty * 0.40;
                $sub_total = $line_amount;
                $total = $sub_total;
                
                // if the address is empty, set contacts and email as the bill to information
                $billto = '';
                if (!empty($address))
                {
                    $billto = $address;
                    // replace , with space <br/>
                    $billto = str_replace(',', '<br/>', $billto);
                }
                else
                {
                    $billto = $contact_number . '<br/>' . $emailadress;
                }
                
                // substitute the values
                $substitutedTemplate = str_replace("CUSTOMER_NAME", $client_name, file_get_contents('invoice.html'));
                $substitutedTemplate = str_replace("BILL_TO_DETAILS", $billto, $substitutedTemplate);
                $substitutedTemplate = str_replace("ACCOUNT_NUMBER", $account_number, $substitutedTemplate);
                $substitutedTemplate = str_replace("INVOICE_DATE", $invoice_date, $substitutedTemplate);
                $substitutedTemplate = str_replace("INVOICE_DUE_DATE", $invoice_due_date, $substitutedTemplate);
                $substitutedTemplate = str_replace("QUANTITY", $qty, $substitutedTemplate);
                $substitutedTemplate = str_replace("QUNITPRICE", 'R'.$qty_unit_price, $substitutedTemplate);
                $substitutedTemplate = str_replace("LINEAMOUNT", 'R'.number_format((float)$line_amount, 2, '.', ''), $substitutedTemplate);
                $substitutedTemplate = str_replace("UNIT_SUB_TOTAL", 'R'.number_format((float)$sub_total, 2, '.', ''), $substitutedTemplate);
                $substitutedTemplate = str_replace("UNIT_TOTAL", 'R'.number_format((float)$total, 2, '.', ''), $substitutedTemplate);
                
                // create the invoice html
                $path = 'invoices/'.$account_number.'/';
                // create the directory
                mkdir($path, 0777, true);
                $file_parser->createNewFile($path.$invoice_date.'.html', $substitutedTemplate);
                
                echo "Invoice Generated ". $invoice_date.'.html';
                
                // send an email
                $msg = array('recipient' => $emailadress, 'subject' => 'New Invoice - '.$invoice_date, 'message' => $substitutedTemplate, 
                        'from' => 'accounts@permanentlink.co.za', 'replytoName' => 'Generate Invoice', 'replyto' => 'accounts@permanentlink.co.za');
                
                new SendMail($msg);
                
            }
            
            $index++;
        }
    }
?>