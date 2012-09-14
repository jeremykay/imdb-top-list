<?php
class Imdb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('imdb_model');
	}

	public function index()
	{
		//enable cache
		$this->output->cache(360);

		$data['imdb'] = $this->imdb_model->get_imdb();
		$data['title'] = 'IMDB archive';

		$this->load->view('templates/header', $data);
		$this->load->view('imdb/index', $data);
		$this->load->view('templates/footer');

	}

	public function date($dateToFind)
	{
		//enable cache
		$this->output->cache(360);

		$data['imdb'] = $this->imdb_model->get_imdb($dateToFind);

		if (empty($data['imdb']))
		{
			$data['title'] = 'No Dates Found';
			$this->load->view('templates/header', $data);
			$this->load->view('templates/empty');
			$this->load->view('templates/footer');
		}

		$data['title'] = 'Top Movies for ' . $dateToFind;

		$this->load->view('templates/header', $data);
		$this->load->view('imdb/index', $data);
		$this->load->view('templates/footer');
	}

	public function update($login = FALSE) 
	{
		//make sure update can only be run if there is this absurdly long string in URL
		//this makes it secure-ish
		if ($login != 'njksdg_vaud_fgFHGc987239bKHjJKBBJ87897dshGfdgKIKKKnbsdbfbf4y7tr43-34h-7u-gf3g')
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