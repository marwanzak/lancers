<?php 
if($table_data!='main')
	if($this->session->userdata('user_role')=='admin')
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
								echo form_hidden('hidden_item_id','admin_id');
								break;
			case 'la_lancers':
				$this->table->set_heading('<input type="checkbox"
						name="lancers_check" value="all" />',
						'Full Name','Email','Skills','Level','More details','Modify'
								);
								echo form_hidden('hidden_table_name',$table_data);
								echo form_hidden('hidden_item_id','lancer_id');
								break;
			case 'la_projects':
				$this->table->set_heading('<input type="checkbox"
						name="projects_check" value="all" />',
						'Title','Requirements','Deadline','Agreement','Freelancer','More details','Modify'
								);
								echo form_hidden('hidden_table_name',$table_data);
								echo form_hidden('hidden_item_id','pr_id');
								break;
			
			case 'main':

										break;

		}
		$Q=$this->db->get($table_data);
		foreach ($Q-> result() as $row){
			switch ($table_data){
				case 'la_admins':
					$this->table->add_row('<input type="checkbox"
							name="check_list[]" value=\''. $row->admin_id .'\'/>'
							,$row->admin_name, $row->admin_username, $row->admin_password, $row->admin_email
							, $row->admin_mobile,							
							'<span class=\'modify_admin\' id='.$row->admin_id.'>Modify</span>'
					);

					break;
				case 'la_lancers':
					$this->table->add_row('<input type="checkbox"
							name="check_list[]" value=\''. $row->lancer_id .'\'/>',
							$row->lancer_name,$row->lancer_email,
							$row->lancer_skills, $row->lancer_level,
							'<span class=\'lancer_details_button\' id='.$row->lancer_id.'>Details</span>',
							'<span id = '.$row->lancer_id.' class=\'modify_lancer\'>Modify</span>'
					);

					break;
				case 'la_projects':
					$lancer_name_query = $this->HomeModel->get_where('la_lancers',
										 array('lancer_id' => $row->pr_lancerid));
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
							$lancer_name->lancer_name,
							'<span class=\'project_details_button\' id='.$row->pr_id.'>Details</span>',		
							'<span id = '.$row->pr_id.' class=\'modify_project\'>Modify</span>'
							
					);

					break;

				case 'main':
					$this->table->add_row(	);
									break;



				default:
					echo "";
			}
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


		//insert report form
		if($table_data=='aq_reports')
		{


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
			case 'aq_tests':
				$this->table->set_heading(
				'اسم المعيار','المرحلة','الصف','المادة','مجموع المهارات'

						);
						echo form_hidden('hidden_table_name',$table_data);
						echo form_hidden('hidden_item_id','test_id');
						break;
			case 'aq_skills':
				$this->table->set_heading('المرحلة','الصف','المادة','اسم المهارة' ,'المعيار' ,'أقل درجة',
				'أعلى درجة'
						);
						echo form_hidden('hidden_table_name',$table_data);
						echo form_hidden('hidden_item_id','skill_id');
						break;


			case 'aq_marks':
				$this->table->set_heading('المرحلة', 'الصف', 'الفصل', 'المادة', 'المعيار', 'المهارة', 'الطالب','العلامة'
						);


				break;
			default:
				echo"";
					
					
		}
		foreach ($permit_query->result() as $row)
		{
			$permit_tests=$this->HomeModel->get_where('aq_tests', array('test_level'=>$row->permit_level,
					'test_class'=>$row->permit_class, 'test_subject'=>$row->permit_subject
			));
			foreach($permit_tests -> result() as $row1)
				$skills_num=$this->HomeModel->get_where('aq_skills',
						array('skill_test' => $row1->test_name,'skill_level'=> $row1->test_level,
								'skill_class'=> $row1->test_class ,'skill_subject'=>$row1->test_subject));
			{
				switch($table_data)
				{

					case 'aq_tests':
						$this->table->add_row($row1->test_name,$row1->test_level,$row1->test_class, $row1->test_subject,
						$skills_num->num_rows()
						);
						break;

					case 'aq_skills':
						foreach($skills_num-> result() as $row2)
						{



							$this->table->add_row($row2->skill_level,
									$row2->skill_class,$row2->skill_subject,
									$row2->skill_name,$row2->skill_test, $row2->min_grade,
									$row2->max_grade

							);
						}
						break;
							
					case 'aq_marks':
						$permit_marks=$this->HomeModel->get_where('aq_marks', array('mark_level'=>$row->permit_level,
						'mark_class'=>$row->permit_class, 'mark_subject'=>$row->permit_subject,
						'mark_room' => $row->permit_room
						));

						foreach($permit_marks -> result() as $row3)
						{
							$mark_st=$this->HomeModel->get_where('aq_students', array('st_id'=>$row3->mark_student
							));
							foreach($mark_st->result() as $student_fn)
								$this->table->add_row($row3->mark_level,
										$row3->mark_class,$row3->mark_room,
										$row3->mark_subject,$row3->mark_test, $row3->mark_skill,
										$student_fn->st_fna . ' ' . $student_fn->st_ffna . ' ' . $student_fn->st_lna,
										$row3->mark_value

								);

						}
						break;
					default:
						echo"";
				}


			}

		}




		echo $this->table->generate();
		echo form_close();


		//insert mark form
		if($table_data=='aq_marks')
		{
			echo "<button class='add_mark'>إضافة علامة</button>";
				

		}

	}

                             