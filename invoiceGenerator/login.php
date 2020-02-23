<?php
    session_start();
    include ("ExecuteQuery.php");
    require_once('Utils.php');
    require_once('SendMail.php');
    
    $executeSQl = new ExecuteQuery;
    $utils = new Utils;
    
    $error = '';
    
    // register
    if (isset($_POST['register']))
    {
        $uuid = bin2hex(openssl_random_pseudo_bytes(16));
        $name = strip_tags(trim($_POST['name']));
        $email = strip_tags(trim($_POST['email']));
        $contactNumber = strip_tags(trim($_POST['contact-number']));
        $pwd = strip_tags(trim($_POST['password']));
        $account_number = rand(1111111, 9999999);
        $account_type = 'Trial';
        $address = strip_tags(trim($_POST['address']));
        $trial_end_date = $utils->addDays(30);
        
        $name = explode(' ',trim($name));
        
        // check that there is a lastname
        if (empty($name[1]))
        {
            $error = 'You need to fill in your name and last names';
        }
        else
        {
            //encode the password
            $pwd = $utils->getEncryptedPassword($pwd);
            
            // check that the user cell or email does not exist
            $select = "SELECT * FROM gn_invoice_accounts WHERE contact_number = '$contactNumber' OR emailaddress = '$email'";
            $userExists = $executeSQl->execute($select);
            
            if ($userExists['results'] != "0")
            {
                //record exists
                $error = "The email or contact number already exists. Please sign in or choose a different email or number.";
            }
            else
            {
                $fullname = $name[0].' '.$name[1];
                // record does not exist
                $query = "INSERT INTO gn_invoice_accounts (uuid, fullname, emailaddress, pwd, contact_number, account_type, account_number, address, trial_end_date) VALUES ('$uuid', '$fullname', '$email', '$pwd', '$contactNumber', '$account_type', '$account_number', '$address', '$trial_end_date')";
                
                if ($executeSQl->execute($query)['results'])
                {
                    $text = '<p>Thank you for signing up for a Trial Account.</p>
                            <p><b>Your Account Information</b></p>
                            <table class="account-table" width="100%">
                            	<tr style="background:#428bca;color:white">
                            		<th>Email</th>
                            		<th>Account Type</th>
                            		<th>Your Offer</th>
                            		<th>Payment</th>
                            	</tr>
                            <tr>
                            		<td>'.$email.'</td>
                            		<td>'.$account_type.'</td>
                            		<td>Free 30 days trial (ends '.$trial_end_date.')</td>
                            		<td>PAID</td>
                            	</tr>
                            </table>
                            <p>Should you have any queries or require additional assistance, please email accounts@permanentlink.co.za or call 011 000 0000. <br/><br/></p>';
                    
                    $msg = array('recipient' => $email, 'subject' => 'Welcome to Invoice Generating System, '.$name[0], 'message' => notification($name[0], $text), 
        'from' => 'accounts@permanentlink.co.za', 'replytoName' => 'Generate Invoice', 'replyto' => 'accounts@permanentlink.co.za');
        
                    new SendMail($msg);
                    
                    header('Location: ?signin&success');
                    die();
                }
                else
                {
                    // failed
                    $error = "Failed to open account. Please try again later! ";
                }
            }
        }
    }
    
    // login
    if (isset($_POST['signin']))
    {
        $email = strip_tags(trim($_POST['email']));
        $pwd = strip_tags(trim($_POST['password']));
        
        //encode the password
        $pwd = $utils->getEncryptedPassword($pwd);
        
        // check that the user cell or email does not exist
        $select = "SELECT * FROM gn_invoice_accounts WHERE pwd = '$pwd' AND emailaddress = '$email'";
        $userExists = $executeSQl->execute($select);
        
        if ($userExists['results'] != "0")
        {
            $_SESSION['UUID'] = $userExists['results'][0]['uuid'];
            //record exists
            // redirect
            header("Location: index.php");
            die();
        }
        else
        {
            $error = "Email or password incorrect!";
        }
    }
    
    function notification($name, $text)
    {
        $template = '
        <!DOCTYPE html
        	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        	<title>Generate Invoice</title>
        	<meta https-equiv="Content-Type" content="text/html;">
        	<style type="text/css">
        		@media only screen and (max-width: 640px) {
        
        			table[class=w0],
        			td[class=w0] {
        				width: 0 !important;
        			}
        
        			table[class=w2],
        			td[class=w2],
        			img[class=w2] {
        				width: 2px !important;
        			}
        
        			table[class=w5],
        			td[class=w5],
        			img[class=w5] {
        				width: 5px !important;
        			}
        
        			table[class=w10],
        			td[class=w10],
        			img[class=w10] {
        				width: 10px !important;
        			}
        
        			table[class=w15],
        			td[class=w15],
        			img[class=w15] {
        				width: 7px !important;
        			}
        
        			table[class=w20],
        			td[class=w20],
        			img[class=w20] {
        				width: 10px !important;
        			}
        
        			table[class=w30],
        			td[class=w30],
        			img[class=w30] {
        				width: 20px !important;
        			}
        
        			table[class=w45],
        			td[class=w45],
        			img[class=w45] {
        				width: 45px !important;
        			}
        
        			table[class=w60],
        			td[class=w60],
        			img[class=w60] {
        				width: 10px !important;
        			}
        
        			table[class=w125],
        			td[class=w125],
        			img[class=w125] {
        				width: 55px !important;
        			}
        
        			table[class=w130],
        			td[class=w130],
        			img[class=w130] {
        				width: 55px !important;
        			}
        
        			table[class=w135],
        			td[class=w135],
        			img[class=w135] {
        				width: 65px !important;
        			}
        
        			table[class=w140],
        			td[class=w140],
        			img[class=w140] {
        				width: 90px !important;
        			}
        
        			table[class=w160],
        			td[class=w160],
        			img[class=w160] {
        				width: 130px !important;
        			}
        
        			table[class=w170],
        			td[class=w170],
        			img[class=w170] {
        				width: 100px !important;
        			}
        
        			table[class=w180],
        			td[class=w180],
        			img[class=w180] {
        				width: 80px !important;
        			}
        
        			table[class=w195],
        			td[class=w195],
        			img[class=w195] {
        				width: 80px !important;
        			}
        
        			table[class=w220],
        			td[class=w220],
        			img[class=w220] {
        				width: 80px !important;
        			}
        
        			table[class=w230],
        			td[class=w230],
        			img[class=w230] {
        				width: 140px !important;
        			}
        
        			table[class=w240],
        			td[class=w240],
        			img[class=w240] {
        				width: 180px !important;
        			}
        
        			table[class=w255],
        			td[class=w255],
        			img[class=w255] {
        				width: 185px !important;
        			}
        
        			table[class=w275],
        			td[class=w275],
        			img[class=w275] {
        				width: 135px !important;
        			}
        
        			table[class=w280],
        			td[class=w280],
        			img[class=w280] {
        				width: 135px !important;
        			}
        
        			table[class=w290],
        			td[class=w290],
        			img[class=w290] {
        				width: 145px !important;
        			}
        
        			table[class=w300],
        			td[class=w300],
        			img[class=w300] {
        				width: 140px !important;
        			}
        
        			table[class=w325],
        			td[class=w325],
        			img[class=w325] {
        				width: 95px !important;
        			}
        
        			table[class=w330],
        			td[class=w330],
        			img[class=w330] {
        				width: 100px !important;
        			}
        
        			table[class=w360],
        			td[class=w360],
        			img[class=w360] {
        				width: 140px !important;
        			}
        
        			table[class=w380],
        			td[class=w380],
        			img[class=w380] {
        				width: 150px !important;
        			}
        
        			table[class=w400],
        			td[class=w400],
        			img[class=w400] {
        				width: 160px !important;
        			}
        
        			table[class=w410],
        			td[class=w410],
        			img[class=w410] {
        				width: 180px !important;
        			}
        
        			table[class=w470],
        			td[class=w470],
        			img[class=w470] {
        				width: 200px !important;
        			}
        
        			table[class=w560],
        			td[class=w560],
        			img[class=w560] {
        				width: 250px !important;
        			}
        
        			table[class=w580],
        			td[class=w580],
        			img[class=w580] {
        				width: 270px !important;
        			}
        
        			table[class=w600],
        			td[class=w600],
        			img[class=w600] {
        				width: 290px !important;
        			}
        
        			table[class=w640],
        			td[class=w640],
        			img[class=w640] {
        				width: 300px !important;
        			}
        
        			table[class=block-hieght],
        			td[class=block-hieght],
        			img[class=block-hieght] {
        				height: 40px !important;
        				border: 2px solid #ece7e4 !important;
        			}
        
        			table[class=block-border],
        			td[class=block-border],
        			img[class=block-border] {
        				border: 0px solid #ece7e4 !important;
        			}
        
        			table[class=w600_border],
        			td[class=w600_border],
        			img[class=w600_border] {
        				border-right: 2px solid #ece7e4 !important;
        				width: 290px !important;
        				background-color: #c7c6c6 !important;
        			}
        
        			table[class=height_reduced],
        			td[class=height_reduced],
        			img[class=height_reduced] {
        				height: 1px !important;
        			}
        
        			font[class=span],
        			table[class=span],
        			td[class=span],
        			img[class=span] {
        				color: #f21d26;
        				font-family: sans-serif;
        				font-size: 12px !important;
        			}
        
        			font[class=landing_links],
        			table[class=landing_links],
        			td[class=landing_links],
        			img[class=landing_links] {
        				font-size: 12px !important;
        				color: #ece7e4;
        				font-family: Arial !important;
        			}
        
        			font[class=hide_pipes],
        			table[class=hide_pipes],
        			td[class=hide_pipes],
        			img[class=hide_pipes] {
        				font-size: 18px !important;
        				color: #ece7e4;
        				font-family: Arial !important;
        			}
        
        			font[class=header_copy],
        			table[class=header_copy],
        			td[class=header_copy],
        			img[class=header_copy] {
        				font-size: 18px !important;
        				color: #575756;
        				font-family: Arial !important;
        			}
        
        			table[class=w600c],
        			td[class=w600c],
        			img[class=w600c] {
        				width: 290px !important;
        				margin: 0 auto !important;
        				text-align: center !important;
        			}
        
        			table[class*=hide],
        			td[class*=hide],
        			img[class*=hide],
        			p[class*=hide],
        			span[class*=hide] {
        				display: none !important;
        			}
        
        			table[class=h0],
        			td[class=h0] {
        				height: 0 !important;
        			}
        
        			img[class=headerImage] {
        				width: 280px !important;
        				height: 80px !important;
        			}
        
        			.preHeader {
        				display: none;
        			}
        
        			p[class=footer-content-left] {
        				text-align: center !important;
        			}
        
        			#headline p {
        				font-size: 30px !important;
        			}
        
        			.article-content,
        			#left-sidebar {
        				-webkit-text-size-adjust: 90% !important;
        				-ms-text-size-adjust: 90% !important;
        			}
        
        			.header-content,
        			.footer-content-left {
        				-webkit-text-size-adjust: 80% !important;
        				-ms-text-size-adjust: 80% !important;
        			}
        
        			img {
        				height: auto;
        				line-height: 100%;
        			}
        
        			tr[class=top-border] {
        				border-top: 1px solid #ffffff !important;
        			}
        
        			tr[class=top-border2] {
        				border-top: 1px solid #aaaaaa !important;
        			}
        
        			.alignCenter {
        				margin: 0 auto !important;
        				text-align: center !important;
        			}
        
        			.ProductName {
        				font-family: Arial;
        				font-size: 22px;
        				color: #007cd5;
        			}
        
        			.ProductPrice {
        				font-family: Arial;
        				font-size: 22px;
        				color: #ff33cc;
        			}
        
        			.ProductDisc {
        				font-family: Arial;
        				font-size: 18px;
        				color: #000000;
        			}
        
        			.footerLinks {
        				font-family: Arial;
        				font-size: 18px;
        				color: #0066FF;
        				line-height: 290%;
        			}
        		}
        
        		#outlook a {
        			padding: 0;
        		}
        
        		/* Force Outlook to provide a "view in browser" button. */
        
        		html {
        			margin: 0px;
        			height: 100%;
        			width: 100%;
        		}
        
        		body {
        			margin: 0px;
        			background: #f2f2f2;
        			min-height: 100%;
        			width: 100%;
        		}
        
        		.ReadMsgBody {
        			width: 100%;
        		}
        
        		.ExternalClass {
        			width: 100%;
        			display: block !important;
        		}
        
        		/* Force Hotmail to display emails at full width */
        		/* Reset Styles as best practise */
        
        		img {
        			outline: none;
        			text-decoration: none;
        			display: block;
        		}
        
        		br,
        		strong br,
        		b br,
        		em br,
        		i br {
        			line-height: 100%;
        		}
        
        		h1,
        		h2,
        		h3,
        		h4,
        		h5,
        		h6 {
        			-webkit-font-smoothing: antialiased;
        			font-weight: normal;
        		}
        
        		h1 a,
        		h2 a,
        		h3 a,
        		h4 a,
        		h5 a,
        		h6 a {
        			color: none !important;
        		}
        
        		a:visited,
        		a:visited,
        		a:visited,
        		a:visited,
        		a:visited,
        		a:visited,
        			{
        			color: none !important;
        		}
        
        		h1 a:active,
        		h2 a:active,
        		h3 a:active,
        		h4 a:active,
        		h5 a:active,
        		h6 a:active {
        			color: none !important;
        		}
        
        		h1 a:visited,
        		h2 a:visited,
        		h3 a:visited,
        		h4 a:visited,
        		h5 a:visited,
        		h6 a:visited,
        			{
        			color: none !important;
        		}
        
        		table td,
        		table tr {
        			border-collapse: collapse;
        		}
        
        		table {
        			border-collapse: collapse;
        			mso-table-lspace: 0pt;
        			mso-table-rspace: 0pt;
        		}
        
        		/* Body text color for Yahoo. */
        
        		.yshortcuts,
        		.yshortcuts a,
        		.yshortcuts a:link,
        		.yshortcuts a:visited,
        		.yshortcuts a:hover,
        		.yshortcuts a span {
        			color: black;
        			text-decoration: none !important;
        			border-bottom: none !important;
        			background: none !important;
        		}
        
        		#background-table {
        			background-color: #ffffff;
        		}
        
        		/* Fonts and Content */
        
        		body,
        		td {
        			font-family: Arial, sans-serif;
        		}
        
        		.preHeader {
        			font-size: 14px;
        			color: #191919;
        		}
        
        		.header-content,
        		.footer-content-left,
        		.footer-content-right {
        			-webkit-text-size-adjust: none;
        			-ms-text-size-adjust: none;
        		}
        
        		.header-content {
        			font-size: 12px;
        			color: #808080;
        		}
        
        		.header-content a {
        			font-weight: bold;
        			text-decoration: none;
        		}
        
        		#headline p {
        			color: #ffffff;
        			font-family: Arial, sans-serif;
        			font-size: 36px;
        			text-align: center;
        			margin-top: 0px;
        			margin-bottom: 30px;
        		}
        
        		#headline p a {
        			color: #ffffff;
        			text-decoration: none;
        		}
        
        		h2 {
        			font-size: 24px;
        			line-height: 24px;
        			margin-top: 18px;
        			margin-bottom: 18px;
        			font-family: Arial, sans-serif;
        		}
        
        		h3 {
        			font-size: 18px;
        			line-height: 24px;
        			margin-top: 18px;
        			margin-bottom: 18px;
        			font-family: Arial, sans-serif;
        		}
        
        		.article-title a {
        			text-decoration: none;
        		}
        
        		.overwrite-links a,
        		a:link,
        		a:active {
        			color: none;
        			 !important;
        		}
        
        		.article-title.with-meta {
        			margin-bottom: 0;
        		}
        
        		.article-meta {
        			font-size: 13px;
        			line-height: 20px;
        			color: #ccc;
        			font-weight: bold;
        			margin-top: 0;
        		}
        
        		.article-content {
        			font-size: 12px !important;
        			margin-top: 0px;
        			padding: 10px 0;
        			font-family: Arial, sans-serif;
        		}
        
        		.article-content a {
        			font-weight: bold;
        			text-decoration: none;
        		}
        
        		.article-content img {
        			max-width: 100%
        		}
        
        		.article-content ol,
        		.article-content ul {
        			margin-top: 0px;
        			margin-bottom: 18px;
        			margin-left: 19px;
        			padding: 0;
        		}
        
        		.article-content li {
        			font-size: 13px;
        			line-height: 18px;
        			color: #666;
        		}
        
        		.article-content li a {
        			color: #ff9900;
        			text-decoration: underline;
        		}
        
        		.article-content p {
        			margin-bottom: 18px;
        			margin-top: 18px;
        		}
        
        		.footer-content-left {
        			font-size: 14px;
        			line-height: 15px;
        			color: #ffffff;
        			margin-top: 0px;
        			margin-bottom: 15px;
        		}
        
        		.footer-content-left a {
        			color: #ffffff;
        			font-weight: bold;
        			text-decoration: none;
        		}
        
        		.footer-content-right {
        			font-size: 14px;
        			line-height: 16px;
        			color: #ffffff;
        			margin-top: 0px;
        			margin-bottom: 15px;
        		}
        
        		.footer-content-right a {
        			color: #ffffff;
        			font-weight: bold;
        			text-decoration: none;
        		}
        
        		#footer {
        			background-color: #ffffff;
        			color: #ffffff;
        		}
        
        		#footer a {
        			color: #ffffff;
        			text-decoration: none;
        			font-weight: bold;
        		}
        
        		body,
        		td,
        		th {
        			font-family: sans-serif;
        			font-size: 12px;
        			color: #666;
        			margin: 0px;
        		}
        
        		.sml {
        			font-family: sans-serif;
        			font-size: 11px;
        			color: #999;
        			padding: 5px;
        		}
        
        		.tit {
        			font-family: sans-serif;
        			font-size: 11px;
        			color: #666;
        			font-weight: bold;
        			padding: 5px;
        		}
        
        		a:link {
        			color: #eb1c22;
        			text-decoration: none;
        			zoom: 1;
        			text-decoration: none;
        			display: inline-block;
        			*display: inline;
        		}
        
        		a:visited {
        			text-decoration: none;
        			color: #eb1c22;
        		}
        
        		a:hover {
        			text-decoration: underline;
        			color: #a50b1a;
        		}
        
        		a:active {
        			text-decoration: none;
        			color: #eb1c22;
        		}
        
        		.email {
        			font-family: sans-serif;
        			font-size: 12px;
        			color: #666;
        		}
        
        		.email a:link {
        			font-family: sans-serif;
        			font-size: 12px;
        			color: #666;
        		}
        
        		.table-styles {
        			font-family: arial, sans-serif;
        			border-collapse: collapse;
        			width: 100%;
        		}
        
        		.table-styles td,
        		th {
        			border: 1px solid #dddddd;
        			text-align: left;
        			padding: 8px;
        		}
        
        		textarea {
        			border-style: none;
        			border-color: Transparent;
        			overflow: hidden;
        			height: 50px;
        			width: 100%;
        		}
        
        		.theme-table {
        			width: 100%;
        			font-family: arial, sans-serif;
        			margin-bottom: 18px;
        		}
        
        		.theme-table td,
        		th {
        			padding: 8px;
        			border: 1px solid #dddddd;
        		}
        
        		.text-center {
        			text-align: center;
        		}
        
        		.text-right {
        			text-align: right;
        		}
        		p, table {
        			font-family: montserrat-regular;
        		}
        		.account-table {
        			font-family: arial, sans-serif;
                      border-collapse: collapse;
                      width: 100%;
        		}
        		.account-table td, th {
        			border: 1px solid #dddddd;
                      text-align: left;
                      padding: 8px;
        		}
        		.account-table th {
        			color:white;
        		}
        	</style>
        
        </head>
        
        <body>
        	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#f2f2f2">
        		<tr>
        			<td height="10" style="line-height:0px; font-size:0px;"></td>
        		</tr>
        
        		<tr>
        			<td height="10" style="line-height:0px; font-size:0px;"></td>
        		</tr>
        		<tr>
        			<td align="center">
        				<table border="0" cellpadding="0" cellspacing="0" width="640" class="w600" align="center"
        					bgcolor="#ffffff">
        					<tr>
        						<td width="10"></td>
        						<td align="left" valign="bottom">
        							<!-- <table border="0" cellpadding="0" cellspacing="0" width="640" class="w600" align="center"
        								bgcolor="#ffffff">
        								<tr>
        									<td><img src="" width="640"
        											alt="BANNER" border="0" height="150" /></td>
        								</tr>
        							</table> -->
        						</td>
        						<td align="right"></td>
        						<td width="10"></td>
        					</tr>
        					<tr>
        						<td width="10"></td>
        						<td align="left" valign="bottom">
        							<table border="0" cellpadding="0" cellspacing="0" width="640" class="w600" bgcolor="#ffffff">
        								<tr>
        									<td width="20" class="w10">&nbsp;</td>
        									<td align="left" class="article-content">
        											<p>Hi '.$name.',</p>
        											'.$text.'
        									</td>
        									<td width="20" class="w10">&nbsp;</td>
        								</tr>
        							</table>
        						</td>
        						<td align="right"></td>
        						<td width="10"></td>
        					</tr>
        				</table>
        			</td>
        		</tr>
        	</table>
        
        	<!-------end table for unsub copy -------->
        	<!-- Include the layout editor JavaScript library. -->
        
        </body>
        
        </html>';
                
                return $template;
            }
    
    if (isset($_GET['logout']))
    {
        session_destroy();
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
    <h3 class="w3-wide"><b></b></h3>
  </div>
  
</nav>

<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <?php
    if (!empty($error))
    {
        echo 'ERROR: '.$error.PHP_EOL;
    }
    
    if (isset($_GET['success']))
    {
        echo 'You have been registered successfully!';
    }
  ?>
  
  <?php
  if (isset($_GET['open'])){?>
  <div class="w3-container w3-padding-32">
        <h4>Register</h4>
        <form action="" method="post">
          <p><input class="w3-input w3-border" type="text" placeholder="Name" name="name" required></p>
          <p><input class="w3-input w3-border" type="email" placeholder="Email" name="email" required></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Contact No." name="contact-number" required></p>
          <p><input class="w3-input w3-border" type="password" placeholder="Password" name="password" required></p>
          <p><textarea class="w3-input w3-border" type="text" placeholder="Address" name="address" required></textarea></p>
          <button type="submit" class="w3-button w3-block w3-black" name="register">Submit</button>
        </form>
        <p>Already have an account? Sign In <a href="?signin">here</a></p>
  </div>
  <?php } ?>
  
  <?php
  if (isset($_GET['signin'])){?>
  <div class="w3-container w3-padding-32">
        <h4>Sign In</h4>
        <form action="" method="post">
          <p><input class="w3-input w3-border" type="email" placeholder="Email" name="email" required></p>
          <p><input class="w3-input w3-border" type="password" placeholder="Password" name="password" required></p>
          <button type="submit" class="w3-button w3-block w3-black" name="signin">Sign In</button>
        </form>
        <p>Don't have an account? <a href="?open">Open an account</a></p>
  </div>
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
