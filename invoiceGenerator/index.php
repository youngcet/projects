<?php
    require_once('sessions.php');
    require_once('Utils.php');
    
    $timeUtils = new Utils;
    
    // when send message button is clicked
    if (isset($_POST['sendMsg']))
    {
        $msg = strip_tags(trim($_POST['msg'])); // we not gonna do anything with this for this demostration
        
        $sql_select = "SELECT account_number FROM gn_invoice_dashboard WHERE account_number = '".ACCOUNT_NUMBER."'";
        $sql = $execute->execute($sql_select);
        
        // if account number does not exist, insert else update
        if ($sql['results'] == "0")
        {
            // check if the day is after the 20th of the month
            if ($timeUtils->getCurrentDay() >= 20)
            {
                $execute->execute("INSERT INTO gn_invoice_dashboard (account_number, ".$timeUtils->getNextMonth().",totalMsgSent) VALUES ('".ACCOUNT_NUMBER."', 1, 1)");
            }
            else
            {
                $execute->execute("INSERT INTO gn_invoice_dashboard (account_number, ".$timeUtils->getMonth().",totalMsgSent) VALUES ('".ACCOUNT_NUMBER."', 1, 1)");
            }
            
        }
        else
        {
            if ($timeUtils->getCurrentDay() >= 20)
            {
                $execute->execute("UPDATE gn_invoice_dashboard SET totalMsgSent = totalMsgSent + 1, ".$timeUtils->getNextMonth()." = ".$timeUtils->getNextMonth()." + 1 WHERE account_number = '".ACCOUNT_NUMBER."'");
            }
            else
            {
                $execute->execute("UPDATE gn_invoice_dashboard SET totalMsgSent = totalMsgSent + 1, ".$timeUtils->getMonth()." = ".$timeUtils->getMonth()." + 1 WHERE account_number = '".ACCOUNT_NUMBER."'");
            }
        }
        
        header ('Location: index.php');
        die();
    }
?>
<!DOCTYPE html>
<html>
<title>Generate Invoice</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
</style>
<body class="w3-content" style="max-width:1200px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <h3 class="w3-wide"><b>Generate Invoice</b></h3>
  </div>
  <a href="?invoices" class="w3-bar-item w3-button w3-padding">My Invoices</a><br/><br/> 
  <a href="login.php?logout" class="w3-bar-item w3-button w3-padding">Log Out</a> 
</nav>

<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <!-- Top header -->
  <header class="w3-container w3-xlarge">
    <p class="w3-left">Services</p>
    <p class="w3-right">
        <?php
            $selct_balance = $execute->execute("SELECT ".$timeUtils->getMonth()." FROM gn_invoice_dashboard WHERE account_number = ".ACCOUNT_NUMBER." AND ".$timeUtils->getMonth()." = ".$timeUtils->getMonth());
            $balance_due = $selct_balance['results'][0][$timeUtils->getMonth()] * 0.40;
            
            echo "R$balance_due";
        ?>
    </p>
  </header>

  <form action="" method="post">
  <div class="w3-container w3-padding-32">
    <p>Assuming that each time you send a message, it costs R0.40:</p>
    <p><input class="w3-input w3-border" type="text" placeholder="Enter message" style="width:100%" name="msg" required></p>
    <input type="submit" class="w3-button w3-red w3-margin-bottom" value="SEND MESSAGE" name="sendMsg">
  </div>
  </form>
  
  <?php 
    if (isset($_GET['invoices']))
    {?>
        <table class="task-table">
			   <?php
			        $invoices = glob(INVOICES_DIR."*");
                    
                    if (sizeof($invoices) > 0)
                    {
                        echo '<tr>
                            <td colspan="2"></td>
                            </tr>';
                        echo '<tr>
                            <th>Date</th>
                            <th></th>
                            </tr>';
                        foreach ($invoices as $invoice)
                        {
                            $file_extension = pathinfo($invoice);
                            $name = basename($invoice);
                            
                            if ($file_extension['extension'] == 'pdf')
                            {
                                $name = str_replace('.pdf', '', $name);
                                echo "<tr>";
                                echo "<td>$name</td>";
                                echo "<td style='text-align:right'><a href='?view=$name' target='_blank'>view</a></td>";
                                echo "</tr>";
                            }
                            else
                            {
                                $name = str_replace('.html', '', $name);
                                echo "<tr>";
                                echo "<td>$name</td>";
                                echo "<td style='text-align:right'><a href='?view=$name'>view</a></td>";
                                echo "</tr>";
                            }
                            
                        }
                        
                    }
                    else
                    {
                        echo "<tr>";
                        echo "<td>There are no invoices to display at this time. </td>";
                        echo "<td style='text-align:right'></td>";
                        echo "</tr>";
                    }
			   ?>
			   </table>
    <?php } ?>
</div>

<script>
// Accordion 
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

// Click on the "Jeans" link on page load to open the accordion for demo purposes
document.getElementById("myBtn").click();


// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>
