<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function get_site_icon()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
    return $query->row();
  }

  public function delete_topic($topic_id)
  {
    return $this->db->query("DELETE t.*,p.*,c.* FROM topics t left JOIN posts p ON t.topic_id = p.topic_id left JOIN comments c ON t.topic_id = c.topic_id where t.topic_id = '$topic_id'");
  }

  public function delete_ads()
  {
    $query = $this->db->query("DELETE FROM `advertisements` WHERE end_date < CURDATE() and type ='Regular'");
  }

  public function get_review($id)
  {
    $query = $this->db->query("select * from reviews r join basic_info bi join profile p join rates ra on (r.business_id=bi.id and r.user_id=p.user_id and r.business_id = ra.business_id) where review_id = '$id' limit 1");
  }

  public function get_supplier($id)
  {
    // $query = $this->db->query("select * from basic_info where id = '$id'");
    // return $query->row();
    $this->db->select('*');
    $this->db->from('basic_info');
    $this->db->join('users','basic_info.user_id=users.user_id');
    $this->db->where('id', $id);
    // $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->row();
  }

  function function_pagination_suppliers($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('basic_info');
    // $this->db->join('users','basic_info.user_id=users.user_id');
    $this->db->order_by('date_created','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_admin($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('admin');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function update_account($Account,$admin_id)
  {
    $this->db->where('admin_id', $admin_id);
    return $this->db->update('admin', $Account);
  }

  function pagination_events($limit, $offset)
	{
    $date = new DateTime("now");
    $cur_date = $date->format('Y-m-d ');
    $this->db->select('*');
    $this->db->from('events');
    $this->db->where('start_date >=', $cur_date);
    $this->db->order_by('start_date','ASC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function pagination_finished_events($limit, $offset)
	{
    $date = new DateTime("now");
    $cur_date = $date->format('Y-m-d ');
    $this->db->select('*');
    $this->db->from('events');
    $this->db->where('start_date <', $cur_date);
    $this->db->order_by('start_date','ASC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_faves($limit, $offset)
	{
    // select * from votes v join users u join basic_info bi on (v.voter_id=u.user_id and v.business_id=bi.id)
    $this->db->select('*');
    $this->db->from('votes');
    $this->db->join('users','votes.voter_id=users.user_id');
    $this->db->join('basic_info','votes.business_id=basic_info.id');
    // $this->db->order_by('date_created','DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_reviews($limit, $offset)
	{
    // select * from reviews r join basic_info bi join profile p on (r.business_id=bi.id and r.user_id=p.user_id)
    $this->db->select('*');
    $this->db->from('reviews');
    $this->db->join('basic_info','reviews.business_id=basic_info.id');
    $this->db->join('profile','reviews.user_id=profile.user_id');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_topics($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('topics');
    // $this->db->join('users','topics.created_by=users.user_id');
    $this->db->where('created_by', 'Admin');
    // $this->db->where('topics.status', '1');
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_user_topics($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('topics');
    $this->db->join('users','topics.created_by=users.user_id');
    $this->db->where('created_by !=', 'Admin');
    $this->db->where('topics.status', '0');
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function validate_user($username)
  {
    $query = $this->db->get_where('admin', ['username' => $username]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function get_account($admin_id)
  {
    $query = $this->db->get_where('admin', ['admin_id' => $admin_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function BusinessIdExists($business_id)
  {
    $this->db->select('business_name');
    $this->db->where('id', $business_id);
    $query = $this->db->get('basic_info');

    if ($query->num_rows() > 0) {
        return false;
    } else {
        return true;
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

  public function get_email($user_id)
  {
    $query = $this->db->get_where('users', ['user_id' => $user_id]);

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

  public function approve_topic($topic_id)
  {
    $data = array('status' => '1');
    $this->db->where('topic_id', $topic_id);
    return $this->db->update('topics', $data);
  }

  public function disapprove_topic($topic_id)
  {
    $data = array('status' => '0');
    $this->db->where('topic_id', $topic_id);
    return $this->db->update('topics', $data);
  }

  function get_approved_user_topics($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('topics');
    $this->db->join('users','topics.created_by=users.user_id');
    $this->db->where('created_by !=', 'Admin');
    $this->db->where('topics.status', '1');
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function get_priority_ad()
  {
    $deadline = date('Y-m-d', strtotime("+5 days"));
    $deadline4 = date('Y-m-d', strtotime("+4 days"));
    $deadline3 = date('Y-m-d', strtotime("+3 days"));
    $deadline2 = date('Y-m-d', strtotime("+2 days"));
    $deadline1 = date('Y-m-d', strtotime("+1 days"));
    $query = $this->db->query("select business_name,advertisement_id,title from basic_info bi join advertisements a on (bi.id=a.business_id) where type = 'Priority' and (termination_date > '$deadline' or termination_date = '$deadline' or termination_date = '$deadline4' or termination_date = '$deadline3' or termination_date = '$deadline2' or termination_date = '$deadline1')");
    return $query->result();
  }

  public function get_regular_ad()
  {
    $query = $this->db->query("select business_name,advertisement_id,title from basic_info bi join advertisements a on (bi.user_id=a.business_id) where type = 'Regular'");
    return $query->result();
  }

  function function_pagination($limit, $offset)
	{
    $deadline = date('Y-m-d', strtotime("+5 days"));
    $where = "(advertisements.termination_date > '$deadline')";
    $this->db->select('*');
    $this->db->from('basic_info');
    $this->db->join('advertisements','basic_info.id=advertisements.business_id');
    $this->db->where('type', 'Regular');
    $this->db->where($where);
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_finished_priorities($limit, $offset)
	{
    $cur = new DateTime("now");
    $curdate = $cur->format('Y-m-d');
    $this->db->select('*');
    $this->db->from('basic_info');
    $this->db->join('advertisements','basic_info.id=advertisements.business_id');
    $this->db->where('type', 'Priority');
    $this->db->where('termination_date <', $curdate);
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  function function_pagination_finished_regulars($limit, $offset)
	{
    $cur = new DateTime("now");
    $curdate = $cur->format('Y-m-d');
    $this->db->select('*');
    $this->db->from('basic_info');
    $this->db->join('advertisements','basic_info.id=advertisements.business_id');
    $this->db->where('type', 'Regular');
    $this->db->where('termination_date <', $curdate);
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function sendemail($email,$msg)
  {
    $this->load->library('email');
    $from = "no-reply@travelhub.ph";    //senders email address
    $subject = 'Your advertisement is going to expire';  //email subject
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
    $this->email->cc('contact@travelhub.ph');
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

  function function_pagination_ending($limit, $offset)
	{
    $date = new DateTime("tomorrow");
    $tom = $date->format('Y-m-d');
    $deadline = date('Y-m-d', strtotime("+5 days"));
    $deadline4 = date('Y-m-d', strtotime("+4 days"));
    $deadline3 = date('Y-m-d', strtotime("+3 days"));
    $deadline2 = date('Y-m-d', strtotime("+2 days"));
    $deadline1 = date('Y-m-d', strtotime("+1 days"));
    $where = "(advertisements.termination_date = '$deadline' or advertisements.termination_date = '$deadline4' or advertisements.termination_date = '$deadline3' or advertisements.termination_date = '$deadline2' or advertisements.termination_date = '$deadline1')";
    $this->db->select('*');
    $this->db->from('basic_info');
    $this->db->join('advertisements','basic_info.id=advertisements.business_id');
    $this->db->where($where);
    // $this->db->where('type', 'Priority');
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function get_ad($ad_id)
  {
    $query = $this->db->query("select business_name,advertisement_id,title,business_id,user_id,start_date,end_date,subtext,description,a.image,contract,termination_date from basic_info bi join advertisements a on (bi.id=a.business_id) where advertisement_id = '$ad_id'");
    return $query->row();
  }

  public function update_ad($Ad,$ad_id)
  {
    $this->db->where('advertisement_id', $ad_id);
    return $this->db->update('advertisements', $Ad);
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
    return $this->db->update('localities', $Locality);
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
    return $this->db->update('categories', $Category);
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
    return $this->db->update('themes', $Theme);
  }
  // END OF THEMES

  // LAYOUT
  public function update_content($Content,$content_id)
  {
    $this->db->where('content_id', $content_id);
    return $this->db->update('layout', $Content);
  }

  public function get_reviews_count()
  {
    $query = $this->db->query("SELECT count(user_id) as review_count from reviews");
    return $query->row();
  }

  public function get_vote_count()
  {
    $query = $this->db->query("SELECT count(voter_id) as vote_count from votes");
    return $query->row();
  }

  public function get_supplier_count()
  {
    $query = $this->db->query("SELECT count(id) as supplier_count from basic_info");
    return $query->row();
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

  public function get_email_address()
  {
    $query = $this->db->query("select * from layout where meta_key = 'email_address'");
    return $query->row();
  }

  public function get_about_title()
  {
    $query = $this->db->query("select * from layout where meta_key = 'about_title'");
    return $query->row();
  }

  public function get_about_subtitle()
  {
    $query = $this->db->query("select * from layout where meta_key = 'about_subtitle'");
    return $query->row();
  }

  function function_pagination_about_texts($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('layout');
    $this->db->where('meta_key', 'about_detail');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function get_content($content_id)
  {
    $query = $this->db->get_where('layout', ['content_id' => $content_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  function image_slider($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('layout');
    $this->db->where('meta_key', 'image_slider');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}
  // END OF LAYOUT

  // EVENTS
  public function get_events()
  {
    $query = $this->db->query("select * from events");
    return $query->result();
  }

  public function get_event($event_id)
  {
    $query = $this->db->get_where('events', ['event_id' => $event_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
  }

  public function update_event($Event,$event_id)
  {
    $this->db->where('event_id', $event_id);
    return $this->db->update('events', $Event);
  }
  // END OF EVENTS

  // FORUM
  public function get_topic($topic_id)
  {
    $query = $this->db->get_where('topics', ['topic_id' => $topic_id]);

    if ($query->num_rows() > 0) {
      return $query->row();
    }
    return FALSE;
  }

  public function update_topic($Topic,$topic_id)
  {
    $this->db->where('topic_id', $topic_id);
    return $this->db->update('topics', $Topic);
  }
  // END OF FORUM
}
