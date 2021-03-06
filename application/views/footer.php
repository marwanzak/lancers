</div>
<div class="cleared"></div>
</div>

<div class="cleared"></div>
</div>
</div>
<div class="cleared"></div>
</div>
</div>
</div>
<div class="cleared"></div>

<div class="cleared"></div>
</div>
</div>
<div class="cleared"></div>

</div>
</div>

<!-- Create folder dialog -->
<div id="create_folder_dialog" title="Create folder" class='dialog_div'>
	<?php 
	echo form_open();
	echo '<label class = "add_label">Folder name</label>'.form_input(array('name' => 'create_input', 'id' => 'create_input'));
	echo form_close();
	?>
</div>

<!-- upload file dialog -->
<div id="upload_file_dialog" title="Upload file" class='dialog_div'>
	<?php 
	echo form_open();
	echo '<label class = "add_label">Folder name</label>'.form_upload(array('name' => 'drop_upload_input', 'id' => 'drop_upload_input'));
	echo form_close();
	?>
</div>

<!-- Insert Admin form -->
<div id="add_admin_dialog" title="Add Admin Form" class='dialog_div'>
	<?php 
	$att=array('id'=>'admin_insert_form');

	$input_values = array('user_name' 	   => 'Full Name',
			'user_username' => 'Username',
			'user_password' => 'Password',
			'user_email'    => 'Email',
			'user_mobile'   => 'Mobile'
	);

	echo form_open('home/add_admin',$att);
	foreach($input_values as $key => $value)
	{
		echo '<p><label class = "add_label">'. $value .'</label>';
		echo form_input(array('name' => $key, 'class' => 'required'));
		echo '</p>';

	}
	echo '<p>'.form_submit('submit','Add admin').'</p>';
	echo form_close();
	?>
</div>

<!-- Insert Lancer form -->
<div id="add_lancer_dialog" title="Add Lancer Form" class='dialog_div'>
	<?php 
	$att=array('id'=>'lancer_insert_form');

	$input_values = array('user_name'			=> 'Full Name',
						  'user_username'		=> 'Username',
						  'user_password'		=> 'Password',
						  'user_email'		=> 'Email',
						  'user_mobile'		=> 'Mobile',
						  'user_country'		=> 'Country',
						  'user_city'			=> 'City',
						  'user_paymethod'	=> 'Payment method',
						  'user_skills'		=> 'Lancer skills',
						  'user_level'		=> 'Lancer level'
						);

	echo form_open('home/add_lancer',$att);
	foreach($input_values as $key => $value)
	{
		echo '<label class = "add_label">'. $value .'</label>';
		echo form_input(array('name' => $key, 'class' => 'required'));

	}
	echo form_submit('submit','Add Lancer');
	echo form_close();
	?>
</div>

<!-- Insert Project form -->
<div id="add_project_dialog" title="Add Project Form" class='dialog_div'>
	<?php 
	$att=array('id'=>'project_insert_form');
	$lancers = $this->HomeModel->get_lancers();
	$input_values = array('pr_title'		=> 'Title',
						  'pr_requires'		=> 'Requirements',
						  'pr_currency'		=> 'Currency',
						  'pr_admincuragree'=> 'Currency agreement',
						  'pr_dl'			=> 'Deadline',
						  'pr_admindlagree' => 'Deadline agreement',
						  'pr_obj'			=> 'Objectives',
						  'pr_desc'			=> 'Description',
						  'pr_lancerid'		=> 'Lancer'
						);

	echo form_open('home/add_project',$att);
	foreach($input_values as $key => $value)
	{
		echo '<label class = "add_label">'. $value .'</label>';
		if($key == 'pr_lancerid')
		{
			echo form_dropdown($key, $lancers, '', 'class = "required"').'<br/>';
			continue;				
		}
		if($key == 'pr_obj' || $key == 'pr_desc')
		{
			echo "<textarea name='".$key."' rows='4' cols='20'></textarea><br/>";
			continue;
		}
		if($key == 'pr_admincuragree')
		{
			echo'<div id="currencyagreement">
    <input type="radio" id="ApproveButton1" name="pr_admincuragree" value = "1" checked />
    <label id="ApproveButtonLabel1" for="ApproveButton1"></label>

    <input type="radio" id="RejectButton1" name="pr_admincuragree" value = "0" />
    <label id="RejectButtonLabel1" for="RejectButton1"></label>
	</div><br/>';
				
			continue;
				
		}
		
		if($key == 'pr_admindlagree')
		{
			echo'<div id="deadlineagreement">
    <input type="radio" id="ApproveButton2" name="pr_admindlagree" value = "1" checked />
    <label id="ApproveButtonLabel2" for="ApproveButton2"></label>
		
    <input type="radio" id="RejectButton2" name="pr_admindlagree" value = "0" />
    <label id="RejectButtonLabel2" for="RejectButton2"></label>
	</div><br/>';
		
			continue;
		
		}
		echo form_input(array('name' => $key, 'class' => 'required')).'<br/>';

	}
	echo form_submit('submit','Add project');
	echo form_close();
	?>
</div>

<!--  lancer details dialog -->
<div id="lancer_details_dialog" title="Lancer full details" class='dialog_div'>

</div>

<!-- modify lancer dialog -->
<div id="lancer_modify_dialog" title="Modify lancer data" class='dialog_div'>

	<?php 

			$lancer_hidden_past_id = array('id'  => 'hidden_past_lancer_id',
											'name'=> 'hidden_past_lancer_name',
											'style' => 'display:none;'
											);
			$att=array('id'=>'lancer_modify_form');
			echo form_open('home/modify_lancer',$att);

			echo form_input($lancer_hidden_past_id);
				
			echo form_close();



			?>

</div>

<!-- modify Admin dialog -->
<div id="admin_modify_dialog" title="Modify admin data" class='dialog_div'>

	<?php 

			$admin_hidden_past_id = array('id'  => 'hidden_past_admin_id',
											'name'=> 'hidden_past_admin_name',
											'style' => 'display:none;'
											);
			$att=array('id'=>'admin_modify_form');
			echo form_open('home/modify_admin',$att);

			echo form_input($admin_hidden_past_id);
				
			echo form_close();



			?>

</div>
</body>
</html>
