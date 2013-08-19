<?php
	
require_once('../ORM/Customers.php');

$method = $_SERVER['REQUEST_METHOD'];
session_start();

if($method=='GET'){
	
	if(!isset($_GET['delete']) && count($_GET)>1){
		if(!is_null($_GET['Username']))
			$user=$_GET['Username'];

		if(!is_null($_GET['Password']))
			$pass=$_GET['Password'];


		$id=Customers::getIdByLogin($user, $pass);

		if($id>0){
			header("Content-type: application/json");
			$_SESSION['Username']=$user;
			$_SESSION['Password']=$pass;
                	print(json_encode($id));
                	exit();
		}
		else{
			header("HTTP/1.1 404 Not Found");
			exit();
		}
	}

	else if(isset($_GET['delete']) && count($_GET)>1) {
	
		if(!is_null($_GET['first']))
                        $first=$_GET['first'];
        
                if(!is_null($_GET['last']))
                        $last=$_GET['last'];

		if(!is_null($_GET['DOB']))
                        $DOB=$_GET['DOB'];
        
                if(!is_null($_GET['SSN']))
                        $SSN=$_GET['SSN'];
	
		$success=Customers::delete($first, $last, $DOB, $SSN);

		if($success==true){
			header("Content-type: application/json");
                        print(json_encode("Customer deleted"));
                        exit();
		}

		else{
			header("HTTP/1.1 404 Not Found");
			header("Content-type: application/json");
			print(json_encode("Customer not found. Unable to delete"));
			exit();
		}
	}
}

else if($method=='POST'){
	
	if(count($_POST)>6){
		if(!is_null($_POST['first']))
			$first=$_POST['first'];

		if(!is_null($_POST['last']))
			$last=$_POST['last'];

		if(!is_null($_POST['SSN']))
			$SSN=$_POST['SSN'];

		if(!is_null($_POST['DOB']))
			$DOB=$_POST['DOB'];

		if(!is_null($_POST['address']))
			$address=$_POST['address'];

		if(!is_null($_POST['account']))
			$account=$_POST['account'];

		if(!is_null($_POST['routing']))
			$routing=$_POST['routing'];

		if(!is_null($_POST['username']))
			$user=$_POST['username'];

		if(!is_null($_POST['password']))
			$pass=$_POST['password'];

		if(!is_null($_POST['initBalance']))
			$balance=floatval($_POST['initBalance']);

		if(!is_null($_POST['email']))
			$email=$_POST['email'];

		if($balance<0){
			header("HTTP/1.1 412 Precondition Failed");
			header("Content-type: application/json");
			print(json_encode("Balance must be larger than 0"));
			exit();
		}
	
		else{
			$success=Customers::addEntry($first, $last, $SSN, $DOB, $address, $account, $routing, $email, $user, $pass, $balance);
			if($success){
				header("HTTP/1.1 200 Success");
				header("Content-type: application/json");
				print(json_encode("Customer added"));
				exit();
			}
			else{
				header("HTTP/1.1 400 Bad Request");
				header("Content-type: application/json");
				print(json_encode("Insertion failed"));
				exit();
			}
		}
	}

	else if(count($_POST)>1){
		if(!is_null($_POST['oldUser']))
			$oldUser=$_POST['oldUser'];
		if(!is_null($_POST['oldPass']))
			$oldPass=$_POST['oldPass'];
		if(!is_null($_POST['newUser']))
			$newUser=$_POST['newUser'];
		if(!is_null($_POST['newPass']))
			$newPass=$_POST['newPass'];
		if(!is_null($_POST['email']))
			$email=$_POST['email'];
		if(!is_null($_POST['address']))
			$address=$_POST['address'];
		$result=Customers::update($oldUser, $oldPass, $newUser, $newPass, $email, $address);	
		
		if($result){
			header("Content-type: application/json");
			$_SESSION['Username']=$newUser;
			$_SESSION['Password']=$newPass;
			print(json_encode($result->getJSON()));
			exit();
		}

		else{
			header("HTTP/1.1 404 Not Found");
                        print("Customer not found.");
                        exit();
		}
	}
	
}

header("HTTP/1.1 400 Bad Request");	
print("URL does not match any known action.");

?>
		
		
