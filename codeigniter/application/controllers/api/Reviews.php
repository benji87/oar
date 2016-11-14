<?php
	
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Reviews extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/reviews_model');
	}

	public function index_get()
	{

	    $parameters = $this->input->get(array('id'));

		$data = $this->reviews_model->get_reviews($parameters);

        //Convert timestamp to readable date d M y
        foreach ($data as $key => $value)
        {
            $date = new DateTime($data[$key]['timestamp']);
            $data[$key]['plain_datetime'] = $date->format('d M y');;
        }

        if (!empty($data))
        {
            $this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Reviews could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
		
		
		
	}

    public function time_convert($timestamp){
        return date('l Y/m/d H:i', $timestamp);
    }
}