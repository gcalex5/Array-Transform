<?php
//Open a session so we can utilize $_SESSION for recursion
session_start(); //Not needed if it was in Drupal

//Define the given input
$input_one = array(
  "1" => "One",
  "2" => "Two",
  "3" => "Three",
);

$input_two = array(
  "2" => array(
    "1" => "This Text",
    "2" => "Is not related",
    "3" => "To the key that it is associated with",
  ),
  "3" => "You can have values on different levels",
);

//Ensure our session variable isn't improperly set and transform the input
cleanSession();
$output_one = transform($input_one);
cleanSession();
$output_two = transform($input_two);

//Echo the output
echo ($output_one);
echo ($output_two);

/**
 * Transform the arrays into lists
 *
 * @param $array_input -> Pre-defined input
 * @return string -> HTML markup
 */
function transform($array_input){
  if(isset($_SESSION['array_transform']['markup']) &&
    !empty($_SESSION['array_transform']['markup'])){
    $markup = $_SESSION['array_transform']['markup'];
  }
  else if(!isset($markup)){
    $markup="<ul>";
  }
  foreach($array_input as $arr){
    $markup.= "<li>";
    //If we see that our current array row is an array
    //Store our current markup and recursively call the function
    if(is_array($arr) == true){
      $markup.= "<ul>";
      $_SESSION['array_transform']['markup'] = $markup;
      $markup = transform($arr);
    }
    else{
      $markup.= $arr . "</li>";
    }
  }
  $markup.="</ul>";
  return "$markup";
}

function cleanSession(){
  if(isset($_SESSION['array_transform']['markup'])){
    unset($_SESSION['array_transform']['markup']);
  }
}