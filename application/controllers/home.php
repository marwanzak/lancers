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
	
	public function c_panel($table_data,$project_id = ''){
		$data ['table_data'] = $table_data;
		$data['project_id'] = $project_id;
		$this->load->view('header');
		$this->load->view('content', $data);
		$this->load->view('footer');
		
	}
	
	public function add_comment(){
		$datestring = "%Y/%m/%d - %h:%i %a";
		$time = time();
		$att = array(
			'co_comment' => $_POST['co_comment'],
			'co_userid' => $_POST['co_userid'],
			'co_projectid' => $_POST['co_projectid'],
			'co_date' => mdate($datestring, $time)
				
				);
		$this->db->insert('la_comments', $att);
		redirect(base_url().'home/c_panel/project/'.$att['co_projectid'],'refresh');
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
				'user_name' 		=> $_POST['admin_name'],
				'user_username' 	=> $_POST['admin_username'],
				'user_password' 	=> $_POST['admin_password'],
				'user_email' 		=> $_POST['admin_email'],
				'user_mobile'	 	=> $_POST['admin_mobile'],
				'user_role' 		=>'admin'
		);
		$this->db->insert('la_users',$att);
		redirect('home/c_panel/la_admins','refresh');
		
	
	}
	
	//////////////
	public function add_lancer(){
	
		$att = array(
				'user_name' 		=> $_POST['lancer_name'],
				'user_username' 	=> $_POST['lancer_username'],
				'user_password' 	=> $_POST['lancer_password'],
				'user_email' 		=> $_POST['lancer_email'],
				'user_mobile' 	=> $_POST['lancer_mobile'],
				'user_country' 	=> $_POST['lancer_country'],
				'user_city' 		=> $_POST['lancer_city'],
				'user_paymethod' 	=> $_POST['lancer_paymethod'],
				'user_level' 		=> $_POST['lancer_level'],
				'user_skills'	 	=> $_POST['lancer_skills'],
				'user_role'			=> 'user'
		);
		$this->db->insert('la_users',$att);
		redirect('home/c_panel/la_lancers','refresh');	
	}
	
	//////////////////////////
	public function get_lancer(){
		$lancer_id = $_POST['user_id'];
		$lancer_query = $this->HomeModel->get_where('la_users',array('user_id'=>$lancer_id));
		echo json_encode($lancer_query->result(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
	
	}
	
	//////////////////////////
	public function get_admin(){
		$admin_id = $_POST['user_id'];
		$admin_query = $this->HomeModel->get_where('la_users',array('user_id'=>$admin_id));
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
				'pr_lancerid' 	=> $_POST['pr_lancerid'],
				'pr_admincuragree'	=> $_POST['pr_admincuragree'],
				'pr_admindlagree'	=> $_POST['pr_admindlagree']
		);
		$this->db->insert('la_projects',$att);
		redirect('home/c_panel/la_projects','refresh');
	
	
	}
	

	//////////////////
	public function modify_lancer() {
		$lancer_past_id = $_POST['hidden_past_lancer_name'];
		$att1 = array(
				'user_name' 		=> $_POST ['lancer_name'],
				'user_username'	=> $_POST ['lancer_username'],
				'user_password'	=> $_POST ['lancer_password'],
				'user_email'		=> $_POST ['lancer_email'],
				'user_mobile'		=> $_POST ['lancer_mobile'],
				'user_country'	=> $_POST ['lancer_country'],
				'user_city'		=> $_POST ['lancer_city'],
				'user_paymethod'	=> $_POST ['lancer_paymethod'],
				'user_skills'		=> $_POST ['lancer_skills'],
				'user_level'		=> $_POST ['lancer_level']
		);
		$this->db->where('user_id',$lancer_past_id);
		$this->db->update('la_users', $att1);
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
		$this->db->where('user_id',$admin_past_id);
		$this->db->update('la_users', $att1);
		redirect('home/c_panel/la_admins','refresh');
	
	}
	
	////////////////
	public function delete_list() {
		$table_name = $_POST ['hidden_table_name'];
		$item_id    = $_POST ['hidden_item_id'];
		if($table_name == 'la_admins' || $table_name == 'la_lancers')
			$table = 'la_users';
		else $table = $table_name;
		if(!empty($_POST['check_list']))
		{
			foreach ( $_POST ['check_list'] as $check)
			{
				$this->delete_query( $table, $item_id, $check);
			}
		}
		redirect('home/c_panel/'.$table_name,'refresh');
	}
	
	public function delete_comment($comment_id,$project_id){
		$this->delete_query('la_comments','co_id',$comment_id);
		$this->delete_query('la_attachments','at_commentid',$comment_id);
		redirect('home/c_panel/project/'.$project_id,'refresh');
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
	