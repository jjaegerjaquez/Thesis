<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Theme extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		// $this->load->model('Generals');
    // if (!$this->session->userdata('is_logged_in')) {
    //   redirect('/User');
    // }
	}

  public function index()
  {

  }

  public function preview($theme)
  {
    $this->load->view('account/themes/'.$theme.'/preview/index');
  }

  public function about($theme)
  {
    $this->load->view('account/themes/'.$theme.'/preview/about');
  }

  public function gallery($theme)
  {
    $this->load->view('account/themes/'.$theme.'/preview/gallery');
  }

  public function contacts($theme)
  {
    $this->load->view('account/themes/'.$theme.'/preview/contacts');
  }

}
