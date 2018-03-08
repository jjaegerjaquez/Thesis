<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forums extends CI_Model
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

  public function get_topic($topic_id)
  {
    $query = $this->db->query("select t.topic_id,topic,count(p.user_id) as count from topics t join posts p on (t.topic_id=p.topic_id) where t.topic_id = '$topic_id'");
    return $query->row();
  }

  public function get_site_icon()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
    return $query->row();
  }

  public function get_topics()
  {
    $query = $this->db->query("select * from topics");
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
    $query = $this->db->get_where('basic_info', ['user_id' => $business_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_search_result($keyword)
  {
    $query = $this
                ->db
                ->select('*')
                ->from('topics')
                ->like('topic',$keyword)
                ->get();

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
  }

  public function get_topic_comments($topic_id)
  {
    $query = $this->db->query("select p.post_id,p.content,p.date_created,u.username,p.user_id,pr.image from posts p join users u join profile pr on (p.user_id=u.user_id and p.user_id=pr.user_id) where p.topic_id = '$topic_id' ORDER BY p.post_id");
    return $query->result();
  }

  public function get_replies($post_id)
  {
    $query = $this->db->query("select c.comment_id,c.topic_id,c.post_id,c.comment,c.date_created,u.username,u.user_id,pr.image from comments c join users u join profile pr on (c.user_id=u.user_id and c.user_id=pr.user_id) where c.post_id = '$post_id' ORDER BY c.comment_id");
    return $query->result();
  }

  public function get_reply_count($topic_id)
  {
    $query = $this->db->query("select count(topic_id) as reply_count from comments where topic_id = '$topic_id'");
    return $query->row();
  }

}
