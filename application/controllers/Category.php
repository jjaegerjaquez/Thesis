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
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Categories->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Categories->get_traveller_profile($this->traveller_id);
    }
	}

  public function index()
  {

  }

  public function result($category)
  {
      // echo str_replace('_', ' ', $category);
      $this->data['results'] = $this->Categories->get_category_result($category);
      $this->data['category'] = $category;
      $this->load->view('home/result',$this->data);
      // print_r($data['results']);
  }

  public function search()
  {
    $this->load->view('home/search');
  }

  public function view($business_name)
  {
    $this->data['business'] = $this->Categories->get_business(str_replace('_', ' ', $business_name));
    $business_id = $this->data['business']->user_id;
    $query = $this->db->query("select * from votes where voter_id = '$this->traveller_id' and business_id = '$business_id'");
    if ($query->num_rows() > 0)
    {
      echo "
      <script type='text/javascript'>
        var elem = document.createElement('script');
        elem.onload = function () {
            jQuery(document).ready(function () {
              var vote = {
                business_id: 10
              };
              $.ajax({
                  url: '/Category/check_vote',
                  type: 'POST',
                  data: vote,
                  success: function(message) {
                    if (message == 'Voted') {
                      $('#toggle-heart').prop('checked', true);
                    }else if (message=='Unsucessful') {
                      $('#toggle-heart').prop('checked', false);
                    }
                  }
              });
            });
        };
        elem.src = '/public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js';
        document.getElementsByTagName('head')[0].appendChild(elem);
      </script>";
      // $data['lol'] = $query->row();
      // print_r($data['lol']);
    }
    $this->data['business'] = $this->Categories->get_business(str_replace('_', ' ', $business_name));
    $this->data['vote'] = $this->Categories->get_vote($this->data['business']->user_id);
    $this->data['reviews'] = $this->Categories->get_reviews($this->data['business']->user_id);
    $this->load->view('home/view_business/index',$this->data);
  }

  public function check_vote()
  {
    echo "Voted";
  }

  public function add_review()
  {
    $rate = $this->input->post('rate');
    if ($rate == '0')
    {
      echo 'Please select your rate';
    }
    else
    {
      $this->form_validation->set_rules(
          'review', 'Review',
          'trim|required',
          array(
                  'required'      => 'Please share us your experience...'
          )
      );
      if ($this->form_validation->run() == FALSE)
      {
        echo validation_errors();
      }
      else
      {
        $Rate = [
          'user_id' => $this->traveller_id,
          'business_id' => $this->input->post('business_id'),
          'rate' => $this->input->post('rate')
        ];
        if ($this->db->insert('rates',$Rate)) {
          // $this->data['vote'] = $this->Homes->get_vote($business_id);
          // echo $this->data['vote']->vote;
          $Review = [
            'user_id' => $this->traveller_id,
            'business_id' => $this->input->post('business_id'),
            'review' => $this->input->post('review')
          ];
          if ($this->db->insert('reviews',$Review)) {
            // $this->data['vote'] = $this->Homes->get_vote($business_id);
            $this->data['business_details'] = $this->Categories->get_business_by_Id($this->input->post('business_id'));
            // echo $this->data['business_details']->business_name;
            // base_url().'View/home/'.$this->data['account']->username
            // echo "/Category/view/".str_replace(' ', '_', $this->data['business_details']->business_name);
            echo "
            <script type='text/javascript'>
              var elem = document.createElement('script');
              elem.onload = function () {
                  jQuery(document).ready(function () {
                    $(location).attr('href','/Category/view/".str_replace(' ', '_', $this->data['business_details']->business_name)."');
                  });
              };
              elem.src = '/public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js';
              document.getElementsByTagName('head')[0].appendChild(elem);
            </script>";
          }
        }
      }
    }
  }

}
