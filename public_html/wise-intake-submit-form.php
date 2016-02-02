<?php
//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start the session so that form data can be saved across pages
session_start();

//require functions
require('includes/functions.php');

//define the options for the radio/checkbox lists
require('includes/wise-form-list-arrays.php');

//data is assumed valid unless an error is present in the $errorArray
$errorArray = array();

//get database connection named $wiseDBConnection
require('../secure-includes/wise-intake-db-connection.php');

//since data is validated on the server each time the user uses the next or previous button,
//data in the session array is assumed to be valid.

//get data from the session. anything that will change (such as "yes" to "y", etc.) is marked as "extra formatting".
$wiseIntakeLName = wise_session_item_check('wiseIntakeLName');
$wiseIntakeStudentID = wise_session_item_check('wiseIntakeStudentID');
$wiseIntakeFName = wise_session_item_check('wiseIntakeFName');
$wiseIntakeCourse = wise_session_item_check('wiseIntakeCourse');
$wiseIntakeMInitial = wise_session_item_check('wiseIntakeMInitial'); //optional

$wiseIntakeEduBackground = wise_session_item_check('wiseIntakeEduBackground');
$wiseIntakeEduGoal = wise_session_item_check('wiseIntakeEduGoal');
$wiseIntakeEduCurrentStatus = wise_session_item_check('wiseIntakeEduCurrentStatus'); //extra formatting
$wiseIntakeIntendedPrograms = wise_session_item_check('wiseIntakeIntendedPrograms'); //extra formatting IF other is chosen
$wiseIntakeIntendedProgramOther = wise_session_item_check('wiseIntakeIntendedProgramOther'); //optional, unless an intended program is "other"

$wiseIntakeDemoGender = wise_session_item_check('wiseIntakeDemoGender'); //extra formatting
$wiseIntakeDemoDateOfBirth = wise_session_item_check('wiseIntakeDemoDateOfBirth'); //extra formatting
$wiseIntakeDemoPrimaryPhoneNumber = wise_session_item_check('wiseIntakeDemoPrimaryPhoneNumber');
$wiseIntakeDemoPreferredEmail = wise_session_item_check('wiseIntakeDemoPreferredEmail');
$wiseIntakeDemoRace = wise_session_item_check('wiseIntakeDemoRace');
$wiseIntakeDemoDisability = wise_session_item_check('wiseIntakeDemoDisability'); //extra formatting
$wiseIntakeDemoPellGrant = wise_session_item_check('wiseIntakeDemoPellGrant'); //extra formatting
$wiseIntakeDemoTAA = wise_session_item_check('wiseIntakeDemoTAA'); //extra formatting
$wiseIntakeDemoEligibleVeteran = wise_session_item_check('wiseIntakeDemoEligibleVeteran'); //extra formatting
$wiseIntakeDemoSpouseOfEligibleVeteran = wise_session_item_check('wiseIntakeDemoSpouseOfEligibleVeteran'); //extra formatting

$wiseIntakeEmploymentStatus = wise_session_item_check('wiseIntakeEmploymentStatus');
$wiseIntakeEmployerName = wise_session_item_check('wiseIntakeEmployerName'); //optional
$wiseIntakeEmploymentStartDate = wise_session_item_check('wiseIntakeEmploymentStartDate'); //optional
$wiseIntakeEmploymentHoursPerWeek = wise_session_item_check('wiseIntakeEmploymentHoursPerWeek'); //optional
$wiseIntakeEmploymentCurrentSalary = wise_session_item_check('wiseIntakeEmploymentCurrentSalary'); //optional

$verifyQuestionnaire = wise_session_item_check('verifyQuestionnaire'); //extra formatting
$verifyEqualOpportunityStatement = wise_session_item_check('verifyEqualOpportunityStatement'); //extra formatting
$verifyFERPA = wise_session_item_check('verifyFERPA'); //extra formatting

