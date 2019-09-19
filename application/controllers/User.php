<?php

use Src\Services\OktaApiService as Okta;

class User extends CI_Controller
{
    protected $okta;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('users_model');
        $this->okta = new Okta;
    }

    public function login()
    {
        if (! isset($this->session->username)) {
            $state = bin2hex(random_bytes(5));
            $authorizeUrl = $this->okta->buildAuthorizeUrl($state);
            $this->session->state = $state;
            redirect($authorizeUrl, 'refresh');
        }

        redirect('/');
    }

    public function callback()
    {
        if (isset($_GET['code'])) {
            $result = $this->okta->authorizeUser($this->session->state);
            if (isset($result['error'])) {
                echo $result['errorMessage'];
                die();
            }
        }

        $userId = $this->users_model->find_or_create($result['username']);

        $this->session->userId = $userId;
        $this->session->username = $result['username'];
        $this->session->access_token = $result['access_token'];
        redirect('/');
    }

    public function logout()
    {
        $this->session->userId = null;
        $this->session->username = null;
        redirect('/');
    }
}
