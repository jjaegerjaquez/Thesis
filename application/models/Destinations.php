<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destinations extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function get_notif_count($user_id)
  {
    $date = new DateTime("now");
    $cur_date = $date->format('Y-m-d ');
    // $this->db->where('start_date >=', $cur_date);
    $query = $this->db->query("select count(recipient_id) as notif_count from notifications where recipient_id = '$user_id' and is_unread = '0' and created_time = '$cur_date'");
    return $query->row();
  }

  public function get_notifications($user_id)
  {
    $date = new DateTime("now");
    $cur_date = $date->format('Y-m-d ');
    $query = $this->db->query("select * from notifications where recipient_id = '$user_id' and created_time = '$cur_date' order by created_time DESC");
    return $query->result();
  }

  public function set_read($Notif,$user_id)
  {
    $this->db->where('recipient_id', $user_id);
    return $this->db->update('notifications', $Notif);
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

  public function get__localities($letter)
  {
    $query = $this->db->query("SELECT locality as locality FROM localities WHERE locality LIKE '$letter%' ORDER BY locality");
    return $query->result();
  }

  public function get__counts($letter)
  {
    $query = $this->db->query("SELECT count(locality_id) FROM localities WHERE locality LIKE '$letter%' ORDER BY locality");
    return $query->result();
  }

  public function get_locality_result($limit,$offset,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    // $query = $this->db->query("SELECT * FROM `basic_info` WHERE locality = '$lclty'");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $this->db->where('locality',$lclty);
    // $this->db->order_by('date_created','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_locality_result_by_votes($limit,$offset,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    // $query = $this->db->query("SELECT * FROM `basic_info` WHERE locality = '$lclty'");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $this->db->where('locality',$lclty);
    $this->db->order_by('vote_count','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_locality_result_by_ratings($limit,$offset,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    // $query = $this->db->query("SELECT * FROM `basic_info` WHERE locality = '$lclty'");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $this->db->where('locality',$lclty);
    $this->db->order_by('rate','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_locality_result_by_category($locality,$category)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query = $this->db->query("select * from basic_info where locality = '$lclty' and category = '$ctgry'");
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

  public function get_destination($locality)
  {
    $destination = str_replace('_', ' ', $locality);
    $query = $this->db->get_where('localities', ['locality' => $destination]);

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
    $query = $this->db->query("select count(business_id) as vote,business_id from votes WHERE business_id = '$business_id'");

    if ($query->num_rows() > 0) {
      $res = $query->row();
      if ($res->vote == '0') {
        $business = new stdClass;
        $business->vote = "0";
        $business->business_id = $business_id;
        return $business;
      }
      else {
        return $query->row();
      }
    }
  }

  public function get_business_details($user_id)
  {
    $query = $this->db->query("SELECT * FROM `basic_info` WHERE id = '$user_id'");
    return $query->row();
  }

  public function get_rates($business_id)
  {
    $query = $this->db->query("SELECT (sum(rate) / count(user_id)) as rate,business_id FROM `reviews` WHERE business_id = '$business_id'");
    // return $query->row();
    if ($query->num_rows() > 0) {
      $res = $query->row();
      if (empty($res->rate)) {
        $business = new stdClass;
        $business->rate = "0";
        $business->business_id = $business_id;
        return $business;
      }
      else {
        return $query->row();
      }
    }
  }

  public function get_locality_result_by_date($limit,$offset,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    // $query = $this->db->query("select bi.user_id,bi.category,bi.business_name,bi.address,bi.cellphone,bi.telephone,bi.website_url,bi.image,u.date_joined from basic_info bi join users u on (bi.user_id=u.user_id) where locality = '$lclty' ORDER by u.date_joined desc");
    // $query = $this->db->query("SELECT * FROM `basic_info` where locality = '$lclty' ORDER by date_created desc");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $this->db->where('locality',$lclty);
    $this->db->order_by('date_created','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function fetch_category_result($limit,$offset,$category,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    // $query = $this->db->query("select bi.user_id,bi.category,bi.business_name,bi.address,bi.cellphone,bi.telephone,bi.website_url,bi.image,u.date_joined from basic_info bi join users u on (bi.user_id=u.user_id) where locality = '$lclty' ORDER by u.date_joined desc");
    // $query = $this->db->query("SELECT * FROM `basic_info` where locality = '$lclty' ORDER by date_created desc");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $this->db->where('locality',$lclty);
    $this->db->where('category',$ctgry);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function fetch_result_by_popular($limit,$offset,$category,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    // $query = $this->db->query("select bi.user_id,bi.category,bi.business_name,bi.address,bi.cellphone,bi.telephone,bi.website_url,bi.image,u.date_joined from basic_info bi join users u on (bi.user_id=u.user_id) where locality = '$lclty' ORDER by u.date_joined desc");
    // $query = $this->db->query("SELECT * FROM `basic_info` where locality = '$lclty' ORDER by date_created desc");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $array = array('locality' => $lclty, 'category' => $ctgry);
    // $this->db->where('locality',$lclty);
    $this->db->where($array);
    $this->db->order_by('vote_count','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function fetch_result_by_ratings($limit,$offset,$category,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    // $query = $this->db->query("select bi.user_id,bi.category,bi.business_name,bi.address,bi.cellphone,bi.telephone,bi.website_url,bi.image,u.date_joined from basic_info bi join users u on (bi.user_id=u.user_id) where locality = '$lclty' ORDER by u.date_joined desc");
    // $query = $this->db->query("SELECT * FROM `basic_info` where locality = '$lclty' ORDER by date_created desc");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $array = array('locality' => $lclty, 'category' => $ctgry);
    // $this->db->where('locality',$lclty);
    $this->db->where($array);
    $this->db->order_by('rate','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function fetch_result_by_recent($limit,$offset,$category,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    // $query = $this->db->query("select bi.user_id,bi.category,bi.business_name,bi.address,bi.cellphone,bi.telephone,bi.website_url,bi.image,u.date_joined from basic_info bi join users u on (bi.user_id=u.user_id) where locality = '$lclty' ORDER by u.date_joined desc");
    // $query = $this->db->query("SELECT * FROM `basic_info` where locality = '$lclty' ORDER by date_created desc");
    // return $query->result();
    $this->db->select('*');
    $this->db->select('(SELECT COUNT(business_id) FROM votes WHERE votes.business_id = basic_info.id) as vote_count,(SELECT (SUM(rate) / count(user_id)) FROM reviews WHERE reviews.business_id = basic_info.id) as rate');
    $this->db->from('basic_info');
    $array = array('locality' => $lclty, 'category' => $ctgry);
    // $this->db->where('locality',$lclty);
    $this->db->where($array);
    $this->db->order_by('date_created','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_locality_result_by_date_by_category($locality,$category)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    // $query = $this->db->query("select bi.user_id,bi.category,bi.business_name,bi.address,bi.cellphone,bi.telephone,bi.website_url,bi.image,u.date_joined from basic_info bi join users u on (bi.user_id=u.user_id) where locality = '$lclty' and category = '$ctgry' ORDER by u.date_joined desc");
    $query = $this->db->query("SELECT * FROM `basic_info` where locality = '$lclty' and category = '$ctgry' ORDER by date_created desc");
    return $query->result();
  }

}
