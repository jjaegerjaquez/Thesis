<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Destination extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Destinations');
    $this->data['destinations'] = $this->Destinations->get_localities();
    $this->data['title'] = $this->Destinations->get_title();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Destinations->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Destinations->get_traveller_profile($this->traveller_id);
    }
    else
    {
      $this->data['destinations'] = $this->Destinations->get_localities();
    }
	}

  public function index()
  {

  }

  public function all()
  {
    $letters = array(0 => 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $ctr=count($letters);
    for ($i=0; $i <$ctr ; $i++) {
      $this->data['localities'.$i] = $this->Destinations->get__localities($letters[$i]);
    }

    $this->load->view('destinations/all',$this->data);
  }

  public function result($locality)
  {
    $count = 0;
    $this->data['results'] = $this->Destinations->get_locality_result($locality);
    foreach ($this->data['results'] as $key => $result) {
      $count++;
    }

    for ($i=0; $i <$count ; $i++) {
      $this->data['votes'][$i] = $this->Destinations->get_votes($this->data['results'][$i]->user_id);
    }
    // print_r($this->data['votes']);
    $this->data['ctr']=$count;
    $this->data['destination'] = $locality;
    $this->load->view('destinations/index',$this->data);
  }

  public function search()
  {
    $this->load->view('home/search');
  }

  public function view($business_name)
  {
    $this->data['business'] = $this->Destinations->get_business(str_replace('_', ' ', $business_name));
    $business_id = $this->data['business']->user_id;
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $query = $this->db->query("select * from votes where voter_id = '$this->traveller_id' and business_id = '$business_id'");
      if ($query->num_rows() > 0)
      {
        $this->data['voted'] = 'Voted';
      }
    }
    $this->data['business'] = $this->Destinations->get_business(str_replace('_', ' ', $business_name));
    $this->data['vote'] = $this->Destinations->get_vote($this->data['business']->user_id);
    $this->data['reviews'] = $this->Destinations->get_reviews($this->data['business']->user_id);
    $this->data['review_count'] = $this->Destinations->get_review_count($this->data['business']->user_id);
    $this->load->view('home/view_business/index',$this->data);
  }

  public function check_vote()
  {
    echo "Voted";
  }

  public function add_review()
  {
    if ($this->session->userdata('traveller_is_logged_in'))
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
            'rate' => $this->input->post('rate'),
            'date_created' => date("Y-m-d")
          ];
          if ($this->db->insert('rates',$Rate)) {
            // $this->data['vote'] = $this->Homes->get_vote($business_id);
            // echo $this->data['vote']->vote;
            $Review = [
              'user_id' => $this->traveller_id,
              'business_id' => $this->input->post('business_id'),
              'review' => $this->input->post('review'),
              'date_created' => date("Y-m-d")
            ];
            if ($this->db->insert('reviews',$Review)) {
              // $this->data['vote'] = $this->Homes->get_vote($business_id);
              $this->data['business_details'] = $this->Destinations->get_business_by_Id($this->input->post('business_id'));
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
    else
    {
      echo "Not logged in";
    }
  }

}
