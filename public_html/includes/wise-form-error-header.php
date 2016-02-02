<?php
//if the form was submitted and there was an error, then a
//big message is displayed saying that something went wrong.
if (isset($errorArray) && !empty($errorArray))
{
	print '<div class="row">';
	print '<!-- Title of the page -->';
	print '<div class="col-xs-12">';
	print '<div class="text-center">';
	print '<h4 class="form-error">Form Error!</h4>';
	print '<h4 class="form-error">Make sure that all required parts of the form are completed!</h4>';
	print '</div>';
	print '</div>';
	print '</div>';
}
?>