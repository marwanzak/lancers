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
		echo $this->Mhome->delete_query($table, $where, $value);
	}
	///////////////////
	public function ins_query($table, $data)
	{
		$this->Mhome->Insert_query($table, $data);
	}
	
	
	////////////////
	public function delete_list() {
		$table_name = $_POST ['hidden_table_name'];
		$item_id    = $_POST ['hidden_item_id'];
		if( ! empty ( $_POST ['check_list'] ) )
		{
			foreach ( $_POST ['check_list'] as $check)
			{
				$this->delete_query( $table_name, $item_id, $check);
			}
		}
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
	