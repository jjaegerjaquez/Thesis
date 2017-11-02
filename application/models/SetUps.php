<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class SetUps extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function update($user_id,$status)
  {
    $data = array('website' => $status, 'set_up' => '1' );
    $this->db->where('user_id', $user_id);
    return $this->db->update('accounts', $data);
  }
}
