<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Login extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Logins');

	}

  public function login()
  {
    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    if ($this->form_validation->run() == FALSE)
    { echo validation_errors(); }
    else
    {
      $this->form_validation->set_rules('password', 'Password', 'trim|required');
      if ($this->form_validation->run() == FALSE)
      { echo validation_errors(); }
      else
      {
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        if ($this->form_validation->run() == FALSE)
        { echo validation_errors(); }
        else
        {
            $email = $this->input->post('email');
            $pass = $this->input->post('password');
            $email_validate = $this->Logins->validate_email($email);
            if ($email_validate) {
              $data['account'] = $this->Logins->validate_email($email);
              // print_r($data['account']->password);
              $status = $data['account']->status;
              if ($status == '0') {
                echo "Unconfirmed";
              }elseif ($status == '1') {
                $password = $data['account']->password;
                if($password !== md5($pass)){
                  echo "Incorrect";
                }else {
                  $set_up = $data['account']->set_up;
                  if ($set_up == '0') {
                    echo "Set up";
                    $this->session->set_userdata('email', $email);
                    $this->session->set_userdata('user_id', $data['account']->user_id);
                    $this->session->set_userdata('is_logged_in', true);
                  }elseif ($set_up == '1') {
                    echo "Dashboard";
                    $this->session->set_userdata('email', $email);
                    $this->session->set_userdata('user_id', $data['account']->user_id);
                    $this->session->set_userdata('is_logged_in', true);
                  }
                }
              }
            }else {
              echo "Invalid";
            }
        }
      }
    }
  }

  public function check_if_null()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    if ($email==NULL && $password ==NULL) {
      echo "Please enter your email and password";
    }elseif ($email==NULL) {
      echo "Please enter your email";
    }elseif ($password==NULL) {
      echo "Please enter your password";
    }
  }
}
