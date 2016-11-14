<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trustpilot_reviews extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->model('api/reviews_model');
        $this->load->helper('url');
    }

    public function index()
    {

        $id = $this->uri->segment(2);

        $apiCall = read_file(base_url() . '/api/reviews?id=' . $id);

        $data['reviews'] = json_decode($apiCall, true);


        $this->load->view('templates/header');
        $this->load->view('trustpilot-reviews', $data);
        $this->load->view('templates/footer');
    }

}
