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

  public function get_title()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_title'");
    return $query->row();
  }

  public function get_site_icon()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
    return $query->row();
  }

    public function verify_email($code)
    {
      $data = array('status' => '1');
      $this->db->where('md5(email)', $code);
      return $this->db->update('users', $data);
    }
}
