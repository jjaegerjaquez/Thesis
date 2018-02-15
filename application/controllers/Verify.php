<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Verify extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Verifies');
    // if (!$this->session->userdata('is_logged_in')) {
    //   redirect('/Home');
    // }
    if (!$this->session->userdata('is_logged_in') || !$this->session->userdata('traveller_is_logged_in'))
    {
      $allowed = array(
            'index'
        );
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
          redirect('/Home');
        }
    }
  }

  public function index()
  {
    $this->load->view('verify/index');
  }

  public function not_sent()
  {
    $this->load->view('verify/not_sent');
  }

  public function unconfirmed()
  {
    $this->load->view('verify/unconfirmed');
  }

  public function confirm_email($code)
    {
        if($this->Verifies->verify_email($code))
        {
            $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Email Address is successfully verified!</div>');
            redirect('/Verify', 'refresh');
        }
        else
        {
            $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Your Email Address Verification Failed. Please try again later...</div>');
            redirect('/Verify/not_sent', 'refresh');
        }
    }

}
