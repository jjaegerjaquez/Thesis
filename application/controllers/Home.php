<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Home extends CI_Controller
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

  public function index()
  {
    // $query = $this->db->get('general','2', $this->uri->segment(3));
		// $data['users'] = $query->result();
    //
		// $query2= $this->db->get('general');
    //
		// $config['base_url'] = '/Home';
		// $config['total_rows'] = $query2->num_rows();
		// $config['per_page'] = 2;
    //
		// $config['full_tag_open'] = '<ul class="pagination">';
		// $config['full_tag_close'] = '</ul>';
    //
		// $config['first_tag_open'] = '<li>';
		// $config['last_tag_open'] = '<li>';
    //
		// $config['next_tag_open'] = '<li>';
		// $config['prev_tag_open'] = '<li>';
    //
		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';
    //
		// $config['first_tag_close'] = '</li>';
		// $config['last_tag_close'] = '</li>';
    //
		// $config['next_tag_close'] = '</li>';
		// $config['prev_tag_close'] = '</li>';
    //
		// $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
		// $config['cur_tag_close'] = '</b></span></li>';
    //
		// $this->pagination->initialize($config);
    $this->load->view('home/index');
  }
}
