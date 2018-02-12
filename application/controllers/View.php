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

  // public function _remap($username)
  // {
  //   $this->index($username);
  // }

  public function home($username)
  {
    $data['account'] = $this->Views->get_account_details($username);
    $business_id = $data['account']->user_id;
    $data['site_title'] = $this->Views->get_site_title($business_id);
    $data['site_tagline'] = $this->Views->get_site_tagline($business_id);
    $data['home_title'] = $this->Views->get_home_title($business_id);
    $data['home_description'] = $this->Views->get_home_description($business_id);
    $data['home_bg'] = $this->Views->get_home_bg($business_id);
    $data['about_header_image'] = $this->Views->get_about_header_image($business_id);
    $data['about_featured_image'] = $this->Views->get_about_featured_image($business_id);
    $data['about_description'] = $this->Views->get_about_description($business_id);
    $data['details'] = $this->Views->get_details($business_id);
    $data['facebook'] = $this->Views->get_facebook($business_id);
    $data['instagram'] = $this->Views->get_instagram($business_id);
    $data['image_sliders'] = $this->Views->get_image_slider($business_id);
    $data['gallery_images'] = $this->Views->get_gallery_images($business_id);
    $theme = $data['account']->template;
    // print_r($data['facebook']);
    $this->load->view('account/themes/'.$theme.'/index',$data);
  }

  public function about($username)
  {
    $data['account'] = $this->Views->get_account_details($username);
    $business_id = $data['account']->user_id;
    $data['site_title'] = $this->Views->get_site_title($business_id);
    $data['about_featured_image'] = $this->Views->get_about_featured_image($business_id);
    $data['about_title'] = $this->Views->get_about_title($business_id);
    $data['about_description'] = $this->Views->get_about_description($business_id);
    $data['about_header_image'] = $this->Views->get_about_header_image($business_id);
    $data['details'] = $this->Views->get_details($business_id);
    $theme = $data['account']->template;
    // print_r($data['facebook']);
    $this->load->view('account/themes/'.$theme.'/about',$data);
  }

  public function gallery($username)
  {
    $data['account'] = $this->Views->get_account_details($username);
    $business_id = $data['account']->user_id;
    $data['site_title'] = $this->Views->get_site_title($business_id);
    $data['gallery_images'] = $this->Views->get_gallery_images($business_id);
    $data['details'] = $this->Views->get_details($business_id);
    $theme = $data['account']->template;
    $this->load->view('account/themes/'.$theme.'/gallery',$data);
  }

  public function contacts($username)
  {
    $data['account'] = $this->Views->get_account_details($username);
    $business_id = $data['account']->user_id;
    $data['site_title'] = $this->Views->get_site_title($business_id);
    $data['facebook'] = $this->Views->get_facebook($business_id);
    $data['instagram'] = $this->Views->get_instagram($business_id);
    $data['twitter'] = $this->Views->get_twitter($business_id);
    $data['details'] = $this->Views->get_details($business_id);
    $theme = $data['account']->template;
    $this->load->view('account/themes/'.$theme.'/contacts',$data);
  }


}
