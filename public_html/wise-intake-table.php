<?php
/*Author: Alex Ball
 *Date: 12/06/2015
 *IT 305 Final Project
 *WISE Intake Form
 *
 *Filename: wise-intake-table.php
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

//start the session so that form data can be saved across pages
session_start();

//require functions list
require('includes/functions.php');

//define the options for the radio/checkbox lists
require('includes/wise-form-list-arrays.php');

//this variable tells the header to appear differently (rather than "form" it will say "table").
$isTablePage = true;

//if not admin, redirect to login page
if (!(isset($_SESSION['admin']) && $_SESSION['admin'] == 'wise-admin'))
{
	header('location: wise-intake-table-login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--	Author: Alex Ball
					Date: 12/06/2015
					IT 305 Final Project
					WISE Intake Form
					
					Filename: wise-intake-table.php
					
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
		
		<title>WISE Intake Table of Entries</title>
	
		<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<!-- Datatable -->
		<link href="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
		
		<!-- WISE intake form CSS -->
		<link href="includes/wise-style.css" rel="stylesheet">
		
	</head>
	<body>
		<!--	Content Area	-->
		<div class="container">
			<!-- Header Area -->
			<?php require('includes/wise-header.php'); ?>
			<!-- End Header Area -->
			
			<!-- Link to Excel csv table export file -->
			<div class="row text-center">
				<a href="wise-intake-report.csv">Click here to download an Excel csv version of this table.</a>
			</div>
			
			<!-- Table Area -->
			<div class="row">
				<table class="table table-striped table-bordered" id="wise-intake-entry-table">
					<thead>
						<tr>
							<th>Student ID</th>
							<th>First Name</th>
							<th>Middle Initial</th>
							<th>Last Name</th>
							<th>Course</th>
							<th>Educational Background</th>
							<th>Educational Goal</th>
							<th>Educational Current Status</th>
							<th>Intended Programs</th>
							<th>Gender</th>
							<th>Date of Birth</th>
							<th>Primary Phone Number</th>
							<th>Preferred Email</th>
							<th>Race</th>
							<th>Disability?</th>
							<th>Pell Grant eligible?</th>
							<th>TAA eligible?</th>
							<th>Eligible Veteran?</th>
							<th>Spouse of Eligible Veteran?</th>
							<th>Employment Status</th>
							<th>Employer Name</th>
							<th>Employment Start Date</th>
							<th>Employment Hours per Week</th>
							<th>Current Salary</th>
							<th>Entry Questionnaire on file?</th>
							<th>Equal Opportunity Statement on file?</th>
							<th>FERPA on file?</th>
							<th>Entry Submitted Timestamp</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>Student ID</th>
							<th>First Name</th>
							<th>Middle Initial</th>
							<th>Last Name</th>
							<th>Course</th>
							<th>Educational Background</th>
							<th>Educational Goal</th>
							<th>Educational Current Status</th>
							<th>Intended Programs</th>
							<th>Gender</th>
							<th>Date of Birth</th>
							<th>Primary Phone Number</th>
							<th>Preferred Email</th>
							<th>Race</th>
							<th>Disability?</th>
							<th>Pell Grant eligible?</th>
							<th>TAA eligible?</th>
							<th>Eligible Veteran?</th>
							<th>Spouse of Eligible Veteran?</th>
							<th>Employment Status</th>
							<th>Employer Name</th>
							<th>Employment Start Date</th>
							<th>Employment Hours per Week</th>
							<th>Current Salary</th>
							<th>Entry Questionnaire on File?</th>
							<th>Equal Opportunity Statement on file?</th>
							<th>FERPA on file?</th>
							<th>Entry Submitted Timestamp</th>
						</tr>
					</tfoot>

					<tbody>
						<?php
						//get database connection named $wiseDBConnection
						require "../secure-includes/wise-intake-db-connection.php";
						
						$sql = 'SELECT * FROM wise_form_intake_entries ORDER BY timestamp DESC';
						
						if ($result = @mysqli_query($wiseDBConnection, $sql))
						{
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
									foreach($intendedProgramResults as $program)
									{
										//add each program from the list into a single string
										$intendedProgramsList = $intendedProgramsList . $program['program_option'] . ' <br />';
									}
								}
								else
								{
									$intendedProgramsList = 'Error retrieving intended programs';
								}
								
								//prepare date of birth so that it is printed the same way it was entered into the form
								$dateOfBirth = date('m/d/Y', strtotime($row['date_of_birth']));
								
								//print data to table
								print '<tr>';
								print '<td>' . $row['student_id'] . '</td>';
								print '<td>' . $row['first_name'] . '</td>';
								print '<td>' . $row['middle_initial'] . '</td>';
								print '<td>' . $row['last_name'] . '</td>';
								print '<td>' . $row['course'] . '</td>';
								print '<td>' . $row['educational_background'] . '</td>';
								print '<td>' . $row['educational_goals'] . '</td>';
								print '<td>' . $row['current_credits'] . '</td>';
								print '<td>' . $intendedProgramsList . '</td>';
								print '<td>' . $row['gender'] . '</td>';
								print '<td>' . $dateOfBirth . '</td>';
								print '<td>' . $row['primary_phone_number'] . '</td>';
								print '<td>' . $row['preferred_email'] . '</td>';
								print '<td>' . $row['race'] . '</td>';
								print '<td>' . $row['has_disability'] . '</td>';
								print '<td>' . $row['pell_grant_eligibility'] . '</td>';
								print '<td>' . $row['taa_eligibility'] . '</td>';
								print '<td>' . $row['eligible_veteran'] . '</td>';
								print '<td>' . $row['spouse_of_eligible_veteran'] . '</td>';
								print '<td>' . $row['employment_status'] . '</td>';
								print '<td>' . $row['name_of_employer'] . '</td>';
								print '<td>' . $row['start_date'] . '</td>';
								print '<td>' . $row['hours_per_week'] . '</td>';
								print '<td>' . $row['current_salary'] . '</td>';
								print '<td>' . $row['intake_questionnaire'] . '</td>';
								print '<td>' . $row['equal_opportunity'] . '</td>';
								print '<td>' . $row['ferpa'] . '</td>';
								print '<td>' . $row['timestamp'] . '</td>';
								print '</tr>';
							}
						}
						else
						{
							echo "<tr><td>Error: Failed to retrive data.</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<!-- End Table Area -->
			
			<!-- Footer Area -->
			<?php include('includes/wise-intake-footer.php'); ?>
			<!-- End Footer Area -->
		</div>
		<!--	End Content Area -->
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script language="JavaScript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		
		<!-- Datatable -->
		<script language="JavaScript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"
					type="text/javascript"></script>
		
		<script>
			$(document).ready(function(){
				$('#wise-intake-entry-table').DataTable({
					scrollX: true,
					//defining the intended programs column to be extra wide
					//so that the rows are not super tall.
					"columnDefs": [ {
						"targets": 8,
						"width": 400
					} ],
					//default sorting by timestamp:
					//most recent entry at the top of the table.
					"order": [[ 27, "desc" ]]
				});
			});
		</script>
	</body>	
</html>