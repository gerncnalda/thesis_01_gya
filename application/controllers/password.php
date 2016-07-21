<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("security");
        $this->load->helper("string");
        $this->load->library('encryption');
        $this->load->library("form_validation");
        $this->load->model("signin_model");
        $this->load->model('users_model');
    }

    public function index($msg = null)
    {
        echo $msg;
    }

    public function new_password($email_code = null)
    {
        echo "genrey";
    }

    public function email_verification($email_code = 'genrey')
    {
        if(!is_null($email_code))
        {
            try{
                $this->encryption->initialize(array('driver'=>'openssl'));
                $email_code = urldecode($this->encryption->decrypt($email_code));
                echo $email_code;
            }
            catch(Exception $e)
            {
               echo $e->getMessage();
            }
        }
        echo $email_code;
    }
}