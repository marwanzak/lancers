var base_url="http://localhost/lancers/home/";
//
$(document).ready(function()
		{
	$('#project_accordion').hide();
	add_dialog('#add_admin_dialog','.add_admin');
	add_dialog('#add_lancer_dialog','.add_lancer');
	add_dialog('#add_project_dialog','.add_project');
	add_dialog('#lancer_details_dialog','.lancer_details_button');

	 $(function() {
		 $( "#currencyagreement" ).buttonset();
		 $( "#deadlineagreement" ).buttonset();
		 $( "#pr_admindlagree" ).buttonset();
		 $( "#pr_admincuragree" ).buttonset();
		 $( "#pr_lancercuragree" ).buttonset();
		 $( "#pr_lancerdlagree" ).buttonset();
		 $( "#pr_deliver" ).buttonset();
		 $( "#pr_paymented" ).buttonset();


		 });
	 $(function() {
		 $( ".date_input" ).datepicker();
		 });
	 $('#project_details_span').click(function(){
		$('#project_accordion').toggle('blind',500); 
	 });
	// lancer details array from the lancer table in the database.
	var lancer_array = ['Full name', 'Username',
	                    'Password', 'Email',
	                    'Mobile', 'Country',
	                    'City', 'Payment method',
	                    'Lancer skills', 'Lancer level'];
	
	var admin_array = ['Full name', 'Username', 'Password','Email', 'Mobile'];

	// Modify lancer.
	$('.modify_lancer').click(function(){
		$(".modify_submit").remove();

		$.post(base_url +'get_lancer',
				{user_id:this.id},		
				function(data){
					var jsonStr = JSON.stringify(data);
					jsonStr = jsonStr.replace('[','');
					jsonStr = jsonStr.replace(']','');
					var Obj = jQuery.parseJSON(jsonStr);
					delete Obj['user_id'];
					delete Obj['user_role'];
					$('.lancer_class').remove();
					var j=0;

					$.each( Obj, function( key, lancer_value ) {

						$('#lancer_modify_form').append(
								"<label class='lancer_class'>"+
								lancer_array[j] + "</label>"
						);
						$('<input/>').attr({type: 'text',
							'class': 'lancer_class',
							name: key, value: lancer_value})
							.appendTo("#lancer_modify_form"
							);

						j++;	
					});
					$('#lancer_modify_form').append(
					"<input class='modify_submit' type=submit value='Modify' />");	

				},"json");		
		modify_dialog('#lancer_modify_dialog', '.modify_lancer',
		'hidden_past_lancer_id')
	});

	// Modify lancer.
	$('.modify_admin').click(function(){
		$(".modify_submit").remove();

		$.post(base_url +'get_admin',
				{user_id:this.id},		
				function(data){
					var jsonStr = JSON.stringify(data);
					jsonStr = jsonStr.replace('[','');
					jsonStr = jsonStr.replace(']','');
					var Obj = jQuery.parseJSON(jsonStr);
					var admin_fields = ['user_id','user_country','user_city','user_paymethod','user_skills','user_level','user_role'];
					$.each(admin_fields,function(key,value){
					delete Obj[value];	
					});
					$('.admin_class').remove();
					var j=0;

					$.each( Obj, function( key, admin_value ) {

						$('#admin_modify_form').append(
								"<label class='admin_class'>"+
								admin_array[j] + "</label>"
						);
						$('<input/>').attr({type: 'text',
							'class': 'admin_class',
							name: key, value: admin_value})
							.appendTo("#admin_modify_form"
							);

						j++;	
					});
					$('#admin_modify_form').append(
					"<input class='modify_submit' type=submit value='Modify' />");	

				},"json");		
		modify_dialog('#admin_modify_dialog', '.modify_admin',
		'hidden_past_admin_id')
	});

	$('.lancer_details_button').click(function(){
		$.post(base_url + 'get_lancer',
				{user_id:this.id},		
				function(data){
					var jsonStr = JSON.stringify(data);
					jsonStr = jsonStr.replace('[','');
					jsonStr = jsonStr.replace(']','');
					var Obj = jQuery.parseJSON(jsonStr);
					delete Obj['user_id'];
					$('.lancer_class').remove();
					var j=0;
					$.each( Obj, function( key, value2 ) {

						$('#lancer_details_dialog').append("<label class='lancer_class'>"+
								lancer_array[j] + "</label>");
						$('<input/>').attr({ type: 'text',
							'class': 'lancer_class',
							name: key, value: value2,
							disabled: 'disabled' })
							.appendTo("#lancer_details_dialog");

						j++;	
					});

				},"json");	

	});
	
		});

//Open blank dialog function to add items to the database.
function add_dialog(dest,butt)
{
	$( dest ).dialog( { autoOpen: false, draggable: true,
		modal: true, resizable: false,
		show: { effect: 'drop', direction: "up" } ,
		width: 500 } );

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
		show: { effect: 'drop', direction: "down" } ,
		width: 500 } );

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

function modify_dialog_open(button, method, id, modifyclass, formid, modifyarray, modifydialog, hiddenid){
	$(button).click(function(){
		$(".modify_submit").remove();

		$.post(base_url + method,
				{id:this.id},		
				function(data){
					var jsonStr = JSON.stringify(data);
					jsonStr = jsonStr.replace('[','');
					jsonStr = jsonStr.replace(']','');
					var Obj = jQuery.parseJSON(jsonStr);
					delete Obj[id];
					$(modifyclass).remove();
					var j=0;

					$.each( Obj, function( key, modify_value ) {

						$(formid).append(
								"<label class='"+modifyclass+"'>"+
								modifyarray[j] + "</label>"
						);
						$('<input/>').attr({type: 'text',
							'class': modifyclass,
							name: key, value: modify_value})
							.appendTo(formid
							);

						j++;	
					});
					$(formid).append(
					"<input class='modify_submit' type=submit value='Modify' />");	

				},"json");		
		modify_dialog(modifydialog, modifyclass,
		hiddenid)
	});
}
