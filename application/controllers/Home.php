<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Home extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Homes');
    if (!$this->session->userdata('is_logged_in'))
    {
      $this->data['categories'] = $this->Homes->get_categories();
      $this->data['title'] = $this->Homes->get_title();
      $this->data['tagline'] = $this->Homes->get_tagline();
      $this->data['facebook'] = $this->Homes->get_facebook();
      $this->data['instagram'] = $this->Homes->get_instagram();
      $this->data['twitter'] = $this->Homes->get_twitter();
      $this->data['google'] = $this->Homes->get_google();
      $allowed = array(
            'index',
            'login',
            'register',
            'logout'
        );
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
          redirect('/Home');
        }
    }
    else
    {
      $this->data['title'] = $this->Homes->get_title();
      $this->data['tagline'] = $this->Homes->get_tagline();
    }
	}

  public function index()
  {
    if ($this->session->userdata('is_logged_in'))
    {
      $email = $_SESSION['email'];
      $this->data['account'] = $this->Homes->validate_email($email);
      $set_up = $data['account']->set_up;
      if ($set_up == '0')
        {
          redirect('/Home/set_up');
        }else {
          redirect('/Home/redirect');
        }
    }
    $this->load->view('home/index',$this->data);

  }

  public function register()
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
          // $this->form_validation->set_rules('username', 'Username', 'alpha_numeric|callback_UsernameExists');
          $this->form_validation->set_rules(
              'username', 'Username',
              'alpha_numeric|callback_UsernameExists|trim',
              array(
                      'alpha_numeric'      => 'Space is not allowed.'
              )
          );
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
                  'username' => $this->input->post('username'),
                  'password' => md5($this->input->post('register_password')),
                  'date_joined' => date("Y-m-d"),
                  'website' => 'No',
                  'set_up' => '0',
                  'status' => '1'
                );
                $email = $this->input->post('register_email');
                $code = md5($email);
                // $this->sendemail($email,$code);
                if ($this->db->insert('users',$RegisterData)) {
                  $data['email_details'] = $this->Homes->get_email($email);
                  $Business_Data = array(
                    'user_id' => $data['email_details']->user_id,
                    'username' => $this->input->post('username'),
                    'business_name' => '',
                    'category' => '',
                    'locality' => '',
                    'address' => '',
                    'cellphone' => '',
                    'telephone' => '',
                    'website_url' => '',
                    'template' => '0',
                    'image' => ''
                  );
                  if ($this->db->insert('basic_info',$Business_Data)) {
                    chmod('./uploads/', 0777);
                    $path   = './uploads/'.$this->input->post('username');
                    if (!is_dir($path)) { //create the folder if it's not already exists
                        mkdir($path, 0755, TRUE);
                    }
                    echo "Successful";
                  }else {
                    $this->db->where('user_id', $data['email_details']->user_id);
                    $this->db->delete('users');
                    echo "Unsucessful";
                  }
                }else {
                  echo "Unsucessful";
                }
                // if($this->Registers->sendemail($email,$code))
                // {
                //   $this->db->insert('users',$RegisterData);
                //   echo "Successful";
                // }
                // else
                // {
                //   echo "Unsucessful";
                // }
            }
          }
        }
      }
    }
  }

  public function EmailExists()
  {
    $email = $this->input->post('register_email');
    $exists = $this->Homes->EmailExists($email);

    if ($exists) {
        $this->form_validation->set_message('EmailExists', 'Email address is taken already.');
        return false;
    } else {
        return true;
    }
  }

  public function UsernameExists()
  {
    $username = $this->input->post('username');
    $exists = $this->Homes->UsernameExists($username);

    if ($exists) {
        $this->form_validation->set_message('UsernameExists', 'Username is already taken.');
        return false;
    } else {
        return true;
    }
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
            $email_validate = $this->Homes->validate_email($email);
            if ($email_validate) {
              $data['account'] = $this->Homes->validate_email($email);
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

  public function redirect()
  {
    $email = $_SESSION['email'];
    $email_validate = $this->Homes->validate_email($email);
    if ($email_validate)
    {
      $data['account'] = $this->Homes->validate_email($email);
      $set_up = $data['account']->set_up;
      if ($set_up == '0')
      {
        $this->load->view('/home/setup/index');
      }
      elseif ($set_up == '1')
      {
        redirect('/Account', 'refresh');
      }
    }
  }

  public function set_up()
  {
    $this->load->view('home/setup/index');
  }

  public function set_up_save()
  {
    $user_id = $_SESSION['user_id'];
    $status = $this->input->post('select');
    if ($status == 'Yes')
    {
      if($this->Homes->update_set_up($user_id,$status))
      {
          $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Okay! You are good to go!</div>');
          redirect('/Account', 'refresh');
      }
      else
      {
          $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Something went wrong...</div>');
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
          redirect('/Home', 'refresh');
      }
    }
    else
    {
      if($this->Homes->update_set_up($user_id,$status))
      {
          $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Okay! You are good to go!</div>');
          redirect('/Account/themes', 'refresh');
      }
      else
      {
          $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Something went wrong...</div>');
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
          redirect('/Home', 'refresh');
      }
    }
  }

  public function user_with_website()
  {

  }

  public function user_without_website()
  {
    # code...
  }

  public function search()
  {
    $this->load->view('home/search');
  }

  public function logout()
  {
    if ($this->session->userdata('is_logged_in')) {
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
        }
        redirect('/Home');
  }
}
