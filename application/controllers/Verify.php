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
    $this->data['title'] = $this->Verifies->get_title();
    $this->data['icon'] = $this->Verifies->get_site_icon();
    if (!$this->session->userdata('is_logged_in') || !$this->session->userdata('traveller_is_logged_in'))
    {
      $allowed = array(
            'index',
            'not_sent',
            'unconfirmed',
            'confirm_email',
            'confirmed'
        );
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
          redirect(base_url().'Home');
        }
    }
  }

  public function index()
  {
    $this->load->view('verify/index', $this->data);
  }

  public function not_sent()
  {
    $this->load->view('verify/not_sent', $this->data);
  }

  public function unconfirmed()
  {
    $this->load->view('verify/unconfirmed', $this->data);
  }

  public function confirm_email($code)
    {
        if($this->Verifies->verify_email($code))
        {
            $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Email Address is successfully verified!</div>');
            redirect(base_url().'Verify/confirmed', 'refresh');
        }
        else
        {
            $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Your Email Address Verification Failed. Please try again later...</div>');
            redirect(base_url().'Verify/not_sent', 'refresh');
        }
    }

  public function confirmed()
  {
    $this->load->view('verify/confirm', $this->data);
  }

}
