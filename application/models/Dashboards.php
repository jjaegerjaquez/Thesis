<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Dashboards extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function get($user_id)
  {
    $query = $this->db->get_where('accounts', ['user_id' => $user_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }
}
