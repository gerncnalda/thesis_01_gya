<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'register' => array(
        array(
            'field' =>  'usr_fname',
            'label' =>  'first name',
            'rules' =>  'required|alpha|max_length[125]'
        ),
        array(
            'field' =>  'usr_lname',
            'label' =>  'last name',
            'rules' =>  'required|alpha|max_length[125]'
        ),
        array(
            'field' =>  'usr_uname',
            'label' =>  'username',
            'rules' =>  'alpha_numeric|max_length[125]|is_unique[users.usr_uname]'
        ),
        array(
            'field' =>  'usr_email',
            'label' =>  'email address',
            'rules' =>  'required|valid_email|max_length[255]|is_unique[users.usr_email]'
        ),
        array(
            'field' =>  'usr_email_match',
            'label' =>  'confirm email address',
            'rules' =>  'required|valid_email|max_length[255]|matches[usr_email]'
        ),
        array(
            'field' =>  'usr_password',
            'label' =>  'password',
            'rules' =>  'required|min_length[6]'
        ),
        array(
            'field' =>  'usr_password_match',
            'label' =>  'confirm password',
            'rules' =>  'required|min_length[6]|matches[usr_password]'
        )
    ),
    'signin' => array(
        array(
            'field' =>  'usr_email_uname',
            'label' =>  'username or email',
            'rules' =>  'required|max_length[255]'
        ),
        array(
            'field' =>  'usr_password',
            'label' =>  'user password',
            'rules' =>  'required|min_length[6]'
        )
    )
);
