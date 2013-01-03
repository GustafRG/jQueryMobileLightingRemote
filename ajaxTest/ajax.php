<?php

/**
 * Description:
 * 
 * Nothing fancy.
 * A small example app using communicating with JSON via ajax 
 * using jQuery, jQuery Mobile and PHP.
 * 
 * The ajax.php page was originally intended to work as a server side
 * test for a Netduino+ application, where a mobile web-app will control ceiling
 * lighting over network. Unsure if i will be using JSON though, as 
 * parsing it on the Netduino is a bit memory intensive!
 * 
 * Author:  Gustaf Rylander Gerdeman, 2013
 * E-mail:  gustaf.rylander-gerdeman@bredband.net
 */
 

header('content-type: application/json; charset=utf-8');

class RGBColor
{
    public $red = null;
    public $green  = null;
    public $blue = null;
}


class Person
{
	public $name = null;
	public $lastname = null;
}

//print_r($_SERVER);

//print $_SERVER["PATH_INFO"];

$person = new Person();
$person->name="Jay";
$person->lastname = "JaySon";

if(isset($_POST["json"]))
{
    $json = $_POST["json"];
}

//looks up called function and calls it
call_user_func(trim($_SERVER["PATH_INFO"], "/"), $json);

// Makes an object from JSON string,
// manipulates the "text" property of the object and
// returns the "same" object with reversed text.
function ajaxCalledFunction($json)
{
    //wait to allow for the ajax-loader to show
    //sleep(3);
    $output = json_decode($json);
    //$output = $json;
    //strrev($output->text);
    $output->text = strrev($output->text);
    print json_encode($output);
}

// Makes an object from JSON string,
// creates an instance of RGBColor and
// populates it using color values of json object
function slideStopHandler($json)
{
    
    $json = json_decode($json);
    $result = new RGBColor();
    $result -> red = $json->red;
    $result -> green = $json->green;
    $result -> blue = $json->blue;
    print json_encode($result);
    
}
//echo json_encode($_REQUEST[0]);

?>