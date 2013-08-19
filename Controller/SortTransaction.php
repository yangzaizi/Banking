<?php

	require_once('../ORM/Transactions.php');

	session_start();

	if(!is_null($_SESSION['Username']))
		$user=$_SESSION['Username'];
	if(!is_null($_SESSION['Password']))
		$pass=$_SESSION['Password'];

	
	$result=$_SESSION['Transaction'];
	
	function sortAmountAsc($a, $b){
    		return $a->amount-$b->amount;
	}

	function sortAmountDesc($a, $b){
                return $b->amount-$a->amount;
        }
	
	function sortDateAsc($a, $b){
		$d1=strtotime($a->day);
		$d2=strtotime($b->day);
		return $d1-$d2;
	}
	
	                  
        function sortDateDesc($a, $b){
                $d1=strtotime($a->day);
                $d2=strtotime($b->day);
                return $d2-$d1;
        }
        


	if(!is_null($_GET['Type']))
		$type=$_GET['Type'];

	if(!is_null($_GET['Order']))
		$order=$_GET['Order'];
	
	if($result){	
		if($type=="Amount" && $order=="Decreasing")
			usort($result, "sortAmountDesc");

		else if($type=="Amount" && $order=="Increasing")
			usort($result, "sortAmountAsc");
		
		else if($type=="Date" && $order=="Decreasing")
			usort($result, "sortDateDesc");

		else
			usort($result, "sortDateAsc");

		header("HTTP/1.1 200 Success");
		header("Content-type: text/html");
		$response="";
		foreach($transactions as $item){
					$entry=$item->getJSON();
					$response=$response."<tr><td>".$entry['Date']."</td><td>".$entry['Type']."</td><td>".$entry['Amount']."</td></tr>";
				}
				print($response);
		exit();
	}

	else{
		header("HTTP/1.1 204 No Transaction");
		exit();
	}
?>
