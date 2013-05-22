$(document).ready(function(){
	
		$("#btnSubmit").on("click", function(e){	
			var reactie = $("#activitymessage").val();
			var user = $("#username").val();
				var request = $.ajax({
			  	url: "ajax/save_reactie.php",
			  	type: "POST",
			  	data: {reactie : reactie}, 
			  	dataType: "json"
			});

			request.done(function(msg) 
			{
				if(msg.status == "success")
			 	 {
			 	var li = '<li style="display:none" class="clearfix">'+
						 '<p><strong>'+user+'</strong>'+reactie+'</p></li>';
						
				$("#listupdates").prepend(li);
				$("#listupdates li").first().slideDown();
			 	 }
			 	 else
				 {
			 	 }
			});
	 
			request.fail(function(jqXHR, textStatus) {
			  alert( "Request failed: " + textStatus );
			});
			
			e.preventDefault();
	 
		});
		
});