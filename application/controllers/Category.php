<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Category extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Categories');
	}

  public function index()
  {

  }

  public function result($category)
  {
    if ($this->session->userdata('is_logged_in')) {
      echo "looged in";
    }
    else
    {
      $data['results'] = $this->Categories->get_category_result($category);
      $data['category'] = $category;
      $this->load->view('home/result',$data);
    }
  }

  public function search()
  {
    $this->load->view('home/search');
  }


}
