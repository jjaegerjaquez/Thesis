<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Views extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function view_user_webpage($user_id)
  {
    $query = $this->db->get_where('general', ['user_id' => $user_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }
}
