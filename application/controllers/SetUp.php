<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SetUp extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('SetUps');
	}

  public function index()
  {
    $this->load->view('setup/index');
  }

  public function update()
  {
    $user_id = $_SESSION['user_id'];
    $status = $this->input->post('select');
    if($this->SetUps->update($user_id,$status))
    {
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Okay! You are good to go!</div>');
        redirect('/Dashboard', 'refresh');
    }
    else
    {
        $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Something went wrong...</div>');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('user_id');
        redirect('/Home', 'refresh');
    }
  }

}
