<?php
	
	header('Content-type: application/json');
	error_reporting(E_ERROR | E_PARSE);
	defined('BASEPATH') OR exit('No direct script access allowed');	
	
	class Ratings extends CI_controller
	{
		
		function __construct() {
			parent::__construct();
			$this->load->model('cron/Ratings_model');
		}
		
		public function index()
		{
			$data = $this->Ratings_model->put_averages();
			if($data) {
				echo json_encode(array('status' => 0, 'message' => 'Success'));
			}
		}
		
	}