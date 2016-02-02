<?php
/*Author: Alex Ball
 *Date: 11/30/2015
 *IT 305 Final Project
 *WISE Intake Form
 *
 *Filename: wise-intake-form-3.php
 *
 *This page is designed as part of an intake form for the Washington
 *Integrated Sector Employment (WISE) project. Users will fill
 *out the form, which is split into 4 pages. The data is stored
 *in a database and can be exported to an Excel csv file.
 */

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start the session so that form data can be saved across pages
session_start();

//require functions list
require('includes/functions.php');

//error array must be empty for information to be added to the session
$errorArray = array();

//get the session value to make the form sticky if the user is returning
//to this page before they submit the entire form
$verifyEqualOpportunityStatement = wise_session_item_check('verifyEqualOpportunityStatement');

//handle form if it was submitted
if (isset($_POST['submit']))
{
	//as a checkbox, this element's variable will be assigned and checked for emptiness without a function.
	if (!empty($_POST['verifyEqualOpportunityStatement']))
	{
		$verifyEqualOpportunityStatement = $_POST['verifyEqualOpportunityStatement'];
	}
	else
	{
		$errorArray['verifyEqualOpportunityStatement'] = '<span class="form-error">You must verify the information to continue!</span>';
		$verifyEqualOpportunityStatement = array();
	}
	
	//add to the session if the box was checked, then redirect to previous or next page.
	if (empty($errorArray))
	{
		$_SESSION['verifyEqualOpportunityStatement'] = $verifyEqualOpportunityStatement;
		
		//if previous button, go back to page 2. if anything else (including next button
		//or the user just hitting the enter key), go to page 4.
		if ($_POST['submit'] == 'previous')
		{
			header('location: wise-intake-form-2.php');
		}
		else
		{
			header('location: wise-intake-form-4.php');
		}
	}
}

//this is page 3
$pageNumber = 3;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--	Author: Alex Ball
					Date: 11/30/2015
					IT 305 Final Project
					WISE Intake Form
					
					Filename: wise-intake-form-3.php
					
					This page is designed as part of an intake form for the Washington
					Integrated Sector Employment (WISE) project. Users will fill
					out the form, which is split into 4 pages. The data is stored
					in a database and can be exported to an Excel csv file.
					
		-->
			
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>WISE Intake Form - Page <?php print $pageNumber; ?> - Equal Opportunity Statement</title>
	
		<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- WISE intake form CSS -->
		<link href="includes/wise-style.css" rel="stylesheet">
	
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<!--	Content Area	-->
		<div class="container">
			<!-- Header Area -->
			<?php require('includes/wise-header.php'); ?>
			<!-- End Header Area -->
			
			<!-- Form Area -->
			<div class="row">
				<form method="post" action="#">
					<!-- Top Page Swap -->
					<?php require('includes/wise-form-page-swap.php'); ?>
					<!-- End Top Page Swap -->
					
					<!-- Equal Opportunity Statement Area -->
					<div class="row">
						<div class="col-xs-12">
							<!-- Title of the Page -->
							<h3 class="text-center serif-font">EQUAL OPPORTUNITY IS THE LAW</h3>
							
							<?php require('includes/wise-form-error-header.php'); ?>
							
							<p>
								It is against the law for Green River College as a recipient of federal financial
								assistance to discriminate on the following bases:
							</p>
							
							<p>
								Against any individual in the United States, on the basis of race, color, religion,
								sex, national origin, age, disability, political affiliation or belief; and
							</p>
							
							<p>
								Against any beneficiary of programs financially assisted under Title I
								of the Workforce Investment Act of 1998 (WIA), on the basis of the beneficiary's
								citizenship/status as a lawfully admitted immigrant authorized to work in the
								United States, or his or her participation in any WIA Title I-financially assisted
								program or activity.
							</p>
							
							<p>
								The recipient must not discriminate in any of the following areas:
							</p>
							
							<p>
								Deciding who will be admitted, or have access, to any WIA Title I-financially assisted
								program or activity; 
							</p>
							
							<p>
								providing opportunities in, or treating any person with regard to, such a program or
								activity;
							</p>
							
							<p>
								or
							</p>
							
							<p>
								making employment decisions in the administration of, or in connection with, such a
								program or activity.
							</p>
							
							<h4>WHAT TO DO IF YOU BELIEVE YOU HAVE EXPERIENCED DISCRIMINATION</h4>
							
							<p>
								If you think that you have been subjected to discrimination under a WIA Title I-financially
								assisted program or activity, you may file a complaint within 180 days from the date of the
								alleged violation with either:
							</p>
							
							<p class="pull-left left-margin-30 serif-font">
								Marshall Sampson<br />
								Human Resources & Legal Affairs <br />
								Green River College<br />
								Auburn, WA  98092<br />
								mSampson@greenriver.edu<br />
								(253) 833-9111 x3320<br />
							</p>
							
							<p class="pull-left left-margin-30 serif-font">
								or<br />
								<br />
								The Director, Civil Rights Center (CRC), <br />
								U.S. Department of Labor, <br />
								200 Constitution Avenue NW, Room N-4123, <br />
								Washington, DC 20210.<br />
							</p>
							
							<p class="clear-both-floats">
								If you file your complaint with the recipient, you must wait either until the recipient
								issues a written Notice of Final Action, or until 90 days have passed (whichever is sooner),
								before filing with the Civil Rights Center (CRC)(see address above).
							</p>
							
							<p>
								If the recipient does not give you a written Notice of Final Action within 90 days of the
								day on which you filed your complaint, you do not have to wait for the recipient to issue that
								Notice before filing a complaint with CRC. However, you must file your CRC complaint within 30
								days of the 90-day deadline (in other words, within 120 days after the day on which you filed
								your complaint with the recipient).
							</p>
							
							<p>
								If the recipient does give you a written Notice of Final Action on your complaint, but you are
								dissatisfied with the decision or resolution, you may file a complaint with CRC. You must file your
								CRC complaint within 30 days of the date on which you received the Notice of Final Action.
							</p>
						</div>
					</div>
					<!-- End Equal Opportunity Statement Area -->
					
					<hr />
					
					<!-- Verification Checkbox Area -->
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<div class="checkbox verify-statement">
									<?php
									//if the checkbox was not selected, print an error.
									print (empty($errorArray['verifyEqualOpportunityStatement'])) ? '' : '<p>' . $errorArray['verifyEqualOpportunityStatement'] . '</p>';
									?>
									<label for="verifyEqualOpportunityStatement"><input type="checkbox" id="verifyEqualOpportunityStatement" name="verifyEqualOpportunityStatement"
									value="verifyEqualOpportunityStatement" <?php print (empty($verifyEqualOpportunityStatement)) ? '' : 'checked'; ?>>
									<strong>I hereby verify that the information I have provided is true and correct to the best
									of my knowledge. I understand further that (1) I have the right not to consent to the release
									of my education records; (2) I have the right to inspect such records upon request.</strong></label>
								</div>
							</div>
						</div>
					</div>
					<!-- End Verification Checkbox Area -->
					
					<hr />
					
					<!-- Bottom Form Swap -->
					<?php require('includes/wise-form-page-swap.php'); ?>
					<!-- End Bottom Form Swap -->
				</form>
			</div>
			<!-- End Form Area -->
			<!-- Footer Area -->
			<?php include('includes/wise-intake-footer.php'); ?>
			<!-- End Footer Area -->
		</div>
		<!--	End Content Area -->
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../bootstrap/js/bootstrap.min.js"></script>
	</body>	
</html>