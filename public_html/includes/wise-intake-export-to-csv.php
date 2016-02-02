<?php
//get database connection named $wiseDBConnection
require "/home/alexb/public_html/305/final-project/secure-includes/wise-intake-db-connection.php";

$sql = 'SELECT * FROM wise_form_intake_entries ORDER BY timestamp DESC';

if ($result = @mysqli_query($wiseDBConnection, $sql))
{
	//open or create the file to be exported to. The previous file, if it exists,
	//will be overwritten with the current data from the database.
	$targetExportFile = fopen('wise-intake-report.csv', 'w');
	
	$columnHeaderArray = array();
	$columnHeaderArray[] = 'SID #';
	$columnHeaderArray[] = 'Last Name';
	$columnHeaderArray[] = 'First Name';
	$columnHeaderArray[] = 'Middle Initial';
	$columnHeaderArray[] = 'Entry Questionnaire on file (Y,N)';
	$columnHeaderArray[] = 'Equal Opportunity Statement on file (Y,N)';
	$columnHeaderArray[] = 'FERPA on file (Y,N)';
	$columnHeaderArray[] = 'Vet Documentation on file if applicable (Y,N)';
	
	$columnHeaderArray[] = 'Home Phone';
	$columnHeaderArray[] = 'Cell Phone';
	$columnHeaderArray[] = 'Email 1';
	$columnHeaderArray[] = 'Email 2';
	
	$columnHeaderArray[] = 'Program Name';
	$columnHeaderArray[] = 'Program Length (6 months,1 year,etc.)';
	$columnHeaderArray[] = 'Program Structure (Stacked, Latticed, N/A)';
	$columnHeaderArray[] = 'Start Quarter of Participant (1-16)';
	$columnHeaderArray[] = 'How many Prior Learning Credits awarded?';
	$columnHeaderArray[] = 'Participant has High School Equivalent (Y,N)';
	
	$columnHeaderArray[] = 'Currently Employed (Incumbent) (Y,N)';
	$columnHeaderArray[] = 'Current Employer Name';
	$columnHeaderArray[] = 'Employment Start Date';
	$columnHeaderArray[] = 'Is this incumbent job associated with program of study? (Y,N)';
	$columnHeaderArray[] = 'Current Incumbent Wage (Total over 6 months)';
	
	$columnHeaderArray[] = 'Identified as Basic Skills Deficient (comp study) (Y,N)';
	$columnHeaderArray[] = 'I-Best Student (Y,N)';
	$columnHeaderArray[] = 'Birthdate';
	$columnHeaderArray[] = 'Gender (F,M,O)';
	$columnHeaderArray[] = 'Disabled Status (Y,N)';
	$columnHeaderArray[] = 'Veteran Status (No,Active,Guard,reserve,Discharged)';
	$columnHeaderArray[] = 'Ethnicity (Use Drop Down)';
	$columnHeaderArray[] = 'Full (12 Cr or more) Part (11 Cr or less) (Full,Part)';
	$columnHeaderArray[] = 'TAA Eligible (Y,N,O (I do not know))';
	$columnHeaderArray[] = 'Pell Grant Eligible (Y,N,O (I do not know))';
	$columnHeaderArray[] = 'Foreign Student (Y,N)';
	
	//write the column header row to the file
	fputcsv($targetExportFile, $columnHeaderArray);
	
	
	//for each entry, add it to the csv file
	foreach($result as $row)
	{
		//prepare intended programs, because there can be multiple results here
		$intendedProgramSQL = 'SELECT intended_program_options.program_option
					FROM intended_program_options, entries_to_program_options
					WHERE intended_program_options.program_id = entries_to_program_options.program_id
					AND entries_to_program_options.entry_id = ' . $row['entry_id'];
		
		//each program found for the entry will be put into a single string. each program
		//will be displayed in the same cell.
		$intendedProgramsList = '';
		if ($intendedProgramResults = @mysqli_query($wiseDBConnection, $intendedProgramSQL))
		{
			$firstProgramAdded = true;
			foreach($intendedProgramResults as $program)
			{
				//the first program added does not have a ampersand (&) before it.
				//every other program afterwards will have an ampersand before it to
				//separate each program.
				if (!$firstProgramAdded)
				{
					$intendedProgramsList = $intendedProgramsList . ' & ';
				}
				//add each program from the list into a single string
				$intendedProgramsList = $intendedProgramsList . $program['program_option'];
				
				//if a program just got added, future programs are not the first program.
				$firstProgramAdded = false;
			}
		}
		else
		{
			$intendedProgramsList = 'Error retrieving intended programs';
		}
		
		//prepare date of birth so that it is printed the same way it was entered into the form
		$dateOfBirth = date('m/d/Y', strtotime($row['date_of_birth']));
		
		//put elements into an array in the order specified in the acceptance criteria, according
		//to attachment 4: format for excel sheet report.
		$exportArray = array();
		$exportArray[] = $row['student_id'];
		$exportArray[] = $row['last_name'];
		$exportArray[] = $row['first_name'];
		$exportArray[] = $row['middle_initial'];
		$exportArray[] = $row['intake_questionnaire'];
		$exportArray[] = $row['equal_opportunity'];
		$exportArray[] = $row['ferpa'];
		$exportArray[] = ''; //vet documentation: blank column
		
		$exportArray[] = $row['primary_phone_number'];
		$exportArray[] = ''; //cell phone: blank column
		$exportArray[] = $row['preferred_email'];
		$exportArray[] = ''; //email 2: blank column
		
		$exportArray[] = $intendedProgramsList;
		$exportArray[] = ''; //program length: blank column
		$exportArray[] = ''; //program structure: blank column
		$exportArray[] = ''; //start quarter: blank column
		$exportArray[] = ''; //prior learning credits: blank column
		$exportArray[] = ''; //has high school equivalent: blank column
		
		$exportArray[] = $row['employment_status'];
		$exportArray[] = $row['name_of_employer'];
		$exportArray[] = $row['start_date'];
		$exportArray[] = ''; //is incumbent job associated with program: blank column
		$exportArray[] = ''; //current incumbent wage: blank column
		
		$exportArray[] = ''; //basic skills deficient: blank column
		$exportArray[] = ''; //I-Best student: blank column
		$exportArray[] = $dateOfBirth;
		$exportArray[] = $row['gender'];
		$exportArray[] = $row['has_disability'];
		$exportArray[] = $row['eligible_veteran'];
		$exportArray[] = $row['race'];
		$exportArray[] = $row['current_credits'];
		$exportArray[] = $row['taa_eligibility'];
		$exportArray[] = $row['pell_grant_eligibility'];
		$exportArray[] = ''; //foreign student: blank column
		
		//unused data: these columns are not described in attachment 4.
		//$exportArray[] = $row['course'];
		//$exportArray[] = $row['educational_background'];
		//$exportArray[] = $row['educational_goals'];
		//$exportArray[] = $row['spouse_of_eligible_veteran'];
		//$exportArray[] = $row['hours_per_week'];
		//$exportArray[] = $row['current_salary'];
		//$exportArray[] = $row['timestamp'];
		
		
		//write this row to the file
		fputcsv($targetExportFile, $exportArray);
	}
	
	//close the export file
	fclose($targetExportFile);
	
	//used for testing
	//print '<h3>success!</h3>';
}
else
{
	//used for testing; no error message should be displayed normally, as this would
	//break the header redirect in the submit form script.
	//print "<h3>Failed to export data to csv file: error getting data from database</h3>";
}

//close the database connection
@mysqli_close($wiseDBConnection);

?>