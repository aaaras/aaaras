<?php 
	function connessione()
	{
		$conn=new mysqli("localhost", "root", "", "votailprof") or die("Error");
		return $conn;
	}
	
	
	
	
?>