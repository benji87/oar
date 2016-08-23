<?php
	class Ratings_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function put_averages()
		{
			
			$this->db->trans_start();
			
			$this->db->select('agent_id, AVG(rating)');
			$this->db->from('trustpilot_reviews');
			$this->db->group_by('agent_id'); 					
			$query = $this->db->get();
			

			foreach ($query->result_array() as $row)
			{			
				
				$this->db->set('trustpilot_average', $row['AVG(rating)']);
				$this->db->where('id', $row['agent_id']);
				$this->db->update('agents'); 
				
			}
			
			$this->db->trans_complete();
			
		}
	}