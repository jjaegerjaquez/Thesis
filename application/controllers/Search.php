<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Search extends CI_Controller
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
		$this->load->model('Searchs');
    $this->data['destinations'] = $this->Searchs->get_localities();
    $this->data['categories'] = $this->Searchs->get_categories();
    $this->data['title'] = $this->Searchs->get_title();
    $this->data['icon'] = $this->Searchs->get_site_icon();
    $this->data['tagline'] = $this->Searchs->get_tagline();
    $this->data['facebook'] = $this->Searchs->get_facebook();
    $this->data['instagram'] = $this->Searchs->get_instagram();
    $this->data['twitter'] = $this->Searchs->get_twitter();
    $this->data['google'] = $this->Searchs->get_google();
    $this->data['google_login_url']=$this->google->get_login_url();
    $this->data['fb_login_url'] =  $this->facebook->login_url();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Searchs->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Searchs->get_traveller_profile($this->traveller_id);
      $this->data['notif_count'] = $this->Searchs->get_notif_count($this->traveller_id);
      $this->data['notifications'] = $this->Searchs->get_notifications($this->traveller_id);
    }
    else
    {
      $this->data['destinations'] = $this->Searchs->get_localities();
    }
	}

  public function result($locality_='',$category_='')
  {
      $locality = $this->input->post('locality-search');
      $filter = $this->input->post('filter');
      $category = $this->input->post('category');
      $cat = $this->input->post('_category');
      $_locality = ucwords($locality);
      $_category = ucwords($category);
      $lclty = str_replace(' ', '_', $_locality);
      $ctgry = str_replace(' ', '_', $_category);
      if (!empty($this->input->post('filter')) && !empty($this->input->post('_category'))) {

        if ($filter == 'popular') {
          redirect(base_url().'Search/search_popular/'.$locality_.'/'.$cat);
        }
        elseif ($filter == 'rating') {
          redirect(base_url().'Search/search_rating/'.$locality_.'/'.$cat);
        }
        elseif ($filter == 'recent') {
          redirect(base_url().'Search/search_recent/'.$locality_.'/'.$cat);
        }
      }elseif (!empty($filter)) {
        if ($filter == 'popular') {
          redirect(base_url().'Search/popular/'.$locality_.'/'.$category_);
        }elseif ($filter == 'rating') {
          redirect(base_url().'Search/ratings/'.$locality_.'/'.$category_);
        }elseif ($filter == 'recent') {
          redirect(base_url().'Search/recent/'.$locality_.'/'.$category_);
        }
      }elseif (!empty($cat)) {
        redirect(base_url().'Search/results/'.$locality_.'/'.$cat);
      }else {
        redirect(base_url().'Search/search/'.$lclty.'/'.$ctgry);
      }
  }

  public function search($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/search/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->get_locality_result_by_category($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->load->view('home/search/index',$this->data);
  }

  public function results($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/results/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->get_locality_result_by_category($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->data['selected_category'] = $ctgry;
    $this->load->view('home/search/index',$this->data);
  }

  public function popular($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/popular/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->fetch_result_by_popular($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->data['selected_filter'] = 'popular';
    $this->load->view('home/search/index',$this->data);
  }

  public function ratings($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/ratings/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->fetch_result_by_ratings($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->data['selected_filter'] = 'rating';
    $this->load->view('home/search/index',$this->data);
  }

  public function recent($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/recent/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->fetch_result_by_recent($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->data['selected_filter'] = 'recent';
    $this->load->view('home/search/index',$this->data);
  }

  public function search_popular($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/search_popular/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->fetch_result_by_popular($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->data['selected_filter'] = 'popular';
    $this->data['selected_category'] = $ctgry;
    $this->load->view('home/search/index',$this->data);
  }

  public function search_rating($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/search_rating/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->fetch_result_by_ratings($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->data['selected_filter'] = 'rating';
    $this->data['selected_category'] = $ctgry;
    $this->load->view('home/search/index',$this->data);
  }

  public function search_recent($locality='',$category='')
  {
    $lclty = str_replace('_', ' ', $locality);
    $ctgry = str_replace('_', ' ', $category);
    $query2= $this->db->get_where('basic_info', ['locality' => $lclty,'category' => $ctgry]);
    $limit = 2;
    $offset = $this->uri->segment(5);
    $config['uri_segment'] = 5;
    $config['base_url'] = '/Search/search_recent/'.$locality.'/'.$category;
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
    // $this->data['results'] = $this->Destinations->get_category_result($limit,$offset,$locality);
    $this->data['results'] = $this->Searchs->fetch_result_by_recent($limit,$offset,$lclty,$ctgry);
    $this->data['destination'] = $lclty;
    $this->data['_category'] = $ctgry;
    $this->data['selected_filter'] = 'recent';
    $this->data['selected_category'] = $ctgry;
    $this->load->view('home/search/index',$this->data);
  }

  // public function search($locality='')
  // {
  //   $filter = $this->input->post('filter');
  //   $category = $this->input->post('category');
  //   $count = 0;
  //   if (!empty($filter) && !empty($category))
  //   {
  //     if ($filter == 'popular')
  //     {
  //       $this->data['results'] = $this->Searchs->get__result($locality,$category);
  //       foreach ($this->data['results'] as $key => $result) {
  //         $count++;
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
  //       }
  //
  //       if (!empty($this->data['votes'])) {
  //         rsort($this->data['votes']);
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['votes'][$i]->business_id);
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['votes'][$i]->business_id);
  //       }
  //       echo '
  //         <script>
  //           $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
  //           $("#target_destination").html("'.str_replace("_"," ",$category).'");
  //         </script>
  //       ';
  //       if (!empty($count))
  //       {
  //         echo '
  //           <ul class="list-inline">
  //             <li class="filter-list-style">'.ucwords($filter).'</li>
  //             <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
  //           </ul>
  //         ';
  //         for ($i=0; $i <$count ; $i++)
  //         {
  //           echo '
  //             <div class="media" style="background-color:#fff;border:5px solid #fff;">
  //               <div class="pull-left visible-lg visible-md visible-sm media-left">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
  //             ';
  //           }
  //           echo '
  //               </div>
  //             <div class="media-body rating">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }
  //           echo '
  //                <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           else {
  //             echo 'vote <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           echo '
  //               <span class="category-style">'.$this->data['results'][$i]->category.'</span>
  //               <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes </span>';
  //           }
  //           else {
  //             echo 'vote </span>';
  //           }
  //           echo '
  //               <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
  //               <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
  //               <div class="separator"></div>
  //               <ul>
  //                 <div class="list-text visible-lg visible-md visible-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 <div class="hidden-lg hidden-md hidden-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 ';
  //             if (!empty($this->data['results'][$i]->cellphone)) {
  //               echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
  //             }else {
  //               echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
  //             }
  //           echo '
  //               </ul>
  //               <div class="row button-div">
  //               <div class="col-lg-12">
  //                 <div class="col-xs-6 btn-style1">
  //                   <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
  //                     <div class="space"></div>
  //                   <span><i class="ion-earth"></i> Visit Website</span>
  //                   </a>
  //                 </div>
  //                 <div class="col-xs-6 btn-style2">
  //                   <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
  //                   <div class="space"></div>
  //                   <span><i class="ion-information-circled"></i> More</span>
  //                   </a>
  //                 </div>
  //               </div>
  //               </div>
  //             </div>
  //           </div>
  //           ';
  //
  //         }
  //       }
  //       else
  //       {
  //         echo "0 results";
  //       }
  //     }
  //     elseif ($filter == 'rating')
  //     {
  //       $this->data['results'] = $this->Searchs->get__result($locality,$category);
  //       foreach ($this->data['results'] as $key => $result) {
  //         $count++;
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
  //       }
  //
  //       if (!empty($this->data['rates'])) {
  //         rsort($this->data['rates']);
  //       }
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['rates'][$i]->business_id);
  //       }
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['rates'][$i]->business_id);
  //       }
  //       echo '
  //         <script>
  //           $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
  //           $("#target_destination").html("'.str_replace("_"," ",$category).'");
  //         </script>
  //       ';
  //       if (!empty($count))
  //       {
  //         echo '
  //           <ul class="list-inline">
  //             <li class="filter-list-style">'.ucwords($filter).'</li>
  //             <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
  //           </ul>
  //         ';
  //         for ($i=0; $i <$count ; $i++)
  //         {
  //           echo '
  //             <div class="media" style="background-color:#fff;border:5px solid #fff;">
  //               <div class="pull-left visible-lg visible-md visible-sm media-left">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
  //             ';
  //           }
  //           echo '
  //               </div>
  //             <div class="media-body rating">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }
  //           echo '
  //                <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           else {
  //             echo 'vote <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           echo '
  //               <span class="category-style">'.$this->data['results'][$i]->category.'</span>
  //               <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes </span>';
  //           }
  //           else {
  //             echo 'vote </span>';
  //           }
  //           echo '
  //               <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
  //               <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
  //               <div class="separator"></div>
  //               <ul>
  //                 <div class="list-text visible-lg visible-md visible-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 <div class="hidden-lg hidden-md hidden-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 ';
  //             if (!empty($this->data['results'][$i]->cellphone)) {
  //               echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
  //             }else {
  //               echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
  //             }
  //           echo '
  //               </ul>
  //               <div class="row button-div">
  //               <div class="col-lg-12">
  //                 <div class="col-xs-6 btn-style1">
  //                   <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
  //                     <div class="space"></div>
  //                   <span><i class="ion-earth"></i> Visit Website</span>
  //                   </a>
  //                 </div>
  //                 <div class="col-xs-6 btn-style2">
  //                   <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
  //                   <div class="space"></div>
  //                   <span><i class="ion-information-circled"></i> More</span>
  //                   </a>
  //                 </div>
  //               </div>
  //               </div>
  //             </div>
  //           </div>
  //           ';
  //
  //         }
  //       }
  //       else
  //       {
  //         echo "0 results";
  //       }
  //     }
  //     elseif ($filter == 'recent')
  //     {
  //       $this->data['results'] = $this->Searchs->_get_result_by_date($locality,$category);
  //       foreach ($this->data['results'] as $key => $result) {
  //         $count++;
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
  //       }
  //       echo '
  //         <script>
  //           $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
  //           $("#target_destination").html("'.str_replace("_"," ",$category).'");
  //         </script>
  //       ';
  //       if (!empty($count))
  //       {
  //         echo '
  //           <ul class="list-inline">
  //             <li class="filter-list-style">'.ucwords($filter).'</li>
  //             <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
  //           </ul>
  //         ';
  //         for ($i=0; $i <$count ; $i++)
  //         {
  //           echo '
  //             <div class="media" style="background-color:#fff;border:5px solid #fff;">
  //               <div class="pull-left visible-lg visible-md visible-sm media-left">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
  //             ';
  //           }
  //           echo '
  //               </div>
  //             <div class="media-body rating">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }
  //           echo '
  //                <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           else {
  //             echo 'vote <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           echo '
  //               <span class="category-style">'.$this->data['results'][$i]->category.'</span>
  //               <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes </span>';
  //           }
  //           else {
  //             echo 'vote </span>';
  //           }
  //           echo '
  //               <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
  //               <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
  //               <div class="separator"></div>
  //               <ul>
  //                 <div class="list-text visible-lg visible-md visible-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 <div class="hidden-lg hidden-md hidden-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 ';
  //             if (!empty($this->data['results'][$i]->cellphone)) {
  //               echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
  //             }else {
  //               echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
  //             }
  //           echo '
  //               </ul>
  //               <div class="row button-div">
  //               <div class="col-lg-12">
  //                 <div class="col-xs-6 btn-style1">
  //                   <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
  //                     <div class="space"></div>
  //                   <span><i class="ion-earth"></i> Visit Website</span>
  //                   </a>
  //                 </div>
  //                 <div class="col-xs-6 btn-style2">
  //                   <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
  //                   <div class="space"></div>
  //                   <span><i class="ion-information-circled"></i> More</span>
  //                   </a>
  //                 </div>
  //               </div>
  //               </div>
  //             </div>
  //           </div>
  //           ';
  //
  //         }
  //       }
  //       else
  //       {
  //         echo "0 results";
  //       }
  //     }
  //   }
  //   elseif (!empty($filter)) {
  //     if ($filter == 'popular')
  //     {
  //       $this->data['results'] = $this->Searchs->get_result($locality,$_SESSION['category']);
  //       foreach ($this->data['results'] as $key => $result) {
  //         $count++;
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
  //       }
  //
  //       rsort($this->data['votes']);
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['votes'][$i]->business_id);
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['votes'][$i]->business_id);
  //       }
  //
  //       echo '
  //         <script>
  //           $("#title").html("'.str_replace("_"," ",ucwords($_SESSION['category'])).' in '.str_replace(" ", "_", ucwords($locality)).'");
  //         </script>
  //       ';
  //
  //       if (!empty($count))
  //       {
  //         echo '
  //
  //           <ul class="list-inline">
  //             <li class="filter-list-style">'.ucwords($filter).'</li>
  //             <li class="filter-list-style">'.ucwords($_SESSION['category']).'</li>
  //           </ul>
  //         ';
  //         for ($i=0; $i <$count ; $i++)
  //         {
  //           echo '
  //             <div class="media" style="background-color:#fff;border:5px solid #fff;">
  //               <div class="pull-left visible-lg visible-md visible-sm media-left">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
  //             ';
  //           }
  //           echo '
  //               </div>
  //             <div class="media-body rating">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }
  //           echo '
  //                <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           else {
  //             echo 'vote <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           echo '
  //               <span class="category-style">'.$this->data['results'][$i]->category.'</span>
  //               <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes </span>';
  //           }
  //           else {
  //             echo 'vote </span>';
  //           }
  //           echo '
  //               <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
  //               <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
  //               <div class="separator"></div>
  //               <ul>
  //                 <div class="list-text visible-lg visible-md visible-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 <div class="hidden-lg hidden-md hidden-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 ';
  //             if (!empty($this->data['results'][$i]->cellphone)) {
  //               echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
  //             }else {
  //               echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
  //             }
  //           echo '
  //               </ul>
  //               <div class="row button-div">
  //               <div class="col-lg-12">
  //                 <div class="col-xs-6 btn-style1">
  //                   <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
  //                     <div class="space"></div>
  //                   <span><i class="ion-earth"></i> Visit Website</span>
  //                   </a>
  //                 </div>
  //                 <div class="col-xs-6 btn-style2">
  //                   <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
  //                   <div class="space"></div>
  //                   <span><i class="ion-information-circled"></i> More</span>
  //                   </a>
  //                 </div>
  //               </div>
  //               </div>
  //             </div>
  //           </div>
  //           ';
  //
  //         }
  //       }
  //       else
  //       {
  //         echo "0 results";
  //       }
  //     }
  //     elseif ($filter == 'rating')
  //     {
  //       $this->data['results'] = $this->Searchs->get_result($locality,$_SESSION['category']);
  //       foreach ($this->data['results'] as $key => $result) {
  //         $count++;
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
  //       }
  //
  //       rsort($this->data['rates']);
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['rates'][$i]->business_id);
  //       }
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['rates'][$i]->business_id);
  //       }
  //       echo '
  //         <script>
  //           $("#title").html("'.str_replace("_"," ",ucwords($_SESSION['category'])).' in '.str_replace(" ", "_", ucwords($locality)).'");
  //         </script>
  //       ';
  //       if (!empty($count))
  //       {
  //         echo '
  //           <ul class="list-inline">
  //             <li class="filter-list-style">'.ucwords($filter).'</li>
  //             <li class="filter-list-style">'.ucwords($_SESSION['category']).'</li>
  //           </ul>
  //         ';
  //         for ($i=0; $i <$count ; $i++)
  //         {
  //           echo '
  //             <div class="media" style="background-color:#fff;border:5px solid #fff;">
  //               <div class="pull-left visible-lg visible-md visible-sm media-left">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
  //             ';
  //           }
  //           echo '
  //               </div>
  //             <div class="media-body rating">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }
  //           echo '
  //                <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           else {
  //             echo 'vote <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           echo '
  //               <span class="category-style">'.$this->data['results'][$i]->category.'</span>
  //               <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes </span>';
  //           }
  //           else {
  //             echo 'vote </span>';
  //           }
  //           echo '
  //               <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
  //               <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
  //               <div class="separator"></div>
  //               <ul>
  //                 <div class="list-text visible-lg visible-md visible-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 <div class="hidden-lg hidden-md hidden-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 ';
  //             if (!empty($this->data['results'][$i]->cellphone)) {
  //               echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
  //             }else {
  //               echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
  //             }
  //           echo '
  //               </ul>
  //               <div class="row button-div">
  //               <div class="col-lg-12">
  //                 <div class="col-xs-6 btn-style1">
  //                   <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
  //                     <div class="space"></div>
  //                   <span><i class="ion-earth"></i> Visit Website</span>
  //                   </a>
  //                 </div>
  //                 <div class="col-xs-6 btn-style2">
  //                   <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
  //                   <div class="space"></div>
  //                   <span><i class="ion-information-circled"></i> More</span>
  //                   </a>
  //                 </div>
  //               </div>
  //               </div>
  //             </div>
  //           </div>
  //           ';
  //
  //         }
  //       }
  //       else
  //       {
  //         echo "0 results";
  //       }
  //     }
  //     elseif ($filter == 'recent')
  //     {
  //       $this->data['results'] = $this->Searchs->get_result_by_date($locality,$_SESSION['category']);
  //       foreach ($this->data['results'] as $key => $result) {
  //         $count++;
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
  //       }
  //
  //       for ($i=0; $i <$count ; $i++) {
  //         $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
  //       }
  //       echo '
  //         <script>
  //           $("#title").html("'.str_replace("_"," ",ucwords($_SESSION['category'])).' in '.str_replace(" ", "_", ucwords($locality)).'");
  //         </script>
  //       ';
  //       if (!empty($count))
  //       {
  //         echo '
  //           <ul class="list-inline">
  //             <li class="filter-list-style">'.ucwords($filter).'</li>
  //             <li class="filter-list-style">'.ucwords($_SESSION['category']).'</li>
  //           </ul>
  //         ';
  //         for ($i=0; $i <$count ; $i++)
  //         {
  //           echo '
  //             <div class="media" style="background-color:#fff;border:5px solid #fff;">
  //               <div class="pull-left visible-lg visible-md visible-sm media-left">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
  //             ';
  //           }
  //           echo '
  //               </div>
  //             <div class="media-body rating">
  //           ';
  //           if (!empty($this->data['results'][$i]->image)) {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }else {
  //             echo '
  //                 <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //             ';
  //           }
  //           echo '
  //                <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           else {
  //             echo 'vote <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //           }
  //           echo '
  //               <span class="category-style">'.$this->data['results'][$i]->category.'</span>
  //               <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
  //           ';
  //           if ($this->data['votes'][$i]->vote > 1)
  //           {
  //             echo 'votes </span>';
  //           }
  //           else {
  //             echo 'vote </span>';
  //           }
  //           echo '
  //               <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
  //               <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
  //               <div class="separator"></div>
  //               <ul>
  //                 <div class="list-text visible-lg visible-md visible-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 <div class="hidden-lg hidden-md hidden-sm">
  //                   <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //                 </div>
  //                 ';
  //             if (!empty($this->data['results'][$i]->cellphone)) {
  //               echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
  //             }else {
  //               echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
  //             }
  //           echo '
  //               </ul>
  //               <div class="row button-div">
  //               <div class="col-lg-12">
  //                 <div class="col-xs-6 btn-style1">
  //                   <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
  //                     <div class="space"></div>
  //                   <span><i class="ion-earth"></i> Visit Website</span>
  //                   </a>
  //                 </div>
  //                 <div class="col-xs-6 btn-style2">
  //                   <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
  //                   <div class="space"></div>
  //                   <span><i class="ion-information-circled"></i> More</span>
  //                   </a>
  //                 </div>
  //               </div>
  //               </div>
  //             </div>
  //           </div>
  //           ';
  //
  //         }
  //       }
  //       else
  //       {
  //         echo "0 results";
  //       }
  //     }
  //   }
  //   elseif (!empty($category)) {
  //     $this->data['results'] = $this->Searchs->get__result($locality,$category);
  //     foreach ($this->data['results'] as $key => $result) {
  //       $count++;
  //     }
  //
  //     for ($i=0; $i <$count ; $i++) {
  //       $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
  //     }
  //
  //     if (!empty($this->data['votes'])) {
  //       rsort($this->data['votes']);
  //     }
  //
  //     for ($i=0; $i <$count ; $i++) {
  //       $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['votes'][$i]->business_id);
  //     }
  //
  //     for ($i=0; $i <$count ; $i++) {
  //       $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['votes'][$i]->business_id);
  //     }
  //     echo '
  //       <script>
  //         $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
  //         $("#target_destination").html("'.str_replace("_"," ",$category).'");
  //       </script>
  //     ';
  //     if (!empty($count))
  //     {
  //       echo '
  //         <ul class="list-inline">
  //           <li class="filter-list-style">Popular</li>
  //           <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
  //         </ul>
  //       ';
  //       for ($i=0; $i <$count ; $i++)
  //       {
  //         echo '
  //           <div class="media" style="background-color:#fff;border:5px solid #fff;">
  //             <div class="pull-left visible-lg visible-md visible-sm media-left">
  //         ';
  //         if (!empty($this->data['results'][$i]->image)) {
  //           echo '
  //               <img class="media-object" src="'.$this->data['results'][$i]->image.'" alt="image" width="200px" height="200px">
  //           ';
  //         }else {
  //           echo '
  //               <img class="media-object" src="/public/img/default-img.jpg" alt="image" width="200px" height="200px">
  //           ';
  //         }
  //         echo '
  //             </div>
  //           <div class="media-body rating">
  //         ';
  //         if (!empty($this->data['results'][$i]->image)) {
  //           echo '
  //               <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="'.$this->data['results'][$i]->image.'" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //           ';
  //         }else {
  //           echo '
  //               <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/public/img/default-img.jpg" alt="image"><br class="hidden-lg hidden-md hidden-sm">
  //           ';
  //         }
  //         echo '
  //              <span class="votes-style hidden-lg hidden-md hidden-sm">'.$this->data['votes'][$i]->vote.'
  //         ';
  //         if ($this->data['votes'][$i]->vote > 1)
  //         {
  //           echo 'votes <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //         }
  //         else {
  //           echo 'vote <span class="badge rating-style hidden-lg hidden-md hidden-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span></span>';
  //         }
  //         echo '
  //             <span class="category-style">'.$this->data['results'][$i]->category.'</span>
  //             <span class="pull-right votes-style visible-lg visible-md visible-sm">'.$this->data['votes'][$i]->vote.'
  //         ';
  //         if ($this->data['votes'][$i]->vote > 1)
  //         {
  //           echo 'votes </span>';
  //         }
  //         else {
  //           echo 'vote </span>';
  //         }
  //         echo '
  //             <span class="badge pull-right rating-style visible-lg visible-md visible-sm" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
  //             <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
  //             <div class="separator"></div>
  //             <ul>
  //               <div class="list-text visible-lg visible-md visible-sm">
  //                 <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //               </div>
  //               <div class="hidden-lg hidden-md hidden-sm">
  //                 <li class="detail-list">'.$this->data['results'][$i]->address.', '.$this->data['results'][$i]->locality.'</li>
  //               </div>
  //               ';
  //           if (!empty($this->data['results'][$i]->cellphone)) {
  //             echo '<li class="detail-list">+63'.$this->data['results'][$i]->cellphone.'</li>';
  //           }else {
  //             echo '<li class="detail-list">'.$this->data['results'][$i]->telephone.'</li>';
  //           }
  //         echo '
  //             </ul>
  //             <div class="row button-div">
  //             <div class="col-lg-12">
  //               <div class="col-xs-6 btn-style1">
  //                 <a href="'.$this->data['results'][$i]->website_url.'" class="btn">
  //                   <div class="space"></div>
  //                 <span><i class="ion-earth"></i> Visit Website</span>
  //                 </a>
  //               </div>
  //               <div class="col-xs-6 btn-style2">
  //                 <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn">
  //                 <div class="space"></div>
  //                 <span><i class="ion-information-circled"></i> More</span>
  //                 </a>
  //               </div>
  //             </div>
  //             </div>
  //           </div>
  //         </div>
  //         ';
  //
  //       }
  //     }
  //     else
  //     {
  //       echo "0 results";
  //     }
  //   }
  // }

}
