<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Verifies extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function verify_email($code)
  {
    $data = array('status' => '1');
    $this->db->where('md5(email)', $code);
    return $this->db->update('accounts', $data);
  }
}
