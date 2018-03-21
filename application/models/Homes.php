<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homes extends CI_Model
{

  function __construct()
  {
    parent::__construct();

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

  public function get_site_icon()
  {
    $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
    return $query->row();
  }

  public function get_priority_ad()
  {
    $query = $this->db->query("select business_name,advertisement_id,title,subtext,a.image from basic_info bi join advertisements a on (bi.id=a.business_id) where type = 'Priority'");
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

  public function sendemail($email,$code)
  {
    $from = "victonaragang@gmail.com";    //senders email address
    $subject = 'Verify email address';  //email subject
    $url = base_url()."Verify/confirm_email/".$code;
        //sending confirmEmail($receiver) function calling link to the user, inside message body
        $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
        <a href='.$url.'>Click Here</a><br><br>Thanks';

        // $from_email = $from;
        // $to_email = $email;
        //Load email library
        // $this->load->library('email');
        // $this->email->from($from_email, 'Identification');
        // $this->email->to($to_email);
        // $this->email->subject('Send Email Codeigniter');
        // $this->email->message('The email send using codeigniter library');
        //config email settings
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = $from;
        $config['smtp_pass'] = 'victonarasalasgalang';  //sender's password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = 'TRUE';
        $config['newline'] = "\r\n";

        $this->load->library('email', $config);
		    $this->email->initialize($config);
        //send email
        $this->email->from($from);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);

        if($this->email->send()){
			    //for testing
          // echo "sent to: ".$email."<br>";
    			// echo "from: ".$from. "<br>";
    			// echo "protocol: ". $config['protocol']."<br>";
    			// echo "message: ".$message;
          return true;
        }else{
          // echo "email send failed";
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
