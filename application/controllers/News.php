<?php
class News extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
}
