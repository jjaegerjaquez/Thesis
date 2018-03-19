<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function BusinessNameExists($business_name)
  {
    $this->db->select('user_id');
    $this->db->where('business_name', $business_name);
    $query = $this->db->get('basic_info');

    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
  }

  public function update_business_name($user_id,$Business_Name)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where('position', 'Primary');
    return $this->db->update('basic_info', $Business_Name);
  }

  public function get_account_details($user_id)
  {
    $query = $this->db->get_where('users', ['user_id' => $user_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
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
  public function get_website($user_id,$business)
  {
    $query = $this->db->query("SELECT * FROM `basic_info` WHERE user_id = '$user_id' and business_name = '$business'");

    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function save_profile($Business_Details,$user_id,$Business)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where('business_name', $Business);
    return $this->db->update('basic_info', $Business_Details);
  }

  public function update_business_status($user_id,$business_name,$Status)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where('business_name', $business_name);
    return $this->db->update('basic_info', $Status);
  }

  public function get_localities()
  {
    $query = $this->db->query("select * from localities order by locality asc");
    return $query->result();
  }

  public function get_categories()
  {
    $query = $this->db->query("select * from categories order by category asc");
    return $query->result();
  }

  public function update_user_template($Template,$user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where('position', 'Primary');
    return $this->db->update('basic_info', $Template);
  }

  public function update_new_theme($Template,$user_id,$business_name)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where('business_name', $business_name);
    return $this->db->update('basic_info', $Template);
  }

  public function get_business_template($user_id,$business)
  {
    $query = $this->db->query("SELECT * FROM `basic_info` WHERE user_id = '$user_id' and business_name = '$business'");

    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_theme($business)
  {
    $query = $this->db->get_where('basic_info', ['business_name' => $business]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_themes()
  {
    $query = $this->db->query("select * from themes");
    return $query->result();
  }

  public function get_businesses($user_id)
  {
    $query = $this->db->query("select * from basic_info where user_id = '$user_id'");
    return $query->result();
  }

  public function get_site_logo($user_id,$id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and id = '$id' and meta_key = 'site_logo'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_site_title($user_id,$id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and id = '$id' and meta_key = 'site_title'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_site_tagline($user_id,$id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and id = '$id' and meta_key = 'site_tagline'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function update_site_title($Site_Title,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('contents', $Site_Title);
  }

  public function update_site_tagline($Site_Tagline,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('contents', $Site_Tagline);
  }

  public function update_site_logo($Site_Logo,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('contents', $Site_Logo);
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
      return FALSE;
    }
  }

  public function update_home_title($Home_Title,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('contents', $Home_Title);
  }

  public function update_home_description($Home_Description,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('contents', $Home_Description);
  }

  public function get_featured_image($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'about_featured_image'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_about_description($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'about_description'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function update_about_description($About_Description,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('contents', $About_Description);
  }

  public function update_featured_image($Featured_Image,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('contents', $Featured_Image);
  }

  public function get_gallery_images($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'gallery_image'");
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    return $query->result();
  }

  public function get_image($user_id,$content_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and content_id = '$content_id' and meta_key = 'gallery_image'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function update_gallery_image($Image,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $user_id);
    return $this->db->update('contents', $Image);
  }

  public function get_facebook_url($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'facebook_url'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_instagram_url($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'instagram_url'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_twitter_url($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'twitter_url'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function update_facebook_url($Facebook,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $user_id);
    return $this->db->update('contents', $Facebook);
  }

  public function update_instagram_url($Instagram,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $user_id);
    return $this->db->update('contents', $Instagram);
  }

  public function update_twitter_url($Twitter,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $user_id);
    return $this->db->update('contents', $Twitter);
  }

  public function get_slider_images($user_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and meta_key = 'image_slider'");
    if ($query->num_rows() > 0) {
      return $query->result();
    }else {
      return $query->result();
    }
  }

  public function get_image_slider($user_id,$content_id)
  {
    $query = $this->db->query("SELECT * FROM `contents` WHERE user_id = '$user_id' and content_id = '$content_id' and meta_key = 'image_slider'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
  }

  public function update_image_slider($Image,$user_id,$content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $user_id);
    return $this->db->update('contents', $Image);
  }

}
