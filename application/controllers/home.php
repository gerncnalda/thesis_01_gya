<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("security");
        $this->load->helper("string");
    }

    function index()
    {
        $data['body_class'] = "home_index";
        $this->load->view('authentication/common/header',$data);
        $this->load->view('authentication/navigations/top_nav');
        $this->load->view('home');
        $this->load->view('authentication/common/footer');
    }
}