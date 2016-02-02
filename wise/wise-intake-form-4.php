<?php
/*Author: Alex Ball
 *Date: 11/30/2015
 *IT 305 Final Project
 *WISE Intake Form
 *
 *Filename: wise-intake-form-4.php
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
$verifyFERPA = wise_session_item_check('verifyFERPA');

//handle form if it was submitted
if (isset($_POST['submit']))
{
	//as a checkbox, this element's variable will be assigned and checked for emptiness without a function.
	if (!empty($_POST['verifyFERPA']))
	{
		$verifyFERPA = $_POST['verifyFERPA'];
	}
	else
	{
		$errorArray['verifyFERPA'] = '<span class="form-error">You must agree to continue!</span>';
		$verifyFERPA = array();
	}
	
	//add to the session if the box was checked, then redirect to previous or next page.
	if (empty($errorArray))
	{
		$_SESSION['verifyFERPA'] = $verifyFERPA;
		
		//if previous button, go back to page 3. if anything else (including next button
		//or the user just hitting the enter key), go to submit form script.
		if ($_POST['submit'] == 'previous')
		{
			header('location: wise-intake-form-3.php');
		}
		else
		{
			header('location: wise-intake-submit-form.php');
		}
	}
}

//this is page 4
$pageNumber = 4;
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
		
		<title>WISE Intake Form - Page <?php print $pageNumber; ?> - FERPA</title>
	
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
					
					<!-- FERPA Description Area -->
					<div class="row">
						<div class="col-xs-12">
							<!-- Title of the Page -->
							<h3 class="text-center serif-font">
								Grant Funded Student’s Authorization to Disclose Information
								in Education Records Pursuant to FERPA
							</h3>
							
							<?php require('includes/wise-form-error-header.php'); ?>
							
							<p>
								I understand that my educational records are protected by the Family
								Educational Rights and Privacy Act of 1974, and they may not be disclosed
								without my prior written consent. I hereby consent to the disclosure of
								the following education records pertaining to me to the persons and for
								the purposes as stated below:
							</p>
							
							<p>
								I hereby authorize the following officials:
							</p>
							<ol>
								<li>W.I.S.E. grant staff;</li>
								<li>Employment Training Administration (ETA), Employment Security Department (ESD) staff </li>
								<li>Department of Labor staff and;</li>
								<li>Faculty members teaching courses in which I am currently (or was) enrolled</li>
							</ol>
							
							<p>
								To disclose the following:
							</p>
							
							<ol>
								<li>
									Any demographic information, contact information, employment status,
									financial information, academic student records, including social security
									number for reporting outcomes
								</li>
								<li>Any and all information contained in my official permanent academic record;</li>
								<li>Disclose, upon my request in writing, copies of my official permanent academic record; and</li>
								<li>
									Specific information regarding my academic progress (attendance, grades, etc.) prior
									to the final determination of grade
								</li>
							</ol>
							
							<p>
								To the following persons:
							</p>
							
							<ol>
								<li>W.I.S.E., ETA, ESD, DOL  staff members;</li>
								<li>
									Specific state and federal grant funders, lead agencies, fiscal administrators
									of grant programs; and
								</li>
								<li>
									Any other person within the College who the College, in good faith, determines
									has a legitimate “need to know”;
								</li>
							</ol>
							
							<p>
								for the following purposes:
							</p>
							
							<ol>
								<li>To monitor, assist and determine eligibility for grant-funded programs; </li>
								<li>
									To monitor and assist with respect to retention and student support needs related
									to programs within Student &amp; Career Services;
								</li>
								<li>
									For reporting requirements of specific grant programs; as well as for statistical
									analysis of grant outcomes;
								</li>
								<li>To monitor and assist with graduate placement needs and employment outcome tracking</li>
							</ol>
							
							<p>
								I authorize the Employment Security Department to release my employment and wage information
								with authorized WorkSource Partners for the purposes of reporting and research only, unless I
								specify otherwise.  This information is not subject to disclosure under the Public Records
								Act (RCW 42.17.310).
							</p>
							
							<p>
								I understand further: (1) that such records may be disclosed only on the condition that the
								party to whom the information is disclosed will not re-disclose the information to any other
								party without my written consent unless specifically allowed by law; (2)  I have the right to
								not consent to the release of my educational records by completing the RTC Form or by filing a
								written notice to the RTC registrar; (3) that I recognize that a copy of such records must be
								provided to me upon my request; and 4) that this Authorization remains in effect unless revoked
								by me in writing. 
							</p>
						</div>
					</div>
					<!-- End FERPA Description Area -->
					
					<hr />
					
					<!-- Verification Checkbox Area -->
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<div class="checkbox verify-statement">
									<?php
									//if the checkbox was not selected, print an error.
									print (empty($errorArray['verifyFERPA'])) ? '' : '<p>' . $errorArray['verifyFERPA'] . '</p>';
									?>
									<label for="verifyFERPA"><input type="checkbox" id="verifyFERPA" name="verifyFERPA"
									value="verifyFERPA" <?php print (empty($verifyFERPA)) ? '' : 'checked'; ?>>
									<strong>I certify that I agree to the disclosure of the records referenced above.
									This authorization and consent by me is valid for the life of the grant reporting
									period or until I revoke it in writing. A copy of this authorization shall be
									considered as effective and valid as the original.</strong></label>
								</div>
							</div>
						</div>
					</div>
					<!-- End Verification Checkbox Area -->
					
					<hr />
					<!-- Disclaimer Area -->
					<div class="row">
						<div class="col-xs-12">
							<br />
							<!-- Note that &amp; is the code for an ampersand (&) -->
							<p class="disclaimer">
								In accordance with the Privacy Act of 1974 (Public Law No. 93-579, 5 U.S.C. 552a),
								you are hereby notified that the Department of Labor is authorized to collect information
								to implement the Trade Adjustment Assistance Community College and Career Training Program
								under 19 USC 2372 – 2372a.  The principal purpose for collecting this information is to
								administer the program (grant number TC-26512-14-60-A-53) , including tracking and evaluating
								participant progress. Providing this information, including a social security number (SSN) is
								voluntary; failure to disclose a SSN will not result in the denial of any right, benefit or
								privilege to which the participant is entitled. The information that is collected on this form
								will be retained in the program files of the grantee and may be released to other department
								officials in the performance of their official duties.
							</p>
							<br />
						</div>
					</div>
					<!-- End Disclaimer Area -->
					
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