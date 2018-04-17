<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homes extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function get_loc_count()
  {
    $query = $this->db->query("select count(DISTINCT locality) as loc_count from localities");
    return $query->row();
  }

  public function get_sup_count()
  {
    $query = $this->db->query("select count(DISTINCT business_name) as sup_count from basic_info");
    return $query->row();
  }

  public function get_user_count()
  {
    $query = $this->db->query("select count(DISTINCT user_id) as user_count from profile");
    return $query->row();
  }

  public function get_review_count()
  {
    $query = $this->db->query("select count(review_id) as review_count from reviews");
    return $query->row();
  }

  public function get_fave_count()
  {
    $query = $this->db->query("select count(vote_id) as fave_count from votes");
    return $query->row();
  }

  public function get_cat_count()
  {
    $query = $this->db->query("select count(DISTINCT category) as cat_count from categories");
    return $query->row();
  }

  public function get_all_categories()
  {
    $query = $this->db->query("select * from categories");
    return $query->result();
  }

  public function get_category_count($_category)
  {
    $query = $this->db->query("SELECT category, count(id) as category_count from basic_info where category = '$_category'");
    if ($query->num_rows() > 0) {
      $res = $query->row();
      if ($res->category == NULL) {
        $query2 = $this->db->query("select * from categories where category = '$_category'");
        $data['cat'] = $query2->row();
        $category = new stdClass;
        $category->category = $_category;
        $category->category_count = "0";
        $category->image = $data['cat']->image;
        return $category;
      }
      else {
        $data['cat_count_det'] = $query->row();
        $query2 = $this->db->query("select * from categories where category = '$_category'");
        $data['cat'] = $query2->row();
        $category = new stdClass;
        $category->category = $_category;
        $category->category_count = $data['cat_count_det']->category_count;
        $category->image = $data['cat']->image;
        return $category;

      }
    }
  }

  public function update_email($Email,$user_id)
  {
    $this->db->where('user_id', $user_id);
    return $this->db->update('users', $Email);
  }

  function function_pagination_all_notifications($limit, $offset,$id)
	{
    $this->db->select('*');
    $this->db->from('notifications');
    $this->db->where('recipient_id', $id);
    //$query = $this->db->get();
    $this->db->order_by('created_time','DESC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function GetRow($keyword) {
        $this->db->order_by('locality', 'ASC');
        $this->db->like("locality", $keyword);
        return $this->db->get('localities')->result_array();
    }

    public function get_look_result($keyword) {
          $this->db->order_by('category', 'DESC');
          $this->db->like("category", $keyword);
          return $this->db->get('categories')->result_array();
      }

  public function EmailExists($email)
  {
    $this->db->select('user_id');
    $this->db->where('email', $email);
    $query = $this->db->get('users');

    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
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

  public function get_site_icon()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
    return $query->row();
  }

  public function get_image_sliders()
  {
    $query = $this->db->query("select * from layout where meta_key = 'image_slider'");
    return $query->result();
  }

  public function get_priority_ad()
  {
    $deadline = date('Y-m-d', strtotime("+5 days"));
    $query = $this->db->query("select business_name,advertisement_id,title,subtext,a.image from basic_info bi join advertisements a on (bi.id=a.business_id) where type = 'Priority' and termination_date > '$deadline'");
    return $query->result();
  }

  public function update_user_template($Template,$user_id)
  {
    $this->db->where('user_id', $user_id);
    return $this->db->update('users', $Template);
  }

  public function UsernameExists($username)
  {
    $this->db->select('user_id');
    $this->db->where('username', $username);
    $query = $this->db->get('users');

    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
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

  public function sendemail($email,$msg)
  {
    $this->load->library('email');
    $from = "no-reply@travelhub.ph";    //senders email address
    $subject = 'Please verify your Travel Hub account';  //email subject
    $from_email = $from;
    $to_email = $email;

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'travelhub.ph';
    $config['smtp_port'] = '587';
    $config['smtp_user'] = $from;
    $config['smtp_pass'] = '2EtrdEms2I';  //sender's password
    $config['mailtype'] = 'html';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = 'TRUE';
    $config['newline'] = "\r\n";

    $this->load->library('email');
    $this->email->initialize($config);

    $this->email->from($from_email, 'Travel Hub');
    $this->email->to($to_email);
    $this->email->cc('support@travelhub.ph');
    $this->email->subject($subject);
    $this->email->message($msg);

    if($this->email->send())
    {
      return true;
    }else
    {
      return false;
    }
  }

  public function validate_email($email)
  {
    $query = $this->db->get_where('users', ['email' => $email]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function fetch_basic_info($user_id)
  {
    $query = $this->db->query("SELECT * FROM `basic_info` WHERE user_id = '$user_id' and position = 'Primary'");

    if ($query->num_rows() > 0) {
        return $query->row();
    } else {
        return false;
    }
  }

  public function get_traveller_details($traveller_id)
  {
    $query = $this->db->get_where('users', ['user_id' => $traveller_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_account($user_id)
  {
    $query = $this->db->get_where('users', ['user_id' => $user_id]);

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

  public function get_localities()
  {
    $query = $this->db->query("select * from localities limit 15");
    return $query->result();
  }

  public function get_all_localities()
  {
    $query = $this->db->query("select * from localities limit 15");
    return $query->result();
  }

  public function get_counts($locality)
  {
    $query = $this->db->query("select count(user_id) as count from basic_info WHERE locality = '$locality'");
    return $query->row();
  }

  public function get($user_id)
  {
    $query = $this->db->get_where('users', ['user_id' => $user_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function get_email($email)
  {
    $query = $this->db->get_where('users', ['email' => $email]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function update_set_up($user_id)
  {
    $data = array('set_up' => '1' );
    $this->db->where('user_id', $user_id);
    return $this->db->update('users', $data);
  }

  public function get_categories()
  {
    $query = $this->db->query("select * from categories limit 11");
    return $query->result();
  }

  public function get_user_details($user_id)
  {
    $query = $this->db->query("select * from users u join basic_info bi on u.user_id=bi.user_id where u.user_id='$user_id'");
    if ($query->num_rows() > 0) {
      return $query->row();
    }else {
      return $query->row();
    }
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

  public function update_traveller_profile($Profile,$user_id)
  {
    $this->db->where('user_id', $user_id);
    return $this->db->update('profile', $Profile);
  }

  public function update_password($Password,$user_id)
  {
    $this->db->where('user_id', $user_id);
    return $this->db->update('users', $Password);
  }

  public function update_username($Username,$user_id)
  {
    $this->db->where('user_id', $user_id);
    return $this->db->update('users', $Username);
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

  public function get_events()
  {
    $query = $this->db->query("SELECT * FROM `events` WHERE start_date >= curdate() limit 3");
    return $query->result();
  }

  public function get_topics()
  {
    $query = $this->db->query("select * from topics limit 5");
    return $query->result();
  }

}
