<?php
/*Author: Alex Ball
 *Date: 11/30/2015
 *IT 305 Final Project
 *WISE Intake Form
 *
 *Filename: wise-intake-form-2.php
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
$wiseIntakeDemoGender = wise_session_item_check('wiseIntakeDemoGender');
$wiseIntakeDemoDateOfBirth = wise_session_item_check('wiseIntakeDemoDateOfBirth');
$wiseIntakeDemoPrimaryPhoneNumber = wise_session_item_check('wiseIntakeDemoPrimaryPhoneNumber');
$wiseIntakeDemoPreferredEmail = wise_session_item_check('wiseIntakeDemoPreferredEmail');
$wiseIntakeDemoRace = wise_session_item_check('wiseIntakeDemoRace');
$wiseIntakeDemoDisability = wise_session_item_check('wiseIntakeDemoDisability');
$wiseIntakeDemoPellGrant = wise_session_item_check('wiseIntakeDemoPellGrant');
$wiseIntakeDemoTAA = wise_session_item_check('wiseIntakeDemoTAA');
$wiseIntakeDemoEligibleVeteran = wise_session_item_check('wiseIntakeDemoEligibleVeteran');
$wiseIntakeDemoSpouseOfEligibleVeteran = wise_session_item_check('wiseIntakeDemoSpouseOfEligibleVeteran');

$wiseIntakeEmploymentStatus = wise_session_item_check('wiseIntakeEmploymentStatus');
$wiseIntakeEmployerName = wise_session_item_check('wiseIntakeEmployerName');
$wiseIntakeEmploymentStartDate = wise_session_item_check('wiseIntakeEmploymentStartDate');
$wiseIntakeEmploymentHoursPerWeek = wise_session_item_check('wiseIntakeEmploymentHoursPerWeek');
$wiseIntakeEmploymentCurrentSalary = wise_session_item_check('wiseIntakeEmploymentCurrentSalary');

$verifyQuestionnaire = wise_session_item_check('verifyQuestionnaire');

//form validation
require('includes/wise-form-validation-2.php');


//radio values are placed in arrays to work with the create_radio_checkbox_list function
//to make the form sticky.
$wiseIntakeDemoGender = array('wiseIntakeDemoGender' => $wiseIntakeDemoGender);
$wiseIntakeDemoRace = array('wiseIntakeDemoRace' => $wiseIntakeDemoRace);
$wiseIntakeDemoDisability = array('wiseIntakeDemoDisability' => $wiseIntakeDemoDisability);
$wiseIntakeDemoPellGrant = array('wiseIntakeDemoPellGrant' => $wiseIntakeDemoPellGrant);
$wiseIntakeDemoTAA = array('wiseIntakeDemoTAA' => $wiseIntakeDemoTAA);
$wiseIntakeDemoEligibleVeteran = array('wiseIntakeDemoEligibleVeteran' => $wiseIntakeDemoEligibleVeteran);
$wiseIntakeDemoSpouseOfEligibleVeteran = array('wiseIntakeDemoSpouseOfEligibleVeteran' => $wiseIntakeDemoSpouseOfEligibleVeteran);
$wiseIntakeEmploymentStatus = array('wiseIntakeEmploymentStatus' => $wiseIntakeEmploymentStatus);

//this is page 2
$pageNumber = 2;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--	Author: Alex Ball
					Date: 11/30/2015
					IT 305 Final Project
					WISE Intake Form
					
					Filename: wise-intake-form-2.php
					
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
					
					<!-- Demographic Area -->
					<div class="row">
						<div class="col-xs-12">
							<fieldset>
								<legend class="serif-font no-padding-top">Demographic Information</legend>
								<div class="form-group">
									<!-- Demographic Row 1 -->
									<div class="row">
										<!-- Left Column -->
										<div class="col-xs-12 col-sm-4">
											<!-- Gender -->
											<fieldset>
												<legend class="serif-font no-padding-top">Gender: <span class="form-error">*</span>
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeDemoGender'])) ? '' : '<br /><span class="sub-legend">' .
															$errorArray['wiseIntakeDemoGender'];
															?></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeDemoGender', $demoGenderRadio, 'radio', $wiseIntakeDemoGender);
												?>
											</fieldset>
											
											<hr />
											
											<!-- Date of Birth -->
											<label for="wiseIntakeDemoDateOfBirth">Date of Birth (MM/DD/YYYY): <span class="form-error">*</span>
														<?php
														//if there is an error for this element, print it. otherwise, print an empty string.
														print (empty($errorArray['wiseIntakeDemoDateOfBirth'])) ? '' : '<br />' . $errorArray['wiseIntakeDemoDateOfBirth'];
														?></label>
											<input type="text" class="form-control" id="wiseIntakeDemoDateOfBirth" name="wiseIntakeDemoDateOfBirth"
														placeholder="MM/DD/YYYY" value="<?php print $wiseIntakeDemoDateOfBirth; ?>" required="required">
											
											<!-- Primary Phone Number -->
											<label for="wiseIntakeDemoPrimaryPhoneNumber" class="padding-top-10">Primary phone number: <span class="form-error">*</span>
														<?php
														//if there is an error for this element, print it. otherwise, print an empty string.
														print (empty($errorArray['wiseIntakeDemoPrimaryPhoneNumber'])) ? '' : '<br />' . $errorArray['wiseIntakeDemoPrimaryPhoneNumber'];
														?></label>
											<input type="text" class="form-control" id="wiseIntakeDemoPrimaryPhoneNumber" name="wiseIntakeDemoPrimaryPhoneNumber"
														placeholder="Phone Number" value="<?php print $wiseIntakeDemoPrimaryPhoneNumber; ?>" required="required">
											
											<!-- Preferred Email: -->
											<label for="wiseIntakeDemoPreferredEmail" class="padding-top-10">Preferred email: <span class="form-error">*</span>
														<?php
														//if there is an error for this element, print it. otherwise, print an empty string.
														print (empty($errorArray['wiseIntakeDemoPreferredEmail'])) ? '' : '<br />' . $errorArray['wiseIntakeDemoPreferredEmail'];
														?></label>
											<input type="email" class="form-control" id="wiseIntakeDemoPreferredEmail" name="wiseIntakeDemoPreferredEmail"
														placeholder="Email Address" value="<?php print $wiseIntakeDemoPreferredEmail; ?>" required="required">
										</div>
										
										<!-- Middle Column -->
										<div class="col-xs-12 col-sm-4">
											<!-- Race -->
											<fieldset>
												<legend class="serif-font no-padding-top">Race: <span class="form-error">*</span><br />
																<span class="sub-legend">(Choose the one that best applies)
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeDemoRace'])) ? '' : '<br />' . $errorArray['wiseIntakeDemoRace'];
															?></span></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeDemoRace', $demoRaceRadio, 'radio', $wiseIntakeDemoRace);
												?>
											</fieldset>
											
											<!-- Disability -->
											<fieldset>
												<legend class="serif-font no-padding-top">Do you have any disability? <span class="form-error">*</span>
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeDemoDisability'])) ? '' : '<br /><span class="sub-legend">' .
															$errorArray['wiseIntakeDemoDisability'];
															?></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeDemoDisability', $yesNoRadio, 'radio', $wiseIntakeDemoDisability);
												?>
											</fieldset>
										</div>
										
										<!-- Right Column -->
										<div class="col-xs-12 col-sm-4">
											<!-- Pell Grant Eligibility -->
											<fieldset>
												<legend class="serif-font no-padding-top">Are you Pell Grant eligible? <span class="form-error">*</span>
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeDemoPellGrant'])) ? '' : '<br /><span class="sub-legend">' .
															$errorArray['wiseIntakeDemoPellGrant'];
															?></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeDemoPellGrant', $yesNoIDoNotKnowRadio, 'radio', $wiseIntakeDemoPellGrant);
												?>
											</fieldset>
											
											<!-- TAA Eligibility -->
											<fieldset>
												<legend class="serif-font no-padding-top">Are you TAA eligible? <span class="form-error">*</span>
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeDemoTAA'])) ? '' : '<br /><span class="sub-legend">' .
															$errorArray['wiseIntakeDemoTAA'];
															?></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeDemoTAA', $yesNoIDoNotKnowRadio, 'radio', $wiseIntakeDemoTAA);
												?>
											</fieldset>
											
											<!-- Eligible Veteran -->
											<fieldset>
												<legend class="serif-font no-padding-top">Are you an Eligible Veteran? <span class="form-error">*</span>
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeDemoEligibleVeteran'])) ? '' : '<br /><span class="sub-legend">' .
															$errorArray['wiseIntakeDemoEligibleVeteran'];
															?></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeDemoEligibleVeteran', $yesNoRadio, 'radio', $wiseIntakeDemoEligibleVeteran);
												?>
											</fieldset>
											
											<!-- Spouse of Eligible Veteran -->
											<fieldset>
												<legend class="serif-font no-padding-top">Are you the Spouse of an Eligible Veteran? <span class="form-error">*</span>
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeDemoSpouseOfEligibleVeteran'])) ? '' : '<br /><span class="sub-legend">' .
															$errorArray['wiseIntakeDemoSpouseOfEligibleVeteran'];
															?></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeDemoSpouseOfEligibleVeteran', $yesNoRadio, 'radio', $wiseIntakeDemoSpouseOfEligibleVeteran);
												?>
											</fieldset>
										</div>
									</div>
									<!-- End Demographic Row 1 -->
								</div>
							</fieldset>
						</div>
					</div>
					<!-- End Demographic Area -->
					
					<!-- Employment Information Area -->
					<div class="row">
						<div class="col-xs-12">
							<fieldset>
								<legend class="serif-font no-padding-top">Employment Information</legend>
								<div class="form-group">
									<!-- Employment Row 1 -->
									<div class="row">
										<!-- Left Column -->
										<div class="col-xs-12 col-sm-4">
											<!-- Employment Status -->
											<fieldset>
												<legend class="serif-font no-padding-top">Employment Status: <span class="form-error">*</span><br />
															<span class="sub-legend">(Choose one)
															<?php
															//if there is an error for this element, print it. otherwise, print an empty string.
															print (empty($errorArray['wiseIntakeEmploymentStatus'])) ? '' : '<br />' . $errorArray['wiseIntakeEmploymentStatus'];
															?></span></legend>
												<?php
												//create the radio list using the create_radio_checkbox_list function.
												create_radio_checkbox_list('wiseIntakeEmploymentStatus', $employmentStatusRadio, 'radio', $wiseIntakeEmploymentStatus);
												?>
											</fieldset>
										</div>
										
										<!-- Large Right Column -->
										<div class="col-xs-12 col-sm-8">
											<fieldset>
												<legend class="serif-font no-padding-top">If Employed:</legend>
												<div class="row">
													<!-- Left Sub-column -->
													<div class="col-xs-6">
														<!-- Employer Name -->
														<label for="wiseIntakeEmployerName">Name of Employer
																	<?php
																	//if there is an error for this element, print it. otherwise, print an empty string.
																	print (empty($errorArray['wiseIntakeEmployerName'])) ? '' : '<br />' . $errorArray['wiseIntakeEmployerName'];
																	?></label>
														<input type="text" class="form-control" id="wiseIntakeEmployerName" name="wiseIntakeEmployerName"
																placeholder="Employer Name" value="<?php print $wiseIntakeEmployerName; ?>">
														
														<!-- Employment Start Date -->
														<label for="wiseIntakeEmploymentStartDate" class="padding-top-10">Start Date (MM/YYYY):
																	<?php
																	//if there is an error for this element, print it. otherwise, print an empty string.
																	print (empty($errorArray['wiseIntakeEmploymentStartDate'])) ? '' : '<br />' . $errorArray['wiseIntakeEmploymentStartDate'];
																	?></label>
														<input type="text" class="form-control" id="wiseIntakeEmploymentStartDate" name="wiseIntakeEmploymentStartDate"
																placeholder="MM/YYYY" value="<?php print $wiseIntakeEmploymentStartDate; ?>">
													</div>
													
													<!-- Right Sub-column -->
													<div class="col-xs-6">
														<!-- Employment Hours per Week -->
														<label for="wiseIntakeEmploymentHoursPerWeek">Hours/week:
																	<?php
																	//if there is an error for this element, print it. otherwise, print an empty string.
																	print (empty($errorArray['wiseIntakeEmploymentHoursPerWeek'])) ? '' : '<br />' . $errorArray['wiseIntakeEmploymentHoursPerWeek'];
																	?></label>
														<input type="number" class="form-control" id="wiseIntakeEmploymentHoursPerWeek" name="wiseIntakeEmploymentHoursPerWeek"
																placeholder="Hours/week" value="<?php print $wiseIntakeEmploymentHoursPerWeek; ?>">
														
														<!-- Current Salary -->
														<label for="wiseIntakeEmploymentCurrentSalary" class="padding-top-10">Current salary:
																	<?php
																	//if there is an error for this element, print it. otherwise, print an empty string.
																	print (empty($errorArray['wiseIntakeEmploymentCurrentSalary'])) ? '' : '<br />' . $errorArray['wiseIntakeEmploymentCurrentSalary'];
																	?></label>
														<input type="text" class="form-control" id="wiseIntakeEmploymentCurrentSalary" name="wiseIntakeEmploymentCurrentSalary"
																placeholder="Current Salary" value="<?php print $wiseIntakeEmploymentCurrentSalary; ?>">
													</div>
												</div>
											</fieldset>
										</div>
									</div>
									<!-- End Employment Row 1 -->
								</div>
							</fieldset>
						</div>
					</div>
					<!-- End Employment Information Area -->
					
					<hr />
					
					<!-- Verification Checkbox Area -->
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<div class="checkbox verify-statement">
									<?php
									//if the checkbox was not selected, print an error.
									print (empty($errorArray['verifyQuestionnaire'])) ? '' : '<p>' . $errorArray['verifyQuestionnaire'] . '</p>';
									?>
									<label for="verifyQuestionnaire"><input type="checkbox" id="verifyQuestionnaire" name="verifyQuestionnaire"
									value="verifyQuestionnaire" <?php print (empty($verifyQuestionnaire)) ? '' : 'checked'; ?>>
									<strong>I hereby verify that the
									information I have provided is true and correct to the best
									of my knowledge.</strong></label>
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