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
        $this->load->library("form_validation");
        $this->load->model("password_model");
        $this->load->model('users_model');
    }

    public function index()
    {
        redirect('password/forgot_password');
    }
    public function forgot_password($msg = null)
    {
        if($this->form_validation->run('forgot_pwd') == FALSE)
        {
            if(!is_null($msg))
            {
                $msg_content = array(
                    2   => 'You will receive an email to reset your password if the email exist in our database.'
                );
                $data['forgot_pwd_notification']    =   $msg_content[$msg];
            }
            $data['body_class'] = 'forgot_password';
            $this->load->view('authentication/common/header',$data);
            $this->load->view('authentication/navigations/top_nav');
            $this->load->view('authentication/forgot_pwd_form', $data);
            $this->load->view('authentication/common/footer');
        } else {

            $usr_email      =  $this->input->post('usr_email');
            $usr_pwd_code   =  $this->users_model->make_code();

            if($this->password_model->does_user_exist($usr_email))
            {
                $data   =   array(
                    'usr_email' => $usr_email,
                    'usr_pwd_change_code'   =>  $usr_pwd_code
                );

                //store the usr_pwd_code to the user with this   email
                if($this->users_model->update_user_code($data))
                {
                    // getuser details
                    $query  =  $this->users_model->get_user_details_by_email($usr_email);
                    foreach($query->result() as $row)
                    {
                        $usr_fname  =   $row->usr_fname;
                    }

                    // create a link
                    $link = "<a href='".base_url('password/new_password')."/".$usr_pwd_code."'>here</a>";

                    //get the contents of the forgot password  template
                    $email_content  =   file_get_contents('application/views/authentication/email_scripts/forgot_password.txt');
                    $email_content  =   str_replace('%firstname%', $usr_fname, $email_content);
                    $email_content  =   str_replace('%here%', $link, $email_content);

                    $this->load->library("email");

//                $config['protocol']     =   'smtp';
//                $config['smtp_host']    =   'ssl://smtp.gmail.com';
//                $config['smtp_port']    =   '465';
//                $config['smtp_timeout'] =   '30';
//                $config['smtp_user']    =   'gerncnalda@gmail.com';
//                $config['smtp_pass']    =   '0q0y05w8vjib';
//                $config['charset']      =   'utf-8';
//                $config['newline']      =   "\r\n";
//                $config['mailtype']     =   'html';
//                $this->email->initialize($config);

                    $this->email->from('gerncnalda@gmail.com', 'Admin');
                    $this->email->to($usr_email);

                    $this->email->subject('Reset Password');
                    $this->email->message($email_content);

                    if($this->email->send())
                    {
                        echo $email_content;
//                        redirect('password/forgot_password/2');
                    }
                }
            }else{
                redirect('password/forgot_password/2');
            }
        }//form_validation
    }

    public function new_password($email_code = null)
    {
        if($this->form_validation->run('new_pwd') == FALSE)
        {
            if(!is_null($email_code))
            {
                $data['pwd_change_code']    =   $email_code;
            } else {
                $data['pwd_change_code']    =   $this->input->post('usr_pwd_change_code');
            }
            $data['body_class'] = 'new_password';
            $this->load->view('authentication/common/header',$data);
            $this->load->view('authentication/navigations/top_nav');
            $this->load->view('authentication/new_pwd_form', $data);
            $this->load->view('authentication/common/footer');
        } else {

            $usr_email              =  xss_clean($this->input->post('usr_email'));
            $usr_raw_pwd            =  $this->input->post('usr_pwd');
            $usr_pwd_change_code    =  $this->input->post('usr_pwd_change_code');

            $data   =   array(
                'usr_email'             =>  $usr_email,
                'usr_pwd_change_code'   =>  $usr_pwd_change_code
            );

            if($this->users_model->does_code_match($data))
            {
                // code match
                $usr_hash   =   password_hash($usr_raw_pwd, PASSWORD_DEFAULT);
                $hash_data  =   array(
                    'usr_hash'  => $usr_hash
                );
                if($this->users_model->update_user_password_by_email($data, $hash_data))
                {
                    // success change in password
                    redirect('signin/index/5');
                } else {
                    redirect('signin/index/4');
                }
            } else  {
                //code does not match
                redirect('signin/index/3');
            }
        }
    }

    public function email_verification($email_code = null)
    {
        if(is_string($email_code))
        {
            $email_code = urldecode($email_code);
            $email_code = explode('_', $email_code);

            $data = array(
                'usr_email_verify'  => $email_code[0],
                'usr_email'         => $email_code[1]
            );

            //check if usr_email_verify code match
            if($this->users_model->does_email_code_match($data))
            {
                //update if it  match
                if($this->users_model->update_email_verify_code($data))
                {
                    redirect('signin/index/1');
                } else {
                    echo 'we failed update data';
                }
            } else {
                echo "it did not match";
            }
        }
    }
}