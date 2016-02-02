/*
	This file contains the MySQL code to create the tables needed for the
	WISE intake form. It also inserts options into the intended_program_options table.
*/

/*This is the database that is used for the entire wise-intake form*/
USE alexb_wise_intake;

DROP TABLE IF EXISTS wise_form_intake_entries;
DROP TABLE IF EXISTS intended_program_options;
DROP TABLE IF EXISTS entries_to_program_options;

/*table for the data from the wise intake form*/
CREATE TABLE wise_form_intake_entries (
	/*primary key*/
	entry_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	
	/*top box form stuff:*/
	first_name VARCHAR(100) NOT NULL,
	middle_initial CHAR(1),
	last_name VARCHAR(100) NOT NULL,
	student_id BIGINT(10) UNSIGNED ZEROFILL NOT NULL, /*digits only. bigint allows for 19 digits. */
	course VARCHAR(100) NOT NULL, /*not sure; probably a “name of course” field.*/
	
	/*education information:*/
	educational_background VARCHAR(30) NOT NULL,
	educational_goals VARCHAR(30) NOT NULL,
	current_credits VARCHAR(30) NOT NULL, /*save as full or part*/
	/*intended programs are in another table due to many to many relationship*/
	
	/*demographic information:*/
	gender CHAR(1) NOT NULL, /*save as m/f/o*/
	date_of_birth DATE NOT NULL, /*mm/dd/yyyy but stored as date with yyyy-mm-dd*/
	race VARCHAR(30) NOT NULL,
	has_disability CHAR(1) NOT NULL, /*stored as y/n*/
	primary_phone_number VARCHAR(30) NOT NULL,
	preferred_email VARCHAR(100) NOT NULL,
	
	/*eligibility information:*/
	pell_grant_eligibility CHAR(1) NOT NULL, /*stored as y/n/o (where o is for “i don’t know”*/
	taa_eligibility CHAR(1) NOT NULL, /*stored as y/n/o (where o is for “i don’t know”*/
	eligible_veteran CHAR(1) NOT NULL, /*stored as y/n*/
	spouse_of_eligible_veteran CHAR(1) NOT NULL, /*stored as y/n*/
	
	/*employment information:*/
	employment_status VARCHAR(30) NOT NULL,
	name_of_employer VARCHAR(200),
	start_date VARCHAR(30), /*(mm/yyyy)*/
	hours_per_week TINYINT UNSIGNED, /*0 to 255 hours which is more than 7*24=168 */
	current_salary VARCHAR(30), /*just in case users want to type “x dollars” or “$xxxx”*/
	
	/*forms submitted (based off of the "verify" checkbox in each part)
	if the "verify" values are not submitted, these columns default to n*/
	intake_questionnaire CHAR(1) NOT NULL DEFAULT 'n', /*store as y/n*/
	equal_opportunity CHAR(1) NOT NULL DEFAULT 'n', /*store as y/n*/
	ferpa CHAR(1) NOT NULL DEFAULT 'n', /*store as y/n*/
	
	timestamp DATETIME NOT NULL
);

/*table for intended program options*/
CREATE TABLE intended_program_options (
	program_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	program_option VARCHAR(100) NOT NULL
);

/*since there is a many to many relationship,
	we need a junction table between entries and program options.
*/
CREATE TABLE entries_to_program_options (
	entry_id INT UNSIGNED NOT NULL,
	program_id INT UNSIGNED NOT NULL,
	
	FOREIGN KEY (entry_id) REFERENCES wise_form_intake_entries(entry_id),
	FOREIGN KEY (program_id) REFERENCES intended_program_options(program_id),
	PRIMARY KEY (entry_id, program_id)
);

/*fill the intended_program_options table with the default options from the form.
note that the options here are entered in the same order as
they are shown in the form. if users choose "undecided/other", then
their specified answers will be added to this table and the junction table.*/
INSERT INTO intended_program_options
(program_option)
VALUES
('MTX - Mechatronics Maintenance 1 (Certificate)'),
('MTX - Mechatronics Maintenance 2 (Certificate)'),
('BUS - Business Foundations (Certificate)'),
('BUS - Customer Services Representative (Certificate)'),
('BUS - Management & Supervision (Certificate)'),
('BUS - Marketing and Sales (Certificate)'),
('BUS - Retail Management (Certificate)'),
('BUS - Associate in Applied Arts (Degree)'),
('BUS - Bachelor of Applied Sciences (Degree)'),
('MTX - Associate in Applied Science (Degree)'),
('Undecided or Other (specify):');



