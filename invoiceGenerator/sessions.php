<?php
session_start();

if (!isset($_SESSION['UUID']))
{
    header("Location: login.php?signin");
    die();
}

?>