<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_isvalidated();
	
	}

	public function index()
	{
		$this->c_panel('main');
		
	}
	
	public function c_panel($table_data){
		$data ['table_data'] = $table_data;
		
		$this->load->view('header');
		$this->load->view('content', $data);
		$this->load->view('footer');
		
	}
	
	
	////////////////////
	public function delete_query($table, $where, $value)
	{
		echo $this->HomeModel->delete_query($table, $where, $value);
	}
	///////////////////
	public function ins_query($table, $data)
	{
		$this->HomeModel->Insert_query($table, $data);
	}
	
	//////////////
	public function add_admin(){
	
		$att = array(
				'admin_name' 		=> $_POST['admin_name'],
				'admin_username' 	=> $_POST['admin_username'],
				'admin_password' 	=> $_POST['admin_password'],
				'admin_email' 		=> $_POST['admin_email'],
				'admin_mobile'	 	=> $_POST['admin_mobile']
		);
		$this->db->insert('la_admins',$att);
		redirect('home/c_panel/la_admins','refresh');
		
	
	}
	
	//////////////
	public function add_lancer(){
	
		$att = array(
				'lancer_name' 		=> $_POST['lancer_name'],
				'lancer_username' 	=> $_POST['lancer_username'],
				'lancer_password' 	=> $_POST['lancer_password'],
				'lancer_email' 		=> $_POST['lancer_email'],
				'lancer_mobile' 	=> $_POST['lancer_mobile'],
				'lancer_country' 	=> $_POST['lancer_country'],
				'lancer_city' 		=> $_POST['lancer_city'],
				'lancer_paymethod' 	=> $_POST['lancer_paymethod'],
				'lancer_level' 		=> $_POST['lancer_level'],
				'lancer_skills'	 	=> $_POST['lancer_skills']
		);
		$this->db->insert('la_lancers',$att);
		redirect('home/c_panel/la_lancers','refresh');	
	}
	
	//////////////////////////
	public function get_lancer(){
		$lancer_id = $_POST['lancer_id'];
		$lancer_query = $this->HomeModel->get_where('la_lancers',array('lancer_id'=>$lancer_id));
		echo json_encode($lancer_query->result(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
	
	}
	
	//////////////////////////
	public function get_admin(){
		$admin_id = $_POST['admin_id'];
		$admin_query = $this->HomeModel->get_where('la_admins',array('admin_id'=>$admin_id));
		echo json_encode($admin_query->result(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
	
	}
	
	//////////////
	public function add_project(){
	
		$att = array(
				'pr_title' 		=> $_POST['pr_title'],
				'pr_requires' 	=> $_POST['pr_requires'],
				'pr_currency' 	=> $_POST['pr_currency'],
				'pr_dl' 		=> $_POST['pr_dl'],
				'pr_obj' 		=> $_POST['pr_obj'],
				'pr_desc' 		=> $_POST['pr_desc'],
				'pr_attach' 	=> $_POST['pr_attach'],
				'pr_lancerid' 	=> $_POST['pr_lancerid'],
				'pr_admincuragree' => $_POST['pr_admincuragree'],
				'pr_admindlagree' => $_POST['pr_admindlagree']
		);
		$this->db->insert('la_projects',$att);
		redirect('home/c_panel/la_projects','refresh');
	
	
	}
	

	//////////////////
	public function modify_lancer() {
		$lancer_past_id = $_POST['hidden_past_lancer_name'];
		$att1 = array(
				'lancer_name' 		=> $_POST ['lancer_name'],
				'lancer_username'	=> $_POST ['lancer_username'],
				'lancer_password'	=> $_POST ['lancer_password'],
				'lancer_email'		=> $_POST ['lancer_email'],
				'lancer_mobile'		=> $_POST ['lancer_mobile'],
				'lancer_country'	=> $_POST ['lancer_country'],
				'lancer_city'		=> $_POST ['lancer_city'],
				'lancer_paymethod'	=> $_POST ['lancer_paymethod'],
				'lancer_skills'		=> $_POST ['lancer_skills'],
				'lancer_level'		=> $_POST ['lancer_level']
		);
		$this->db->where('lancer_id',$lancer_past_id);
		$this->db->update('la_lancers', $att1);
		redirect('home/c_panel/la_lancers','refresh');
		
	}
	
	//////////////////
	public function modify_admin() {
		$admin_past_id = $_POST['hidden_past_admin_name'];
		$att1 = array(
				'admin_name' 		=> $_POST ['admin_name'],
				'admin_username'	=> $_POST ['admin_username'],
				'admin_password'	=> $_POST ['admin_password'],
				'admin_email'		=> $_POST ['admin_email'],
				'admin_mobile'		=> $_POST ['admin_mobile']
		);
		$this->db->where('admin_id',$admin_past_id);
		$this->db->update('la_admins', $att1);
		redirect('home/c_panel/la_admins','refresh');
	
	}
	
	////////////////
	public function delete_list() {
		$table_name = $_POST ['hidden_table_name'];
		$item_id    = $_POST ['hidden_item_id'];
		if(!empty($_POST['check_list']))
		{
			foreach ( $_POST ['check_list'] as $check)
			{
				$this->delete_query( $table_name, $item_id, $check);
			}
		}
		redirect('home/c_panel/'.$table_name,'refresh');
	}
	//////////////////
	private function check_isvalidated(){
		if(! $this->session->userdata('validated')){
			redirect('login');
		}
	}
	///////////////////
	public function do_logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
	
	
	
	}
	