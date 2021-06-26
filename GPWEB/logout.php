<?php 
	require 'functions/init.php';
	session_destroy();
	redirect('login.php');
?>