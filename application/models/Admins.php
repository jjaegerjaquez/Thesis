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

}
