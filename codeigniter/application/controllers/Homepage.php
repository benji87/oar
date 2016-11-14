<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {


	function __construct() {
		parent::__construct();
		$this->load->model('api/agents_model');
	}

	public function index()
	{
		
		$apiCall = read_file(base_url() . '/api/agents');
		$data['agents'] = json_decode($apiCall, true);
		
		$this->load->view('templates/header');
		$this->load->view('homepage', $data);
		$this->load->view('templates/footer');
	}
}
