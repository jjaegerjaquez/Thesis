<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Logins extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function validate_email($email)
  {
    $query = $this->db->get_where('accounts', ['email' => $email]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }
  public function get_user_login($email, $password)
  {
    $query = $this->db->get_where('accounts', array('email' => $email, 'password' => md5($password)));
       //return $query->num_rows();
       return $query->row_array();
  }
}
