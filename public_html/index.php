<?php
/*Author: Alex Ball
 *Date: 11/30/2015
 *IT 305 Final Project
 *WISE Intake Form
 *
 *Filename: index.php
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

//define the options for the radio/checkbox lists
require('includes/wise-form-list-arrays.php');

/*if session variables are already set (probably because a user is looking at
 *this page via the previous button on the next page) then the form should be
 *filled out with the information that they entered. (form stickyness)
 */
$wiseIntakeLName = wise_session_item_check('wiseIntakeLName');
$wiseIntakeStudentID = wise_session_item_check('wiseIntakeStudentID');
$wiseIntakeFName = wise_session_item_check('wiseIntakeFName');
$wiseIntakeCourse = wise_session_item_check('wiseIntakeCourse');
$wiseIntakeMInitial = wise_session_item_check('wiseIntakeMInitial');

$wiseIntakeEduBackground = wise_session_item_check('wiseIntakeEduBackground');
$wiseIntakeEduGoal = wise_session_item_check('wiseIntakeEduGoal');
$wiseIntakeEduCurrentStatus = wise_session_item_check('wiseIntakeEduCurrentStatus');
$wiseIntakeIntendedPrograms = wise_session_item_check('wiseIntakeIntendedPrograms');
$wiseIntakeIntendedProgramOther = wise_session_item_check('wiseIntakeIntendedProgramOther');

//form validation
require('includes/wise-form-validation-1.php');

//radio values are placed in arrays to work with the create_radio_checkbox_list function
//to make the form sticky.
$wiseIntakeEduBackground = array('wiseIntakeEduBackground' => $wiseIntakeEduBackground);
$wiseIntakeEduGoal = array('wiseIntakeEduGoal' => $wiseIntakeEduGoal);
$wiseIntakeEduCurrentStatus = array('wiseIntakeEduCurrentStatus' => $wiseIntakeEduCurrentStatus);

