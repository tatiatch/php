<?php
$errors=array();
function fieldname_as_text($fieldname){
	$fieldname=str_replace("_", " ", $fieldname);
	$fieldname=ucfirst($fieldname);
	return $fieldname;
}
function presence($value){
	return isset($value) && $value !== "";
}
function validate_presence($fields_required){
	global $errors;
	foreach ($fields_required as $field) {
		$value=trim($_POST[$field]);
		if(!presence($value)){
			$errors[$field]=fieldname_as_text($field) . " can't be blanck";
		}
	}
}

function max_length($value, $max){
	return strlen($value)<=$max;
}
function validate_max_length($fields_with_max_length){
	global $errors;
	foreach ($fields_with_max_length as $field => $max) {
		$value=trim($_POST[$field]);
		if(!max_length($value, $max)){
			$errors[$field]=fieldname_as_text($field) . " is too long";
		}
	}
}


function min_length($value, $min){
	return strlen($value)>=$min;
}
function type_string($value){
	return is_string($value);
}
function inclusion_in_set($value, $set=array()){
	return in_array($value, $set);
}
function format($value, $symbol){
	return preg_match("/$symbol/", $value);
}


?>