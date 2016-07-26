<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class  Signin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("security");
        $this->load->helper("string");
        $this->load->library("form_validation");
        $this->load->model("signin_model");
        $this->load->model('users_model');

    }

    function index($msg = null)
    {
        //check if logged in already
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE){
            if($_SESSION['usr_access_level'] == 1)
            {
                //admin level
                echo  'redirect to users';
            } elseif($_SESSION['usr_access_level'] == 2){
                //staff level
                echo 'redirect to staff';
            }elseif($_SESSION['usr_access_level'] == 3){
                //customer  level
                redirect('me');
            }else{
                //don't belong here
                echo "you don't belong here";
            }
        } else {

            //not logged in
            if($this->form_validation->run('signin') == FALSE)
            {
                if(!is_null($msg))
                {
                    $msg_cntnt = array(
                        1 => 'Email verification successful, you can sign in now.',
                        2 => 'Your account is not activated yet. We\'ve send you an email for verification. Kindly follow the link on your email to activate your account',
                        3 => 'Code does not match.',
                        4 => 'We failed to update you password please contact you system administrator.',
                        5 => 'You have successfully change your password.'
                    );
                    $data['signin_notification'] = $msg_cntnt[$msg];
                }
                $data['body_class']             = "sign_in_page";
                $this->load->view('authentication/common/header',$data);
                $this->load->view('authentication/navigations/top_nav');
                $this->load->view('authentication/signin_form', $data);
                $this->load->view('authentication/common/footer');
            }else{

                //get username of email
                $usr_email_uname    =   $this->input->post('usr_email_uname');
                $raw_pwd            =   $this->input->post('usr_password');

                if(filter_var($usr_email_uname, FILTER_VALIDATE_EMAIL))
                {
                    $query  =   $this->signin_model->does_user_exist($usr_email_uname);
                } else {
                    $query  =   $this->signin_model->does_uname_exist($usr_email_uname);
                }

                if($query->num_rows() == 1)
                {
                    foreach($query->result() as $row)
                    {
                        if($row->usr_email_verify == 0)
                        {
                            if(password_verify($raw_pwd,$row->usr_hash))
                            {
                                $data = array(
                                    'usr_id'            => $row->usr_id,
                                    'acc_id'            => $row->acc_id,
                                    'usr_email'         => $row->usr_email,
                                    'usr_access_level'  => $row->usr_access_level,
                                    'logged_in'         => TRUE
                                );

                                $this->session->set_userdata($data);
                                session_write_close();
                                if($data['usr_access_level'] == 1)
                                {
                                    //admin level
                                    echo "redirect to admin dashboard";
                                }elseif($data['usr_access_level'] == 2){
                                    echo "redirect to staff";
                                }elseif($data['usr_access_level'] == 3){
                                    redirect('me');
                                }else{
                                    echo "you don't belong here";
                                }
                            } else{
                                $data['signin_notification'] =  "Incorrect username, email or  password.!";
                                $data['body_class'] = "sign_in_page";
                                $this->load->view('authentication/common/header',$data);
                                $this->load->view('authentication/navigations/top_nav');
                                $this->load->view('authentication/signin_form', $data);
                                $this->load->view('authentication/common/footer');
                            }
                        }else{
                            $data['body_class'] = "sign_in_page";
                            $data['signin_notification'] =  "Your account is not activated yet. We've send you an email for verification. Kindly follow the link on your email to activate your account";
                            $this->load->view('authentication/common/header',$data);
                            $this->load->view('authentication/navigations/top_nav');
                            $this->load->view('authentication/signin_form',$data);
                            $this->load->view('authentication/common/footer');
                        }//verify
                    }//foreach
                } else{

                    $data['signin_notification'] =  "User does not exist.!";
                    $data['body_class'] = "sign_in_page";
                    $this->load->view('authentication/common/header',$data);
                    $this->load->view('authentication/navigations/top_nav');
                    $this->load->view('authentication/signin_form', $data);
                    $this->load->view('authentication/common/footer');
                }//query->num_rows()
            }//form_validation

        }//check if already logged in
    }

    public function signout()
    {
        $this->session->sess_destroy();
        redirect('signin');
    }
}