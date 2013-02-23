<?php 
if($table_data!='main')
	if($this->session->userdata('user_role')=='admin')
	{
		
		$att = array('id' => 'table_form');
		echo form_open('', $att);
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
							'<span class=\'modify_admin_button\' id='.$row->admin_id.'>Modify</span>'
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
					$lancer_name_query = $this->HomeModel('la_lancers', array('lancer_id' => $row->pr_lancerid));
					$lancer_name = $lancer_name_query->row();
					$this->table->add_row('<input type="checkbox"
							name="check_list[]" value=\''. $row->pr_id .'\' />',
							$row->pr_title,$row->pr_requires,
							$row->pr_dl, $row->pr_curagree && $row->pr_dlagree, 
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
			$att11=array('id'=>'report_form', 'target'=>'_blank');
				
			$levels = $this->Mhome->get_levels();
			$users = $this->Mhome->get_users();

			$begin_para = array('all'=>'الكل');
			echo "<div class='form_div'>";
				
			echo form_open(base_url().'Report/',$att11);
			echo '<p><label>المرحلة:</label>'. form_dropdown('report_level',$levels ,'','class="r_level_drop required"').'</p>';
			echo '<p><label>الصف:</label>'. form_dropdown('report_class',$begin_para ,'','class="r_class_drop required"').'</p>';
			echo '<p><label>الفصل:</label>'. form_dropdown('report_room',$begin_para ,'','class="r_room_drop required"').'</p>';
			echo '<p><label>المادة:</label>'. form_dropdown('report_subject',$begin_para,'','class="r_subject_drop required"').'</p>';
			echo '<p><label>المعيار:</label>'. form_dropdown('report_test',$begin_para ,'','class="r_test_drop required"').'</p>';
			echo '<p><label>المهارة:</label>'. form_dropdown('report_skill',$begin_para ,'','class="r_skill_drop required"').'</p>';
			echo '<p><label>اسم الطالب:</label>'. form_dropdown('report_student',$begin_para ,'','class="r_student_drop required"').'</p>';
			echo form_submit('submit','إظهار');
			echo form_close();
			echo "</div>";

		}




	


	if($this->session->userdata('user_role')=='user')
	{

		$user_name=$this->session->userdata('user_username');
		$permit_query = $this->Mhome->get_where('aq_permissions',
				array('permit_username'=>$user_name));
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
			$permit_tests=$this->Mhome->get_where('aq_tests', array('test_level'=>$row->permit_level,
					'test_class'=>$row->permit_class, 'test_subject'=>$row->permit_subject
			));
			foreach($permit_tests -> result() as $row1)
				$skills_num=$this->Mhome->get_where('aq_skills',
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
						$permit_marks=$this->Mhome->get_where('aq_marks', array('mark_level'=>$row->permit_level,
						'mark_class'=>$row->permit_class, 'mark_subject'=>$row->permit_subject,
						'mark_room' => $row->permit_room
						));

						foreach($permit_marks -> result() as $row3)
						{
							$mark_st=$this->Mhome->get_where('aq_students', array('st_id'=>$row3->mark_student
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




	?>
                                          
                                              		
                                              	</div><!-- end row -->
                                              </div><!-- end table -->
                                                  
                                          </div>
                                          
                                          
                          </div>
                          
                              </div>
                          </div>
                          </div>
                