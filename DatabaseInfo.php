<?php


function makeConn(){
	//DB Credentials
	$servername = "";
    $username = "";
    $password = "";
    $dbname = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connectioncode, main, condition, group, order, limit
	if (!$conn) {
		echo "Bad Connection";
		exit();
	}
	return $conn;
}


?>