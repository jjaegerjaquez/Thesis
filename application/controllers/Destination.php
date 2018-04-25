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
    $this->load->library('google');
    $this->load->library('facebook');
		$this->load->model('Destinations');
    $this->data['destinations'] = $this->Destinations->get_localities();
    $this->data['categories'] = $this->Destinations->get_categories();
    $this->data['title'] = $this->Destinations->get_title();
    $this->data['icon'] = $this->Destinations->get_site_icon();
    $this->data['tagline'] = $this->Destinations->get_tagline();
    $this->data['facebook'] = $this->Destinations->get_facebook();
    $this->data['instagram'] = $this->Destinations->get_instagram();
    $this->data['twitter'] = $this->Destinations->get_twitter();
    $this->data['google'] = $this->Destinations->get_google();
    $this->data['google_login_url']=$this->google->get_login_url();
    $this->data['fb_login_url'] =  $this->facebook->login_url();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Destinations->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Destinations->get_traveller_profile($this->traveller_id);
      $this->data['notif_count'] = $this->Destinations->get_notif_count($this->traveller_id);
      $this->data['notifications'] = $this->Destinations->get_notifications($this->traveller_id);
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

  public function result($locality='')
  {
    if (!empty($this->input->post('filter')) && !empty($this->input->post('category'))) {
      $category = $this->input->post('category');
      $filter = $this->input->post('filter');
      if ($this->input->post('filter') == 'popular') {
        redirect(base_url().'Destination/search_popular/'.$filter.'/'.$category.'/'.$locality);
      }elseif ($this->input->post('filter') == 'rating') {
        redirect(base_url().'Destination/search_rating/'.$filter.'/'.$category.'/'.$locality);
      }elseif ($this->input->post('filter') == 'recent') {
        redirect(base_url().'Destination/search_recent/'.$filter.'/'.$category.'/'.$locality);
      }
    }elseif (!empty($this->input->post('filter'))) {
      if ($this->input->post('filter') == 'popular') {
        redirect(base_url().'Destination/popular/'.$locality);
      }
      elseif ($this->input->post('filter') == 'rating') {
        redirect(base_url().'Destination/ratings/'.$locality);
      }
      elseif ($this->input->post('filter') == 'recent') {
        redirect(base_url().'Destination/recent/'.$locality);
      }
    }elseif (!empty($this->input->post('category'))) {
      $category = $this->input->post('category');
      redirect(base_url().'Destination/search/'.$category.'/'.$locality);
    }
    else {
      $lclty = str_replace('_', ' ', $locality);
      $query2= $this->db->get_where('basic_info', ['locality' => $lclty]);
      $limit = 2;
      $offset = $this->uri->segment(4);
      $config['uri_segment'] = 4;
      $config['base_url'] = '/Destination/result/'.$locality;
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
      $this->data['results'] = $this->Destinations->get_locality_result($limit,$offset,$locality);
      $this->data['destination'] = $this->Destinations->get_destination($locality);
      // $this->data['ctr'] = $count;
      $this->load->view('destinations/index',$this->data);
    }

  }

  public function search($category='',$locality='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Destination/search/'.$category.'/'.$locality;
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
    $this->data['results'] = $this->Destinations->fetch_category_result($limit,$offset,$category,$locality);
    $this->data['destination'] = $this->Destinations->get_destination($locality);
    $this->data['selected_category'] = $ctgry;
    $this->load->view('destinations/index',$this->data);
  }

  public function search_popular($filter,$category,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(6);
    $config['uri_segment'] = 6;
    $config['base_url'] = '/Destination/search_popular/'.$filter.'/'.$category.'/'.$locality;
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
    $this->data['results'] = $this->Destinations->fetch_result_by_popular($limit,$offset,$category,$locality);
    $this->data['destination'] = $this->Destinations->get_destination($locality);
    $this->data['selected_filter'] = 'popular';
    $this->data['selected_category'] = $ctgry;
    $this->load->view('destinations/index',$this->data);
  }

  public function search_rating($filter,$category,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(6);
    $config['uri_segment'] = 6;
    $config['base_url'] = '/Destination/search_rating/'.$filter.'/'.$category.'/'.$locality;
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
    $this->data['results'] = $this->Destinations->fetch_result_by_ratings($limit,$offset,$category,$locality);
    $this->data['destination'] = $this->Destinations->get_destination($locality);
    $this->data['selected_filter'] = 'rating';
    $this->data['selected_category'] = $ctgry;
    $this->load->view('destinations/index',$this->data);
  }

  public function search_recent($filter,$category,$locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(6);
    $config['uri_segment'] = 6;
    $config['base_url'] = '/Destination/search_recent/'.$filter.'/'.$category.'/'.$locality;
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
    $this->data['results'] = $this->Destinations->fetch_result_by_recent($limit,$offset,$category,$locality);
    $this->data['destination'] = $this->Destinations->get_destination($locality);
    $this->data['selected_filter'] = 'recent';
    $this->data['selected_category'] = $ctgry;
    $this->load->view('destinations/index',$this->data);
  }

  public function popular($locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty]);
    $limit = 2;
    $offset = $this->uri->segment(4);
    $config['uri_segment'] = 4;
    $config['base_url'] = '/Destination/popular/'.$locality;
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
    $this->data['results'] = $this->Destinations->get_locality_result_by_votes($limit,$offset,$locality);
    $this->data['destination'] = $this->Destinations->get_destination($locality);
    $this->data['selected_filter'] = 'popular';
    $this->load->view('destinations/index',$this->data);
  }

  public function ratings($locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty]);
    $limit = 2;
    $offset = $this->uri->segment(4);
    $config['uri_segment'] = 4;
    $config['base_url'] = '/Destination/ratings/'.$locality;
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
    $this->data['results'] = $this->Destinations->get_locality_result_by_ratings($limit,$offset,$locality);
    $this->data['destination'] = $this->Destinations->get_destination($locality);
    $this->data['selected_filter'] = 'rating';
    $this->load->view('destinations/index',$this->data);
  }

  public function recent($locality)
  {
    $lclty = str_replace('_', ' ', $locality);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty]);
    $limit = 2;
    $offset = $this->uri->segment(4);
    $config['uri_segment'] = 4;
    $config['base_url'] = '/Destination/recent/'.$locality;
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
    $this->data['results'] = $this->Destinations->get_locality_result_by_date($limit,$offset,$locality);
    $this->data['destination'] = $this->Destinations->get_destination($locality);
    $this->data['selected_filter'] = 'recent';
    $this->load->view('destinations/index',$this->data);
  }

  public function original_result($locality)
  {
    unset($_SESSION['filter']);
    $count = 0;
    $this->data['results'] = $this->Destinations->get_locality_result($locality);
    foreach ($this->data['results'] as $key => $result) {
      $count++;
    }

    for ($i=0; $i <$count ; $i++) {
      $this->data['votes'][$i] = $this->Destinations->get_votes($this->data['results'][$i]->id);
    }

    for ($i=0; $i <$count ; $i++) {
      $this->data['rates'][$i] = $this->Destinations->get_rates($this->data['results'][$i]->id);
    }

    if (!empty($count))
    {
      for ($i=0; $i <$count ; $i++)
      {
        echo '
          <div class="media" style="background-color:#fff;border:5px solid #fff;">
            <div class="pull-left visible-lg visible-md visible-sm media-left">
        ';
        if (!empty($this->data['results'][$i]->image)) {
          echo '
              <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
          ';
        }else {
          echo '
              <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
          ';
        }
        echo '
            </div>
          <div class="media-body rating">
        ';
        if (!empty($this->data['results'][$i]->image)) {
          echo '
              <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
          ';
        }else {
          echo '
              <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
          ';
        }
        echo '
             <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
        ';
        if ($this->data['votes'][$i]->vote > 1)
        {
          echo 'faves <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
        }
        else {
          echo 'fave <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
        }
        echo '
            <span class="category-style">'.$this->data['results'][$i]->category.'</span>
            <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
        ';
        if ($this->data['votes'][$i]->vote > 1)
        {
          echo 'faves </span>';
        }
        else {
          echo 'fave </span>';
        }
        echo '
            <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
            <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
            <div class="separator"></div>
            <ul>
              <div class="list-text visible-lg visible-md visible-sm">
                <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
              </div>
              <div class="hidden-lg hidden-md hidden-sm">
                <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
              </div>
              ';
          if (!empty($this->data['results'][$i]->cellphone)) {
            echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
          }else {
            echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
          }
        echo '
            </ul>
            <div class="row button-div">
            <div class="col-lg-12">
              <div class="col-xs-6 btn-style1">
                <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
                  <div class="space"></div>
                <span><i class="ion-earth"></i> Visit Website</span>
                </a>
              </div>
              <div class="col-xs-6 btn-style2">
                <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
                <div class="space"></div>
                <span><i class="ion-information-circled"></i> More</span>
                </a>
              </div>
            </div>
            </div>
          </div>
        </div>
        ';

      }
    }
    else
    {
      echo "0 results";
    }
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
