<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class General extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Generals');
    if (!$this->session->userdata('is_logged_in')) {
      redirect('/User');
    }
	}

  public function index()
  {

  }
}
