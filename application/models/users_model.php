<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This contains the main bulk of the model functions,
 * specifically CRUD operations to be performed on users
 * and various other admin functions.
 */
class Users_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * get all users
     */
    function get_all_users()
    {
        return $this->db->get('users');
    }

    /**
     * add user data to  database
     */
    function process_create_user($data)
    {
        if($this->db->insert('users', $data))
        {
            return $this->db->insert_id();
        } else  {
            return false;
        }
    }

    /**
     * update user data using it's user_id
     */
    function process_update_user($id, $data)
    {
        $this->db->where("usr_id", $id);
        if($this->db->update('users', $data))
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get user details using it's  user_id
     */
    function get_user_details($id)
    {
        $this->db->where('usr_id', $id);
        $result = $this->db->get('users');
        if($result){
            return $result;
        } else {
            return false;
        }
    }

    /**
     * get user details using it's user_email
     */
    function get_user_details_by_email($email)
    {
        $this->db->where("usr_email", $email);
        $result = $this->db->get('users');
        if($result)
        {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * delete user using  it's user_id
     */
    function delete_user($id)
    {
        if($this->db->delete('users', array('usr_id' => $id)))
        {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return string
     * This function creates a unique code and saves it to the user's record.
     * This code is sent out at the end of a URL in an e-mail to the user.
     * If this code in the URL matches the code in the database, then chances
     * are that it's a genuine password change as it is unlikely that someone would have
     * accurately guessed the code.
     */
    function make_code()
    {
        do
        {
            $url_code = random_string('alnum', 8);
            $this->db->where("usr_pwd_change_code = ", $url_code);
            $this->db->from("users");
            $num = $this->db->count_all_results();

        } while($num >= 1);

        return $url_code;
    }

    /**
     * @param $data
     * @param $email
     * @return bool
     */
    function does_code_match($data, $email)
    {

        $query = "SELECT COUNT(*) AS `count`
                  FROM `users`
                  WHERE `usr_pwd_change_code` = ?
                  AND `usr_email` = ? ";
        $res = $this->db->query($query, array($data['code'], $email));
        foreach ($res->result() as $row) {
            $count = $row->count;
        }
        if ($count == 1)
        {
            return true;
        } else {
            return false;
        }
    }

    function does_email_code_match($data)
    {
        $this->db->where($data);
        $this->db->get('users');
        $results = $this->db->count_all_results();
        if($results == 1)
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     *
     */
    function make_verification_code()
    {
        do
        {
            $url_code = random_string('alnum', 8);
            $this->db->where("usr_email_verify = ", $url_code);
            $this->db->from("users");
            $num = $this->db->count_all_results();

        } while($num >= 1);

        return $url_code;
    }

    /**
     * @param $email
     * @return mixed
     *
     * count emails in the users table
     * given the email
     *
     */
    function count_results($email)
    {
        $this->db->where('usr_email', $email);
        $this->db->from('users');
        return $this->db->count_all_results();
    }

    /**
     *
     * @param $data
     * @return bool
     * Updates the users password using its id
     *
     */
    function update_user_password($data)
    {
        $this->db->where('usr_id', $data['usr_id']);
        if ($this->db->update('users', $data))
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     *
     * Updates user code using it's email
     */
    function update_user_code($data)
    {
        $this->db->where('usr_email', $data['usr_email']);
        if ($this->db->update('users', $data))
        {
            return true;
        } else {
            return false;
        }
    }

    function update_email_verify_code($data)
    {
        $data_1  = array('usr_email_verify' => 0);

        $this->db->where('usr_email', $data['usr_email']);
        $this->db->where('usr_email_verify', $data['usr_email_verify']);

        if($this->db->update('users', $data_1))
        {
            return true;
        } else {
            return false;
        }
    }
}