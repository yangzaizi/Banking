<?php

require_once('../ORM/Transactions.php');
require_once('../ORM/Customers.php');

$method = $_SERVER['REQUEST_METHOD'];
session_start();
if($method=='GET'){
	if(count($_SESSION)>1){
		if(!is_null($_SESSION['Username']))
			$user=$_SESSION['Username'];

		if(!is_null($_SESSION['Password']))
			$pass=$_SESSION['Password'];

		$cust=Customers::getIdByLogin($user, $pass);
	
		if($cust<=0){
			header("HTTP/1.1 404 Not Found.");
			print("Customer not found.");
			exit();
		}

		else{
			$transactions=Transactions::getTransaction($cust);
			
			if($transactions){
				$_SESSION['Transaction']=$transactions;
				header("HTTP/1.1 200 Success");
				header("Content-type: text/html");
				$result="";
				foreach($transactions as $item){
					$entry=$item->getJSON();
					$result=$result."<tr><td>".$entry['Date']."</td><td>".$entry['Type']."</td><td>".$entry['Amount']."</td></tr>";
				}
				print($result);
				exit();
			}
			else{
				header("HTTP/1.1 204 No Data Available");
				exit();
			}
		}
	}

}

else if($method=='POST'){

	if(count($_POST)>1){

		if(!is_null($_POST['account']))
			$account=$_POST['account'];

		if(!is_null($_POST['routing']))
			$routing=$_POST['routing'];

		if(!is_null($_POST['day']))
			$day=$_POST['day'];

		if(!is_null($_POST['amount']))
			$amount=floatval($_POST['amount']);

		if(!is_null($_POST['type']))
			$type=$_POST['type'];

		$cust=Customers::getIdByAccount($account, $routing);
		if($cust>0){
			$success=Transactions::postTransaction($cust, $amount, $type, $day);
			if($success==true){
				header("Content-type: application/json");
				print(json_encode("Transaction added."));
				exit();
			}
			else{
				header("HTTP/1.1 412 Precondition Failed");
				header("Content-type: application/json");
				print(json_encode("Over withdraw."));
				exit();
			}
		}
		else{
			header("HTTP/1.1 404 Not Found");
			header("Content-type: application/json");
			print(json_encode("Customer not found."));
			exit();
		}
	}
}
header("HTTP/1.1 400 Bad Request");
print("URL does not match any known action.");

?>
		
		
	
