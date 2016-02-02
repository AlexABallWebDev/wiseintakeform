<div class="row">
	<div class="col-xs-12 page-swap">
		<?php
		//for pages that are not the entry table, show the page number and form submit "previous"
		//and "next" buttons that submit the form with a submit value of "previous" or "next"
		if ($pageNumber != 5)
		{
			//print previous button for all pages except the first.
			if ($pageNumber != 1)
			{
				print '<button class="previous-page" value="previous" type="submit" name="submit">Previous</button>';
			}
			
			//print "page n of m"
			print "This is page $pageNumber of 4";
			
			if ($pageNumber != 4)
			{
				print '<button class="next-page" value="next" type="submit" name="submit">Next</button>';
			}
			//if this is the last page, show submit form button instead of next
			else
			{
				print '<button class="next-page" value="next" type="submit" name="submit">Submit Form</button>';
			}
		}
		//for the entry table page, show the page number and a link to go back to page 1 of the form
		if ($pageNumber == 5)
		{
			print "<p>This is page $pageNumber of 5</p>";
			print '<a href="index.php"
						class="black-text"><button value="previous">Back to Form page 1</button></a>';
		}
		?>
	</div>
</div>