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
	echo form_open('',$att);
	echo '<p><label>Full name</label>'. form_input('admin_name','','class=required').'</p>';
	echo '<p><label>Username</label>'. form_input('admin_username','','class=required').'</p>';
	echo '<p><label>Password</label>'. form_input('admin_password','','class=required').'</p>';
	echo '<p><label>Email</label>'. form_input('admin_email','','class=required').'</p>';
	echo '<p><label>Mobile</label>'. form_input('admin_mobile','','class=required').'</p>';
	echo '<p>'.form_submit('submit','Add admin').'</p>';
	echo form_close();
	?>
</div>

<!-- Insert Lancer form -->
<div id="add_lancer_dialog" title="Add Lancer Form" class='dialog_div'>
	<?php 
	$att=array('id'=>'lancer_insert_form');
	echo form_open('',$att);
	echo '<p><label>Full name</label>'. form_input('lacner_name','','class=required').'</p>';
	echo '<p><label>Username</label>'. form_input('lancer_username','','class=required').'</p>';
	echo '<p><label>Password</label>'. form_input('lancer_password','','class=required').'</p>';
	echo '<p><label>Email</label>'. form_input('lancer_email','','class=required').'</p>';
	echo '<p><label>Mobile</label>'. form_input('lancer_mobile','','class=required').'</p>';
	echo '<p><label>Country</label>'. form_input('lancer_country','','class=required').'</p>';
	echo '<p><label>City</label>'. form_input('lancer_city','','class=required').'</p>';
	echo '<p><label>Payment Method</label>'. form_input('lancer_paymethod','','class=required').'</p>';
	echo '<p><label>Lancer\'s Skills</label>'. form_input('lancer_skills','','class=required').'</p>';
	echo '<p><label>Lancer\'s level</label>'. form_input('lancer_level','','class=required').'</p>';
	echo '<p>'.form_submit('submit','Add admin').'</p>';
	echo form_close();
	?>
</div>

<!-- Insert Lancer form -->
<div id="add_lancer_dialog" title="Add Lancer Form" class='dialog_div'>
	<?php 
	$att=array('id'=>'lancer_insert_form');
	echo form_open('',$att);
	echo '<p><label>Full name</label>'. form_input('lacner_name','','class=required').'</p>';
	echo '<p><label>Username</label>'. form_input('lancer_username','','class=required').'</p>';
	echo '<p><label>Password</label>'. form_input('lancer_password','','class=required').'</p>';
	echo '<p><label>Email</label>'. form_input('lancer_email','','class=required').'</p>';
	echo '<p><label>Mobile</label>'. form_input('lancer_mobile','','class=required').'</p>';
	echo '<p><label>Country</label>'. form_input('lancer_country','','class=required').'</p>';
	echo '<p><label>City</label>'. form_input('lancer_city','','class=required').'</p>';
	echo '<p><label>Payment Method</label>'. form_input('lancer_paymethod','','class=required').'</p>';
	echo '<p><label>Lancer\'s Skills</label>'. form_input('lancer_skills','','class=required').'</p>';
	echo '<p><label>Lancer\'s level</label>'. form_input('lancer_level','','class=required').'</p>';
	echo '<p>'.form_submit('submit','Add admin').'</p>';
	echo form_close();
	?>
</div>


	



</body>
</html>