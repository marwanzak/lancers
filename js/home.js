var base_url="http://localhost/lancers/home/";
$(document).ready(function()
		{
		
		}

//Open blank dialog function to add items to the database.
function add_dialog(dest,butt)
{
	$( dest ).dialog( { autoOpen: false, draggable: true,
		modal: true, resizable: false,
		show: { effect: 'drop', direction: "up" } ,
		width: 700 } );

	$(butt).click(function(){

		$(dest).dialog('open');
		return false;
	});
}

//Open dialog function with input to modify items in the database.
function modify_dialog(dest,butt,hidden_element)
{
	$( dest ).dialog( { autoOpen: false, draggable: true,
		modal: true, resizable: false,
		show: { effect: 'drop', direction: "up" } ,
		width: 700 } );

	$(butt).click(function(){
		var element=document.getElementById(hidden_element);
		element.value=this.id;   
		$(dest).dialog('open');
		return false;
	});
}

//Submit form function to controller method with refresh the webpage.
function form_submit(submit_form,submit_dest)
{

			$(submit_form).validate({
				   submitHandler: function(submit_form) {						
						$(submit_form).submit(function()
								{
							
							$.post(base_url + submit_dest,
									$(submit_form).serialize(),
									function(data){

								window.location.reload(true);
							});
							return false;
				
								});			
				   }	
			})

			

}