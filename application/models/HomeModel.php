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
		$query=$this->db->get('la_admins');
		foreach ($query->result() as $row){
			$admins[$row->admin_id]=$row->admin_name;

		}
		return $admins;
	}
	
	public function get_lancers(){
		$query=$this->db->get('la_lancers');
		foreach ($query->result() as $row){
			$lancers[$row->lancer_id]=$row->lancer_name;
	
		}
		return $lancers;
	}
	
	public function validate(){
		// grab user input
		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
	
		// Prep the query
		$this->db->where('admin_username', $username);
		$this->db->where('admin_password', $password);
	
		// Run the query
		$query = $this->db->get('la_admins');
		// Let's check if there are any results
		if($query->num_rows == 1)
		{
			// If there is a user, then create session data
			$row = $query->row();
			$data = array(
					'user_id' => $row->admin_id,
					'user_name' => $row->admin_name,
					'user_username' => $row->admin_username,
					'user_role' => 'admin',
					'validated' => true
			);
			$this->session->set_userdata($data);
			return true;
		}
		elseif($query->num_rows !== 1)
		{
			$this->db->where('lancer_username', $username);
			$this->db->where('lancer_password', $password);
			$query = $this->db->get('la_lancers');
			if($query->num_rows == 1)
			{
			$row = $query->row();
			$data = array(
					'user_id' => $row->lancer_id,
					'user_name' => $row->lancer_name,
					'user_username' => $row->lancer_username,
					'user_role' => 'lancer',
					'validated' => true
			);
			$this->session->set_userdata($data);
			return true;
			}	
			
			
		}
		// If the previous process did not validate
		// then return false.
		return false;
	}
	

}
