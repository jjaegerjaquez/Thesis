<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abouts extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function get_business_details($user_id)
  {
    $query = $this->db->get_where('basic_info', ['user_id' => $user_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_site_icon()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
    return $query->row();
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

  public function get_notif_count($user_id)
  {
    $query = $this->db->query("select count(recipient_id) as notif_count from notifications where recipient_id = '$user_id' and is_unread = '0' ");
    return $query->row();
  }

  public function get_notifications($user_id)
  {
    $query = $this->db->query("select * from notifications where recipient_id = '$user_id' order by created_time DESC");
    return $query->result();
  }

  public function get_about_title()
  {
    $query = $this->db->query("select * from layout where meta_key = 'about_title'");
    return $query->row();
  }

  public function get_about_details()
  {
    $query = $this->db->query("select * from layout where meta_key = 'about_detail'");
    return $query->result();
  }

}
