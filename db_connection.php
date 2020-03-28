<?php

function OpenCon()
{
	$dbhost = "127.0.0.1";
	$dbuser = "fvc353_4";
	$dbpass = "r0cmu51c";
	$db = "fvc353_4";
	$port = "3306";

	$conn = new mysqli($dbhost, $dbuser, $dbpass, $db, $port) or die("Connect failed: %s\n" . $conn->error);
	if ($conn->connect_errno) {
		echo "Failed to connect to MySQL: " . $conn->connect_error;
		exit();
	}

	return $conn;
}

function CloseCon($conn)
{
	$conn->close();
}
