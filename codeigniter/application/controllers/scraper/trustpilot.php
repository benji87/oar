<?php
	
	//header('Content-type: application/json');
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
			
/*
			$page = $this->uri->segment(3); 
			echo($page); die;
*/
			
			$html = new Simple_html_dom();
			$html = file_get_html('https://uk.trustpilot.com/review/www.yopa.co.uk?page=5');

			$ret = $html->find('h1 span');
			
			$review_ids = array();
			$reviews = array();
			$i=0;
 
			foreach($html->find('div[itemprop="review"]') as $review)
			{
				
				//Grab all the user review details
				$item['trustpilot_id'] = $review->attr['data-reviewmid'];
				$item['name'] = $review->find('div.user-review-name', 0)->plaintext;
				$item['rating'] = $review->find('meta[itemprop="ratingValue"]', 0)->attr['content'];
				$item['timestamp'] = $review->find('time.ndate', 0)->attr['datetime'];
				$item['title'] = $review->find('a.review-title-link', 0)->plaintext;
				$item['description'] = trim(htmlentities($review->find('div.review-body',0)->plaintext));
				
				
				//See if there is a company reply
/*
				if(!empty($review->find('div.company-comment',0)))
				{					
					$item[$i]['company_reply'] = $review->find('div.comment', 0)->plaintext;
				}
*/
				
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
	
	
	
/*
	
	
	
	if(empty($properties)) {
	$status = array('status' => '0', 'message' => 'No properties were found.');
	echo json_encode($status);
	die;
} else {


	include_once("dbconnect.php");
	
	$property_ids = array();
	
	$result = mysql_query("SELECT id, property_id FROM properties") or die(mysql_error());
	while($row = mysql_fetch_array($result)) {
		
		array_push($property_ids, $row['property_id']);
	}
	
	//echo "This should be just property IDs";
	//print_r($property_ids); die;
	
	
	//if(!empty($property_ids)) {
	
		foreach($properties as $property) {
			
			if(!in_array($property['property_id'], $property_ids)) {
				
				echo "This property IS NOT in the database\n";
				
				$query = mysql_query("INSERT INTO properties (property_id, price, address, thumbnail, agent_name, agent_telephone) VALUES('". $property['property_id'] ."', '". $property['price'] ."', '". $property['address'] ."', '". $property['thumbnail'] ."', '". $property['agent_name'] ."', '". $property['agent_telephone'] ."')") or die(mysql_error());
				
				
			} else {
	
				echo "This property is already in the database " . $property['property_id'] . "\n";
				
			}
			
		}
	//}
}
*/
