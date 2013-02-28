
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

<!-- Insert Admin form -->
<div id="add_admin_dialog" title="Add Admin Form" class='dialog_div'>
	<?php 
	$att=array('id'=>'admin_insert_form');

	$input_values = array('admin_name' 	   => 'Full Name',
			'admin_username' => 'Username',
			'admin_password' => 'Password',
			'admin_email'    => 'Email',
			'admin_mobile'   => 'Mobile'
	);

	echo form_open('home/add_admin',$att);
	foreach($input_values as $key => $value)
	{
		echo '<p><label>'. $value .'</label>';
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

	$input_values = array('lancer_name'			=> 'Full Name',
						  'lancer_username'		=> 'Username',
						  'lancer_password'		=> 'Password',
						  'lancer_email'		=> 'Email',
						  'lancer_mobile'		=> 'Mobile',
						  'lancer_country'		=> 'Country',
						  'lancer_city'			=> 'City',
						  'lancer_paymethod'	=> 'Payment method',
						  'lancer_skills'		=> 'Lancer skills',
						  'lancer_level'		=> 'Lancer level'
						);

	echo form_open('home/add_lancer',$att);
	foreach($input_values as $key => $value)
	{
		echo '<p><label>'. $value .'</label>';
		echo form_input(array('name' => $key, 'class' => 'required'));
		echo '</p>';

	}
	echo '<p>'.form_submit('submit','Add Lancer').'</p>';
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
		echo '<p><label>'. $value .'</label>';
		if($key == 'pr_lancerid')
		{
			echo form_dropdown($key, $lancers, '', 'class = "required"');
			echo '</p>';
			continue;				
		}
		if($key == 'pr_obj' || $key == 'pr_desc')
		{
			echo "<textarea name='".$key."' rows='4' cols='20'></textarea>";
			echo "</p>";
			continue;
		}
		if($key == 'pr_admincuragree')
		{
			echo'<div id="currencyagreement">
    <input type="radio" id="ApproveButton1" name="pr_admincuragree" value = "1" checked />
    <label id="ApproveButtonLabel1" for="ApproveButton1"></label>

    <input type="radio" id="RejectButton1" name="pr_admincuragree" value = "0" />
    <label id="RejectButtonLabel1" for="RejectButton1"></label>
	</div>';
			echo "</p><br/>";
				
			continue;
				
		}
		
		if($key == 'pr_admindlagree')
		{
			echo'<div id="deadlineagreement">
    <input type="radio" id="ApproveButton2" name="pr_admindlagree" value = "1" checked />
    <label id="ApproveButtonLabel2" for="ApproveButton2"></label>
		
    <input type="radio" id="RejectButton2" name="pr_admindlagree" value = "0" />
    <label id="RejectButtonLabel2" for="RejectButton2"></label>
	</div>';
			echo "</p><br/>";
		
			continue;
		
		}
		echo form_input(array('name' => $key, 'class' => 'required'));
		echo '</p>';

	}
	echo '<p>'.form_submit('submit','Add project').'</p>';
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
