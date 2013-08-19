<?php

class CustomerTransactionDate{

	private static function connect(){
		$connect = new mysqli("classroom.cs.unc.edu", "hxing", "CH@ngemenow99Please!hxing", "comp42615db");
		return $connect;
	}

	public static function getDateId($customerId){
		$result=CustomerTransactionDate::connect()->query("SELECT DateID FROM CustomerTransactionDate WHERE CustomerID='$customerId'");
		if($result)
			return $result;
		else
			return null;
	}
	
	public static function addEntry($custId, $dateId){
		if(CustomerTransactionDate::search($dateId)!=$custId)
			CustomerTransactionDate::connect()->query("INSERT INTO CustomerTransactionDate VALUES('0', '$custId', '$dateId')");
	}

	public static function search($dateId){
		$result=CustomerTransactionDate::connect()->query("SELECT CustomerID FROM CustomerTransactionDate WHERE DateID='$dateId'");
		if($result){
			if($result->num_rows==0)
				return null;
			else{
				$item=$result->fetch_array();
				return intval($item['CustomerID']);
			}
		}
		else
			return null;
	}

	public static function delete($dateId){
		CustomerTransactionDate::connect()->query("DELETE FROM CustomerTransactionDate WHERE DateID='$dateId'");
	}
	
}

?>
