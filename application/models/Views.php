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

  public function get_account_details($username)
  {
    $query = $this->db->get_where('basic_info', ['username' => $username]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function get_site_title($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'site_title'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_site_tagline($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'site_tagline'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_home_title($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'home_title'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_home_description($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'home_description'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_home_bg($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'home_background_image'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_about_featured_image($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'about_featured_image'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_about_title($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'about_title'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_about_description($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'about_description'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_about_header_image($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'about_header_image'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_details($user_id)
  {
    $query = $this->db->query("select * from users u join basic_info bi on u.user_id=bi.user_id where u.user_id='$user_id'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_facebook($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'facebook_url'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_instagram($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'instagram_url'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_twitter($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'twitter_url'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function get_image_slider($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'image_slider'");
    if ($query->num_rows() > 0) {
      return $query->result();
    }else {
      return $query->result();
    }
  }

  public function get_gallery_images($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'gallery_image'");
    if ($query->num_rows() > 0) {
      return $query->result();
    }else {
      return $query->result();
    }
  }
}
