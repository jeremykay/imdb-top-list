<?php
class Imdb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('imdb_model');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	//use this so i can route everything to the index()
	function  _remap ( $method )  {
		$param_offset = 2;
		
		// Default to index
		if ( ! method_exists($this, $method))
		{
		// We need one more param
		$param_offset = 1;
		$method = 'index';
		}
		
		// Since all we get is $method, load up everything else in the URI
		$params = array_slice($this->uri->rsegment_array(), $param_offset);
		
		// Call the determined method with all params
		call_user_func_array(array($this, $method), $params);
	} 
	
	public function index($dateToFind = FALSE)
	{
		
		//if dateToFind is false, set default to TODAY
		if ($dateToFind === FALSE)
		{
			$dateToFind = date('Y-m-d');
		}
		
		//enable cache
		$this->output->cache(180);
		
		$data['imdb'] = $this->imdb_model->get_imdb($dateToFind);
		$data['dates'] = $this->imdb_model->get_dates();
		$data['thisDateToFind'] = $dateToFind;
		
		if ( empty($data['imdb'][0]) )
		{
			//redirect to "nonefound"
			redirect('nonefound');
		}
		else
		{
			$data['title'] = 'Top Movies for ' . $dateToFind;
	
			$this->load->view('templates/header', $data);
			$this->load->view('imdb/index', $data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/footer');
		}
	}
	
	public function all()
	{
		//enable cache
		$this->output->cache(180);

		$data['imdb'] = $this->imdb_model->get_imdb();
		$data['dates'] = $this->imdb_model->get_dates();
		$data['title'] = 'All Time IMDB Top 10 Archive';

		$this->load->view('templates/header', $data);
		$this->load->view('imdb/index', $data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/footer');

	}
	
	public function nonefound() {
		//enable cache
		$this->output->cache(180);
		
		$data['dates'] = $this->imdb_model->get_dates();
		$data['title'] = 'No Dates Found';

		$this->load->view('templates/header', $data);
		$this->load->view('imdb/empty');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/footer');
	}
	
	public function processDateForm() 
	{
		
		$this->form_validation->set_rules('date', 'Date', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$data['title'] = 'Error';
			$data['dates'] = $this->imdb_model->get_dates();
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/error');
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/footer');
		}
		else
		{
			//clean up date so form can accept most human entered dates
			$cleanedUpDate = date('Y-m-d',strtotime($this->input->post('date')));
			redirect($cleanedUpDate);
		}
		
	}

	public function update($login = FALSE) 
	{
		//make sure update can only be run if there is this absurdly long string in URL
		////check to make sure remote address and server address are the same so this only runs locally
		if ( ($login != 'njksdg_vaud_fgFHGc987239bKHjJKBBJ87897dshGfdgKIKnbsdbfbf4y7t') || ($this->input->server('REMOTE_ADDR') != $this->input->server('SERVER_ADDR')) )
		{
			show_404();
		} 
		else 
		{
			//set news
			$data = $this->imdb_model->update_imdb();
		}
		
	}
}

