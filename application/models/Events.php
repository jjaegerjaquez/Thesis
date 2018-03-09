<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Model
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

  public function get_events()
  {
    $query = $this->db->query("SELECT * FROM `events` WHERE start_date >= curdate() order by start_date asc");
    return $query->result();
  }

  public function get_previous_events()
  {
    $query = $this->db->query("SELECT * FROM `events` WHERE start_date < curdate() order by start_date asc");
    return $query->result();
  }

  public function get_traveller_details($traveller_id)
  {
    $query = $this->db->get_where('users', ['user_id' => $traveller_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_traveller_profile($traveller_id)
  {
    $query = $this->db->get_where('profile', ['user_id' => $traveller_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_event($event_id)
  {
    $query = $this->db->get_where('events', ['event_id' => $event_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_business_details($business_id)
  {
    $query = $this->db->get_where('basic_info', ['user_id' => $business_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

}
