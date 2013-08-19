<?php

require_once("TransactionDate.php");
require_once("Customers.php");
require_once("CustomerTransactionDate.php");

class Transactions{
	
	private static function connect(){
		$connect = new mysqli("classroom.cs.unc.edu", "hxing", "CH@ngemenow99Please!hxing", "comp42615db");
		return $connect;
	}

	public function __construct($amount, $type, $date){
		$this->amount=$amount;
		$this->type=$type;
		$this->day=$date;
	}
	
	private static function getAmountAndType($dateId){
		$result=Transactions::connect()->query("SELECT Amount, Type FROM Transaction WHERE DateID='$dateId'");
		if($result)
			return $result;
		else
			return null;
	}
	
	public static function getTransaction($custId){

		$result=Transactions::connect()->query("SELECT * FROM Transaction WHERE CustomerID='$custId'");
		$returnValue=array();
		if($result){
			if($result->num_rows>0){			
				while($item=$result->fetch_array()){
					$transac=new Transactions(doubleval($item['Amount']), $item['Type'], 
TransactionDate::getDate(intval($item['DateID'])));
					$returnValue[]=$transac;
						
				}
			}
			
		}
		return $returnValue;
	}
	
	public static function postTransaction($custId, $amount, $type, $day){
			
		$success=false;
		$result=Customers::updateBalance($custId, $amount, $type);
		if($result==true){
				$id=TransactionDate::addEntry($day);
                		CustomerTransactionDate::addEntry($custId, $id);
				Transactions::connect()->query("INSERT INTO Transaction VALUES('0', '$amount', '$type', '$id', '$custId')");
				$success=true;
		}
		return $success;
	}
	
	public function getJSON(){
		$jsonRep=array();
		$jsonRep['Amount']=$this->amount;
		$jsonRep['Type']=$this->type;
		$jsonRep['Date']=$this->day;
		return $jsonRep;
	}

	public static function delete($custId){
		$result=Transactions::connect()->query("SELECT DateID FROM Transaction WHERE CustomerID='$custId'");
		if($result){
			if($result->num_rows>0){
				while($item=$result->fetch_array()){
					TransactionDate::delete(intval($item['DateID']));
					CustomerTransactionDate::delete(intval($item['DateID']));
				}
			}
		}

		Transactions::connect()->query("DELETE FROM Transaction WHERE CustomerID='$custId'");
	}

}
?>
		
