<?php

class Employees{
	
	private static function connect(){
		$connect = new mysqli("classroom.cs.unc.edu", "hxing", "CH@ngemenow99Please!hxing", "comp42615db");
		return $connect;
	}
	public static function getEmployee($user, $pass){
		$result=Employees::connect()->query("SELECT Id FROM Employee WHERE UserName='$user' AND PassWord='$pass'");
                if($result){
                        $item=$result->fetch_array();
                        return intval($item['Id']);
                }
                else
                        return null;	
	}
		
	public static function edit($oldUser, $oldPass, $newUser, $newPass){
		$success=false;
		$employee=Employees::getEmployee($oldUser, $oldPass);
		if($employee>0){
			$success=true;
			Employees::connect()->query("UPDATE Employee SET UserName='$newUser', PassWord='$newPass' WHERE Id='$employee'");
		}
		return $success;
	}
}
	
?>
