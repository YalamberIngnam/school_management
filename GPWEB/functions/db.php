<?php 
	$connect_gp_db = new PDO('mysql:dbname=gp_db;host=localhost', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	
	function query($stmt)
	{
		global $connect_gp_db;
		return $connect_gp_db->prepare($stmt);
	}
?>