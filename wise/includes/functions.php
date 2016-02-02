<?php
/*This file contains the functions used in the WISE intake form pages.
 */

/*creates a radio or checkbox list using the given name
 *and an array of values. The type must be "radio" or "checkbox".
 *the $checkedOptions is an array of strings representing which
 *boxes should be checked. these strings are the values of the
 *options to be checked.
 */
function create_radio_checkbox_list($itemName, $valueArray, $type, $checkedOptions)
{
	$buttonCount = 0;
	//if this is a checkbox list, then it should submit an array of the selected options.
	$makeArray = '';
	if ($type == 'checkbox')
	{
		$makeArray = '[]';
	}
	
	foreach ($valueArray as $value)
	{
		//buttonCount changes the id of the item to match its position on this list.
		$buttonCount += 1;
		$itemID = $itemName . $buttonCount;
		$item = "<div class='$type'><label for='$itemID'>";
		//the value will be the actual value sent with the form AND will be displayed to the user.
		$item = $item . "<input type='$type' id='$itemID' name='$itemName" . $makeArray . "' value='$value'";
		//if the array contains this item's number, it should be checked.
		if (!empty($checkedOptions) && in_array($value, $checkedOptions))
		{
			$item = $item . ' checked';
		}
		$item = $item . ">$value</label></div>";
		print $item;
	}
}

/*This function cleans data for the WISE intake form. This function will
 *trim spaces and strip tags for the given variable, returning the cleaned version.
 */
function wise_clean_data($item)
{
	//clean item
	$cleanedItem = trim($item);
	$cleanedItem = strip_tags($cleanedItem);
	
	return $cleanedItem;
}

/*This function checks if an $itenName is saved to the session. if it is,
 *return it. otherwise, return an empty string.
 */
function wise_session_item_check($itemName)
{
	if (!empty($_SESSION[$itemName]))
	{
		$item = $_SESSION[$itemName];
	}
	else
	{
		$item = '';
	}
	return $item;
}

/*This function checks if a submitted radio or checkbox form input is empty.
 *The itemName is the given name (name attribute on the form) of the input.
 *If the input is empty, an empty string is returned.
 */
function wise_check_radio_data($itemName)
{
	if (!empty($_POST[$itemName]))
	{
		return $_POST[$itemName];
	}
	else
	{
		return '';
	}
}

/*This function checks if the given $itemName's value in the POST array is empty.
 *If it is empty, an empty string is returned and the $errorMessage is put into a span of
 *class "form-error" in a string, which is placed into the $errorArray, which is assumed to exist.
 */
function wise_validate($itemName, $errorMessage)
{
	global $errorArray;
	
	if (!empty($_POST[$itemName]))
	{
		$item = wise_clean_data($_POST[$itemName]);
		return $item;
	}
	else
	{
		$errorArray[$itemName] = "<span class=\"form-error\">$errorMessage</span>";
		return '';
	}
}

/*This function returns true if $data is in the $validOptions array, false otherwise*/
function wise_validate_radio_checkbox_data($data, $validOptions)
{
	return (in_array($data, $validOptions));
}

/*This function adds an error to $errorArray with a key of $itemName if $item is not in the
 *$validOptions array, and no error is already in $errorArray with a key of $itemName. Does nothing otherwise.
 */
function wise_validate_radio_checkbox_spoofing($item, $itemName, $validOptions)
{
	global $errorArray;
	
	if (!wise_validate_radio_checkbox_data($item, $validOptions) && empty($errorArray[$itemName]))
	{
		$errorArray[$itemName] = '<span class="form-error">You may only choose from the available options!</span>';
	}
}

/*This function validates the format of the given date. returns true if the date matches
 *the format. returns false if the date does not match the format OR if
 *the date cannot exist (41st of October, etc.).
 */
function validateDate($date, $format = 'm/d/Y')
{
	$result = DateTime::createFromFormat($format, $date);
	return $result && $result->format($format) == $date;
}