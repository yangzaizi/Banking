<?php
	require_once('../ORM/Transactions.php');
	require_once('../ORM/Customers.php');

	session_start();

	if(!is_null($_GET['account']))
		$account=$_GET['account'];
	if(!is_null($_GET['routing']))
		$routing=$_GET['routing'];
	if(!is_null($_GET['date']))
		$day=$_GET['date'];
	if(!is_null($_GET['amount']))
		$amount=floatval($_GET['amount']);
	
	if(!is_null($_SESSION['Username']))
                $user=$_SESSION['Username'];
        if(!is_null($_SESSION['Password']))
                $pass=$_SESSION['Password'];

	$dest=Customers::getIdByAccount($account, $routing);

	$from=Customers::getIdByLogin($user, $pass);

	if($dest<=0){
		header("HTTP/1.1 404 Not Found");
		header("Content-type: application/json");
		print(json_encode("Wrong account information"));
		exit();
	}
	
	else{
		$result=Transactions::postTransaction($from, $amount, "Debit", $day);
		if($result==false){
			header("HTTP/1.1 400 Bad Request");
			header("Content-type: application/json");
			print(json_encode("Over withdraw!"));
			exit();
		}
		else{
			Transactions::postTransaction($dest, $amount, "Credit", $day);
			header("HTTP/1.1 200 Success");
			exit();
		}
	}
?> 
