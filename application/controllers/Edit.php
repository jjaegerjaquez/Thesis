<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Edit extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		// $this->load->model('Generals');
	}

  public function Home(){
    $this->load->view('edit/home');
  }

  public function General()
  {
      $this->load->view('general/index');
  }

  public function About()
  {
      $this->load->view('edit/about');
  }
  public function Contacts()
  {
    $this->load->view('edit/contact');
  }
  public function Gallery()
  {
    $this->load->view('edit/gallery');
  }

  public function Theme()
  {
    $this->load->view('edit/theme');
  }
}
