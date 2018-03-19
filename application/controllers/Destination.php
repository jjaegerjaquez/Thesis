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
    $this->data['categories'] = $this->Destinations->get_categories();
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

  public function result($locality='')
  {
    $filter = $this->input->post('filter');
    $category = $this->input->post('category');
    $count = 0;
    if (!empty($filter) && !empty($category))
    {
      if ($filter == 'popular')
      {
        $this->data['results'] = $this->Destinations->get_locality_result_by_category($locality,$category);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Destinations->get_votes($this->data['results'][$i]->id);
        }

        if (!empty($this->data['votes'])) {
          rsort($this->data['votes']);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Destinations->get_business_details($this->data['votes'][$i]->business_id);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Destinations->get_rates($this->data['votes'][$i]->business_id);
        }

        if (!empty($count))
        {
          echo '
            <script>
              $(".filter_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filters = {
                               filter: "",
                               category: "'.$category.'"
                           };
                   $.ajax({
                       url: "/Destination/result/"+destination,
                       type: "POST",
                       data: filters,
                       success: function(message) {
                         $("#main").html(message);
                         $("input:radio[name=filter]").each(function () { $(this).prop("checked", false); });
                       }
                   });
                });
             $(".category_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filters = {
                               filter: "'.$filter.'",
                               category: ""
                           };
                   $.ajax({
                       url: "/Destination/result/"+destination,
                       type: "POST",
                       data: filters,
                       success: function(message) {
                         $("#main").html(message);
                         $("option:selected").prop("selected", false);
                       }
                   });
               });
            </script>
            <ul class="list-inline">
              <li class="filter-list-style">'.$filter.' <button class="filter_remove filter-remove-btn">x</button></li>
              <li class="filter-list-style">'.str_replace("_", " ", $category).' <button class="category_remove filter-remove-btn">x</button></li>
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
                <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
                <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
                <div class="separator"></div>
                <ul>
                  <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
                  <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
                  <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
                </ul>
                <div class="row">
                  <div class="col-xs-6">
                    <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                      <div class="space"></div>
      			        <span class="" style="color: #f37430;">Visit Website</span>
      		          </a>
                  </div>
                  <div class="col-xs-6">
                    <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
      			        <span class="" style="color: #f37430;">View</span>
      		          </a>
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
        $this->data['results'] = $this->Destinations->get_locality_result_by_category($locality,$category);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Destinations->get_rates($this->data['results'][$i]->id);
        }

        if (!empty($this->data['rates'])) {
          rsort($this->data['rates']);
        }
        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Destinations->get_business_details($this->data['rates'][$i]->business_id);
        }
        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Destinations->get_votes($this->data['rates'][$i]->business_id);
        }

        if (!empty($count))
        {
          echo '
            <script>
              $(".filter_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filters = {
                               filter: "",
                               category: "'.$category.'"
                           };
                   $.ajax({
                       url: "/Destination/result/"+destination,
                       type: "POST",
                       data: filters,
                       success: function(message) {
                         $("#main").html(message);
                         $("input:radio[name=filter]").each(function () { $(this).prop("checked", false); });
                       }
                   });
                });
             $(".category_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filters = {
                               filter: "'.$filter.'",
                               category: ""
                           };
                   $.ajax({
                       url: "/Destination/result/"+destination,
                       type: "POST",
                       data: filters,
                       success: function(message) {
                         $("#main").html(message);
                         $("option:selected").prop("selected", false);
                       }
                   });
               });
            </script>
            <ul class="list-inline">
              <li class="filter-list-style">'.$filter.' <button class="filter_remove filter-remove-btn">x</button></li>
              <li class="filter-list-style">'.str_replace("_", " ", $category).' <button class="category_remove filter-remove-btn">x</button></li>
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
                <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
                <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
                <div class="separator"></div>
                <ul>
                  <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
                  <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
                  <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
                </ul>
                <div class="row">
                  <div class="col-xs-6">
                    <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                      <div class="space"></div>
      			        <span class="" style="color: #f37430;">Visit Website</span>
      		          </a>
                  </div>
                  <div class="col-xs-6">
                    <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
      			        <span class="" style="color: #f37430;">View</span>
      		          </a>
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
        $this->data['results'] = $this->Destinations->get_locality_result_by_date_by_category($locality,$category);
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
          echo '
            <script>
              $(".filter_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filters = {
                               filter: "",
                               category: "'.$category.'"
                           };
                   $.ajax({
                       url: "/Destination/result/"+destination,
                       type: "POST",
                       data: filters,
                       success: function(message) {
                         $("#main").html(message);
                         $("input:radio[name=filter]").each(function () { $(this).prop("checked", false); });
                       }
                   });
                });
             $(".category_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filters = {
                               filter: "'.$filter.'",
                               category: ""
                           };
                   $.ajax({
                       url: "/Destination/result/"+destination,
                       type: "POST",
                       data: filters,
                       success: function(message) {
                         $("#main").html(message);
                         $("option:selected").prop("selected", false);
                       }
                   });
               });
            </script>
            <ul class="list-inline">
              <li class="filter-list-style">'.$filter.' <button class="filter_remove filter-remove-btn">x</button></li>
              <li class="filter-list-style">'.str_replace("_", " ", $category).' <button class="category_remove filter-remove-btn">x</button></li>
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
                <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
                <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
                <div class="separator"></div>
                <ul>
                  <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
                  <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
                  <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
                </ul>
                <div class="row">
                  <div class="col-xs-6">
                    <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                      <div class="space"></div>
      			        <span class="" style="color: #f37430;">Visit Website</span>
      		          </a>
                  </div>
                  <div class="col-xs-6">
                    <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
      			        <span class="" style="color: #f37430;">View</span>
      		          </a>
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
        $this->data['results'] = $this->Destinations->get_locality_result($locality);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Destinations->get_votes($this->data['results'][$i]->id);
        }

        rsort($this->data['votes']);
        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Destinations->get_business_details($this->data['votes'][$i]->business_id);
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Destinations->get_rates($this->data['votes'][$i]->business_id);
        }

        if (!empty($count))
        {
          echo '
            <script>
              $(".filter_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filter = {
                               filter: ""
                           };
                   $.ajax({
                       url: "/Destination/original_result/"+destination,
                       type: "POST",
                       data: filter,
                       success: function(message) {
                         $("#main").html(message);
                       }
                   });
                });
            </script>
            <ul class="list-inline">
              <li class="filter-list-style">'.$filter.' <button class="filter_remove filter-remove-btn">x</button></li>
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
                <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
                <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
                <div class="separator"></div>
                <ul>
                  <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
                  <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
                  <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
                </ul>
                <div class="row">
                  <div class="col-xs-6">
                    <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                      <div class="space"></div>
      			        <span class="" style="color: #f37430;">Visit Website</span>
      		          </a>
                  </div>
                  <div class="col-xs-6">
                    <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
      			        <span class="" style="color: #f37430;">View</span>
      		          </a>
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
        $this->data['results'] = $this->Destinations->get_locality_result($locality);
        foreach ($this->data['results'] as $key => $result) {
          $count++;
        }

        for ($i=0; $i <$count ; $i++) {
          $this->data['rates'][$i] = $this->Destinations->get_rates($this->data['results'][$i]->id);
        }

        rsort($this->data['rates']);
        for ($i=0; $i <$count ; $i++) {
          $this->data['results'][$i] = $this->Destinations->get_business_details($this->data['rates'][$i]->business_id);
        }
        for ($i=0; $i <$count ; $i++) {
          $this->data['votes'][$i] = $this->Destinations->get_votes($this->data['rates'][$i]->business_id);
        }

        if (!empty($count))
        {
          echo '
            <script>
              $(".filter_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filter = {
                               filter: ""
                           };
                   $.ajax({
                       url: "/Destination/original_result/"+destination,
                       type: "POST",
                       data: filter,
                       success: function(message) {
                         $("#main").html(message);
                       }
                   });
                });
            </script>
            <ul class="list-inline">
              <li class="filter-list-style">'.$filter.' <button class="filter_remove filter-remove-btn">x</button></li>
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
                <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
                <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
                <div class="separator"></div>
                <ul>
                  <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
                  <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
                  <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
                </ul>
                <div class="row">
                  <div class="col-xs-6">
                    <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                      <div class="space"></div>
      			        <span class="" style="color: #f37430;">Visit Website</span>
      		          </a>
                  </div>
                  <div class="col-xs-6">
                    <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
      			        <span class="" style="color: #f37430;">View</span>
      		          </a>
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
        $this->data['results'] = $this->Destinations->get_locality_result_by_date($locality);
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
          echo '
            <script>
              $(".filter_remove").on("click", function(){
                   $(this).closest("li").remove();
                   var destination = "'.str_replace(" ", "_", $locality).'";
                   var filter = {
                               filter: ""
                           };
                   $.ajax({
                       url: "/Destination/original_result/"+destination,
                       type: "POST",
                       data: filter,
                       success: function(message) {
                         $("#main").html(message);
                       }
                   });
                });
            </script>
            <ul class="list-inline">
              <li class="filter-list-style">'.$filter.' <button class="filter_remove filter-remove-btn">x</button></li>
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
                <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
                <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
                <div class="separator"></div>
                <ul>
                  <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
                  <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
                  <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
                </ul>
                <div class="row">
                  <div class="col-xs-6">
                    <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                      <div class="space"></div>
      			        <span class="" style="color: #f37430;">Visit Website</span>
      		          </a>
                  </div>
                  <div class="col-xs-6">
                    <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
      			        <span class="" style="color: #f37430;">View</span>
      		          </a>
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

      $this->data['results'] = $this->Destinations->get_locality_result_by_category($locality,$category);
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
        echo '
          <script>
            $(".category_remove").on("click", function(){
                 $(this).closest("li").remove();
                 var destination = "'.str_replace(" ", "_", $locality).'";
                 var category = {
                             category: ""
                         };
                 $.ajax({
                     url: "/Destination/original_result/"+destination,
                     type: "POST",
                     data: category,
                     success: function(message) {
                       $("#main").html(message);
                       $("option:selected").prop("selected", false);
                     }
                 });
              });
          </script>
          <ul class="list-inline">
            <li class="filter-list-style">'.str_replace("_", " ", $category).' <button class="category_remove filter-remove-btn">x</button></li>
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
              <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
              <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
              <div class="separator"></div>
              <ul>
                <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
                <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
                <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
              </ul>
              <div class="row">
                <div class="col-xs-6">
                  <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
                  <span class="" style="color: #f37430;">Visit Website</span>
                  </a>
                </div>
                <div class="col-xs-6">
                  <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                  <div class="space"></div>
                  <span class="" style="color: #f37430;">View</span>
                  </a>
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
    else {
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

      // print_r($this->data['rates']);
      $this->data['destination'] = $locality;
      $this->data['ctr'] = $count;
      $this->load->view('destinations/index',$this->data);
    }

  }


  public function original_result($locality)
  {
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
            <span class="pull-right votes-style" style="">'.$this->data['votes'][$i]->vote.'
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
            <h3 class="media-heading business-title">'.$this->data['results'][$i]->business_name.'</h3>
            <div class="separator"></div>
            <ul>
              <li class="detail-list"><i class="ion-location icons"></i>&nbsp; '.$this->data['results'][$i]->address.'</li>
              <li class="detail-list"><i class="ion-ios-pricetag icons">&nbsp;</i>   '.$this->data['results'][$i]->category.'</li>
              <li class="detail-list"><i class="ion-ios-telephone icons"></i> '.$this->data['results'][$i]->telephone.'</li>
            </ul>
            <div class="row">
              <div class="col-xs-6">
                <a href="'.$this->data['results'][$i]->website_url.'" class="btn btn-lg btn-primary btn-style">
                  <div class="space"></div>
                <span class="" style="color: #f37430;">Visit Website</span>
                </a>
              </div>
              <div class="col-xs-6">
                <a href="/Category/view/'.str_replace(' ', '_', $this->data['results'][$i]->business_name).'" class="btn btn-lg btn-primary btn-style">
                <div class="space"></div>
                <span class="" style="color: #f37430;">View</span>
                </a>
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
