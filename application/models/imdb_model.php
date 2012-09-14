<?php
class Imdb_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('simple_html_dom');
	}

	//gets all dates in the db
	public function get_dates()
	{
		$this->db->order_by('dateAdded', 'desc');
		$this->db->group_by('DATE(dateAdded)'); 
		$dateQuery = $this->db->get('imdb');
		return $dateQuery->result_array();

	}

	public function get_imdb($dateToFind = FALSE)
	{
		//if no dateToFind is specified, get all records sorted by date
		if ($dateToFind === FALSE)
		{
			
			//get all the dates
			$dates = $this->imdb_model->get_dates();

			//loop over each date
			foreach ($dates as $date)
			{

				$dateShort = date('Y-m-d', strtotime($date['dateAdded']));

				$this->db->order_by('dateAdded', 'desc');
				$this->db->order_by('rank', 'asc');
				//in case there are more than one records per day, limit to the most recent top 10
				$this->db->limit(10);
				$query = $this->db->get_where('imdb', array('DATE(dateAdded)' => $dateShort));
				$query = $query->result_array();
				$allResults[] = $query;


			}

			return $allResults;
		}


		//make sure date is right format
		$dateShort = date('Y-m-d', strtotime($dateToFind));

		//otherwise, get the date specified
		$this->db->order_by('dateAdded', 'desc');
		$this->db->order_by('rank', 'asc');
		//in case there are more than one records per day, limit to the most recent top 10
		$this->db->limit(10);
		$query = $this->db->get_where('imdb', array('DATE(dateAdded)' => $dateShort));
		$query = $query->result_array();
		$allResults[] = $query;

		return $allResults;

	}

	public function update_imdb()
	{
		

		//set date
		$dateAdded =  date('Y-m-d H:i:s');
		
		// Grab HTML From the URL
		$html = file_get_html('http://www.imdb.com/chart/top/')->getElementById("main");

		foreach($html->find('tr') as $tr) {    

			//if element is found
			if ( $tr->find('td.number', 0) )  {

				//rank
			    $rank = $tr->find('td.number', 0)->innertext; 
			    $item['rank'] = str_replace('.', '', $rank); 

			    //title
			    $item['title'] = $tr->find('td.title', 0)->find('a',0)->innertext;

			    //year
			    $year = $tr->find('td.title', 0)->find('span.year_type',0)->innertext;
		    	$year =  str_replace('(', '', $year);
		    	$year =  str_replace(')', '', $year);
			    $item['year'] = $year;

			    //image
			    $item['image'] = $tr->find('td.image', 0)->find('img',0)->src;

			    //outline
			    $item['outline'] = $tr->find('td.title', 0)->find('span.outline',0)->innertext;

			    //votes
			    $number_of_votes = $tr->find('td.imdb_rating', 0)->find('div',0)->plaintext;
			    $item['number_of_votes'] = str_replace(',','',$number_of_votes);

			    //rating
			    $rating = $tr->find('td.imdb_rating', 0)->innertext;
			    $rating = explode('<br>', $rating);
			    $item['rating'] = $rating[0];

			    //date
			    $item['dateAdded'] = $dateAdded;
     
			    $movies[] = $item;  
			}

		}  

		//this helps with memory issues
		$html->clear(); 
		unset($html);

		//for the top 10 movies
		for ($i = 0; $i <= 9; $i++) {

			print_r($movies[$i]);
			echo "<br>";
			echo "<br>";
			echo "<br>";

			$this->db->insert('imdb', $movies[$i]);

		}

	}

	

}