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
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Searchs->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Searchs->get_traveller_profile($this->traveller_id);
    }
    else
    {
      $this->data['destinations'] = $this->Searchs->get_localities();
    }
	}

  public function result()
  {
    $this->form_validation->set_rules(
        'locality-search', 'Location',
        'trim|required',
        array()
    );
    $this->form_validation->set_rules(
        'category', 'Category',
        'trim|required',
        array()
    );
    // END VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      $locality = $this->input->post('locality-search');
      $filter = $this->input->post('filter');
      $category = $this->input->post('category');
      $count = 0;

      $this->data['results'] = $this->Searchs->get_locality_result_by_category($locality,$category);
      foreach ($this->data['results'] as $key => $result) {
        $count++;
      }

      for ($i=0; $i <$count ; $i++) {
        $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
      }

      if (!empty($this->data['votes'])) {
        rsort($this->data['votes']);
      }

      for ($i=0; $i <$count ; $i++) {
        $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['votes'][$i]->business_id);
      }

      for ($i=0; $i <$count ; $i++) {
        $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['votes'][$i]->business_id);
      }
      $this->data['destination'] = $locality;
      $this->data['_category'] = $category;
      $this->data['ctr'] = $count;
      $this->session->set_userdata('category', $category);
      $this->load->view('home/search/index',$this->data);
    }
    else
    {
      redirect('/Home', 'refresh');
    }
  }

  public function search($locality='')
  {
    $filter = $this->input->post('filter');
    $category = $this->input->post('category');
    $count = 0;
    if (!empty($filter) && !empty($category))
    {
      if ($filter == 'popular')
      {
        $this->data['results'] = $this->Searchs->get__result($locality,$category);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
        }

        if (!empty($this->data['votes'])) {
          rsort($this->data['votes']);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['votes'][$i]->business_id);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['votes'][$i]->business_id);
        }
        echo '
          <script>
            $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
            $("#target_destination").html("'.str_replace("_"," ",$category).'");
          </script>
        ';
        if (!empty($count))
        {
          echo '
            <ul class="list-inline">
              <li class="filter-list-style">'.ucwords($filter).'</li>
              <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
            </ul>
          ';
          for ($i=0; $i <$count ; $i++)
          {
            echo '
              <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
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
                <span class="category-style">'.$this->data['results'][$i]->category.'</span>
                <span class="pull-right votes-style">'.$this->data['votes'][$i]->vote.'
            ';
            if ($this->data['votes'][$i]->vote > 1)
            {
              echo 'votes </span>';
            }
            else {
              echo 'vote </span>';
            }
            echo '
                <span class="badge pull-right rating-style" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
                <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
                <div class="separator"></div>
                <ul>
                  <div class="list-text">
                    <li class="detail-list">'.$this->data['results'][$i]->address.'</li>
                  </div>';
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
      elseif ($filter == 'rating')
      {
        $this->data['results'] = $this->Searchs->get__result($locality,$category);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
        }

        if (!empty($this->data['rates'])) {
          rsort($this->data['rates']);
        }
        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['rates'][$i]->business_id);
        }
        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['rates'][$i]->business_id);
        }
        echo '
          <script>
            $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
            $("#target_destination").html("'.str_replace("_"," ",$category).'");
          </script>
        ';
        if (!empty($count))
        {
          echo '
            <ul class="list-inline">
              <li class="filter-list-style">'.ucwords($filter).'</li>
              <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
            </ul>
          ';
          for ($i=0; $i <$count ; $i++)
          {
            echo '
              <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
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
                <span class="category-style">'.$this->data['results'][$i]->category.'</span>
                <span class="pull-right votes-style">'.$this->data['votes'][$i]->vote.'
            ';
            if ($this->data['votes'][$i]->vote > 1)
            {
              echo 'votes </span>';
            }
            else {
              echo 'vote </span>';
            }
            echo '
                <span class="badge pull-right rating-style" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
                <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
                <div class="separator"></div>
                <ul>
                  <div class="list-text">
                    <li class="detail-list">'.$this->data['results'][$i]->address.'</li>
                  </div>';
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
      elseif ($filter == 'recent')
      {
        $this->data['results'] = $this->Searchs->_get_result_by_date($locality,$category);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
        }
        echo '
          <script>
            $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
            $("#target_destination").html("'.str_replace("_"," ",$category).'");
          </script>
        ';
        if (!empty($count))
        {
          echo '
            <ul class="list-inline">
              <li class="filter-list-style">'.ucwords($filter).'</li>
              <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
            </ul>
          ';
          for ($i=0; $i <$count ; $i++)
          {
            echo '
              <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
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
                <span class="category-style">'.$this->data['results'][$i]->category.'</span>
                <span class="pull-right votes-style">'.$this->data['votes'][$i]->vote.'
            ';
            if ($this->data['votes'][$i]->vote > 1)
            {
              echo 'votes </span>';
            }
            else {
              echo 'vote </span>';
            }
            echo '
                <span class="badge pull-right rating-style" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
                <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
                <div class="separator"></div>
                <ul>
                  <div class="list-text">
                    <li class="detail-list">'.$this->data['results'][$i]->address.'</li>
                  </div>';
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
    }
    elseif (!empty($filter)) {
      if ($filter == 'popular')
      {
        $this->data['results'] = $this->Searchs->get_result($locality,$_SESSION['category']);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
        }

        rsort($this->data['votes']);
        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['votes'][$i]->business_id);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['votes'][$i]->business_id);
        }

        echo '
          <script>
            $("#title").html("'.str_replace("_"," ",ucwords($_SESSION['category'])).' in '.str_replace(" ", "_", ucwords($locality)).'");
          </script>
        ';

        if (!empty($count))
        {
          echo '

            <ul class="list-inline">
              <li class="filter-list-style">'.ucwords($filter).'</li>
              <li class="filter-list-style">'.ucwords($_SESSION['category']).'</li>
            </ul>
          ';
          for ($i=0; $i <$count ; $i++)
          {
            echo '
              <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
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
                <span class="category-style">'.$this->data['results'][$i]->category.'</span>
                <span class="pull-right votes-style">'.$this->data['votes'][$i]->vote.'
            ';
            if ($this->data['votes'][$i]->vote > 1)
            {
              echo 'votes </span>';
            }
            else {
              echo 'vote </span>';
            }
            echo '
                <span class="badge pull-right rating-style" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
                <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
                <div class="separator"></div>
                <ul>
                  <div class="list-text">
                    <li class="detail-list">'.$this->data['results'][$i]->address.'</li>
                  </div>';
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
      elseif ($filter == 'rating')
      {
        $this->data['results'] = $this->Searchs->get_result($locality,$_SESSION['category']);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
        }

        rsort($this->data['rates']);
        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['rates'][$i]->business_id);
        }
        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['rates'][$i]->business_id);
        }
        echo '
          <script>
            $("#title").html("'.str_replace("_"," ",ucwords($_SESSION['category'])).' in '.str_replace(" ", "_", ucwords($locality)).'");
          </script>
        ';
        if (!empty($count))
        {
          echo '
            <ul class="list-inline">
              <li class="filter-list-style">'.ucwords($filter).'</li>
              <li class="filter-list-style">'.ucwords($_SESSION['category']).'</li>
            </ul>
          ';
          for ($i=0; $i <$count ; $i++)
          {
            echo '
              <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
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
                <span class="category-style">'.$this->data['results'][$i]->category.'</span>
                <span class="pull-right votes-style">'.$this->data['votes'][$i]->vote.'
            ';
            if ($this->data['votes'][$i]->vote > 1)
            {
              echo 'votes </span>';
            }
            else {
              echo 'vote </span>';
            }
            echo '
                <span class="badge pull-right rating-style" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
                <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
                <div class="separator"></div>
                <ul>
                  <div class="list-text">
                    <li class="detail-list">'.$this->data['results'][$i]->address.'</li>
                  </div>';
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
      elseif ($filter == 'recent')
      {
        $this->data['results'] = $this->Searchs->get_result_by_date($locality,$_SESSION['category']);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['results'][$i]->id);
        }
        echo '
          <script>
            $("#title").html("'.str_replace("_"," ",ucwords($_SESSION['category'])).' in '.str_replace(" ", "_", ucwords($locality)).'");
          </script>
        ';
        if (!empty($count))
        {
          echo '
            <ul class="list-inline">
              <li class="filter-list-style">'.ucwords($filter).'</li>
              <li class="filter-list-style">'.ucwords($_SESSION['category']).'</li>
            </ul>
          ';
          for ($i=0; $i <$count ; $i++)
          {
            echo '
              <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
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
                <span class="category-style">'.$this->data['results'][$i]->category.'</span>
                <span class="pull-right votes-style">'.$this->data['votes'][$i]->vote.'
            ';
            if ($this->data['votes'][$i]->vote > 1)
            {
              echo 'votes </span>';
            }
            else {
              echo 'vote </span>';
            }
            echo '
                <span class="badge pull-right rating-style" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
                <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
                <div class="separator"></div>
                <ul>
                  <div class="list-text">
                    <li class="detail-list">'.$this->data['results'][$i]->address.'</li>
                  </div>';
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
    }
    elseif (!empty($category)) {
      $this->data['results'] = $this->Searchs->get__result($locality,$category);
      foreach ($this->data['results'] as $key => $result) {
        $count++;
      }

      for ($i=0; $i <$count ; $i++) {
        $this->data['votes'][$i] = $this->Searchs->get_votes($this->data['results'][$i]->id);
      }

      if (!empty($this->data['votes'])) {
        rsort($this->data['votes']);
      }

      for ($i=0; $i <$count ; $i++) {
        $this->data['results'][$i] = $this->Searchs->get_business_details($this->data['votes'][$i]->business_id);
      }

      for ($i=0; $i <$count ; $i++) {
        $this->data['rates'][$i] = $this->Searchs->get_rates($this->data['votes'][$i]->business_id);
      }
      echo '
        <script>
          $("#title").html("'.str_replace("_"," ",$category).' in '.str_replace(" ", "_", ucwords($locality)).'");
          $("#target_destination").html("'.str_replace("_"," ",$category).'");
        </script>
      ';
      if (!empty($count))
      {
        echo '
          <ul class="list-inline">
            <li class="filter-list-style">Popular</li>
            <li class="filter-list-style">'.str_replace("_", " ", $category).'</li>
          </ul>
        ';
        for ($i=0; $i <$count ; $i++)
        {
          echo '
            <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
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
              <span class="category-style">'.$this->data['results'][$i]->category.'</span>
              <span class="pull-right votes-style">'.$this->data['votes'][$i]->vote.'
          ';
          if ($this->data['votes'][$i]->vote > 1)
          {
            echo 'votes </span>';
          }
          else {
            echo 'vote </span>';
          }
          echo '
              <span class="badge pull-right rating-style" style="">'.number_format($this->data['rates'][$i]->rate, 1).'</span>
              <h2 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h2>
              <div class="separator"></div>
              <ul>
                <div class="list-text">
                  <li class="detail-list">'.$this->data['results'][$i]->address.'</li>
                </div>';
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
  }

}
