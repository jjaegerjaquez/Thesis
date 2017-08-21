<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Dashboard extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Dashboards');
    if (!$this->session->userdata('is_logged_in')) {
      redirect('/User');
    }
	}

  public function index()
  {
    $user_id = $_SESSION['user_id'];
    $data['user_info'] = $this->Dashboards->get($user_id);
    $this->load->view('dashboard/index',$data);
  }

  public function logout()
  {
    if ($this->session->userdata('is_logged_in')) {

            //$this->session->unset_userdata(array('email' => '', 'is_logged_in' => ''));
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('is_logged_in');
            $this->session->unset_userdata('user_id');
        }
        redirect('/User');
  }
}
