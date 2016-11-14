<?php
	class Agents_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function get_agents($parameters)
		{
			
			$this->db->select('*');
			$this->db->from('agents');
			$this->db->join('agent_pricing', 'agents.id = agent_pricing.agent_id');
			$this->db->join('agent_affil_links', 'agents.id = agent_affil_links.agent_id');
			
			if(isset($parameters['type']) && !empty($parameters['type']))
			{
				$this->db->where('type = ' . $parameters['type']);		
			}
			
			if(isset($parameters['photos_floorplans_inc']))
			{
				$this->db->where('photos_floorplans_inc = ' . $parameters['photos_floorplans_inc']);		
			}
			
			if(isset($parameters['viewings_package_offered']))
			{
				$this->db->where('viewings_package_offered = '. $parameters['viewings_package_offered']);
			}
			
			if(isset($parameters['expert_local_agent']))
			{
				$this->db->where('expert_local_agent = '. $parameters['expert_local_agent']);
			}
			
			if(isset($parameters['order_by']) && !empty($parameters['order_by']))
			{
				$orderDirection = ($parameters['order_by'] == 'base_price' ? 'ASC' : 'DESC');
				$this->db->order_by($parameters['order_by'], $orderDirection);
			}
						
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_agents_with_type($type)
		{
			$this->db->select('*');
			$this->db->from('agents');
			$this->db->join('agent_pricing', 'agents.id = agent_pricing.agent_id');
			$this->db->join('agent_affil_links', 'agents.id = agent_affil_links.agent_id');
			$this->db->where('type = ' . $type . '');
			$query = $this->db->get();
			return $query->result_array();
		}
			
		
	}