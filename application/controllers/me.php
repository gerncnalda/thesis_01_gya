<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Me extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("security");
        $this->load->helper("string");
        $this->load->library("form_validation");
        $this->load->model('users_model');

        //check if logged in already
        if((!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] != TRUE) || $_SESSION['usr_access_level'] != 3){
            //don't belong here
            redirect('signin/signout', 'location');
        }
    }

    function index($msg = null)
    {
        $id = $_SESSION['usr_id'];

        if($this->form_validation->run('me') == FALSE)
        {
            if(!is_null($msg))
            {
                $msg_content =  array(
                    1   =>  "You information have been successfully updated."
                );
                $data['me_notification'] = $msg_content[$msg];
            }
            $data['body_class'] = "me_page";

            $query = $this->users_model->get_user_details($id);

            foreach($query->result() as $row)
            {
                $data['usr_fname']  =   $row->usr_fname;
                $data['usr_lname']  =   $row->usr_lname;
                $data['usr_uname']  =   $row->usr_uname;
                $data['usr_email']  =   $row->usr_email;
                $data['usr_add1']  =   $row->usr_add1;
                $data['usr_add2']  =   $row->usr_add2;
                $data['usr_add3']  =   $row->usr_add3;
                $data['usr_town_city']  =   $row->usr_town_city;
                $data['usr_zip_pcode']  =   $row->usr_zip_pcode;
            }

            $this->load->view('authentication/common/header',$data);
            $this->load->view('authentication/navigations/top_nav');
            $this->load->view('authentication/me_form', $data);
            $this->load->view('authentication/common/footer');
        } else {
            $data = array(
                'usr_fname' => $this->input->post('usr_fname'),
                'usr_lname' => $this->input->post('usr_lname'),
                'usr_uname' => $this->input->post('usr_uname'),
                'usr_email' => $this->input->post('usr_email'),
                'usr_add1' => $this->input->post('usr_add1'),
                'usr_add2' => $this->input->post('usr_add2'),
                'usr_add3' => $this->input->post('usr_add3'),
                'usr_town_city' => $this->input->post('usr_town_city'),
                'usr_zip_pcode' => $this->input->post('usr_zip_pcode')
            );
            if ($this->users_model->process_update_user($id, $data))
            {
                redirect('me/index/1');
            }
        }
    }
}