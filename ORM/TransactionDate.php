<?php

class TransactionDate{
	
	private static function connect(){
		$connect = new mysqli("classroom.cs.unc.edu", "hxing", "CH@ngemenow99Please!hxing", "comp42615db");
		return $connect;
	}

	public static function getDate($id){		
		$result=TransactionDate::connect()->query("SELECT Date FROM TransactionDate WHERE Id='$id'");
		if($result){
			if($result->num_rows==0)
				return null;
			else{
				$item=$result->fetch_array();
				return $item['Date'];
			}
		}
		return null;
	}
	
	public static function addEntry($day){
		$search=TransactionDate::search($day);
		if($search==null){
			$connect=TransactionDate::connect();
			$connect->query("INSERT INTO TransactionDate VALUES('0','$day')");
			return $connect->insert_id;
		}

		else
			return $search;
	}

	public static function search($day){
		$result=TransactionDate::connect()->query("SELECT Id FROM TransactionDate WHERE Date='$day'");
		if($result){
			if($result->num_rows==0)
				return null;
			else{
				$item=$result->fetch_array();
				return intval($item['Id']);
			}
		}
		else
	
			return null;
	}

	public static function delete($id){
		TransactionDate::connect()->query("DELETE FROM TransactionDate WHERE Id='$id'");
	}
}

?>
		
	