//this is page 1
$pageNumber = 1;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--	Author: Alex Ball
					Date: 11/30/2015
					IT 305 Final Project
					WISE Intake Form
					
					Filename: wise-intake-form-1.php
					
					This page is designed as part of an intake form for the Washington
					Integrated Sector Employment (WISE) project. Users will fill
					out the form, which is split into 4 pages. The data is stored
					in a database and can be exported to an Excel csv file.
					
		-->
			
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>WISE Intake Form - Page <?php print $pageNumber; ?> - Questionnaire</title>
	
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
					
					<div class="row">
						<!-- Title of the page -->
						<div class="col-xs-12">
							<div class="text-center serif-font">
								<h3>Wise Student Questionnaire</h3>
							</div>
						</div>
					</div>
					
					<?php require('includes/wise-form-error-header.php'); ?>
					
					<!-- Note about required fields -->
					<div class="row">
						<div class="col-xs-12 required-note">
							<p>Required fields are marked with a red asterisk <span class="form-error">*</span></p>
						</div>
					</div>
					
					<!-- Name Area -->
					<div class="row">
						<div class="col-xs-12">
							<fieldset>
								<legend class="serif-font no-padding-top">Student Information</legend>
								<div class="form-group">
									<!-- Row 1 -->
									<div class="row">
										<!-- Last Name -->
										<div class="col-xs-12 col-sm-4">
											<label for="wiseIntakeLName">Last Name: <span class="form-error">*</span>
														<?php
														//if there is an error for this element, print it. otherwise, print an empty string.
														print (empty($errorArray['wiseIntakeLName'])) ? '' : '<br />' . $errorArray['wiseIntakeLName'];
														?></label>
											<input type="text" class="form-control" id="wiseIntakeLName" name="wiseIntakeLName"
														placeholder="Last Name" value="<?php print $wiseIntakeLName; ?>" required="required">
										</div>
										
										<!-- First Name -->
										<div class="col-xs-12 col-sm-4">
											<label for="wiseIntakeFName">First Name: <span class="form-error">*</span>
											<?php
											//if there is an error for this element, print it. otherwise, print an empty string.
											print (empty($errorArray['wiseIntakeFName'])) ? '' : '<br />' . $errorArray['wiseIntakeFName'];
											?></label>
											<input type="text" class="form-control" id="wiseIntakeFName" name="wiseIntakeFName"
														placeholder="First Name" value="<?php print $wiseIntakeFName; ?>" required="required">
										</div>
										
										<!-- Middle Initial -->
										<div class="col-xs-12 col-sm-4">
											<label for="wiseIntakeMInitial">Middle Initial:
											<?php
											//if there is an error for this element, print it. otherwise, print an empty string.
											print (empty($errorArray['wiseIntakeMInitial'])) ? '' : '<br />' . $errorArray['wiseIntakeMInitial'];
											?></label>
											<input type="text" class="form-control" id="wiseIntakeMInitial" name="wiseIntakeMInitial"
														placeholder="Middle Initial" value="<?php print $wiseIntakeMInitial; ?>">
										</div>
									</div>
									
									<!-- Row 2 -->
									<div class="row">
										<!-- Student ID Number -->
										<div class="col-xs-12 col-sm-4">
											<label for="wiseIntakeStudentID" class="padding-top-10">Student ID Number (Digits only):
														<span class="form-error">*</span>
														<?php
														//if there is an error for this element, print it. otherwise, print an empty string.
														print (empty($errorArray['wiseIntakeStudentID'])) ? '' : '<br />' . $errorArray['wiseIntakeStudentID'];
														?></label>
											<input type="number" class="form-control" id="wiseIntakeStudentID" name="wiseIntakeStudentID"
														placeholder="Student ID Number" value="<?php print $wiseIntakeStudentID; ?>" required="required">
										</div>
										
										<!-- This Course Is -->
										<div class="col-xs-12 col-sm-4">
											<label for="wiseIntakeCourse" class="padding-top-10">This Course Is: <span class="form-error">*</span>
											<?php
											//if there is an error for this element, print it. otherwise, print an empty string.
											print (empty($errorArray['wiseIntakeCourse'])) ? '' : '<br />' . $errorArray['wiseIntakeCourse'];
											?></label>
											<input type="text" class="form-control" id="wiseIntakeCourse" name="wiseIntakeCourse"
														placeholder="Course" value="<?php print $wiseIntakeCourse; ?>" required="required">
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<!-- End Name Area -->
					
					<!-- Education Information Area -->
					<div class="row">
						<div class="col-xs-12">
							<fieldset>
								<legend class="serif-font">Education Information</legend>
								<div class="form-group">
									<!-- Education Information Row 1 -->
									<div class="row">
										<!-- Educational Background -->
										<div class="col-xs-12 col-sm-4">
											<fieldset>
												<legend class="serif-font no-padding-top">Educational Background:<span class="form-error">*</span><br />
															<span class="sub-legend">(check highest level completed)
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeEduBackground'])) ? '' : '<br />' . $errorArray['wiseIntakeEduBackground'];
															?></span></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												//the arrays for the lists are defined near the top of this page.
												create_radio_checkbox_list('wiseIntakeEduBackground', $eduBackgroundRadio, 'radio', $wiseIntakeEduBackground);
												?>
											</fieldset>
										</div>
										
										<!-- Educational Goals -->
										<div class="col-xs-12 col-sm-4">
											<fieldset>
												<legend class="serif-font no-padding-top">Educational Goals:<span class="form-error">*</span><br />
															<span class="sub-legend">(check the one that most applies)
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeEduGoal'])) ? '' : '<br />' . $errorArray['wiseIntakeEduGoal'];
															?></span></legend>
												<?php												
												//create the radio list using the create_radio_checkbox_list function.
												//the arrays for the lists are defined near the top of this page.
												create_radio_checkbox_list('wiseIntakeEduGoal', $eduGoalRadio, 'radio', $wiseIntakeEduGoal);
												?>
											</fieldset>
										</div>
										
										<!-- I am currently (Full / Part time) or Educational Current Status -->
										<div class="col-xs-12 col-sm-4">
											<fieldset>
												<legend class="serif-font no-padding-top">I am currently:<span class="form-error">*</span><br />
															<span class="sub-legend">(current credit enrollment status)
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeEduCurrentStatus'])) ? '' : '<br />' . $errorArray['wiseIntakeEduCurrentStatus'];
															?></span></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												//the arrays for the lists are defined near the top of this page.
												create_radio_checkbox_list('wiseIntakeEduCurrentStatus', $eduCurrentStatusRadio, 'radio', $wiseIntakeEduCurrentStatus);
												?>
											</fieldset>
										</div>
									</div>
									<!-- End Education Information Row 1 -->
									
									<!-- Education Information Row 2 -->
									<div class="row">
										<div class="col-xs-12">
											<!-- Intended Programs -->
											<fieldset>
												<legend class="serif-font no-padding-top">Intended Programs:<span class="form-error">*</span><br />
															<span class="sub-legend">(check all that apply)
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeIntendedPrograms'])) ? '' : '<br />' . $errorArray['wiseIntakeIntendedPrograms'];
															?></span></legend>
												<?php
												//create the checkbox list using the create_radio_checkbox_list function.
												//the arrays for the lists are defined near the top of this page.
												create_radio_checkbox_list('wiseIntakeIntendedPrograms', $intendedProgramsCheckboxes, 'checkbox', $wiseIntakeIntendedPrograms);
												?>
											</fieldset>
										</div>
									</div>
									<!-- End Education Information Row 2 -->
									
									<!-- Education Information Row 3 -->
									<div class="row" id="IntendedProgramOtherInput">
										<div class="col-xs-12 col-sm-4">
											<!-- Intended Programs "Undecided/Other" Text input -->
											<label for="wiseIntakeIntendedProgramOther">Specify Intended Program: <span class="form-error">*</span>
											<?php
											//if there is an error for this element, print it. otherwise, print an empty string.
											print (empty($errorArray['wiseIntakeIntendedProgramOther'])) ? '' : '<br />' . $errorArray['wiseIntakeIntendedProgramOther'];
											?></label>
											<input type="text" class="form-control" id="wiseIntakeIntendedProgramOther" name="wiseIntakeIntendedProgramOther"
														placeholder="Intended Program" value="<?php print $wiseIntakeIntendedProgramOther; ?>">
										</div>
									</div>
									<!-- End Education Information Row 3 -->
								</div>
							</fieldset>
						</div>
					</div>
					<!-- End Education Information Area -->
					
					<!-- Disclaimer Area -->
					<div class="row">
						<div class="col-xs-12">
							<br />
							<p class="disclaimer">
								This workforce solution was funded by a grant awarded by the U.S. Department of Labor’s Employment and
								Training Administration (grant number TC-26512-14-60-A-53). The solution was created by the grantee and
								does not necessarily reflect the official position of the U.S. Department of Labor. The Department of
								Labor makes no guarantees, warranties, or assurances of any kind, express or implied, with respect to
								such information, including any information on linked sites and including, but not limited to, accuracy
								of the information or its completeness, timeliness, usefulness, adequacy, continued availability, or ownership.
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
		
		<script>
			//intended program "undecided/other" text input starts out hidden if it was not checked.
			if (!$('#wiseIntakeIntendedPrograms' + (<?php print $intendedProgramsOtherOptionNumber + 1; ?>)).is(':checked'))
			{
				$('#IntendedProgramOtherInput').hide();
			}
			
			//if intended program "undecided/other" is checked, show "specify" text input.
			$('#wiseIntakeIntendedPrograms' + <?php print $intendedProgramsOtherOptionNumber + 1; ?>).click(function()
			{
				$('#IntendedProgramOtherInput').slideToggle('slow');
			});
		</script>
	</body>	
</html>