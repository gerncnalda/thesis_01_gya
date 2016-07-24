<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("security");
        $this->load->helper("string");
        $this->load->library('encryption');
        $this->load->library('encrypt');
        $this->load->library("form_validation");
        $this->load->model("register_model");
        $this->load->model('users_model');
    }

    public function index()
    {
        if($this->form_validation->run("register")  == FALSE){

            $data['body_class'] =  "register_page";
            $this->load->view("authentication/common/header",$data);
            $this->load->view('authentication/navigations/top_nav.php');
            $this->load->view("authentication/register_form.php");
            $this->load->view("authentication/common/footer");
        }else {

            $usr_fname  =  $this->input->post('usr_fname');
            $usr_lname  =  $this->input->post('usr_lname');
            $usr_email  =  $this->input->post('usr_email');
            $usr_uname  =  $this->input->post('usr_uname');

            $raw_pwd    =  $this->input->post('usr_password');
            $usr_hash   =  password_hash($raw_pwd, PASSWORD_DEFAULT);

            //generate email verification code
            $email_vrfy_code =  $this->users_model->make_verification_code();
            $email_secure    = $email_vrfy_code . '_'. $usr_email;

            //encrypt the code
            $email_secure   = urlencode($email_secure);

            //generate the link
            $link   =   "<a href='" . base_url('password/email_verification') . "/" . $email_secure . "' title='email verification'>Click here</a>";

            $data   =   array(
                'usr_fname'         =>  $usr_fname,
                'usr_lname'         =>  $usr_lname,
                'usr_uname'         =>  $usr_uname,
                'usr_email'         =>  $usr_email,
                'usr_hash'          =>  $usr_hash,
                'usr_access_level'  =>  3,
                'usr_is_active'     =>  0,
                'usr_email_verify'  =>  $email_vrfy_code
            );

            //store to database
            if($this->register_model->register_user($data))
            {
                // fetch content from email_scripts and change value
                $email_content = file_get_contents('application/views/authentication/email_scripts/welcome.txt');
                $email_content = str_replace('%firstname%', $usr_fname, $email_content);
                $email_content = str_replace('%here%', $link, $email_content);

                $this->load->library("email");

                $config['protocol']     =   'smtp';
                $config['smtp_host']    =   'ssl://smtp.gmail.com';
                $config['smtp_port']    =   '465';
                $config['smtp_timeout'] =   '30';
                $config['smtp_user']    =   'gerncnalda@gmail.com';
                $config['smtp_pass']    =   '0q0y05w8vjib';
                $config['charset']      =   'utf-8';
                $config['newline']      =   "\r\n";
                $config['mailtype']     =   'html';
                $this->email->initialize($config);

                $this->email->from('gerncnalda@gmail.com', 'Admin');
                $this->email->to($usr_email);

                $this->email->subject('Welcome to Guya');
                $this->email->message($email_content);

                if($this->email->send())
                {
                    redirect('signin/index/2');
                } else {
                    show_error($this->email->print_debugger());
                }
            }else  {
                echo "something went wrong";
            }

        }
    }
}