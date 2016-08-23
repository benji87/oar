<?php
	class Trustpilot_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function get_review_ids()
		{
			
			$this->db->select('trustpilot_id');
			$this->db->from('trustpilot_reviews');						
			$query = $this->db->get();
			
			$trustpilot_ids = array();
			
			
			foreach ($query->result() as $row)
			{
				array_push($trustpilot_ids, $row->trustpilot_id);
			}
			
			return $trustpilot_ids;			
			
		}
		
		public function put_reviews($review)
		{
			
			$this->db->insert('trustpilot_reviews', $review);
		}
		
		public function get_urls()
		{
			$this->db->select('url');
			$this->db->from('trustpilot_urls');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		
	}