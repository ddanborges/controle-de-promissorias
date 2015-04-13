<?php
error_reporting(0);

date_default_timezone_set('America/Bahia');

function connect() {
	global $con;
	
	$host = "localhost";
	$id = "root";
	$pw = "";
	$db = "stationgas";

	$con = mysqli_connect($host, $id, $pw, $db) or die ("Erro de conexão:" . mysql_error());
	if (mysqli_connect_errno())
  	{
  		echo "Erro ao conectar no mySQL: " . mysqli_connect_error();
  	}

	mysqli_query($con, "SET NAMES 'utf8'");
	mysqli_query($con, 'SET character_set_connection=utf8');
	mysqli_query($con, 'SET character_set_client=utf8');
	mysqli_query($con, 'SET character_set_results=utf8');	
	
	
	}

?>