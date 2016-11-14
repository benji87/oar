<?php
	
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Agents extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/agents_model');
	}

	public function index_get()
	{
			
		$parameters = $this->input->get(array('type', 'photos_floorplans_inc', 'viewings_package_offered', 'expert_local_agent', 'order_by'));

		$data = $this->agents_model->get_agents($parameters);

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($data)
            {
                // Set the response and exit
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;
       

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retreival.
        // Usually a model is to be used for this.

        //$agent = NULL;
		$agent = array();

        if (!empty($data))
        {
			$i=0;
			foreach($data as $agents)
			{
				if($agents['id'] == $id)
				{
					$agent = $data[$i];
				}
				$i++;
			}

        }       
        

        if (!empty($agent))
        {
            $this->set_response($agent, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Agent could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
		
		
		
	}
	
	public function type_get()
	{
		$type = $this->get('is');
		$data = $this->agents_model->get_agents_with_type($type);
		
		if ($data)
        {
            // Set the response and exit
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
		
		
	}
}