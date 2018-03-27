<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Advertisement extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Advertisements');
    // $this->data['advertisements'] = $this->Advertisements->get_advertisements();
    $this->data['title'] = $this->Advertisements->get_title();
    $this->data['icon'] = $this->Advertisements->get_site_icon();
    $this->data['tagline'] = $this->Advertisements->get_tagline();
    $this->data['facebook'] = $this->Advertisements->get_facebook();
    $this->data['instagram'] = $this->Advertisements->get_instagram();
    $this->data['twitter'] = $this->Advertisements->get_twitter();
    $this->data['google'] = $this->Advertisements->get_google();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Advertisements->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Advertisements->get_traveller_profile($this->traveller_id);
      $this->data['notif_count'] = $this->Advertisements->get_notif_count($this->traveller_id);
      $this->data['notifications'] = $this->Advertisements->get_notifications($this->traveller_id);
    }
    else
    {
      // $this->data['advertisements'] = $this->Advertisements->get_Advertisements();
    }
	}

  public function index()
  {

  }

  public function all()
  {
    $this->data['advertisements'] = $this->Advertisements->get_advertisements();
    $this->load->view('advertisements/all',$this->data);
  }

  public function result($ad_id)
  {
    $this->data['ad'] = $this->Advertisements->get_advertisement($ad_id);
    $this->data['business_details'] = $this->Advertisements->get_business_details($this->data['ad']->business_id);
    $this->load->view('advertisements/index',$this->data);
  }

  public function search()
  {
    $this->load->view('home/search');
  }

}
