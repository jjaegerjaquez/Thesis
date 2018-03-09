<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Event extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Events');
    // $this->data['Events'] = $this->Events->get_Events();
    $this->data['title'] = $this->Events->get_title();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Events->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Events->get_traveller_profile($this->traveller_id);
    }
    else
    {
      // $this->data['Events'] = $this->Events->get_Events();
    }
	}

  public function index()
  {

  }

  public function all()
  {
    $this->data['events'] = $this->Events->get_events();
    $this->load->view('events/all',$this->data);
  }

  public function preview($event_id)
  {
    $this->data['event'] = $this->Events->get_event($event_id);
    // $this->data['business_details'] = $this->Events->get_business_details($this->data['ad']->business_id);
    // print_r($this->data['ad']);
    $this->load->view('events/index',$this->data);
  }

  public function result()
  {
    $this->data['events'] = $this->Events->get_previous_events();
    $this->load->view('events/previous',$this->data);
  }

}
