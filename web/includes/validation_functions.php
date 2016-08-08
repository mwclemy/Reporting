<?php
$errors=array();


function  fieldname_as_text($fieldname)
{

$replaced_fieldname=str_replace("_"," ",$fieldname);
$ucfieldname=ucfirst($replaced_fieldname);
return $ucfieldname;
}


function has_presence($value)
{
return isset($value) && $value!=="";
}     
function  validate_presences($required_fields)
{
global $errors;
foreach ($required_fields as $field)
{
if( null!== filter_input(INPUT_POST,$field))
{
$value =trim(filter_input(INPUT_POST,$field));
}
else
{
$value="";
}
if(! has_presence($value))
{
$errors[$field]= fieldname_as_text($field) .  "  can't be blank";
}
}
}
function has_max_length($value,$max)
{
return strlen($value) <=$max;
}

function has_exact_length($value,$length)
{
return strlen($value) ===$length;
}

function validate_exact_lengths($fields_with_exact_lengths)
{
global $errors;
foreach ($fields_with_exact_lengths as $field => $length)
{
$value =trim(filter_input(INPUT_POST,$field));
if(!has_exact_length($value,$length))
{
$errors[$field]= fieldname_as_text($field) .  "  is invalid";
}
}
} 
function has_min_length($value,$min)
{
return strlen($value) >=$min;
}

function validate_max_lengths($fields_with_max_lengths)
{
global $errors;
foreach ($fields_with_max_lengths as $field => $max)
{
$value =trim(filter_input(INPUT_POST,$field));
if(!has_max_length($value,$max))
{
$errors[$field]= fieldname_as_text($field) .  "  is too long";
}
}
} 

function validate_min_lengths($fields_with_min_lengths)
{
global $errors;
foreach ($fields_with_min_lengths as $field => $min)
{
$value =trim(filter_input(INPUT_POST,$field));
if(!has_min_length($value,$min))
{
$errors[$field]= fieldname_as_text($field) .  "  is too short";
}
}
} 

