<?php
/*if the form has been submitted, validate the data for this page. If valid,
 *add the data to the session variable. otherwise, the user must fix any errors
 *that were present.
 *Note: a side effect of this is that the previous and next buttons do not send
 *the user to the previous or next buttons unless this page has valid data.
 */

//check if form was submitted
if (isset($_POST['submit']))
{
	//data is assumed valid unless an error is present in the $errorArray
	$errorArray = array();
	
	//assign data to variables. note that if session variables were assigned before for form stickyness,
	//these POST results will be printed in the form instead of the session variables.
	
	//radio and checkboxes are retrieved with a check function; simply used to reduce code
	//redundancy and reduce the number of if empty/else statements here. if a radio/checkbox
	//is empty, then that radio/checkbox's variable will contain an empty string.
	$wiseIntakeDemoGender = wise_check_radio_data('wiseIntakeDemoGender');
	$wiseIntakeDemoDateOfBirth = $_POST['wiseIntakeDemoDateOfBirth']; //string
	$wiseIntakeDemoPrimaryPhoneNumber = $_POST['wiseIntakeDemoPrimaryPhoneNumber']; //string
	$wiseIntakeDemoPreferredEmail = $_POST['wiseIntakeDemoPreferredEmail']; //string
	$wiseIntakeDemoRace = wise_check_radio_data('wiseIntakeDemoRace');
	$wiseIntakeDemoDisability = wise_check_radio_data('wiseIntakeDemoDisability');
	$wiseIntakeDemoPellGrant = wise_check_radio_data('wiseIntakeDemoPellGrant');
	$wiseIntakeDemoTAA = wise_check_radio_data('wiseIntakeDemoTAA');
	$wiseIntakeDemoEligibleVeteran = wise_check_radio_data('wiseIntakeDemoEligibleVeteran');
	$wiseIntakeDemoSpouseOfEligibleVeteran = wise_check_radio_data('wiseIntakeDemoSpouseOfEligibleVeteran');
	
	$wiseIntakeEmploymentStatus = wise_check_radio_data('wiseIntakeEmploymentStatus');
	$wiseIntakeEmployerName = $_POST['wiseIntakeEmployerName']; //optional string
	$wiseIntakeEmploymentStartDate = $_POST['wiseIntakeEmploymentStartDate']; //optional string
	$wiseIntakeEmploymentHoursPerWeek = $_POST['wiseIntakeEmploymentHoursPerWeek']; //optional string
	$wiseIntakeEmploymentCurrentSalary = $_POST['wiseIntakeEmploymentCurrentSalary']; //optional string
	
	//as a checkbox, this element's variable will be assigned and checked for emptiness without a function.
	if (!empty($_POST['verifyQuestionnaire']))
	{
		$verifyQuestionnaire = $_POST['verifyQuestionnaire'];
	}
	else
	{
		$errorArray['verifyQuestionnaire'] = '<span class="form-error">You must verify the information to continue!</span>';
		$verifyQuestionnaire = array();
	}
	
	//validate data: required fields cannot be empty.
	//data will be stripped of unsafe values such as html tags
	//(mysql injection checks are made upon submitting
	//the entire form rather than on each of the pages). radio and checkbox list
	//values must be on the allowed array of options (to help prevent spoofing).
	$wiseIntakeDemoGender = wise_validate('wiseIntakeDemoGender', 'You must select a Gender!');
	$wiseIntakeDemoDateOfBirth = wise_validate('wiseIntakeDemoDateOfBirth', 'Date of Birth cannot be empty!');
	$wiseIntakeDemoPrimaryPhoneNumber = wise_validate('wiseIntakeDemoPrimaryPhoneNumber', 'Primary Phone Number cannot be empty!');
	$wiseIntakeDemoPreferredEmail = wise_validate('wiseIntakeDemoPreferredEmail', 'Preferred Email cannot be empty!');
	$wiseIntakeDemoRace = wise_validate('wiseIntakeDemoRace', 'You must select a Race!');
	$wiseIntakeDemoDisability = wise_validate('wiseIntakeDemoDisability', 'You must select Yes or No!');
	$wiseIntakeDemoPellGrant = wise_validate('wiseIntakeDemoPellGrant', 'You must select Yes, No, or I do not know!');
	$wiseIntakeDemoTAA = wise_validate('wiseIntakeDemoTAA', 'You must select Yes, No, or I do not know!');
	$wiseIntakeDemoEligibleVeteran = wise_validate('wiseIntakeDemoEligibleVeteran', 'You must select Yes or No!');
	$wiseIntakeDemoSpouseOfEligibleVeteran = wise_validate('wiseIntakeDemoSpouseOfEligibleVeteran', 'You must select Yes or No!');
	
	$wiseIntakeEmploymentStatus = wise_validate('wiseIntakeEmploymentStatus', 'You must select your current Employment Status!');
	//optional data is just cleaned rather than checked for emptiness.
	$wiseIntakeEmployerName = wise_clean_data($_POST['wiseIntakeEmployerName']); //optional string
	$wiseIntakeEmploymentStartDate = wise_clean_data($_POST['wiseIntakeEmploymentStartDate']); //optional string
	$wiseIntakeEmploymentHoursPerWeek = wise_clean_data($_POST['wiseIntakeEmploymentHoursPerWeek']); //optional string
	$wiseIntakeEmploymentCurrentSalary = wise_clean_data($_POST['wiseIntakeEmploymentCurrentSalary']); //optional string
	
	//verify information checkbox was checked during variable assignment.
	
	//validate the date of birth field to make sure it is in mm/dd/yyyy format.
	if (!validateDate($wiseIntakeDemoDateOfBirth, 'm/d/Y'))
	{
		$errorArray['wiseIntakeDemoDateOfBirth'] = '<span class="form-error">Invalid date! Use mm/dd/yyyy format!</span>';
	}
	
	//validate the date of start date field to make sure it is in mm/yyyy format.
	//because its optional, it is only validated if the field is not empty.
	if (!empty($wiseIntakeEmploymentStartDate) && !validateDate($wiseIntakeEmploymentStartDate, 'm/Y'))
	{
		$errorArray['wiseIntakeEmploymentStartDate'] = '<span class="form-error">Invalid date! Use mm/yyyy format!</span>';
	}
	
	//check radio/checkbox data to make sure it is in the allowed array of options. (helps prevent spoofing)
	//only add the error if we know there is no current error for this input.
	wise_validate_radio_checkbox_spoofing($wiseIntakeDemoGender, 'wiseIntakeDemoGender', $demoGenderRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeDemoRace, 'wiseIntakeDemoRace', $demoRaceRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeDemoDisability, 'wiseIntakeDemoDisability', $yesNoRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeDemoPellGrant, 'wiseIntakeDemoPellGrant', $yesNoIDoNotKnowRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeDemoTAA, 'wiseIntakeDemoTAA', $yesNoIDoNotKnowRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeDemoEligibleVeteran, 'wiseIntakeDemoEligibleVeteran', $yesNoRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeDemoSpouseOfEligibleVeteran, 'wiseIntakeDemoSpouseOfEligibleVeteran', $yesNoRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeEmploymentStatus, 'wiseIntakeEmploymentStatus', $employmentStatusRadio);
	
	//if not empty, the work hours per week must be numeric.
	if (!empty($wiseIntakeEmploymentHoursPerWeek) && !is_numeric($wiseIntakeEmploymentHoursPerWeek))
	{
		$errorArray['wiseIntakeEmploymentHoursPerWeek'] = '<span class="form-error">Hours per week must be a number!</span>';
	}
	
	//the verify information checkbox does not need to be validated; we only need to know that it was set.
	
	//if required fields are not empty and data is valid, add the data for this form to the session array,
	//then redirect user to either the previous or next page.
	if (empty($errorArray))
	{
		$_SESSION['wiseIntakeDemoGender'] = $wiseIntakeDemoGender;
		$_SESSION['wiseIntakeDemoDateOfBirth'] = $wiseIntakeDemoDateOfBirth;
		$_SESSION['wiseIntakeDemoPrimaryPhoneNumber'] = $wiseIntakeDemoPrimaryPhoneNumber;
		$_SESSION['wiseIntakeDemoPreferredEmail'] = $wiseIntakeDemoPreferredEmail;
		$_SESSION['wiseIntakeDemoRace'] = $wiseIntakeDemoRace;
		$_SESSION['wiseIntakeDemoDisability'] = $wiseIntakeDemoDisability;
		$_SESSION['wiseIntakeDemoPellGrant'] = $wiseIntakeDemoPellGrant;
		$_SESSION['wiseIntakeDemoTAA'] = $wiseIntakeDemoTAA;
		$_SESSION['wiseIntakeDemoEligibleVeteran'] = $wiseIntakeDemoEligibleVeteran;
		$_SESSION['wiseIntakeDemoSpouseOfEligibleVeteran'] = $wiseIntakeDemoSpouseOfEligibleVeteran;
		$_SESSION['wiseIntakeEmploymentStatus'] = $wiseIntakeEmploymentStatus;
		//optional, only add to session if not empty
		if (!empty($wiseIntakeEmployerName))
		{
			$_SESSION['wiseIntakeEmployerName'] = $wiseIntakeEmployerName;
		}
		
		if (!empty($wiseIntakeEmploymentStartDate))
		{
			$_SESSION['wiseIntakeEmploymentStartDate'] = $wiseIntakeEmploymentStartDate;
		}
		
		if (!empty($wiseIntakeEmploymentHoursPerWeek))
		{
			$_SESSION['wiseIntakeEmploymentHoursPerWeek'] = $wiseIntakeEmploymentHoursPerWeek;
		}
		
		if (!empty($wiseIntakeEmploymentCurrentSalary))
		{
			$_SESSION['wiseIntakeEmploymentCurrentSalary'] = $wiseIntakeEmploymentCurrentSalary;
		}
		
		$_SESSION['verifyQuestionnaire'] = $verifyQuestionnaire;
		
		
		//if previous button, go back to page 1. if anything else (including next button
		//or the user just hitting the enter key), go to page 3.
		if ($_POST['submit'] == 'previous')
		{
			header('location: index.php');
		}
		else
		{
			header('location: wise-intake-form-3.php');
		}
	}
}
