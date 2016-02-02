<?php
/*defining the radio lists used in the wise-intake form*/

//educational background radio
$eduBackgroundRadio = array('High School not completed',
														'High School/GED',
														'Some College',
														'Associate Degree',
														'Bachelor Degree',
														'Master Degree');

//educational goals radio
$eduGoalRadio = array('Job Skills Upgrade',
											'Career Change',
											'Academic Transfer',
											'Continuing Education',
											'Other');

//educational current status radio
$eduCurrentStatusRadio = array('Part-time (11 credits or less)',
															 'Full-time (12 credits or more)');

//intended programs checkbox
$intendedProgramsCheckboxes = array('MTX - Mechatronics Maintenance 1 (Certificate)', //0
																		'MTX - Mechatronics Maintenance 2 (Certificate)',
																		'BUS - Business Foundations (Certificate)',
																		'BUS - Customer Services Representative (Certificate)',
																		'BUS - Management & Supervision (Certificate)',
																		'BUS - Marketing and Sales (Certificate)',
																		'BUS - Retail Management (Certificate)',
																		'BUS - Associate in Applied Arts (Degree)',
																		'BUS - Bachelor of Applied Sciences (Degree)',
																		'MTX - Associate in Applied Science (Degree)',
																		'Undecided or Other (specify):'); //10

//make sure this number matches the position of "undecided or other" on the list above.
//it is used throughout the form, and errors may occur if it does not match.
//Also do not forget to update the SQL intended program options table to match the options in the above array.
$intendedProgramsOtherOptionNumber = 10;

//gender radio
$demoGenderRadio = array('Male',
												 'Female',
												 'Other/Unspecified');

//race radio
$demoRaceRadio = array('Hispanic/Latino',
											 'Asian',
											 'Indian or Alaskan Native',
											 'Black or African American',
											 'Native Hawaiian or other Pacific',
											 'White',
											 'More than One Race',
											 'Other');

//yes or no radio (used for disability, eligible veteran, and spouse of eligible veteran radio lists)
$yesNoRadio = array('Yes',
										'No');

//yes, no, I do not know radio (used for pell grant and TAA radio lists)
$yesNoIDoNotKnowRadio = array('Yes',
															'No',
															'I do not know');

//employment status radio
$employmentStatusRadio = array('Unemployed',
															 'Employed (Full Time)',
															 'Employed (Part Time)',
															 'Intern',
															 'Freelance (contract)');
