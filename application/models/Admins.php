<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends CI_Model
{

  function __construct()
  {
    parent::__construct();

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
    $query = $this->db->query("select business_name,advertisement_id,title from basic_info bi join advertisements a on (bi.id=a.business_id) where type = 'Priority'");
    return $query->result();
  }

  public function get_regular_ad()
  {
    $query = $this->db->query("select business_name,advertisement_id,title from basic_info bi join advertisements a on (bi.user_id=a.business_id) where type = 'Regular'");
    return $query->result();
  }

  function function_pagination($limit, $offset)
	{
    $this->db->select('*');
    $this->db->from('basic_info');
    $this->db->join('advertisements','basic_info.id=advertisements.business_id');
    $this->db->where('type', 'Regular');
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function sendemail($email)
  {
    $this->load->library('email');
    $config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 587,
    'smtp_user' => 'victonaragang@gmail.com',//your E-mail
    'smtp_pass' => 'victonarasalasgalang',//Your password
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1'
    );

    $this->load->library('email', $config);
    $this->email->set_newline("\r\n");

    // Set to, from, message, etc.
    $this->email->from('victonaragang@gmail.com', 'Travel Hub');
    $this->email->to($email);
    // $this->email->cc('another@another-example.com');
    // $this->email->bcc('them@their-example.com');

    $this->email->subject('Email Test');
    $this->email->message('Testing the email class.');

    $result = $this->email->send();
        // $code='lol';
        // $from = "victonaragang@gmail.com";    //senders email address
        // $subject = 'Verify email address';  //email subject
        // $url = base_url()."Verify/confirm_email/".$code;
        //     //sending confirmEmail($receiver) function calling link to the user, inside message body
        //     $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
        //     <a href='.$url.'>Click Here</a><br><br>Thanks';
        //
        //     // $from_email = $from;
        //     // $to_email = $email;
        //     //Load email library
        //     // $this->load->library('email');
        //     // $this->email->from($from_email, 'Identification');
        //     // $this->email->to($to_email);
        //     // $this->email->subject('Send Email Codeigniter');
        //     // $this->email->message('The email send using codeigniter library');
        //     //config email settings
        //     // $config['protocol'] = 'smtp';
        //     // $config['smtp_host'] = 'ssl://smtp.gmail.com';
        //     // $config['smtp_port'] = '465';
        //     // $config['smtp_user'] = $from;
        //     // $config['smtp_pass'] = 'victonarasalasgalang';  //sender's password
        //     // $config['mailtype'] = 'html';
        //     // $config['charset'] = 'iso-8859-1';
        //     // $config['wordwrap'] = 'TRUE';
        //     // $config['newline'] = "\r\n";
        //
        //     $this->load->library('email');
    		//     // $this->email->initialize($config);
        //     //send email
        //     $this->email->from($from);
        //     $this->email->to($email);
        //     $this->email->subject($subject);
        //     $this->email->message($message);
        //
        //     if($this->email->send()){
    		// 	    //for testing
        //       // echo "sent to: ".$email."<br>";
        // 			// echo "from: ".$from. "<br>";
        // 			// echo "protocol: ". $config['protocol']."<br>";
        // 			// echo "message: ".$message;
        //       return true;
        //     }else{
        //       // echo "email send failed";
        //       return false;
        //     }
  }

  function function_pagination_ending($limit, $offset)
	{
    $date = new DateTime("tomorrow");
    $tom = $date->format('Y-m-d');
    $where = "(advertisements.end_date = '$tom' OR advertisements.start_date = '$tom')";
    $this->db->select('*');
    $this->db->from('basic_info');
    $this->db->join('advertisements','basic_info.id=advertisements.business_id');
    $this->db->where($where);
    // $this->db->where('start_date', $tom);
    //$query = $this->db->get();
    // $this->db->order_by('nim','ASC');
    //$query = $this->db->get('tb_mahasiswa','tb_prodi',$limit, $offset);
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
	}

  public function get_ad($ad_id)
  {
    $query = $this->db->query("select business_name,advertisement_id,title,business_id,start_date,end_date,subtext,description,a.image from basic_info bi join advertisements a on (bi.id=a.business_id) where advertisement_id = '$ad_id'");
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
