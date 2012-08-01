<html>
    <head>
        <script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "03482ea5-cc4b-4b55-8d5c-9d23be6e6b0a"}); </script>
    </head>
    <body>
        <span class='st_sharethis_large' displayText='ShareThis'></span>
        <span class='st_facebook_large' displayText='Facebook'></span>
        <span class='st_twitter_large' displayText='Tweet'></span>
        <span class='st_linkedin_large' displayText='LinkedIn'></span>
        <span class='st_email_large' displayText='Email'></span>
    </body>
</html>

<?php

/*
error_reporting(E_ALL ^ E_NOTICE);
//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may differ in your case
echo('<?xml version="1.0" encoding="iso-8859-1"?>'); 

function add_row(){
	
	return "insert";	
}

function update_row(){	
	return "update";	
}

function delete_row(){

	return "delete";	
}

$mode = $_GET["!nativeeditor_status"]; //get request mode
$rowId = $_GET["gr_id"]; //id or row which was updated 
$newId = $_GET["gr_id"]; //will be used for insert operation


switch($mode){
	case "inserted":
		//row adding request
		$action = add_row();
	break;
	case "deleted":
		//row deleting request
		$action = delete_row();
	break;
	default:
		//row updating request
		$action = update_row();
	break;
}


//output update results
echo "<data>";
echo "<action type='".$action."' sid='".$rowId."' tid='".$newId."'/>";
echo "</data>";*/
?>