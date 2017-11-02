<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class View extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Views');
	}

  function _remap($user_id)
  {
    $this->index($user_id);
  }

  public function index($user_id)
  {
    $data['user'] = $this->Views->view_user_webpage($user_id);
    $temp = $data['user']->temp;
    if ($temp == 1) {
      $this->load->view('temp1/home');
    }elseif ($temp == 2) {
      $this->load->view('temp2/home');
    }elseif ($temp == 3) {

    }
  }
}
