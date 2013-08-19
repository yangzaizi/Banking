<?php

	require_once('../ORM/Employees.php');

	$method = $_SERVER['REQUEST_METHOD'];

	if($method=='GET'){
		if(!is_null($_GET['Username']))
			$user=$_GET['Username'];
		if(!is_null($_GET['Password']))
			$pass=$_GET['Password'];
		$id=Employees::getEmployee($user, $pass);
		if($id<=0){
			header("HTTP/1.1 404 Not Found");
			exit();
		}
		else{
			header("Content-type: application/json");
			print(json_encode($id));
			exit();
		}
	}

	else if($method=='POST'){
		if(!is_null($_POST['oldUser']))
			$oldUser=$_POST['oldUser'];

		if(!is_null($_POST['oldPass']))
			$oldPass=$_POST['oldPass'];

		if(!is_null($_POST['newUser']))
			$newUser=$_POST['newUser'];

		if(!is_null($_POST['newPass']))
			$newPass=$_POST['newPass'];

		$success=Employees::edit($oldUser, $oldPass, $newUser, $newPass);

		if($success==false){
			header("HTTP/1.1 404 Not Found");
			print("Failure to find employee specified.");
			exit();
		}
		else{
			header("Content-type: application/json");
			print(json_encode("Success."));
			exit();
		}
	}

header("HTTP/1.1 400 Bad Request");
print("URL did not match any known action.");

?>
		
	