//validate to make sure that all required fields are not empty. if the user went to this script directly via URL,
//then this script needs to display an error if the form wasnt filled out.
//validate data that does not require extra formatting:
if (empty($wiseIntakeLName) || empty($wiseIntakeStudentID) || empty($wiseIntakeFName) || empty($wiseIntakeCourse)
		|| empty($wiseIntakeEduBackground) || empty($wiseIntakeEduGoal) || empty($wiseIntakeDemoPrimaryPhoneNumber)
		|| empty($wiseIntakeDemoPreferredEmail) || empty($wiseIntakeDemoRace) || empty($wiseIntakeEmploymentStatus))
{
	//a catch-all error is used here, as the user should not be on this page if they
	//did not fill out the form, so specific error information should not be needed.
	$errorArray[] = 'An error occurred: Required user input form data missing';
}

//validating the intended programs and "other" value if it was selected.
//if not empty, no error is entered
if (!empty($wiseIntakeIntendedPrograms))
{
	//check each program to see if it is the "other" program option.
	foreach ($wiseIntakeIntendedPrograms as $checkForOtherProgram)
	{
		//if it is "other", only then do we validate the "other" value provided by the user.
		if (array_search($checkForOtherProgram, $intendedProgramsCheckboxes) == $intendedProgramsOtherOptionNumber)
		{
			if (empty($wiseIntakeIntendedProgramOther))
			{
				$errorArray[] = 'An error occurred: Specified "Other" Intended Program missing';
			}
		}
	}
}
else
{
	$errorArray[] = 'An error occurred: Intended Program(s) missing';
}

//format certain data to be stored in the database.
//errors will be added if any of these are empty as well (validation)
//current status stored as "Part" or "Full"
if ($wiseIntakeEduCurrentStatus == $eduCurrentStatusRadio[0])
{
	$wiseIntakeEduCurrentStatus = 'Part';
}
else if ($wiseIntakeEduCurrentStatus == $eduCurrentStatusRadio[1])
{
	$wiseIntakeEduCurrentStatus = 'Full';
}
else
{
	$errorArray[] = 'An error occurred while formatting current credit status.';
}

//gender is stored as "M" or "F" or "O"
if ($wiseIntakeDemoGender == $demoGenderRadio[0])
{
	$wiseIntakeDemoGender = 'M';
}
else if ($wiseIntakeDemoGender == $demoGenderRadio[1])
{
	$wiseIntakeDemoGender = 'F';
}
else if ($wiseIntakeDemoGender == $demoGenderRadio[2])
{
	$wiseIntakeDemoGender = 'O';
}
else
{
	$errorArray[] = 'An error occurred while formatting gender status.';
}

//date formatting. the validation for page 2 ensures that the date here will
//be in mm/dd/yyyy format. it will be stored in yyyy-mm-dd in a date field in the database.
$wiseIntakeDemoDateOfBirth = date('Y-m-d', strtotime($wiseIntakeDemoDateOfBirth));

//disability is stored as "Y" or "N"
if ($wiseIntakeDemoDisability == $yesNoRadio[0])
{
	$wiseIntakeDemoDisability = 'Y';
}
else if ($wiseIntakeDemoDisability == $yesNoRadio[1])
{
	$wiseIntakeDemoDisability = 'N';
}
else
{
	$errorArray[] = 'An error occurred while formatting disability status.';
}

//Pell grant eligibilty is stored as "Y", "N", or "O" for "I do not know"
if ($wiseIntakeDemoPellGrant == $yesNoIDoNotKnowRadio[0])
{
	$wiseIntakeDemoPellGrant = 'Y';
}
else if ($wiseIntakeDemoPellGrant == $yesNoIDoNotKnowRadio[1])
{
	$wiseIntakeDemoPellGrant = 'N';
}
else if ($wiseIntakeDemoPellGrant == $yesNoIDoNotKnowRadio[2])
{
	$wiseIntakeDemoPellGrant = 'O';
}
else
{
	$errorArray[] = 'An error occurred while formatting Pell Grant eligibility.';
}

//TAA eligibilty is stored as "Y", "N", or "O" for "I do not know"
if ($wiseIntakeDemoTAA == $yesNoIDoNotKnowRadio[0])
{
	$wiseIntakeDemoTAA = 'Y';
}
else if ($wiseIntakeDemoTAA == $yesNoIDoNotKnowRadio[1])
{
	$wiseIntakeDemoTAA = 'N';
}
else if ($wiseIntakeDemoTAA == $yesNoIDoNotKnowRadio[2])
{
	$wiseIntakeDemoTAA = 'O';
}
else
{
	$errorArray[] = 'An error occurred while formatting TAA eligibility.';
}

