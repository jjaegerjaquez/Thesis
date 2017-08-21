<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class User extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Users');

	}

  public function index()
  {
    $this->load->view('user/login');
  }

  public function register()
  {
    $this->load->view('user/register');
  }

  public function register_form()
  {
    // $this->form_validation->set_rules('business_name', 'Business Name', 'trim|required|callback_BusinessNameExists');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_EmailExists');
    // $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    $this->form_validation->set_rules('confirm_password', 'Confrim Password', 'trim|required|matches[password]');
    $this->form_validation->set_rules('checkbox', '', 'callback_check');
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('user/register');
    }
    else
    {
      $RegisterData = array(
        'business_name' => $this->input->post('business_name'),
        'email' => $this->input->post('email'),
        'username' => $this->input->post('username'),
        'password' => md5($this->input->post('password')),
        'date_joined' => date("Y-m-d"),
        'image' => ''
    );

    $this->db->insert('users',$RegisterData);
    echo '<script>alert("Successfully registered!");</script>';
    redirect('/User', 'refresh');
    }
  }

  public function check()
  {
    if ($this->input->post('checkbox'))
    {
      return TRUE;
    }
    else
    {
      $error = 'Please agree to our terms.';
      $this->form_validation->set_message('check', $error);
      return FALSE;
    }
  }

  // public function BusinessNameExists()
  // {
  //   $businessname = $this->input->post('business_name');
  //   $business_name_exists = $this->Users->BusinessNameExists($businessname);
  //
  //   if ($business_name_exists) {
  //       $this->form_validation->set_message('BusinessNameExists', 'The business name is already taken.');
  //       return false;
  //   } else {
  //       return true;
  //   }
  // }

  public function EmailExists()
  {
    $email = $this->input->post('email');
    $exists = $this->Users->EmailExists($email);

    if ($exists) {
        $this->form_validation->set_message('EmailExists', 'Email address is taken already.');
        return false;
    } else {
        return true;
    }
  }

  public function login()
  {
    // $email = $this->input->post('email');
    // $password = $this->input->post('password');

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('user/login');
    }
    else
    {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $user = $this->Users->get_user_login($email, $password);

      if ($user = $this->Users->get_user_login($email, $password))
           {
               /*$user_data = array(
                             'email' => $email,
                             'is_logged_in' => true
                        );

               $this->session->set_userdata($user_data);*/

               $this->session->set_userdata('email', $email);
               $this->session->set_userdata('user_id', $user['user_id']);
               $this->session->set_userdata('is_logged_in', true);

               $this->session->set_flashdata('msg_success','Login Successful!');
               redirect('/Dashboard');

           }
           else
           {
              //  $this->session->set_flashdata('msg_error','Login credentials does not match!');
               //
              //  $currentClass = $this->router->fetch_class(); // class = controller
              //  $currentAction = $this->router->fetch_method(); // action = function
               //
              //  redirect("$currentClass/$currentAction");
              //  //redirect('user/login');
           }
    }
  }
}
