<?php

	require('rb.php');
	R::setup( 'mysql:host=localhost;dbname=db_ch2', 'root', '' );
	session_start();

	if(isset($_POST['start'])){
		if(is_numeric($_POST['servicenameorid'])){
			//call start function
			$service = R::load('services', $_POST['servicenameorid']);
			start($service);
		}else{
			//insert customservice first
			$service = R::dispense('services');
			$service->name = $_POST['servicenameorid'];
			$id = R::store($service);//$id=id of newly inserted//

			//call start function
			start($service);
		}
	}
	if(isset($_POST['searchone'])){
		$id = $_POST['id'];
		$attendance_id = $_SESSION['attendance'];	
		$attmemrow = R::findOne('attendancemember', 'attendance_id = :att && member_id = :mem', array(':att' => $attendance_id, ':mem' => $id));
		R::trash($attmemrow);
		$member = R::load('members', $id);
		echo json_encode($member);/*return to members selection*/
	}
	if(isset($_POST['addform'])){
		$name = $_POST['name'];
		$birthdate = $_POST['birthdate'];
		$address = $_POST['address'];
		$contact_no = $_POST['contact_no'];
		$note = $_POST['note'];

		$member = R::dispense('members');
		$member->name = $name;
		$member->birthdate = $birthdate;
		$member->address = $address;
		$member->contact_no = $contact_no;
		$member->note = $note;
		$id = R::store($member);
		echo json_encode($member);
	}
	if(isset($_POST['unset'])){
		
		$attmemrows = R::findAll('attendancemember', 'attendance_id = :att_id', [':att_id' => $_SESSION['attendance']]);
		R::trashAll($attmemrows);
		R::trash('attendance', $_SESSION['attendance']);
		unset($_SESSION['started']);
		unset($_SESSION['attendance']);
	}
	if(isset($_POST['toattendancemember'])){//add member to present
		$attmemrow = R::dispense('attendancemember');
		$attmemrow->attendance_id = $_SESSION['attendance'];
		$attmemrow->member_id = $_POST['memberid'];
		//$attmemrow->timestamp = date("Y-m-d");
		if(isset($_POST['note'])){
			$attmemrow->first = 1;
		}
		R::store($attmemrow);
	}
	if(isset($_POST['refill'])){
		$present = R::findAll('attendancemember', 'attendance_id = :att_id', [':att_id' => $_SESSION['attendance']]);
		echo json_encode($present);
	}
	if(isset($_POST['save'])){
		$all = R::findAll('attendancemember','attendance_id = :att_id', [':att_id' => $_SESSION['attendance']]);
		$total = 0;
		$first = 0;
		foreach($all as $rows){
			$total++;
			if($rows->first == 1){
				$first++;
			}
		}
		$attendancerow = R::load('attendance', $_SESSION['attendance']);
		$attendancerow->total = $total;
		$attendancerow->first = $first;
		$attendancerow->date = date("Y-m-d");
		R::store($attendancerow);
		unset($_SESSION['started']);
		unset($_SESSION['attendance']);
	}
	function start($service){
		
		$startservice = R::dispense('attendance');
		$startservice->service_id = $service->id;
		$attendance = R::store($startservice);
		unset($_SESSION['started']);
		$_SESSION['started'] = $service->name;
		$attendance = R::findLast('attendance');
		$_SESSION['attendance'] = $attendance->id;
		echo json_encode($service);
	}

?>