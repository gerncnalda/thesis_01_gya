<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Signin_model
 * This model contains only one function other than __construct(), that is,
 * does_user_exist($email). This function takes an e-mail address submitted
 * by the user from the sign-in view and returns the active record query.
 *
 */
class Signin_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    /**
     * @param $email
     * @return mixed
     *
     */
    public function does_user_exist($email)
    {
        $this->db->where('usr_email', $email);
        $query = $this->db->get('users');
        return $query;
    }

    public function does_uname_exist($usr_uname)
    {
        $this->db->where('usr_uname', $usr_uname);
        $query  = $this->db->get('users');
        return $query;
    }
}