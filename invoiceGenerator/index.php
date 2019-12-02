<?php
    require_once('HTMLTemplateBuilder.php');
    require_once('SendMail.php');
    
    $data = array('INVOICE_TEMPLATE' => 'invoice.html', 'BILL_TO_DETAILS' => 'Cedric Maenetja<br/>Address', 
    'ACCOUNT_NUMBER' => '0000000', 'INVOICE_DATE' => '29/11/2019', 'INVOICE_DUE_DATE' => '29/11/2019',
    'QUANTITY' => 1, 'QUNITPRICE' => 'R0.50', 'LINEAMOUNT' => 'R0.50', 'UNIT_SUB_TOTAL' => 'R0.50', 'UNIT_TOTAL' => 'R0.50',
    'BILL_FROM' => 'Mr XX', 'ADDRESS_DETAILS' => '000 000 0000<br/>username@somedomain.co.za');

    $htmlBuilder = new HTMLTemplateBuilder($data);
    $substitutedHTML = $htmlBuilder->getSubstitutedTemplate();

    $msg = array('recipient' => 'cmaentja@gmail.com, young.cet@gmail.com', 'subject' => 'New Invoice', 'message' => $htmlBuilder->getSubstitutedTemplate(), 
    'from' => 'account@permanentlink.co.za', 'replytoName' => 'Cedric Maenetja', 'replyto' => 'account@permanentlink.co.za');
    
    new SendMail($msg);

    echo $substitutedHTML;
?>