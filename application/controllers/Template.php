<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Template extends CI_Controller
{

  function __construct()
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
    $this->load->view('template1/index');
  }

  public function temp2()
  {
    $this->load->view('template2/index');
  }

  public function temp3()
  {
    $this->load->view('template3/index');
  }
}
