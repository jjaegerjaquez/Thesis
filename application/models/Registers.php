<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registers extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function EmailExists($email)
  {
    $this->db->select('user_id');
    $this->db->where('email', $email);
    $query = $this->db->get('accounts');

    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
  }

  public function sendemail($email,$code){
    $from = "victonaragang@gmail.com";    //senders email address
    $subject = 'Verify email address';  //email subject
    $url = base_url()."Verify/confirm_email/".$code;
        //sending confirmEmail($receiver) function calling link to the user, inside message body
        $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
        <a href='.$url.'>Click Here</a><br><br>Thanks';
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
}
