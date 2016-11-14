<?php
	class Reviews_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function get_reviews($parameters)
		{

			$this->db->select('*');
			$this->db->from('trustpilot_reviews');
            $this->db->where('agent_id = ' . $parameters['id']);
            $this->db->order_by('timestamp', 'DESC');
            $this->db->limit(10);

			$query = $this->db->get();
			return $query->result_array();
		}
		
	}