$( document ).ready(function() {

	$("#shiftMatch").click(function() {

		event.preventDefault(); // cancel the event
		shiftMatch($(this));
	});

	function shiftMatch(self){

		var shiftTime = $('#shiftTime').val();

		//if empty or numeric
		if(!(shiftTime % 1 === 0 && shiftTime != '')){
			displayAlert("danger", "Le décalage doit être un numéro entier qui correspond a un temps en minute...");
			return;
		}

		var matches = $('#matches tr .separator');
		var tournamentId = $("table#matches").data("tournament");
		var poolId = $("table#matches").data("pool");

		matches.each(function()
		{
			var gameId = $(this).parent().data("game");

		    var oldTime = $(this).text();

			var tempTime = oldTime.split(':');
			var timeInSecond = tempTime[0] * 60 * 60 + tempTime[1] * 60 ; 

			//add time
			timeInSecond += (shiftTime * 60)
		
			//convert second in string HH:MM:SS
			var newDate = new Date(null);
			newDate.setTime( newDate.getTime() + newDate.getTimezoneOffset()*60*1000 ); // make timezone correcte
			newDate.setSeconds(timeInSecond); 
			var result = newDate.toISOString().substr(11, 8);

			// create var for the dom display and for the DB , the 0 add in start and the slice fix the number for having 14:05:00 instead of 14:5:0
			var timeDOM = ('0'+newDate.getHours()).slice(-2)+":"+('0'+newDate.getMinutes()).slice(-2);
			var timeDB = ('0'+newDate.getHours()).slice(-2)+":"+('0'+newDate.getMinutes()).slice(-2)+":"+('0'+newDate.getSeconds()).slice(-2);

			$.ajax({
	            url         : '/admin/tournaments/'+tournamentId+'/pools/'+poolId+'/games/'+gameId,
	            method      : 'PUT',
	            context: this,
	            cache       : false,
	            headers     : {            
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')        
	            },
	            data        : {
	        		newTime : timeDB,
	        		newTime : timeDB
	            },
	            error : function(xhr, options, ajaxError) {
	            	if(xhr.status != 200){
	            		displayAlert("danger", "Une erreur est survenue ...");
	            	}
	            },
	            success : function(data) {
	            	$(this).text(timeDOM);
	            }
	        });

		});

	

	} //shiftMatch

	function displayAlert(type, message){	
		$(".alert").remove();

		switch(type) {

	    	case "danger":

				var errorAlert = $("<div class='alert alert-danger' role='alert'>"+message+"</div>");
				$("#match-block").prepend(errorAlert);
				// After 2sec, the alert will disappear
				disappear(errorAlert);
		        break;

		    case "success":

				var success = $("<div class='alert alert-success' role='alert'>"+message+"</div>");
				$("#match-block").prepend(success);
				// After 2sec, the alert will disappear
				disappear(success);
		        break;
		}
	}

});