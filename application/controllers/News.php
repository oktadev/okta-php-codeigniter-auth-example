<?php
class News extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->view('templates/header');
    }

    public function index()
    {
        $data['title'] = 'News archive';

        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }
}
