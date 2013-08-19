$(document).ready(function(){

	login();
});


var login=function(){
	$('#login').submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		
		var type=$('select option:selected').val();
		var data={'Username': $("input[name='Username']").val(),
			  'Password': $("input[name='Password']").val(),
			  'type': type
			 };

		if(type=="Customer"){
			$.ajax({
				url: '../Controller/Customer.php',
				method: 'GET',
				data: data,
				success: function(){
					window.location="Customer2.html";
				},
				error: function(){
					alert("Wrong login information");
				}
			});
		}

		else{
			 $.ajax({
                                url: '../Controller/Employee.php',
                                method: 'GET',
                                data: data,
                                success: function(){
                                        window.location="Employee2.html";
                                },
                                error: function(){
                                        alert("Wrong login information");
                                }
                        });

		}
	});
};