//eligible veteran is stored as "Y" or "N"
if ($wiseIntakeDemoEligibleVeteran == $yesNoRadio[0])
{
	$wiseIntakeDemoEligibleVeteran = 'Y';
}
else if ($wiseIntakeDemoEligibleVeteran == $yesNoRadio[1])
{
	$wiseIntakeDemoEligibleVeteran = 'N';
}
else
{
	$errorArray[] = 'An error occurred while formatting veteran eligibility status.';
}

//spouse of eligible veteran is stored as "Y" or "N"
if ($wiseIntakeDemoSpouseOfEligibleVeteran == $yesNoRadio[0])
{
	$wiseIntakeDemoSpouseOfEligibleVeteran = 'Y';
}
else if ($wiseIntakeDemoSpouseOfEligibleVeteran == $yesNoRadio[1])
{
	$wiseIntakeDemoSpouseOfEligibleVeteran = 'N';
}
else
{
	$errorArray[] = 'An error occurred while formatting spouse of veteran eligibility status.';
}

//the checkbox for verifying the questionnaire is required on the form, so either a value of Y
//will be stored or an error will be shown.
if (!empty($verifyQuestionnaire))
{
	$verifyQuestionnaire = 'Y';
}
else
{
	$errorArray[] = 'An error occurred: the questionnaire appears to not have been verified via checkbox on page 2.';
}

//the checkbox for verifying the equal opportunity statement is required on the form,
//so either a value of Y will be stored or an error will be shown.
if (!empty($verifyEqualOpportunityStatement))
{
	$verifyEqualOpportunityStatement = 'Y';
}
else
{
	$errorArray[] = 'An error occurred: the Equal Opportunity Statement appears to not have been verified via checkbox on page 3.';
}

//the checkbox for agreeing to FERPA is required on the form, so either a value of Y
//will be stored or an error will be shown.
if (!empty($verifyFERPA))
{
	$verifyFERPA = 'Y';
}
else
{
	$errorArray[] = 'An error occurred: FERPA appears to not have been agreed to via checkbox on page 4.';
}

