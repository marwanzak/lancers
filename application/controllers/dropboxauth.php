<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dropboxauth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
	public function index()
	{
		$this->request_dropbox();
	}
	// Call this method first by visiting http://SITE_URL/example/request_dropbox
	public function request_dropbox()
	{
		$params['key'] = 'qiz7e5nbuptai5y';
		$params['secret'] = 'f4y9x2t0yzjjne9';

		$this->load->library('dropbox', $params);
		$data = $this->dropbox->get_request_token(site_url("dropboxauth/access_dropbox"));
		$this->session->set_userdata('token_secret', $data['token_secret']);
		redirect($data['redirect']);
	}
	//This method should not be called directly, it will be called after
	//the user approves your application and dropbox redirects to it
	public function access_dropbox()
	{
		$params['key'] = 'qiz7e5nbuptai5y';
		$params['secret'] = 'f4y9x2t0yzjjne9';

		$this->load->library('dropbox', $params);

		$oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));

		$this->session->set_userdata('oauth_token', $oauth['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
		redirect('home');
	}

	
}
