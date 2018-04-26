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
    $this->load->library('google');
    $this->load->library('facebook');
    $this->load->library('banbuilder/lang/en_us_wordlist_regex');
		$this->load->model('Categories');
    $this->data['categories'] = $this->Categories->get_categories();
    $this->data['title'] = $this->Categories->get_title();
    $this->data['icon'] = $this->Categories->get_site_icon();
    $this->data['tagline'] = $this->Categories->get_tagline();
    $this->data['facebook'] = $this->Categories->get_facebook();
    $this->data['instagram'] = $this->Categories->get_instagram();
    $this->data['twitter'] = $this->Categories->get_twitter();
    $this->data['google'] = $this->Categories->get_google();
    $this->data['google_login_url']=$this->google->get_login_url();
    $this->data['fb_login_url'] =  $this->facebook->login_url();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Categories->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Categories->get_traveller_profile($this->traveller_id);
      $this->data['notif_count'] = $this->Categories->get_notif_count($this->traveller_id);
      $this->data['notifications'] = $this->Categories->get_notifications($this->traveller_id);
    }
    else
    {
      $this->data['categories'] = $this->Categories->get_categories();
    }
	}

  public function index()
  {

  }

  public function all()
  {
    $this->load->view('categories/index',$this->data);
  }

  public function result($category,$filter='')
  {
    $count = 0;
    if ($filter == 'popular') {
      $ctgry = str_replace('_', ' ', $category);
      $query2= $this->db->get_where('basic_info', ['category' => $ctgry]);
      $limit = 5;
      $offset = $this->uri->segment(5);
      $config['uri_segment'] = 5;
      $config['base_url'] = '/Category/result/'.$category.'/popular';
      $config['total_rows'] = $query2->num_rows();
      $config['per_page'] = $limit;
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_tag_open'] = '<li>';
      $config['last_tag_open'] = '<li>';

      $config['next_tag_open'] = '<li>';
      $config['prev_tag_open'] = '<li>';

      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $config['first_tag_close'] = '</li>';
      $config['last_tag_close'] = '</li>';

      $config['next_tag_close'] = '</li>';
      $config['prev_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
      $config['cur_tag_close'] = '</b></span></li>';
      $this->pagination->initialize($config);
      $this->data['results'] = $this->Categories->get_category_result_by_votes($limit,$offset,$category);
      $this->data['ctr']=$count;
      $this->data['category'] = $category;
      $this->data['filter'] = $filter;
      $this->load->view('categories/result/result',$this->data);
    }
    elseif ($filter == 'ratings')
    {
      $ctgry = str_replace('_', ' ', $category);
      $query2= $this->db->get_where('basic_info', ['category' => $ctgry]);
      $limit = 5;
      $offset = $this->uri->segment(5);
      $config['uri_segment'] = 5;
      $config['base_url'] = '/Category/result/'.$category.'/ratings';
      $config['total_rows'] = $query2->num_rows();
      $config['per_page'] = $limit;
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_tag_open'] = '<li>';
      $config['last_tag_open'] = '<li>';

      $config['next_tag_open'] = '<li>';
      $config['prev_tag_open'] = '<li>';

      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $config['first_tag_close'] = '</li>';
      $config['last_tag_close'] = '</li>';

      $config['next_tag_close'] = '</li>';
      $config['prev_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
      $config['cur_tag_close'] = '</b></span></li>';
      $this->pagination->initialize($config);
      $this->data['results'] = $this->Categories->get_category_result_by_ratings($limit,$offset,$category);
      $this->data['ctr']=$count;
      $this->data['category'] = $category;
      $this->data['filter'] = $filter;
      $this->load->view('categories/result/result',$this->data);
    }
    elseif ($filter == 'recent')
    {
      $ctgry = str_replace('_', ' ', $category);
      $query2= $this->db->get_where('basic_info', ['category' => $ctgry]);
      $limit = 5;
      $offset = $this->uri->segment(5);
      $config['uri_segment'] = 5;
      $config['base_url'] = '/Category/result/'.$category.'/recent';
      $config['total_rows'] = $query2->num_rows();
      $config['per_page'] = $limit;
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_tag_open'] = '<li>';
      $config['last_tag_open'] = '<li>';

      $config['next_tag_open'] = '<li>';
      $config['prev_tag_open'] = '<li>';

      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $config['first_tag_close'] = '</li>';
      $config['last_tag_close'] = '</li>';

      $config['next_tag_close'] = '</li>';
      $config['prev_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
      $config['cur_tag_close'] = '</b></span></li>';
      $this->pagination->initialize($config);
      $this->data['results'] = $this->Categories->get_category_result_by_date($limit,$offset,$category);
      $this->data['ctr']=$count;
      $this->data['category'] = $category;
      $this->data['filter'] = $filter;
      $this->load->view('categories/result/result',$this->data);
    }
    else
    {
      $ctgry = str_replace('_', ' ', $category);
      $query2= $this->db->get_where('basic_info', ['category' => $ctgry]);
      $limit = 5;
      $offset = $this->uri->segment(4);
      $config['uri_segment'] = 4;
      $config['base_url'] = '/Category/result/'.$category;
      $config['total_rows'] = $query2->num_rows();
      $config['per_page'] = $limit;
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_tag_open'] = '<li>';
      $config['last_tag_open'] = '<li>';

      $config['next_tag_open'] = '<li>';
      $config['prev_tag_open'] = '<li>';

      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $config['first_tag_close'] = '</li>';
      $config['last_tag_close'] = '</li>';

      $config['next_tag_close'] = '</li>';
      $config['prev_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
      $config['cur_tag_close'] = '</b></span></li>';
      $this->pagination->initialize($config);
      $this->data['results'] = $this->Categories->get_category_result($limit,$offset,$category);
      $this->data['ctr']=$count;
      $this->data['category'] = $category;
      $this->data['filter'] = NULL;
      $this->load->view('categories/result/result',$this->data);
    }
  }

  public function search()
  {
    $this->load->view('home/search');
  }

  public function view($business_name)
  {
    $this->data['business'] = $this->Categories->get_business(str_replace('_', ' ', $business_name));
    $business_id = $this->data['business']->id;
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $query = $this->db->query("select * from votes where voter_id = '$this->traveller_id' and business_id = '$business_id'");
      if ($query->num_rows() > 0)
      {
        $this->data['voted'] = 'Voted';
      }
    }
    $this->data['rate'] = $this->Categories->get_rates($business_id);
    $this->data['vote'] = $this->Categories->get_vote($business_id);
    $query2= $this->db->get_where('reviews', ['business_id' => $business_id]);
    $limit = 5;
    $offset = $this->uri->segment(4);
    $config['uri_segment'] = 4;
    $config['base_url'] = '/Category/view/'.$business_name;
    $config['total_rows'] = $query2->num_rows();
    $config['per_page'] = $limit;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';

    $config['first_tag_open'] = '<li>';
    $config['last_tag_open'] = '<li>';

    $config['next_tag_open'] = '<li>';
    $config['prev_tag_open'] = '<li>';

    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $config['first_tag_close'] = '</li>';
    $config['last_tag_close'] = '</li>';

    $config['next_tag_close'] = '</li>';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
    $config['cur_tag_close'] = '</b></span></li>';
    $this->pagination->initialize($config);
    $this->data['reviews'] = $this->Categories->get_reviews($limit,$offset,$business_id);
    $this->data['review_count'] = $this->Categories->get_review_count($business_id);
    $this->load->view('categories/view_business/index',$this->data);
  }

  public function add_review()
  {
    $us_wordlist = new en_us_wordlist_regex();
    $badwords = $us_wordlist->getBadWords();
    $this->load->library('banbuilder/Censor_Function');
    $censorFunction = new Censor_Function();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $rate = $this->input->post('rate');
      if ($rate == '0')
      {
        echo 'Rate';
      }
      else
      {
        $this->form_validation->set_rules(
            'review', 'Review',
            'trim|required',
            array(
                    'required'      => 'Please share us your experience'
            )
        );
        if ($this->form_validation->run() == FALSE)
        {
          echo "Experience";
        }
        else
        {
          $censored = $censorFunction->censorString($this->input->post('review'), $badwords);
          if (empty($censored['clean']))
          {
            $Review = [
              'user_id' => $this->traveller_id,
              'business_id' => $this->input->post('business_id'),
              'rate' => $this->input->post('rate'),
              'review' => $this->input->post('review'),
              'is_read' => '0',
              'date_created' => date("Y-m-d")
            ];
            $Notif = [
              'sender_id' => $this->traveller_id,
              'type_of_notification' => 'Review',
              'title_content' => $this->data['traveller_details']->username.' reviewed you.',
              'body_content' => $this->input->post('review'),
              'href' => base_url().'Account',
              'recipient_id' => $this->input->post('business_id'),
              'is_unread' => '0',
              'created_time' => date("Y-m-d")
            ];
            if ($this->db->insert('reviews',$Review) && $this->db->insert('supplier_notifications', $Notif)) {
              $this->data['business_details'] = $this->Categories->get_business_by_Id($this->input->post('business_id'));
              // echo "
              // <script type='text/javascript'>
              //   var elem = document.createElement('script');
              //   elem.onload = function () {
              //       jQuery(document).ready(function () {
              //         $(location).attr('href','/Category/view/".str_replace(' ', '_', $this->data['business_details']->business_name)."');
              //       });
              //   };
              //   elem.src = '/public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js';
              //   document.getElementsByTagName('head')[0].appendChild(elem);
              // </script>";
              echo "Successful";
            }
          }
          else
          {
            echo "Offensive";
          }
        }
      }
    }
    else
    {
      echo "Not logged in";
    }
  }

}
