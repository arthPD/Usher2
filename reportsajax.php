<?php
	require('rb.php');
	R::setup( 'mysql:host=localhost;dbname=db_ch2', 'root', '' );
	session_start();

	if(isset($_POST['updatebar'])){
		$start = $_POST['year']."-".$_POST['month']."-"."01";
		$end = $_POST['year']."-".$_POST['month']."-"."31";

		$services = R::getAll('select * from attendance where date >= :start && date <= :end', array(':start' => $start, ':end' => $end));
		$_SESSION['attendance'] = $services;
		if(empty($services)){
			echo "No Result";
		}
	}
?>