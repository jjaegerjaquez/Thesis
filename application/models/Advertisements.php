<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertisements extends CI_Model
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

  public function get_tagline()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_tagline'");
    return $query->row();
  }

  public function get_facebook()
  {
    $query = $this->db->query("select * from layout where meta_key = 'facebook_link'");
    return $query->row();
  }

  public function get_instagram()
  {
    $query = $this->db->query("select * from layout where meta_key = 'instagram_link'");
    return $query->row();
  }

  public function get_twitter()
  {
    $query = $this->db->query("select * from layout where meta_key = 'twitter_link'");
    return $query->row();
  }

  public function get_google()
  {
    $query = $this->db->query("select * from layout where meta_key = 'google_link'");
    return $query->row();
  }

  public function get_site_icon()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
    return $query->row();
  }

  public function get_advertisements()
  {
    $query = $this->db->query("select * from advertisements order by type, start_date asc");
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

  public function get_advertisement($ad_id)
  {
    $query = $this->db->get_where('advertisements', ['advertisement_id' => $ad_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_business_details($business_id)
  {
    $query = $this->db->get_where('basic_info', ['id' => $business_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

}
