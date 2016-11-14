<?php
	class Ratings_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->helper('simple_html_dom_helper');
			
			$this->load->database();
			$this->load->model('scraper/trustpilot_model');
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
		
		public function put_total_rating($data)
		{
			$data = $this->trustpilot_model->get_urls();
			$total_ratings = array();
			
			foreach($data as $agent)
			{
				$html = new Simple_html_dom();
				$html = file_get_html($agent['url']);
				
				$item['id'] = $agent['agent_id'];
				$item['total_rating'] = $html->find('.average', 0)->plaintext;
				
				array_push($total_ratings, $item);
				
			}
			
			foreach($total_ratings as $rating)
			{
				$this->db->set('trustpilot_total', $rating['total_rating']);
				$this->db->where('id', $rating['id']);
				$this->db->update('agents'); 
			}
			
		}
		
	}