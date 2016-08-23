<?php
	
	header('Content-type: application/json');
	error_reporting(E_ERROR | E_PARSE);
	defined('BASEPATH') OR exit('No direct script access allowed');	
	
	class Trustpilot extends CI_controller
	{
		
		function __construct() {
			parent::__construct();
			$this->load->helper('simple_html_dom_helper');
			$this->load->helper('url');
			$this->load->model('scraper/trustpilot_model');
		}
		
		
		public function index()
		{
			
			$data = $this->trustpilot_model->get_urls();
			
			foreach($data as $agent)
			{
				
				$html = new Simple_html_dom();
				$html = file_get_html($agent['url']);				
	
				$ret = $html->find('h1 span');
				
				
				$review_ids = array();
				$reviews = array();
				
				foreach($html->find('.review') as $review)
				{
					
					//Grab all the user review details
					$item['trustpilot_id'] = $review->attr['data-reviewmid'];
					$item['name'] = $review->find('div.user-review-name', 0)->plaintext;
					$item['rating'] = $review->find('meta[itemprop="ratingValue"]', 0)->attr['content'];
					$item['timestamp'] = $review->find('time.ndate', 0)->attr['datetime'];
					$item['title'] = $review->find('a.review-title-link', 0)->plaintext;
					$item['description'] = trim(htmlentities($review->find('div.review-body',0)->plaintext));
					
					$reviews[] = $item;
				    
				    array_push($review_ids, $item['trustpilot_id']);
				    $i++;
				    
				}
				
			
				//Check to see if there is a response
				if(empty($review_ids))
				{
					echo json_encode(array('status' => 0, 'message' => 'No reviews found.'));
					die;
				}
				else
				{
					//Grab existing review ids from the database
					$data = $this->trustpilot_model->get_review_ids();
				
					//Loop through the scraped reviews, check if they are already in db, if not, insert.
					foreach($reviews as $review)
					{
	
						if(!in_array($review['trustpilot_id'], $data))
						{
							echo(json_encode(array('message' => 'This review is NOT in the database.')));
							$this->trustpilot_model->put_reviews($review);
						}
						else
						{
							echo(json_encode(array('message' => 'This review is ALREADY in the database.')));
						}
					}							
				}
			}
		}
		
	}