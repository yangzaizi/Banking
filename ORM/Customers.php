<?php

require_once("Transactions.php");

class Customers{

	private static function connect(){
		$connect = new mysqli("classroom.cs.unc.edu", "hxing", "CH@ngemenow99Please!hxing", "comp42615db");
		return $connect;
	}

	public function __construct($id, $first, $last, $SSN, $DOB, $address, $account, $routing, $email, $user, $pass, $initBalance){
		$this->id=$id;
		$this->first=$first;
		$this->last=$last;
		$this->SSN=$SSN;
		$this->DOB=$DOB;
		$this->address=$address;
		$this->account=$account;
		$this->routing=$routing;
		$this->email=$email;
		$this->user=$user;
		$this->pass=$pass;
		$this->balance=$initBalance;
	}
	
	public static function getIdByLogin($user, $pass){		
		
		$result=Customers::connect()->query("SELECT Id FROM Customer WHERE UserName='$user' AND PassWord='$pass'");
		if($result){
			$item=$result->fetch_array();
			return intval($item['Id']);
		}
		else
			return null;
	}
	
	public static function getIdByAccount($account, $routing){
		$result=Customers::connect()->query("SELECT Id FROM Customer WHERE Account='$account' AND Routing='$routing'");
		if($result){
			$item=$result->fetch_array();
			return intval($item['Id']);
		}
		else
			return null;
	}
	
	public static function delete($first, $last, $DOB, $SSN){
		$success=false;
		$result=Customers::connect()->query("SELECT Id FROM Customer WHERE First='$first' AND Last='$last' AND DOB='$DOB' AND 
SSN='$SSN'");
		if($result){
			$item=$result->fetch_array();
			$id=intval($item['Id']);
			if($id>0){
				$success=true;
				Customers::connect()->query("DELETE FROM Customer WHERE Id='$id'");
				Transactions::delete($id);
			}
		}
		return $success;
	}
	
	public static function updateBalance($id, $amount, $type){
		$success=true;
		$result=Customers::connect()->query("SELECT Balance FROM Customer WHERE Id='$id'");
		$item=$result->fetch_array();
		$currentBalance=doubleval($item['Balance']);
		$newBalance;
		if($type=="Credit"){
			$newBalance=$currentBalance+$amount;
			Customers::connect()->query("UPDATE Customer SET Balance='$newBalance' WHERE Id='$id'");
		}
		else{
			if($amount>$currentBalance)
				$success=false;
			else{
				$newBalance=$currentBalance-$amount;
				Customers::connect()->query("UPDATE Customer SET Balance='$newBalance' WHERE Id='$id'");
			}
		}
		
		return $success;
	}
	
	public static function update($oldUser, $oldPass, $newUser, $newPass, $email, $address){
		$connect=Customers::connect();
		$result=null;
		$cust=Customers::getIdByLogin($oldUser, $oldPass);
		if($cust>0){
			if($newUser!=null)
				$connect->query("UPDATE Customer SET UserName='$newUser' WHERE Id='$cust'");
			if($newPass!=null)
				$connect->query("UPDATE Customer SET PassWord='$newPass' WHERE Id='$cust'");
			if($email!=null)
				$connect->query("UPDATE Customer SET Email='$email' WHERE Id='$cust'");
			if($address!=null) 
				$connect->query("UPDATE Customer SET Address='$address' WHERE Id='$cust'");
			$data=$connect->query("SELECT * FROM Customer WHERE Id='$cust'");
			$item=$data->fetch_array();
				$result=new Customers(intval($item['Id']), $item['First'], $item['Last'], $item['SSN'], $item['DOB'], $item['Address'], 
$item['Account'], $item['Routing'], $item['Email'], $item['UserName'], $item['PassWord'], floatval($item['Balance']));
		}
		return $result;
	}
	
	
	public static function addEntry($first, $last, $SSN, $DOB, $address, $account, $routing, $email, $user, $pass, $initBalance){
		$result=Customers::connect()->query("INSERT INTO Customer VALUES('0', '$first', '$last', '$user', '$pass', '$address', 
'$email', 
'$account', '$routing', '$SSN', '$DOB', 
'$initBalance')");
		return result;
	}
	
	public function getJSON(){
		$jsonRep=array();
		$jsonRep['Id']=$this->id;
		$jsonRep['First']=$this->first;
		$jsonRep['Last']=$this->last;
		$jsonRep['SSN']=$this->SSN;
		$jsonRep['DOB']=$this->DOB;
		$jsonRep['Address']=$this->address;
		$jsonRep['Account']=$this->account;
		$jsonRep['Routing']=$this->routing;
		$jsonRep['Email']=$this->email;
		$jsonRep['Username']=$this->user;
		$jsonRep['Password']=$this->pass;
		$jsonRep['Balance']=$this->balance;
		return $jsonRep;
	}
}

?>
