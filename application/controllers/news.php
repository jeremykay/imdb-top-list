<?php
class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
	}

	public function index()
	{

		//enable cache
		$this->output->cache(1);

		$data['news'] = $this->news_model->get_news();
		$data['title'] = 'News archive';

		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug)
	{
		$data['news_item'] = $this->news_model->get_news($slug);

		if (empty($data['news_item']))
		{
			show_404();
		}

		$data['title'] = $data['news_item']['title'];

		$this->load->view('templates/header', $data);
		$this->load->view('news/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Create a news item';
			
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('text', 'text', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
		
		//if validation fales
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);	
			$this->load->view('news/create');
			$this->load->view('templates/footer');
		}
		else //if successfull
		{
			//set news
			$data = $this->news_model->set_news();

			//send email to user
			$this->load->library('email');

			$this->email->from('web@example.com', 'Webmaster');
			$this->email->to($this->input->post('email')); 

			$this->email->subject('Your News Item Was Posted: ' . $this->input->post('title'));
			$this->email->message($this->input->post('text'));	

			$this->email->send();

			//display success page
			$data['title'] = 'Success!';
			$this->load->view('templates/header', $data);	
			$this->load->view('news/success', $data);
			$this->load->view('templates/footer');
		}
	}

	public function admin()
	{
			//get news from db
			$data['news'] = $this->news_model->get_news();

			//display news
			$data['title'] = 'Admin News';
			$this->load->view('templates/header', $data);	
			$this->load->view('news/admin');
			$this->load->view('templates/footer');	
	}

	public function delete($id)
	{
		//THIS ADDS CONSOLE.LOG FUNCTIONALITY
		// $this->load->library('console');
		// $this->console->log('working!');
		// $this->console->log('id: ' . $id);
		if((int)$id > 0){

			//delete the news item
    		$this->news_model->delete_news($id);

    		//display succuss page
    		$data['title'] = 'Item Deleted';
    		$this->load->view('templates/header', $data);	
			$this->load->view('news/delete-success');
			$this->load->view('templates/footer');
  		}

	}

}