<?php
/*Author: Alex Ball
 *Date: 12/15/2015
 *IT 305 Final Project
 *WISE Intake Form
 *
 *Filename: wise-intake-form-submitted.php
 *
 *This page is designed as part of an intake form for the Washington
 *Integrated Sector Employment (WISE) project. Users will fill
 *out the form, which is split into 4 pages. The data is stored
 *in a database and can be exported to an Excel csv file.
 *This page displays a table of the entries submitted so far.
 *These entries are pulled from the database.
 */

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--	Author: Alex Ball
					Date: 12/15/2015
					IT 305 Final Project
					WISE Intake Form
					
					Filename: wise-intake-form-submitted.php
					
					This page is designed as part of an intake form for the Washington
					Integrated Sector Employment (WISE) project. Users will fill
					out the form, which is split into 4 pages. The data is stored
					in a database and can be exported to an Excel csv file.
					This page displays a table of the entries submitted so far.
					These entries are pulled from the database.
					
		-->
			
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>WISE Intake Submission Successful</title>
	
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
			
			<div class="row text-center">
				<h3>Your entry has been saved. Thank you for filling out the WISE Student Intake form!</h3>
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