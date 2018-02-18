<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function get_category_result($category)
  {
    $ctgry = str_replace('_', ' ', $category);
    $query = $this->db->query("SELECT * FROM `basic_info` WHERE category = '$ctgry'");
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

  public function get_business($business_name)
  {
    $query = $this->db->get_where('basic_info', ['business_name' => $business_name]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_vote($business_id)
  {
    $query = $this->db->query("SELECT count(voter_id) as vote from votes where business_id = '$business_id'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_review_count($business_id)
  {
    $query = $this->db->query("SELECT count(user_id) as reviews from reviews where business_id = '$business_id'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return FALSE;
    }
  }

  public function get_business_by_Id($business_id)
  {
    $query = $this->db->get_where('basic_info', ['user_id' => $business_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_reviews($business_id)
  {
    $query = $this->db->query("select username,review,rate,r.date_created,image from users u join reviews r join rates ra join profile p on (u.user_id=r.user_id and u.user_id = ra.user_id and u.user_id = p.user_id and r.business_id = ra.business_id) where r.business_id = '$business_id'");
    return $query->result();
  }

  public function get_votes($business_id)
  {
    $query = $this->db->query("select count(business_id) as vote from votes WHERE business_id = '$business_id'");
    return $query->row();
  }

}
