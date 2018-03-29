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
  public function index()
  {

  }

  public function home($business_name)
  {
    $business_name = str_replace('_', ' ', $business_name);
    $data['account'] = $this->Views->get_account_details($business_name);
    $business_id = $data['account']->id;
    $user_id = $data['account']->user_id;
    $data['theme'] = $this->Views->get_theme($business_id,$business_name);
    $data['site_title'] = $this->Views->get_site_title($business_id,$business_name);
    $data['site_tagline'] = $this->Views->get_site_tagline($business_id,$business_name);
    $data['home_title'] = $this->Views->get_home_title($business_id,$business_name);
    $data['home_description'] = $this->Views->get_home_description($business_id,$business_name);
    $data['home_bg'] = $this->Views->get_home_bg($business_id,$business_name);
    $data['about_header_image'] = $this->Views->get_about_header_image($business_id,$business_name);
    $data['about_featured_image'] = $this->Views->get_about_featured_image($business_id,$business_name);
    $data['about_description'] = $this->Views->get_about_description($business_id,$business_name);
    $data['details'] = $this->Views->get_details($user_id,$business_name);
    $data['facebook'] = $this->Views->get_facebook($business_id,$business_name);
    $data['instagram'] = $this->Views->get_instagram($business_id,$business_name);
    $data['image_sliders'] = $this->Views->get_image_slider($business_id,$business_name);
    $data['gallery_images'] = $this->Views->get_gallery_images($business_id,$business_name);
    $theme = $data['theme']->theme;
    $data['icon'] = $this->Views->get_site_icon();
    $this->load->view('account/themes/'.$theme.'/index',$data);
  }

  public function about($business_name)
  {
    $business_name = str_replace('_', ' ', $business_name);
    $data['account'] = $this->Views->get_account_details($business_name);
    $business_id = $data['account']->id;
    $user_id = $data['account']->user_id;
    $data['theme'] = $this->Views->get_theme($business_id,$business_name);
    $data['site_title'] = $this->Views->get_site_title($business_id,$business_name);
    $data['about_featured_image'] = $this->Views->get_about_featured_image($business_id,$business_name);
    $data['about_title'] = $this->Views->get_about_title($business_id,$business_name);
    $data['about_description'] = $this->Views->get_about_description($business_id,$business_name);
    $data['about_header_image'] = $this->Views->get_about_header_image($business_id,$business_name);
    $data['details'] = $this->Views->get_details($user_id,$business_name);
    $theme = $data['theme']->theme;
    $data['icon'] = $this->Views->get_site_icon();
    $this->load->view('account/themes/'.$theme.'/about',$data);
  }

  public function gallery($business_name)
  {
    $business_name = str_replace('_', ' ', $business_name);
    $data['account'] = $this->Views->get_account_details($business_name);
    $business_id = $data['account']->id;
    $user_id = $data['account']->user_id;
    $data['theme'] = $this->Views->get_theme($business_id,$business_name);
    $data['site_title'] = $this->Views->get_site_title($business_id,$business_name);
    $data['gallery_images'] = $this->Views->get_gallery_images($business_id,$business_name);
    $data['details'] = $this->Views->get_details($user_id,$business_name);
    $theme = $data['theme']->theme;
    $data['icon'] = $this->Views->get_site_icon();
    $this->load->view('account/themes/'.$theme.'/gallery',$data);
  }

  public function contacts($business_name)
  {
    $business_name = str_replace('_', ' ', $business_name);
    $data['account'] = $this->Views->get_account_details($business_name);
    $business_id = $data['account']->id;
    $user_id = $data['account']->user_id;
    $data['theme'] = $this->Views->get_theme($business_id,$business_name);
    $data['site_title'] = $this->Views->get_site_title($business_id,$business_name);
    $data['facebook'] = $this->Views->get_facebook($business_id,$business_name);
    $data['instagram'] = $this->Views->get_instagram($business_id,$business_name);
    $data['twitter'] = $this->Views->get_twitter($business_id,$business_name);
    $data['details'] = $this->Views->get_details($user_id,$business_name);
    $theme = $data['theme']->theme;
    $data['icon'] = $this->Views->get_site_icon();
    $this->load->view('account/themes/'.$theme.'/contacts',$data);
  }

}
