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
	$wiseIntakeLName = $_POST['wiseIntakeLName'];
	$wiseIntakeStudentID = $_POST['wiseIntakeStudentID'];
	$wiseIntakeFName = $_POST['wiseIntakeFName'];
	$wiseIntakeCourse = $_POST['wiseIntakeCourse'];
	$wiseIntakeMInitial = $_POST['wiseIntakeMInitial']; //optional
	
	//radio and checkboxes are retrieved with a check function; simply used to reduce code
	//redundancy and reduce the number of if empty/else statements here. if a radio/checkbox
	//is empty, then that radio/checkbox's variable will contain an empty string.
	$wiseIntakeEduBackground = wise_check_radio_data('wiseIntakeEduBackground');
	$wiseIntakeEduGoal = wise_check_radio_data('wiseIntakeEduGoal');
	$wiseIntakeEduCurrentStatus = wise_check_radio_data('wiseIntakeEduCurrentStatus');
	
	//since the intended programs item is the only checkbox item in this entire form,
	//no function was created for its validation.
	//if no intended program was chosen, send an error message and set the variable to an empty array.
	//otherwise, assign the array to a variable.
	if (empty($_POST['wiseIntakeIntendedPrograms']))
	{
		$errorArray['wiseIntakeIntendedPrograms'] = '<span class="form-error">You must choose at least one Intended Program!</span>';
		$wiseIntakeIntendedPrograms = array();
	}
	else
	{
		$wiseIntakeIntendedPrograms = $_POST['wiseIntakeIntendedPrograms'];
		
		//check if the "undecided/other" box was checked
		foreach($wiseIntakeIntendedPrograms as $checkProgramForOther)
		{
			//if "undecided/other" was checked, get the value that the user assigned.
			if (array_search($checkProgramForOther, $intendedProgramsCheckboxes) == $intendedProgramsOtherOptionNumber)
			{
				$wiseIntakeIntendedProgramOther = $_POST['wiseIntakeIntendedProgramOther'];
				$isOtherProgramGiven = true;
			}
		}
	}
	
	
	//validate data: required fields cannot be empty.
	//data will be stripped of unsafe values such as html tags
	//(mysql injection checks are made upon submitting
	//the entire form rather than on each of the pages). radio and checkbox list
	//values must be on the allowed array of options (to help prevent spoofing).
	$wiseIntakeLName = wise_validate('wiseIntakeLName', 'Last Name cannot be empty!');
	$wiseIntakeStudentID = wise_validate('wiseIntakeStudentID', 'Student ID Number cannot be empty!');
	
	//student ID must also be a number, in addition to being not empty
	if (!empty($wiseIntakeStudentID) && !is_numeric($wiseIntakeStudentID))
	{
		$errorArray['wiseIntakeStudentID'] = '<span class="form-error">Student ID may only contain numbers!</span>';
	}
	
	$wiseIntakeFName = wise_validate('wiseIntakeFName', 'First Name cannot be empty!');
	$wiseIntakeCourse = wise_validate('wiseIntakeCourse', 'Course cannot be empty!');
	$wiseIntakeMInitial = wise_clean_data($wiseIntakeMInitial); //optional, so it is just cleaned instead of validated.

	$wiseIntakeEduBackground = wise_validate('wiseIntakeEduBackground', 'You must select an Educational Background!');
	$wiseIntakeEduGoal = wise_validate('wiseIntakeEduGoal', 'You must select a Goal!');
	$wiseIntakeEduCurrentStatus = wise_validate('wiseIntakeEduCurrentStatus', 'You must select your Current Status!');
	//intended programs was checked during variable assignment
	
	
	//check radio/checkbox data to make sure it is in the allowed array of options. (helps prevent spoofing)
	//only add the error if we know there is no current error for this input.
	wise_validate_radio_checkbox_spoofing($wiseIntakeEduBackground, 'wiseIntakeEduBackground', $eduBackgroundRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeEduGoal, 'wiseIntakeEduGoal', $eduGoalRadio);
	wise_validate_radio_checkbox_spoofing($wiseIntakeEduCurrentStatus, 'wiseIntakeEduCurrentStatus', $eduCurrentStatusRadio);
	
	//for the checkbox list, check each selected option to make sure it is on the list of actual options.
	//note that if the array is empty, no error will be added here.
	foreach ($wiseIntakeIntendedPrograms as $SelectedIntendedProgramOption)
	{
		wise_validate_radio_checkbox_spoofing($SelectedIntendedProgramOption, 'wiseIntakeIntendedPrograms', $intendedProgramsCheckboxes);
	}
	
	//if ""undecided/other" was checked, validate to make sure that the "other" value is not empty.
	if (isset($isOtherProgramGiven))
	{
		wise_validate('wiseIntakeIntendedProgramOther', 'You must specify your "other" program!');
	}
	
	
	//if required fields are not empty and data is valid, add the data for this form to the session array,
	//then redirect user to either the previous or next page (since this is page 1, redirect only to page 2).
	if (empty($errorArray))
	{
		$_SESSION['wiseIntakeLName'] = $wiseIntakeLName;
		$_SESSION['wiseIntakeStudentID'] = $wiseIntakeStudentID;
		$_SESSION['wiseIntakeFName'] = $wiseIntakeFName;
		$_SESSION['wiseIntakeCourse'] = $wiseIntakeCourse;
		//optional, only add to session if not empty
		if (!empty($wiseIntakeMInitial))
		{
			$_SESSION['wiseIntakeMInitial'] = $wiseIntakeMInitial;
		}
		
		$_SESSION['wiseIntakeEduBackground'] = $wiseIntakeEduBackground;
		$_SESSION['wiseIntakeEduGoal'] = $wiseIntakeEduGoal;
		$_SESSION['wiseIntakeEduCurrentStatus'] = $wiseIntakeEduCurrentStatus;
		$_SESSION['wiseIntakeIntendedPrograms'] = $wiseIntakeIntendedPrograms;
		$_SESSION['wiseIntakeIntendedProgramOther'] = $wiseIntakeIntendedProgramOther;
		
		//there is no previous page as this is page 1, so just redirect to page 2.
		header('location: wise-intake-form-2.php');
	}
}
