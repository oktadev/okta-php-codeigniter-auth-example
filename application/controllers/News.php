<?php
class News extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
        $this->load->helper('url_helper');

        $this->username = $this->session->username ?? null;
        $data['username'] = $this->username;
        $this->load->view('templates/header', $data);
    }

    public function index()
    {
        $data['title'] = 'News archive';

        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        if (! $this->username) {
            redirect('login');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('news/create', $data);
        } else {
            $this->news_model->set_news();
            $this->load->view('news/success');
        }

        $this->load->view('templates/footer');
    }
}
