$(document).ready(function(){
		$("#btnDeelnemen").on("click", function(e){	
			var eventid = $(this).data("eventid");
			var request = $.ajax({
			  	url: "ajax/save_deelname.php",
			  	type: "POST",
			  	data: {eventid : eventid}, 
			  	dataType: "json"
			});

			request.done(function(msg) 
			{
				if(msg.status == "success")
			 	 {
			 	console.log('event deelname ok');	
			
			 	 }
			 	 else
				 {
				console.log('event deelname niet ok');	

			 	 }
			});
	 
			request.fail(function(jqXHR, textStatus) {
			  alert( "Request failed: " + textStatus );
			});
			
			e.preventDefault();
	 
		});
		
});