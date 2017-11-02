<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Register extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Registers');

	}

  public function index()
  {
    // $email = $this->input->post('register_email');
    // $password = $this->input->post('register_password');
    // $confirm_password = $this->input->post('register_confirm_password');
    $this->form_validation->set_rules('register_email', 'Email', 'trim|required');
    $this->form_validation->set_rules('register_password', 'Password', 'trim|required');
    $this->form_validation->set_rules('register_confirm_password', 'Confrim Password', 'trim|required');
    if ($this->form_validation->run() == FALSE)
    {
      echo validation_errors();
    }
    else
    {
      $this->form_validation->set_rules('register_email', 'Email', 'valid_email');
      if ($this->form_validation->run() == FALSE)
      {
        echo "Please enter a valid email";
      }
      else
      {
        $this->form_validation->set_rules('email', 'Email', 'callback_EmailExists');
        if ($this->form_validation->run() == FALSE)
        {
          echo validation_errors();
        }
        else
        {
          $this->form_validation->set_rules('register_confirm_password', 'Confrim Password', 'matches[register_password]');
          if ($this->form_validation->run() == FALSE)
          {
            echo "Passwords do not matched";
          }else {
              $RegisterData = array(
                'email' => $this->input->post('register_email'),
                'password' => md5($this->input->post('register_password')),
                'date_joined' => date("Y-m-d"),
                'website' => 'No',
                'set_up' => '0',
                'status' => '0'
              );
              $email = $this->input->post('register_email');
              $code = md5($email);
              $this->db->insert('accounts',$RegisterData);
              // $this->sendemail($email,$code);
              if($this->Registers->sendemail($email,$code))
              {
                echo "Successful";
              }
              else
              {
                echo "Unsucessful";
              }
          }
        }
      }
    }
  }

  // public function check_if_null()
  // {
  //   $email = $this->input->post('register_email');
  //   $password = $this->input->post('register_password');
  //   $confirm_password = $this->input->post('register_confirm_password');
  //
  //   if ($email==NULL && $password==NULL && $confirm_password==NULL) {
  //     echo "Please supply all the details";
  //   }elseif ($email==NULL && $password==NULL) {
  //     echo "Please enter your email and password";
  //   }elseif ($email==NULL && $confirm_password==NULL) {
  //     echo "Please enter your email and confirm your password";
  //   }elseif ($password==NULL & $confirm_password==NULL) {
  //     echo "Please enter and confirm your password";
  //   }
  // }

  public function EmailExists()
  {
    $email = $this->input->post('register_email');
    $exists = $this->Registers->EmailExists($email);

    if ($exists) {
        $this->form_validation->set_message('EmailExists', 'Email address is taken already.');
        return false;
    } else {
        return true;
    }
  }
}
