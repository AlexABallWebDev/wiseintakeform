<div class="row">
	<div id="header" class="row">
		<div class="col-xs-12">
			<!-- Green River College logo -->
			<div id="grc-logo" class="pull-left">
				<img src="images/grc-logo.jpg" alt="Green River College" />
			</div>
			
			<!-- WISE logo -->
			<div id="wise-logo" class="pull-right">
				<img src="images/wise-logo.jpg" alt="Washington Integrated Sector Employment (WISE)" />
			</div>
		</div>
		
		<!-- Title of the Website -->
		<div class="col-xs-12">
			<div id="title-heading" class="text-center serif-font">
				<?php
				if (isset($isTablePage))
				{
					print '<h2>Wise Student Intake Table of Entries</h2>';
				}
				else
				{
					print '<h2>Wise Student Intake Form</h2>';
				}
				?>
			</div>
		</div>
	</div>
</div>