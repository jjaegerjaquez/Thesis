<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Users extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function EmailExists($email)
  {
    $this->db->select('user_id');
    $this->db->where('email', $email);
    $query = $this->db->get('users');

    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
  }

  public function BusinessNameExists($businessname)
  {
    $this->db->select('user_id');
    $this->db->where('business_name', $businessname);
    $query = $this->db->get('users');

    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
  }

  public function get_user_login($email, $password)
  {
    $query = $this->db->get_where('users', array('email' => $email, 'password' => md5($password)));
       //return $query->num_rows();
       return $query->row_array();
  }
}
