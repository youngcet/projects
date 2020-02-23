<?php
session_start();

include ("/home/permawer/public_html/var/local/api/ExecuteQuery.php");

if (!isset($_SESSION['UUID']))
{
    header("Location: login.php?signin");
    die();
}

$execute = new ExecuteQuery();

$uuid = $_SESSION['UUID'];

$select = "SELECT * FROM gn_invoice_accounts WHERE uuid = '$uuid'";
$account = $execute->execute($select);

define('ACCOUNT_NUMBER', $account['results'][0]['account_number']);
define('CUSTOMER_NAME', $account['results'][0]['fullname']);
define('CUSTOMER_EMAIL', $account['results'][0]['emailaddress']);
define('ACCOUNT_TYPE', $account['results'][0]['account_type']);
define('CONTACT_NUMBER', $account['results'][0]['contact_number']);
define('CUSTOMER_ADDRESS', $account['results'][0]['address']);
define('TRIAL_END_DATE', $account['results'][0]['trial_end_date']);

define("INVOICES_DIR", "invoices/".ACCOUNT_NUMBER."/");

?>
