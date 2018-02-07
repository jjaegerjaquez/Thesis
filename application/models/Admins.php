<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function validate_user($username)
  {
    $query = $this->db->get_where('admin', ['username' => $username]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get($user_id)
  {
    $query = $this->db->get_where('accounts', ['user_id' => $user_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function get_email($email)
  {
    $query = $this->db->get_where('accounts', ['email' => $email]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function update_set_up($user_id,$status)
  {
    $data = array('website' => $status, 'set_up' => '1' );
    $this->db->where('user_id', $user_id);
    return $this->db->update('accounts', $data);
  }

  // LOCALITY
  public function get_localities()
  {
    $query = $this->db->query("select * from localities order by locality asc");
    return $query->result();
  }

  public function get_locality($locality_id)
  {
    $query = $this->db->get_where('localities', ['locality_id' => $locality_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function update_locality($Locality,$locality_id)
  {
    $this->db->where('locality_id', $locality_id);
    $this->db->update('localities', $Locality);
  }
  // END OF LOCALITY

  // CATEGORY
  public function get_categories()
  {
    $query = $this->db->query("select * from categories order by category asc");
    return $query->result();
  }

  public function get_category($category_id)
  {
    $query = $this->db->get_where('categories', ['category_id' => $category_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }
  public function update_category($Category,$category_id)
  {
    $this->db->where('category_id', $category_id);
    $this->db->update('categories', $Category);
  }
  // END OF CATEGORY

  // THEMES
  public function get_theme($theme_id)
  {
    $query = $this->db->get_where('themes', ['theme_id' => $theme_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function update_theme($Theme,$theme_id)
  {
    $this->db->where('theme_id', $theme_id);
    $this->db->update('themes', $Theme);
  }
  // END OF THEMES

  // LAYOUT
  public function update_site_logo($Logo,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Logo);
  }

  public function update_site_title($Title,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Title);
  }

  public function update_site_tagline($Tagline,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Tagline);
  }

  public function update_site_icon($Icon,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Icon);
  }

  public function get_logo()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_logo'");
    return $query->row();
  }

  public function get_icon()
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

  public function update_facebook_url($Facebook,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Facebook);
  }

  public function update_instagram_url($Instagram,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Instagram);
  }

  public function update_twitter_url($Twitter,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Twitter);
  }

  public function update_google_url($Google,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->update('layout', $Google);
  }


  // END OF LAYOUT

}
