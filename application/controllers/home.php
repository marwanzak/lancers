<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_isvalidated();
		$this->check_dropbox();


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
		$comment_query = $this->db->query('SELECT * FROM la_comments WHERE co_id = (SELECT MAX(co_id)  FROM la_comments)');
		$comment_id = $comment_query->row();
		if(!empty($_POST['comment_files']))
		{
			foreach ( $_POST ['comment_files'] as $check)
			{
				$this->db->insert('la_attachments', array('at_attach' => $check, 'at_commentid' => $comment_id->co_id));
			}
		}
		$user_role = $this->session->userdata('user_role');
		$admin_seen = $user_role == 'admin';
		$lancer_seen = $user_role == 'user';
		$this->db->where('pr_id',$_POST['co_projectid']);
		$this->db->update('la_projects',array('pr_lastupdated' => mdate($datestring, $time),
				'pr_adminseen' => $admin_seen, 'pr_lancerseen' => $lancer_seen, 'pr_updatetype' => 'Comment'));
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
				'user_name' 		=> $_POST['user_name'],
				'user_username' 	=> $_POST['user_username'],
				'user_password' 	=> $_POST['user_password'],
				'user_email' 		=> $_POST['user_email'],
				'user_mobile'	 	=> $_POST['user_mobile'],
				'user_role' 		=>'admin'
		);
		$this->db->insert('la_users',$att);
		redirect('home/c_panel/la_admins','refresh');


	}

	//////////////
	public function add_lancer(){

		$att = array(
				'user_name' 		=> $_POST['user_name'],
				'user_username' 	=> $_POST['user_username'],
				'user_password' 	=> $_POST['user_password'],
				'user_email' 		=> $_POST['user_email'],
				'user_mobile' 		=> $_POST['user_mobile'],
				'user_country' 		=> $_POST['user_country'],
				'user_city' 		=> $_POST['user_city'],
				'user_paymethod' 	=> $_POST['user_paymethod'],
				'user_level' 		=> $_POST['user_level'],
				'user_skills'	 	=> $_POST['user_skills'],
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
		$datestring = "%Y/%m/%d - %h:%i %a";
		$time = time();

		$att = array(
				'pr_title' 		=> $_POST['pr_title'],
				'pr_requires' 	=> $_POST['pr_requires'],
				'pr_currency' 	=> $_POST['pr_currency'],
				'pr_dl' 		=> $_POST['pr_dl'],
				'pr_obj' 		=> $_POST['pr_obj'],
				'pr_desc' 		=> $_POST['pr_desc'],
				'pr_lancerid' 	=> $_POST['pr_lancerid'],
				'pr_admincuragree'	=> $_POST['pr_admincuragree'],
				'pr_admindlagree'	=> $_POST['pr_admindlagree'],
				'pr_lastupdated' => mdate($datestring, $time),
				'pr_adminseen' => '1',
				'pr_lancerseen' => '0',
				'pr_updatetype' => 'New project'
		);
		$this->db->insert('la_projects',$att);
		redirect('home/c_panel/la_projects','refresh');


	}
	


	//////////////////
	public function modify_lancer() {
		$lancer_past_id = $_POST['hidden_past_lancer_name'];
		$att1 = array(
				'user_name' 		=> $_POST ['user_name'],
				'user_username'		=> $_POST ['user_username'],
				'user_password'		=> $_POST ['user_password'],
				'user_email'		=> $_POST ['user_email'],
				'user_mobile'		=> $_POST ['user_mobile'],
				'user_country'		=> $_POST ['user_country'],
				'user_city'			=> $_POST ['user_city'],
				'user_paymethod'	=> $_POST ['user_paymethod'],
				'user_skills'		=> $_POST ['user_skills'],
				'user_level'		=> $_POST ['user_level']
		);
		$this->db->where('user_id',$lancer_past_id);
		$this->db->update('la_users', $att1);
		redirect('home/c_panel/la_lancers','refresh');

	}

	//////////////////
	public function modify_admin() {
		$admin_past_id = $_POST['hidden_past_admin_name'];
		$att1 = array(
				'user_name' 		=> $_POST ['user_name'],
				'user_username'		=> $_POST ['user_username'],
				'user_password'		=> $_POST ['user_password'],
				'user_email'		=> $_POST ['user_email'],
				'user_mobile'		=> $_POST ['user_mobile']
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
	
	private function check_dropbox(){
		if(! $this->session->userdata('oauth_token')){
			redirect('dropboxauth');
		}
		$params['key'] = 'qiz7e5nbuptai5y';
		$params['secret'] = 'f4y9x2t0yzjjne9';
		$params['access'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
				'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));

		$this->load->library('dropbox', $params);
	}
	///////////////////
	public function do_logout(){
		$this->session->sess_destroy();
		redirect('login');
	}

	/////////////////
	public function update_project(){
		$datestring = "%Y/%m/%d - %h:%i %a";
		$time = time();
		$user = $this->session->userdata('user_role');
		if($user == 'admin')
		$att = array(
				'pr_title' 		=> $_POST['pr_title'],
				'pr_requires' 	=> $_POST['pr_requires'],
				'pr_currency' 	=> $_POST['pr_currency'],
				'pr_dl' 		=> $_POST['pr_dl'],
				'pr_sd' 		=> $_POST['pr_sd'],
				'pr_ed' 		=> $_POST['pr_ed'],
				'pr_obj' 		=> $_POST['pr_obj'],
				'pr_desc' 		=> $_POST['pr_desc'],
				'pr_lancerid' 	=> $_POST['pr_lancerid'],
				'pr_admincuragree'	=> $_POST['pr_admincuragree'],
				'pr_admindlagree'	=> $_POST['pr_admindlagree'],
				'pr_paymented'	=> $_POST['pr_paymented'],
				'pr_deliver'	=> $_POST['pr_deliver'],
				'pr_admindlagree'	=> $_POST['pr_admindlagree'],
				'pr_lastupdated' => mdate($datestring, $time),
				'pr_adminseen' => '1',
				'pr_lancerseen' => '0',
				'pr_updatetype' => 'Update project details'
		);
		else
			$att = array(
					'pr_dl'	=>$_POST['pr_dl'],
					'pr_lancerdlagree' => $_POST['pr_lancerdlagree'],
					'pr_lancercuragree' => $_POST['pr_lancercuragree'],
					'pr_currency' => $_POST['pr_currency'],
					'pr_lancerseen' => '1',
					'pr_adminseen' => '0',
					'pr_lastupdated' => mdate($datestring,$time),
					'pr_updatetype' => 'Update project details'
			);
		$this->db->where('pr_id', $_POST['pr_id']);
		$this->db->update('la_projects',$att);
		redirect(base_url().'home/c_panel/project/'.$_POST['pr_id'],'refresh');
		
	}
	
	///////////
	public function getFoldersTree()
	{
		$folder = $_POST['folder'];
		$tree = $this->HomeModel->dropbox_folderstree($folder);
		echo json_encode($tree, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
		
	}
	
	public function getFiles()
	{
		$folder = $_POST['folder'];
		$files = $this->HomeModel->dropbox_files($folder);
		echo json_encode($files, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
	
	}
	
	public function getFolders()
	{
		$folder = $_POST['folder'];
		$folders = $this->HomeModel->dropbox_folders($folder);
		echo json_encode($folders, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
	
	}
	
	public function createFolder(){
		$folder = $_POST['folder'];
		$current_folder = $_POST['current_folder'];
		$request = $this->dropbox->create_folder($current_folder . $folder, $root = "sandbox");
		$respond = (isset($request->error) ? $request->error : "The folder '".$request->path."' has been created");
		echo $respond;
		
	}

	public function uploadFile(){
		$folder = $_POST['folder'];
		$file = $_POST['file'];
		$request = $this-> dropbox->add($folder, $file, $params = array(), $root = "sandbox");
		$respond = ((isset($request->error) || $request == null) ? $request : "The file '".$request->path."' has been created");
		var_dump($respond);
	}

}