//write a query to save the data if there are no errors.
if (empty($errorArray))
{
	//escape any data that the user could have entered to help prevent SQL injection
	$wiseIntakeLName = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeLName);
	$wiseIntakeStudentID = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeStudentID);
	$wiseIntakeFName = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeFName);
	$wiseIntakeCourse = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeCourse);
	$wiseIntakeMInitial = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeMInitial);
	//$wiseIntakeIntendedPrograms = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeIntendedPrograms);
	$wiseIntakeDemoDateOfBirth = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeDemoDateOfBirth);
	$wiseIntakeDemoPrimaryPhoneNumber = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeDemoPrimaryPhoneNumber);
	$wiseIntakeDemoPreferredEmail = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeDemoPreferredEmail);
	$wiseIntakeEmployerName = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeEmployerName);
	$wiseIntakeEmploymentStartDate = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeEmploymentStartDate);
	$wiseIntakeEmploymentHoursPerWeek = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeEmploymentHoursPerWeek);
	$wiseIntakeEmploymentCurrentSalary = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeEmploymentCurrentSalary);
	$wiseIntakeIntendedProgramOther = mysqli_real_escape_string($wiseDBConnection, $wiseIntakeIntendedProgramOther);

	//middle initial is optional: if empty, do not add it.
	$middleInitialSQL = '';
	if (!empty($wiseIntakeMInitial))
	{
		$middleInitialSQL = 'middle_initial, ';
		$wiseIntakeMInitial = "'" . $wiseIntakeMInitial . "', ";
	}
	
	//Name of employer is optional: if empty, do not add it.
	$employerNameSQL = '';
	if (!empty($wiseIntakeEmployerName))
	{
		$employerNameSQL = 'name_of_employer, ';
		$wiseIntakeEmployerName = "'" . $wiseIntakeEmployerName . "', ";
	}
	
	//employment start date is optional: if empty, do not add it.
	$employmentStartDateSQL = '';
	if (!empty($wiseIntakeEmploymentStartDate))
	{
		$employmentStartDateSQL = 'start_date, ';
		$wiseIntakeEmploymentStartDate = "'" . $wiseIntakeEmploymentStartDate . "', ";
	}
	
	//employment hours per week is optional: if empty, do not add it.
	$employmentHoursPerWeekSQL = '';
	if (!empty($wiseIntakeEmploymentHoursPerWeek))
	{
		$employmentHoursPerWeekSQL = 'hours_per_week, ';
		$wiseIntakeEmploymentHoursPerWeek = $wiseIntakeEmploymentHoursPerWeek . ', ';
	}
	
	//current salary is optional: if empty, do not add it.
	$employmentCurrentSalarySQL = '';
	if (!empty($wiseIntakeEmploymentCurrentSalary))
	{
		$employmentCurrentSalarySQL = 'current_salary, ';
		$wiseIntakeEmploymentCurrentSalary = "'" . $wiseIntakeEmploymentCurrentSalary . "', ";
	}
	
	//get timestamp
	$timestamp = date('Y-m-d h:i:s', time());
	
	//create the sql query
	//insert and column names
	$sql = 'INSERT INTO wise_form_intake_entries (last_name, student_id, first_name, ' ;
	$sql = $sql . 'course, ' . $middleInitialSQL . 'educational_background, educational_goals, ';
	$sql = $sql . 'current_credits, gender, date_of_birth, race, has_disability, ';
	$sql = $sql . 'primary_phone_number, preferred_email, pell_grant_eligibility, ';
	$sql = $sql . 'taa_eligibility, eligible_veteran, spouse_of_eligible_veteran, ';
	$sql = $sql . 'employment_status, ' . $employerNameSQL . $employmentStartDateSQL;
	$sql = $sql . $employmentHoursPerWeekSQL . $employmentCurrentSalarySQL;
	$sql = $sql . 'intake_questionnaire, equal_opportunity, ferpa, timestamp) ';
	//the values to be inserted. Note that the optional values look odd here, this is due to the formatting
	//above that will leave out optional column data.
	$sql = $sql . "VALUES ('$wiseIntakeLName', $wiseIntakeStudentID, '$wiseIntakeFName', ";
	$sql = $sql . "'$wiseIntakeCourse', $wiseIntakeMInitial '$wiseIntakeEduBackground', ";
	$sql = $sql . "'$wiseIntakeEduGoal', '$wiseIntakeEduCurrentStatus', '$wiseIntakeDemoGender', ";
	$sql = $sql . "'$wiseIntakeDemoDateOfBirth', '$wiseIntakeDemoRace', '$wiseIntakeDemoDisability', ";
	$sql = $sql . "'$wiseIntakeDemoPrimaryPhoneNumber', '$wiseIntakeDemoPreferredEmail', '$wiseIntakeDemoPellGrant', ";
	$sql = $sql . "'$wiseIntakeDemoTAA', '$wiseIntakeDemoEligibleVeteran', '$wiseIntakeDemoSpouseOfEligibleVeteran', ";
	$sql = $sql . "'$wiseIntakeEmploymentStatus', $wiseIntakeEmployerName $wiseIntakeEmploymentStartDate ";
	$sql = $sql . "$wiseIntakeEmploymentHoursPerWeek $wiseIntakeEmploymentCurrentSalary  '$verifyQuestionnaire', ";
	$sql = $sql . "'$verifyEqualOpportunityStatement', '$verifyFERPA', '$timestamp')";

	//execute query
	$results = @mysqli_query($wiseDBConnection, $sql);

	//if an error occurs, print a message.
	if (!$results)
	{
		print('<h3>Error submitting entry. Try again, then contact an administrator for assistance.</h3>');
		$submissionFailed = true;
	}
	else
	{
		//if the intendedProgram is undecided/other, get the user's answer from the session here,
		//then add it to the database as a new program, including updating the junction and program
		//option tables. if not, just add the program's ID and the entry's id to the junction table.

		//get the entry id for the newly added row
		$generatedEntryID = mysqli_insert_id($wiseDBConnection);
		
		foreach ($wiseIntakeIntendedPrograms as $program)
		{
			//get the key for this option. this works because the array used to generate this list has the options
			//in the same order as the insert command in the table creation script.
			$programID = array_search($program, $intendedProgramsCheckboxes);
			
			//mySQL starts counting at 1, so this offset is required to account for that.
			//note: if statement checks if $programID is numeric because of an issue with
			//the array search returning zero (which is considered false) which breaks
			//the next if statement.
			if (is_numeric($programID))
			{
				$programID = $programID + 1;
			}
			
			//if the option is not null AND is not the other option number + 1 (the SQL id for "unspecified/other")
			//simply add it and the entry id to the junction table.
			if ($programID && ($programID != ($intendedProgramsOtherOptionNumber + 1)))
			{
				$sql = 'INSERT INTO entries_to_program_options (entry_id, program_id) ';
				$sql = $sql . "VALUES ($generatedEntryID, $programID)";
				
				//execute query
				$results = @mysqli_query($wiseDBConnection, $sql);
				
				if (!$results)
				{
					print('<h3>Error submitting intended program. Try again, then contact an administrator for assistance.</h3>');
					$submissionFailed = true;
				}
			}
			//if the option is not null AND is the other option number + 1 (the id for "unspecified/other")
			//then add a new program to the program option table and add it and the entry id to the junction table.
			else if ($programID && ($programID == ($intendedProgramsOtherOptionNumber + 1)))
			{
				//add this new "other" program to the program table
				$sql = 'INSERT INTO intended_program_options (program_option) ';
				$sql = $sql . "VALUES ('$wiseIntakeIntendedProgramOther')";
				
				//execute query
				$results = @mysqli_query($wiseDBConnection, $sql);
				
				if (!$results)
				{
					print('<h3>Error submitting "other" intended program to option list. Try again, then contact an administrator for assistance.</h3>');
					$submissionFailed = true;
				}
				else
				{
					//get the generated program_id for the newly added program
					$generatedProgramID = mysqli_insert_id($wiseDBConnection);
					
					//add the new program's id and the entry id to the junction table
					$sql = 'INSERT INTO entries_to_program_options (entry_id, program_id) ';
					$sql = $sql . "VALUES ($generatedEntryID, $generatedProgramID)";
					
					//execute query
					$results = @mysqli_query($wiseDBConnection, $sql);
					
					if (!$results)
					{
						print('<h3>Error submitting "other" intended program. Try again, then contact an administrator for assistance.</h3>');
						$submissionFailed = true;
					}
				}
			}
			//if the option is not in the original intended programs radio array, something is wrong. display error.
			else
			{
				print('<h3>Error submitting intended program: program ID not found. Try again, then contact an administrator for assistance.</h3>');
				$submissionFailed = true;
			}
		}
	}
}
//report errors, if any
else
{
	print '<a href="wise-intake-form-1.php">Go back to form</a>';
	foreach ($errorArray as $error)
	{
		print '<h3>' . $error . '</h3><br />';
	}
	print '<h3>Try submitting the form again, then contact an administrator for assistance.</h3>';
	$submissionFailed = true;
}

