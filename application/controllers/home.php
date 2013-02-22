<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {


	public function index()
	{
		$this->c_panel();
	}
	
	public function c_panel(){
		$this->load->view('header');
		$this->load->view('content');
		$this->load->view('footer');
		
	}
	
	
	
}
