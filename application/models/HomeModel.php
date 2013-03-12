<?php 
class HomeModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function get_where($table_where,$array_where)
	{
		$this->db->from($table_where)->where($array_where);
		return $this->db->get();
	}


	public function delete_query($table,$where,$value)

	{
		$this->db->where($where, $value);
		$this->db->delete($table);

	}


	public function get_admins(){
		$this->db->where('user_role','admin');
		$query=$this->db->get('la_users');
		foreach ($query->result() as $row){
			$admins[$row->user_id]=$row->user_name;

		}
		return $admins;
	}

	public function get_lancers(){
		$this->db->where('user_role','user');
		$query=$this->db->get('la_users');
		foreach ($query->result() as $row){
			$lancers[$row->user_id]=$row->user_name;

		}
		return $lancers;
	}

	/////////////////////
	public function get_comments($project_id){
		$comments = $this->HomeModel->get_where('la_comments',array('co_projectid'=>$project_id));
		return json_encode($comments->result(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );

	}

	public function dropbox_files($folder)
	{
		$filesarray = array();
		$link = $this->dropbox->metadata($folder,array(), $root='sandbox');

		foreach($link->contents as $file)
		{
			if (!$file->is_dir)
			{
				$newfile = $this->dropbox->media($file->path, $root='sandbox');
				$filearray = array($newfile->url => $file->path);
				$filesarray = array_merge($filesarray, $filearray);
			}

		}
		return $filesarray;
	}
	
	public function dropbox_folderstree($folder)
	{
		$folders_array = array ();
		$link = $this->dropbox->metadata($folder,array(), $root='sandbox');
		foreach($link->contents as $file)
		{
			if ($file->is_dir)
			{
				$sonfolder = array($file->path => $folder);
				$folders_array = array_merge($folders_array, $sonfolder);
				$newarray = $this->dropbox_folders($file->path);
				$folders_array = array_merge($folders_array, $newarray);
				
			}

		}
		return $folders_array;
	}
	
	public function dropbox_folders($folder)
	{
		$folders_array = array ();
		$link = $this->dropbox->metadata($folder,array(), $root='sandbox');
		foreach($link->contents as $file)
		{
			if ($file->is_dir)
			{
				$sonfolder = array($file->path => $folder);
				$folders_array = array_merge($folders_array, $sonfolder);
		
			}
		
		}
		return $folders_array;
	}


	public function validate(){
		// grab user input
		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));

		// Prep the query
		$this->db->where('user_username', $username);
		$this->db->where('user_password', $password);

		// Run the query
		$query = $this->db->get('la_users');
		// Let's check if there are any results
		if($query->num_rows == 1)
		{
			// If there is a user, then create session data
			$row = $query->row();
			$data = array(
					'user_id' => $row->user_id,
					'user_name' => $row->user_name,
					'user_username' => $row->user_username,
					'user_role' => $row->user_role,
					'validated' => true
			);
			$this->session->set_userdata($data);
			return true;
		}
		// If the previous process did not validate
		// then return false.
		return false;
	}
	public function approvalbutton($name,$value,$label)
	{

		if ($value == "NO") $value ='0';
		if ($value == "YES") $value = '1';
		if($value == '1'){
			$yes = 'checked'; $no = '';
		}
		elseif($value == '0') {
			$yes = ''; $no = 'checked';
		}
		echo "<td><label for ='".$name."'>".$label.": "."</label>"."</td><td>".
				'<div id='.$name.'>
						<input type="radio" id="ApproveButton_'.$name.'" name="'.$name.'" value = "1" '. $yes .' />
								<label id="ApproveButtonLabel_'.$name.'" for="ApproveButton_'.$name.'"></label>

										<input type="radio" id="RejectButton_'.$name.'" name="'.$name.'" value = "0"'. $no .' />
												<label id="RejectButtonLabel_'.$name.'" for="RejectButton_'.$name.'"></label>
														</div></td>';

	}

}
