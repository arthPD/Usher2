<?php  

	require('rb.php');
	R::setup( 'mysql:host=localhost;dbname=db_ch2', 'root', '' );
	session_start();

	if(isset($_GET['searchfunction'])){
		$searchtext = $_GET['searchtext'];
		$member = R::getAll( 'select * from members where name LIKE :name', array(':name'=> '%'.$searchtext.'%') );
		echo json_encode($member);
	}

	elseif(isset($_POST['addform'])){
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

		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        //echo "File is not an image.";
	        $uploadOk = 0;
	    }//validation1
	    if (file_exists($target_file)) {
		    //echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}//validation2
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}//validation3
		if ($uploadOk == 0) {// if everything is ok, try to upload file
		    //echo "Sorry, your file was not uploaded.";
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		       	//echo "Sorry, there was an error uploading your file.";
		    }
		}
		$member->image = $_FILES["fileToUpload"]["name"];
		$id = R::store($member);
		getall();
	}

	elseif(isset($_POST['delete'])){
		$id = $_POST['id'];
		$member = R::load('members', $id);
		R::trash($member);
		getall();

	}
	elseif(isset($_POST['editform'])){
		$id = $_POST['id2'];
		$name = $_POST['name2'];
		$birthdate = $_POST['birthdate2'];
		$address = $_POST['address2'];
		$contact_no = $_POST['contact_no2'];
		$note = $_POST['note2'];

		$member = R::load('members', $id);
		$member->name = $name;
		$member->birthdate = $birthdate;
		$member->address = $address;
		$member->contact_no = $contact_no;
		$member->note = $note;

		if(isset($_FILES['fileToUpload2']) && !empty($_FILES['fileToUpload2']['name'])){
			$target_dir = "images/";
			$target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		    $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
		    if($check !== false) {
		        //echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        //echo "File is not an image.";
		        $uploadOk = 0;
		    }//validation1
		    if (file_exists($target_file)) {
			    //echo "Sorry, file already exists.";
			    $uploadOk = 0;
			}//validation2
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}//validation3
			if ($uploadOk == 0) {// if everything is ok, try to upload file
			    //echo "Sorry, your file was not uploaded.";
			} else {
			    if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
			        //echo "The file ". basename( $_FILES["fileToUpload2"]["name"]). " has been uploaded.";
			    } else {
			       	//echo "Sorry, there was an error uploading your file.";
			    }
			}
			$member->image = $_FILES["fileToUpload2"]["name"];
		}else{

		}
		$id = R::store($member);
		getall();
	}

	function getall(){
		$members = R::findAll('members');
		echo json_encode($members);
	}
?>