//close connection
@mysqli_close($wiseDBConnection);

//if successful, redirect to table page. otherwise, remain on page so user can see errors.
if (!isset($submissionFailed))
{
	//export all entry data in the database to a csv file every time this form is successfully submitted
	require('includes/wise-intake-export-to-csv.php');
	
	//send an email to TOstrander@greenriver.edu every time the form is successfully submitted
	$to = 'Aball6@mail.greenriver.edu';
	$subject = 'Wise Intake Form Submission Alert';
	$message = 'An intake form was successfully submitted via:' . "\n\n";
	$message = $message . 'http://alexb.greenrivertech.net/305/final-project/public_html/wise-intake-form-1.php' . "\n\n";
	$message = $message . 'The csv file containing entry data for the WISE intake form has been updated.' . "\n";
	$message = $message . 'You can download this file and view it in Excel at the following URL:' . "\n\n";
	$message = $message . 'http://alexb.greenrivertech.net/305/final-project/public_html/wise-intake-report.csv';
	$headers = 'From:do-not-reply@wise-intake-form.net';
	$success = mail($to, $subject, $message, $headers);
	
	//used for testing: display error message if the email did not successfully send
	/*if (!$success)
	{
		print 'error sending email!';
	}*/
	
	//destroy the form data in the session, as it has been successfully submitted to the database at this point.
	session_destroy();
	
	//redirect to table page.
	header('location: wise-intake-form-submitted.php');
}

?>