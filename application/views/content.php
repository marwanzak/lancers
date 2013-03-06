<?php 
if($table_data!='main' && $table_data!= 'project')
{
	
	$user=$this->session->userdata('user_role');
	if($user=='admin')
	{

		$att = array('id' => 'table_form');
		echo form_open('home/delete_list', $att);
		$tmpl = array ( 'table_open'  => '<table class = "mytable"
				cellpadding = "8" cellspacing = "3" align="center">'
		);
		$this->table->set_template($tmpl);
		switch ($table_data)
		{

			case 'la_admins':
				$this->table->set_heading('<input type = "checkbox" name = "admins_check"
						value = "all" />',
						'Full Name','Username','Password','Email','mobile','Modify'
								);
								echo form_hidden('hidden_table_name',$table_data);
								echo form_hidden('hidden_item_id','user_id');
								break;
			case 'la_lancers':
				$this->table->set_heading('<input type="checkbox"
						name="lancers_check" value="all" />',
						'Full Name','Email','Skills','Level','More details','Modify'
								);
								echo form_hidden('hidden_table_name',$table_data);
								echo form_hidden('hidden_item_id','user_id');
								break;
			case 'la_projects':
				$this->table->set_heading('<input type="checkbox"
						name="projects_check" value="all" />',
						'Title','Requirements','Deadline','Agreement','Freelancer','Show project'
								);
								echo form_hidden('hidden_table_name',$table_data);
								echo form_hidden('hidden_item_id','pr_id');
								break;

			case 'main':

				break;

		}

		switch ($table_data){
			case 'la_admins':
				$this->db->where('user_role','admin');
				$Q=$this->db->get('la_users');
				foreach ($Q-> result() as $row){

					$this->table->add_row('<input type="checkbox"
							name="check_list[]" value=\''. $row->user_id .'\'/>'
							,$row->user_name, $row->user_username, $row->user_password, $row->user_email
							, $row->user_mobile,
							'<span class=\'modify_admin\' id='.$row->user_id.'>Modify</span>'
					);
				}

				break;
			case 'la_lancers':
				$this->db->where('user_role','user');
				$Q=$this->db->get('la_users');
				foreach ($Q-> result() as $row){
					$this->table->add_row('<input type="checkbox"
							name="check_list[]" value=\''. $row->user_id .'\'/>',
							$row->user_name,$row->user_email,
							$row->user_skills, $row->user_level,
							'<span class=\'lancer_details_button\' id='.$row->user_id.'>Details</span>',
							'<span id = '.$row->user_id.' class=\'modify_lancer\'>Modify</span>'
					);
				}

				break;
			case 'la_projects':
				$Q=$this->db->get($table_data);
				foreach ($Q-> result() as $row){
					$lancer_name_query = $this->HomeModel->get_where('la_users',
							array('user_id' => $row->pr_lancerid,));
					$agreement = (bool)$row->pr_admincuragree && (bool)$row->pr_admindlagree &&
					(bool)$row->pr_lancerdlagree && (bool)$row->pr_lancercuragree;
					if($agreement != 1)
						$agreement ='No';
					else $agreement = 'Yes';

					$lancer_name = $lancer_name_query->row();
					$this->table->add_row('<input type="checkbox"
							name="check_list[]" value=\''. $row->pr_id .'\' />',
							$row->pr_title,$row->pr_requires,
							$row->pr_dl, $agreement,
							$lancer_name->user_name,
							anchor(base_url().'home/c_panel/project/'.$row->pr_id,'Show')
					);
				}
				break;

			case 'main':
				break;



			default:
				echo "";
		}


		echo $this->table->generate();
		echo form_submit('submit','Delete');
		echo form_close();

		//insert level form
		if($table_data=='la_admins')
		{
			echo "<button class='add_admin add'>Add admin</button>";
		}

		//insert class form
		if($table_data=='la_lancers' )
		{
			echo "<button class='add_lancer add'>Add lancer</button>";
		}

		//insert room form
		if($table_data=='la_projects')
		{
			echo "<button class='add_project add'>Add project</button>";

		}
	}


	if($this->session->userdata('user_role')=='user')
	{

		$user_name=$this->session->userdata('user_username');

		$att = array('id' => 'table_form');
		echo form_open('', $att);
		$tmpl = array ( 'table_open'  => '<table class = "mytable"
				cellpadding = "5" cellspacing = "3">'
		);
		$this->table->set_template($tmpl);
		switch ($table_data)
		{
			case 'la_projects':
				$this->table->set_heading(
				'Title','Requirements','Deadline','Agreement','Freelancer','Show project'
						);
						break;

			default:
				echo"";


		}
		$user_id = $this->session->userdata('user_id');
		$user_projects = $this->HomeModel->get_where('la_projects',array('pr_lancerid' => $user_id));
		foreach ($user_projects->result() as $row)
		{
			switch($table_data)
			{

				case 'la_projects':
					$lancer_name_query = $this->HomeModel->get_where('la_users',
					array('user_id' => $row->pr_lancerid,));
					$agreement = (bool)$row->pr_admincuragree && (bool)$row->pr_admindlagree &&
					(bool)$row->pr_lancerdlagree && (bool)$row->pr_lancercuragree;
					if($agreement != 1)
						$agreement ='No';
					else $agreement = 'Yes';

					$lancer_name = $lancer_name_query->row();
					$this->table->add_row(
							$row->pr_title,$row->pr_requires,
							$row->pr_dl, $agreement,
							$lancer_name->user_name,
							anchor(base_url().'home/c_panel/project/'.$row->pr_id,'Show')
					);

					break;

				case 'main':

					break;

				default:
					echo "";
			}




		}




		echo $this->table->generate();
		echo form_close();


	}
}


