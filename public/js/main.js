$( document ).ready(function() {
    	
    // Create custom delete alert when we click on a .button-delete
	$('.button-delete').click(function(){
		var type = $(this).data("type");
		var name = $(this).data("name");
		var title = '';
		var text = '';
		var form = $(this).parent();

		switch(type) {
		    case "sport":
		    	title = "Voulez-vous vraiment supprimer le sport \""+name+"\"?";
		        text = "La suppression de ce sport va entrainer la suppression des courts liés"
		        break;
		}

		alertDeleteSport(form, title, text);
  	});

  	function alertDeleteSport(form, title, text){
  		swal({
		  	title: title,
		  	text: text,
		  	type: "warning",
		  	showCancelButton: true,
		  	cancelButtonText: "Annuler",
	  		confirmButtonColor: "#DD6B55",
		  	confirmButtonText: "Oui, supprimer",
		  	closeOnConfirm: false
		},
		function(){
			$(form).submit();
		});
  	}
   

});