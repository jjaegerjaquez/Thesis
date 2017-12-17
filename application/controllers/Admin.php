<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Admin extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		// $this->load->model('Dashboards');
    // if (!$this->session->userdata('is_logged_in')) {
    //   redirect('/Home');
    // }
	}

  public function index()
  {
    $this->load->view('admin/index');
  }

  public function Layout()
  {
    $this->load->view('admin/layout');
  }

  public function Localities()
  {
    $this->load->view('admin/localities');
  }

  public function Categories()
  {
    $this->load->view('admin/categories');
  }

  public function Events()
  {
    $this->load->view('admin/events');
  }
  public function Forum()
  {
    $this->load->view('admin/forum');
  }
  public function Advertisements()
  {
    $this->load->view('admin/advertisements');
  }
}
