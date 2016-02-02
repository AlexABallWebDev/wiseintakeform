<?php
/*Author: Alex Ball
 *Date: 12/16/2015
 *IT 305 Final Project
 *WISE Intake Form
 *
 *Filename: wise-intake-table-login.php
 *
 *This page is designed as part of an intake form for the Washington
 *Integrated Sector Employment (WISE) project. Users will fill
 *out the form, which is split into 4 pages. The data is stored
 *in a database and can be exported to an Excel csv file.
 *This page acts as a login for the table page.
 */

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start session so that the admin variable can be set upon successful login
session_start();

//require functions list
require('includes/functions.php');

//this variable tells the header to appear differently (rather than "form" it will say "table").
$isTablePage = true;

//setting initial username and password to empty strings
$wiseIntakeTableLoginUsername = '';
$wiseIntakeTableLoginPassword = '';

//error array starts empty
$errorArray = array();

//validate the submitted username and password (if the form was submitted)
if (isset($_POST['submit']))
{
	//get submitted username and password
	$wiseIntakeTableLoginUsername = wise_clean_data($_POST['wiseIntakeTableLoginUsername']);
	$wiseIntakeTableLoginPassword = wise_clean_data($_POST['wiseIntakeTableLoginPassword']);
	
	//if username and password are correct, set variable to mark successful login
	if ($wiseIntakeTableLoginUsername == 'wiseAdmin' && $wiseIntakeTableLoginPassword == 'adbEJL5Pmlfbu2k9')
	{
		$successfulLogin = true;
	}
	
	//if username/password combo is correct, redirect to table page with a session variable set
	//marking this session as an admin that can view the table.
	if (isset($successfulLogin))
	{
		$_SESSION['admin'] = 'wise-admin';
		
		header('location: wise-intake-table.php');
	}
	else
	{
		$errorArray['wiseIntakeTableLoginError'] = '<strong><span class="form-error">Username or password incorrect.</span></strong><br />';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--	Author: Alex Ball
					Date: 12/16/2015
					IT 305 Final Project
					WISE Intake Form
					
					Filename: wise-intake-table-login.php
					
					This page is designed as part of an intake form for the Washington
					Integrated Sector Employment (WISE) project. Users will fill
					out the form, which is split into 4 pages. The data is stored
					in a database and can be exported to an Excel csv file.
					This page acts as a login for the table page.
					
		-->
			
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>WISE Intake Table Login</title>
	
		<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<!-- WISE intake form CSS -->
		<link href="includes/wise-style.css" rel="stylesheet">
		
	</head>
	<body>
		<!--	Content Area	-->
		<div class="container">
			<!-- Header Area -->
			<?php require('includes/wise-header.php'); ?>
			<!-- End Header Area -->
			
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 text-center">
					<form method="post" action="#">
						<h3>Login to view table of entries</h3>
						
						<?php
						//if there an error logging in, display error.
						print (empty($errorArray['wiseIntakeTableLoginError'])) ? '' : '<br />' . $errorArray['wiseIntakeTableLoginError'];
						?>
						
						<!-- Username -->
						<label for="wiseIntakeTableLoginUsername" class="padding-top-10">Username:</label>
						<input type="text" class="form-control" id="wiseIntakeTableLoginUsername" name="wiseIntakeTableLoginUsername"
									placeholder="Username" value="<?php print $wiseIntakeTableLoginUsername; ?>">
													
						<!-- Password -->
						<label for="wiseIntakeTableLoginPassword" class="padding-top-10">Password:</label>
						<input type="password" class="form-control" id="wiseIntakeTableLoginPassword" name="wiseIntakeTableLoginPassword"
									placeholder="Password">
						
						<!-- Submit -->
						<br />
						<button type="submit" value="submit" name="submit">Submit</button>
					</form>
				</div>
			</div>
			<!-- Footer Area -->
			<?php include('includes/wise-intake-footer.php'); ?>
			<!-- End Footer Area -->
		</div>
		<!--	End Content Area -->
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script language="JavaScript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../bootstrap/js/bootstrap.min.js"></script>
	</body>	
</html>