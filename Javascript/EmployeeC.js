$(document).ready(function(){

	 create();
	 del();
	 addTransaction();
	 update();
	 logout();
});



var create=function(){

        $('#create').submit(function(e){
                e.preventDefault();
		e.stopPropagation();
		var data= {'first': $("input[name='first']").val(),
			  'last': $("input[name='last']").val(),
			  'SSN': $("input[name='SSN']").val(),
			  'DOB': $("input[name='DOB']").val(),
			  'address': $("input[name='address']").val(),
   			  'account': $("input[name='first']").val(),
			  'routing': $("input[name='routing']").val(),
			  'username': $("input[name='username']").val(),
			  'password': $("input[name='password']").val(),
			  'initBalance': $("input[name='initBalance']").val(),
			  'email': $("input[name='email']").val()
			};

		$.ajax(	{url: '../Controller/Customer.php',
			type: 'POST',
                        data: data,
                       	cache: false,
                        success: function(data, status, jqXHR) {
                                alert(jqXHR.responseText);
                        },
                        error: function(jqXHR, status, error){
                                alert(jqXHR.responseText);
                                }
                        });
        });
};

var del=function(){
	
	$('#delete').submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		

		var data= {'first': $("input[name='firstName']").val(),
			   'last': $("input[name='lastName']").val(),
			   'SSN': $("input[name='#SSN']").val(),
	      		   'DOB': $("input[name='#DOB']").val(),
			   'delete': 'yes'
			};

		
		$.ajax( {url: '../Controller/Customer.php',
			 type:'GET',
			 data: data,
			 cache: false,
			 success: function(data, status, jqXHR){
				alert(jqXHR.responseText);
			 },
			 error: function(jqXHR, status, error){
				alert(jqXHR.responseText);
			 }

			});
		});
};


var addTransaction=function(){
    $('#addTransaction').submit(function(e){
	e.preventDefault();
	e.stopPropagation();
	
	var data={'account':  $("input[name='#account']").val(),
		  'routing':  $("input[name='#routing']").val(),
		  'day':  $("input[name='day']").val(),
		  'amount':  $("input[name='amount']").val(),
		  'type':  $('select option:selected').val()
		};

	$.ajax( {url: '../Controller/Transaction.php',
                         type:'POST',
                         data: data,
                         cache: false,
                         success: function(data, status, jqXHR){
                                alert(jqXHR.responseText);
                         },
                         error: function(jqXHR, status, error){
                                alert(jqXHR.responseText);
                         }
                
                        });
                });       
};                        
                
var update=function(){

        $('#Update').submit(function(e){
                e.preventDefault();
                e.stopPropagation();

        	var newPass=$("input[name='newPass']").val();
		var newPassC=$("input[name='cNewPass']").val();

		if(newPass!=newPassC)
			alert("Please reconfirm your new password");
		else{
	        	var data= {'oldUser': $("input[name='oldUser']").val(),
                           	   'oldPass': $("input[name='oldPass']").val(),
                           	   'newUser': $("input[name='newUser']").val(),
                                   'newPass': $("input[name='newPass']").val()
                                   };

                	$.ajax( {url: '../Controller/Employee.php',
                        	type: 'POST',
                        	data: data,
                        	cache: false,
                        	success: function(data, status, jqXHR) {
                                	alert(jqXHR.responseText);
                        	},
                        	error: function(jqXHR, status, error){
                                	alert(jqXHR.responseText);
                                }
                        });
		}
        });
};

var logout=function(){
	$('#logout').submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		 $.ajax( {url: '../Controller/Logout.php',
                          cache: false,
			  success: function(){
				window.location="Login2.html";
		          },
			  error: function(){}
                        });
		
	});
};
