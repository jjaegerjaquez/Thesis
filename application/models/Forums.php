<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forums extends CI_Model
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

  public function get_topic($topic_id)
  {
    $query = $this->db->query("select t.topic_id,t.description,topic,count(p.user_id) as count from topics t join posts p on (t.topic_id=p.topic_id) where t.topic_id = '$topic_id'");
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
                ->join('users','topics.created_by=users.user_id')
                ->where('created_by !=', 'Admin')
                ->where('topics.status', '1')
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

  public function get_faqs_search_result($keyword)
  {
    $query = $this
                ->db
                ->select('*')
                ->from('topics')
                ->where('created_by', 'Admin')
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

  function function_pagination($limit, $offset)
	{
    $this->db->select('topics.topic_id,topics.topic,topics.date_created');
    $this->db->select('(SELECT COUNT(topic_id) FROM posts WHERE posts.topic_id = topics.topic_id)+
        (SELECT COUNT(topic_id) FROM comments WHERE comments.topic_id = topics.topic_id) as topic_count');
    $this->db->from('topics');
    $this->db->where('created_by !=', 'Admin');
    $this->db->where('topics.status', '1');
    $this->db->order_by('topic_count','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function get_topic_count($topic_id)
  {
    $query = $this->db->query("SELECT (SELECT COUNT(topic_id) FROM posts WHERE topic_id = '$topic_id')+(SELECT COUNT(topic_id) from comments WHERE topic_id = '$topic_id') AS topic_count, topic_id from topics where topic_id ='$topic_id'");

    if ($query->num_rows() > 0) {
      $res = $query->row();
      if ($res->topic_count == '0') {
        $business = new stdClass;
        $business->topic_count = "0";
        $business->topic_id = $topic_id;
        return $business;
      }
      else {
        return $query->row();
      }
    }
  }

  public function get_topic_details($limit,$offset,$topic_id)
  {
    $this->db->select('*');
    $this->db->from('topics');
    $this->db->join('users','topics.created_by=users.user_id');
    $this->db->where('created_by !=', 'Admin');
    $this->db->where('topics.status', '1');
    $this->db->where('topics.topic_id', $topic_id);
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    // $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->row();
  }

  function get_approved_user_topics($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('topics');
    // $this->db->join('users','topics.created_by=users.user_id');
    $this->db->where('created_by !=', 'Admin');
    $this->db->where('topics.status', '1');
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_faqs($limit, $offset)
	{
    // $this->db->select('*');
    // $this->db->from('topics');
    // $this->db->where('created_by', 'Admin');
    // $this->db->limit($limit, $offset);
    // $query = $this->db->get();
    // return $query->result();


    $this->db->select('topics.topic_id,topics.topic,topics.date_created');
    $this->db->select('(SELECT COUNT(topic_id) FROM posts WHERE posts.topic_id = topics.topic_id)+
        (SELECT COUNT(topic_id) FROM comments WHERE comments.topic_id = topics.topic_id) as topic_count');
    $this->db->from('topics');
    $this->db->where('created_by =', 'Admin');
    $this->db->order_by('topic_count','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function get_topic_info($topic_id)
  {
    $query = $this->db->get_where('topics', ['topic_id' => $topic_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

}