if($table_data=='main')
{
	$user_role = $this->session->userdata('user_role');
	$user = ($user_role == 'admin'? 'admin' : 'lancer');
	$user_id = $this->session->userdata('user_id');
	if($user_role == 'user')
		$unseen_projects = $this->HomeModel->get_where('la_projects', array('pr_'.$user.'seen' => '0', 'pr_lancerid' => $user_id));
	else
		$unseen_projects = $this->HomeModel->get_where('la_projects', array('pr_'.$user.'seen' => '0'));

	if($unseen_projects->num_rows() > 0)
		
		foreach($unseen_projects->result() as $project)
		{
			echo "<div class = 'project_div'>";
			echo "Project title: " . $project->pr_title . "<br/>";
			echo "Last update: " . $project->pr_lastupdated . "<br/>";
			echo "Update type: " . $project->pr_updatetype . "<br/>";
			echo "<a href='" .base_url(). "home/c_panel/project/" . $project->pr_id."'>Show</a>";
			echo "</div>";
		}
		else echo "<p style='color:red;'>Nothing new</p>";

}

if($table_data == 'project')
{
	echo "<span id = 'project_details_span'>Project details</span>";
	echo "<div id = 'project_accordion'>";
	$user_role = $this->session->userdata('user_role');
	$user = ($user_role == 'admin'? 'admin':'lancer');
	$project_query = $this->HomeModel->get_where('la_projects',array('pr_id'=>$project_id));
	$this->db->where('pr_id',$project_id);
	$this->db->update('la_projects',array('pr_'.$user.'seen' => 1));
	foreach($project_query->result() as $row)
	{
		$lancer_name_query = $this->HomeModel->get_where('la_users',
				array('user_id' => $row->pr_lancerid));
		$lancer_name = $lancer_name_query->row();
		if($row->pr_deliver==1)  $delivered = 'YES';	else $delivered = "NO";
		if($row->pr_paymented==1) $paymented = "YES"; else $paymented = "NO";
		$project_array = array(
				'pr_title'			=> array("Title"	=> $row->pr_title),
				'pr_lancerid'		=> array("Lancer"	=> $lancer_name->user_name),
				'pr_requires'		=> array("Requirements"	=> $row->pr_requires),
				'pr_obj'			=> array("Objectives"	=> $row->pr_obj),
				'pr_desc'			=> array("Description"	=> $row->pr_desc),
				'pr_sd'				=> array("Start date"	=> $row->pr_sd),
				'pr_ed'				=> array("End date"		=> $row->pr_ed),
				'pr_dl'				=> array("Deadline"		=> $row->pr_dl),
				'pr_currency'		=> array("Currency"		=> $row->pr_currency),
				'pr_admincuragree'	=> array("Admin currency approval"	=> $row->pr_admincuragree),
				'pr_admindlagree'	=> array("Admin deadline approval"	=> $row->pr_admindlagree),
				'pr_lancercuragree'	=> array("Lancer currency approval"	=> $row->pr_lancercuragree),
				'pr_lancerdlagree'	=> array("Lancer deadline approval"	=> $row->pr_lancerdlagree),
				'pr_deliver'		=> array("Delivered?"	=> $delivered),
				'pr_paymented'		=> array("Paymented?"	=> $paymented),
				'pr_lastupdated'	=> array("Last update"	=> $row->pr_lastupdated)
		);
		echo form_open('/home/update_project','id = "update_project_form"');
		echo "<table id = 'project_details_table'>";
		echo form_hidden('pr_id',$row->pr_id);
		$i=0;
		echo "<tr>";
		if ($user_role == 'admin')
			foreach($project_array as $name => $input)
			foreach($input as $label => $value)
			{
				if ($i>1) echo "<tr>";
				if($name == 'pr_requires' || $name == 'pr_desc' || $name == 'pr_obj')
				{
					echo "<tr><td><label for='".$name."'>".$label . ": " . "</label>"."</td><td colspan = '3'>" .
							"<textarea cols = '100' name = '" . $name . "'>".$value . "</textarea>" . "</td></tr>";

				}
				elseif($name == 'pr_sd' || $name == 'pr_ed' || $name == 'pr_dl')
				{
					echo "<td><label for='".$name."'>".$label . ": " ."</label>"."</td><td>".
							form_input($name,$value,'class = date_input'). "</td>";
				}
				elseif($name == 'pr_admincuragree' || $name == 'pr_admindlagree' ||
						$name == 'pr_lancercuragree' || $name == 'pr_lancerdlagree' ||
						$name == 'pr_deliver' || $name == 'pr_paymented'
				)
				{
					
					$this->HomeModel->approvalbutton($name,$value,$label);

				}
				elseif($name == 'pr_lastupdated')
				{
					echo "<td><label for='".$name."'>".$label . ": " ."</label>"."</td><td>".
							$value. "</td>";
				}
				elseif($name == 'pr_lancerid')
				{
					$lancers = $this->HomeModel->get_lancers();
					echo "<td><label for='".$name."'>".$label . ": " ."</label>"."</td><td>".
							form_dropdown($name,$lancers,$row->pr_lancerid) . "</td>";
				}
				else
					echo "<td><label for='".$name."'>".$label . ": " ."</label>"."</td><td>". form_input($name,$value). "</td>";
				$i++;
				if ($i>1) {
					echo "</tr>"; $i=0;
				}
			}
			if($user_role == "user")
			{
				foreach($project_array as $name => $input)
					foreach($input as $label => $value)
					{
						if ($i>1) echo "<tr>";
						if($name == 'pr_requires' || $name == 'pr_desc' || $name == 'pr_obj')
						{
							echo "<tr><td><label for='".$name."'>".$label . ": " . "</label>"."</td><td colspan = '3'>" .
									"<textarea disabled cols = '100' name = '" . $name . "'>".$value . "</textarea>" . "</td></tr>";
								
						}
						elseif($name == 'pr_lancercuragree' || $name == 'pr_lancerdlagree'
						)
						{
							$label = explode(' ', $label);
							$label = $label[1]. ' ' . $label[2];
							$this->HomeModel->approvalbutton($name,$value,$label);
								
						}

						elseif($name == 'pr_dl')
						{
							echo "<td><label for='".$name."'>".$label . ": " ."</label>"."</td><td>".
									form_input($name,$value,'class = date_input'). "</td>";
						}
						elseif($name == 'pr_currency')
						{
							echo "<td><label for='".$name."'>".$label . ": " ."</label>"."</td><td>".
									form_input($name,$value). "</td>";
						}
						elseif($name == 'pr_admindlagree' || $name == 'pr_admincuragree' ||
								$name == 'pr_paymented' || $name == 'pr_deliver' ||
								$name == 'pr_lancerid'
						)
						break;
						else
							echo "<td><label for='".$name."'>".$label . ": " ."</label>"."</td><td>". $value. "</td>";
						$i++;
						if ($i>1) {
							echo "</tr>"; $i=0;
						}
							
							
					}
			}
			echo "<tr><td>".form_submit('Submit','Update')."</td></tr>";
			echo "</table>";
			echo form_close();
			echo "</div>";

			$comments=json_decode($this->HomeModel->get_comments($row->pr_id));
			$user_id = $this->session->userdata('user_id');
			echo "<div id ='comments_div'>";
			foreach($comments as $comment)
			{
				$user_query = $this->HomeModel->get_where('la_users',
						array('user_id' => $comment->co_userid));
				$user = $user_query->row();
				echo "<div class = 'comment_div'>";
				echo "By: " . "<span style='color:red;'>" . $user->user_name .
				"</span>" . " at: " . $comment->co_date;
				if($comment->co_userid == $user_id)
				echo "<span style='color:blue; float:right;'><a href='".base_url()."home/delete_comment/".$comment->co_id."/".$row->pr_id."'>delete</a></span>";
				echo "<p>" . $comment->co_comment . "</p>";
				$comment_attachs = $this->HomeModel->get_where('la_attachments', array('at_commentid' => $comment->co_id));
				echo "<p>";
				foreach($comment_attachs->result() as $attach)
				{
					
					$file_name = explode("_", basename($attach->at_attach));
					$file_ext = explode (".", basename($attach->at_attach));
					if($file_name[0] !='')
					echo "<a href='" . $attach->at_attach . "' target = '_blank'>". $file_name[0]. '.'. $file_ext[1]. "</a> -- ";
				}
				echo "</p></div>";
			}
			echo "<div style='background-color:#ccc;'>";
			$att=array('id'=>'comment_insert_form');
			$user_id=$this->session->userdata('user_id');


			echo form_open('home/add_comment',$att);
			echo "<table id = 'add_comment_table'>";
			echo form_hidden('co_projectid',$row->pr_id);
			echo form_hidden('co_userid',$user_id);
			echo "<tr><td>";
			echo "Add comment<br/>";
			echo "<textarea rows='5' cols='60' name='co_comment' ></textarea><br/>";
			echo form_submit('submit','Add comment');
			echo "</td>";				
			echo "<td style='width:50px;'></td>";
			echo "<td id = 'comment_td'>";
			echo '<div id="upload_div"><form>
					<input id="file_upload" name="file_upload" type="file" multiple="false"/>
					</form></div>';
			echo "</td></tr>";
			echo form_close();
			echo "</div></div>";
			
	}


}

