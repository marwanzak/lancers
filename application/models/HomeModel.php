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
	

}
