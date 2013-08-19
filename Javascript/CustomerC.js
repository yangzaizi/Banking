$(document).ready(function(){

		update();
		logout();
		post();
		sort();
		transfer();

});



var update=function(){

        $('#edit').submit(function(e){
                e.preventDefault();
		e.stopPropagation();

		var newPass= $("input[name='newPass']").val();
                var newPassC= $("input[name='cNewPass']").val();

		if(newPass!=newPassC)
			alert("Reconfirm new password.");

		else{
			var data={'oldUser': $("input[name='oldUser']").val(),
                         	 'oldPass': $("input[name='oldPass']").val(),
                          	'newUser': $("input[name='newUser']").val(),
                          	'newPass': newPass,
                          	'email': $("input[name='email']").val(),
                          	'address':$("input[name='address']").val()
                        	}
			 
			$.ajax(	{url: '../Controller/Customer.php',
				type: 'POST',
                        	data: data,
                       		cache: false,
                        	success: function() {
                                	alert("Success");
					post();
                        	},
                        	error: function(){
                                	alert("Failure");
                                	}
                        	});
		}
        });
	
};

var logout=function(){
	$('#logout').submit(function(e){
		e.preventDefault();
		e.stopPropagation();

		$.ajax({
			url: '../Controller/Logout.php',
			cache: false,
			success: function(){
				window.location="Login2.html";
			},
			error: function(){}
			});
	});
};	

var post=function(){
	$.ajax({
		url: '../Controller/Transaction.php',
		cache: false,
		success: function(data, status, jqXHR){
				if(jqXHR.status==204)
					alert("You have no transaction history at this time.");
				else{
					$('table#data').empty();
					$('table#data').append(jqXHR.responseText);
					$('table#data tr:nth-child(2n)').css("background-color", "#FFCC33");		
				}
		},
		error: function(){}
	  });
};				 

var sort=function(){
	$("button[name='sort']").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		
		var choice=$('select#sort option:selected').val();
		var order=$('select#order option:selected').val();
		$('table#data').empty();
		
		var data={'Type': choice,
			  'Order': order
			};
		$.ajax({
			url: '../Controller/SortTransaction.php',
			data: data,
			cache: false,
			success: function(data, status, jqXHR){
				if(jqXHR.status==204)
					alert("You have no transaction to sort.");
				else{		
                                        $('table#data').append(jqXHR.responseText);
					$('table#data tr:nth-child(2n)').css("background-color", "#FFCC33");
				}
			},
			error: function(){}
		  });
	});
};


var transfer=function(){
	$('#transfer').submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		
		var data={'account': $("input[name='account']").val(),
			  'routing': $("input[name='routing']").val(),
			  'date': $("input[name='day']").val(),
			  'amount': $("input[name='amount']").val()
			};
		$.ajax({
			url: '../Controller/Transfer.php',
			data: data,
			cache: false,
			success: function(){
				alert("Success");
				post();
			},
			error: function(jqXHR, status, error){
				alert(jqXHR.responseText);
			}
		});
	});
};
