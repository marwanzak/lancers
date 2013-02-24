
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
						  'pr_dl'			=> 'Deadline',
						  'pr_obj'			=> 'Objectives',
						  'pr_desc'			=> 'Description',
						  'pr_attach'		=> 'Attachments',
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
			echo form_open('',$att);

			echo form_input($lancer_hidden_past_id);
				
			echo form_close();



			?>

</div>



</body>
</html>
