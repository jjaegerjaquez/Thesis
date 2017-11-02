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
    if (!$this->session->userdata('is_logged_in')) {
      redirect('/User');
    }
	}

  public function index()
  {
    // $user_id = $_SESSION['user_id'];
    $this->load->view('theme/index');
  }

  public function apply_theme($temp)
  {
    $user_id = $_SESSION['user_id'];
    $this->db->set('temp', $temp); //value that used to update column
    $this->db->where('user_id', $user_id); //which row want to upgrade
    $this->db->update('general');  //table name
    echo '<script>alert("Theme applied!");</script>';
    redirect('/Theme', 'refresh');
  }

}
