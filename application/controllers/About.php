<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class About extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Abouts');

    $this->data['title'] = $this->Abouts->get_title();
    $this->data['icon'] = $this->Abouts->get_site_icon();
    $this->data['tagline'] = $this->Abouts->get_tagline();
    $this->data['facebook'] = $this->Abouts->get_facebook();
    $this->data['instagram'] = $this->Abouts->get_instagram();
    $this->data['twitter'] = $this->Abouts->get_twitter();
    $this->data['google'] = $this->Abouts->get_google();
    $this->data['about_title'] = $this->Abouts->get_about_title();
    $this->data['about_details'] = $this->Abouts->get_about_details();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Abouts->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Abouts->get_traveller_profile($this->traveller_id);
      $this->data['notif_count'] = $this->Abouts->get_notif_count($this->traveller_id);
      $this->data['notifications'] = $this->Abouts->get_notifications($this->traveller_id);
    }
	}

  public function index()
  {
    $this->load->view('about/index',$this->data);
  }

  public function terms()
  {
    $this->load->view('about/terms',$this->data);
  }

  public function privacy()
  {
    $this->load->view('about/privacy',$this->data);
  }
}
