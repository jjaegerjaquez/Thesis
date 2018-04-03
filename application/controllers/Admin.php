<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Admin extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Admins');
    if (!$this->session->userdata('admin_is_logged_in'))
    {
      $allowed = array(
            'index',
            'login'
        );
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
          redirect(base_url().'Admin');
        }
    }
    else
    {
      $this->username = $_SESSION['username'];
      $this->data['user'] = $this->Admins->validate_user($this->username);
      $this->data['title'] = $this->Admins->get_title();
      $this->data['icon'] = $this->Admins->get_site_icon();
      $this->data['tagline'] = $this->Admins->get_tagline();
      $this->data['review_count'] = $this->Admins->get_reviews_count();
      $this->data['vote_count'] = $this->Admins->get_vote_count();
      $this->data['supplier_count'] = $this->Admins->get_supplier_count();
    }
	}

  public function index()
  {
    if ($this->session->userdata('admin_is_logged_in'))
    {
      redirect(base_url().'Admin/dashboard');
    }
    $data['error'] = '';
    $this->load->view('admin/index',$data);
  }

  public function login()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'username', 'Username',
        'required|trim',
        array(
                'required'      => 'Please enter your username'
        )
    );
    $this->form_validation->set_rules(
        'password', 'Password',
        'required|trim',
        array(
                'required'      => 'Please enter your password'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $data['error'] = '';
      $this->load->view('admin/index',$data);
    }
    else
    {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $user_validate = $this->Admins->validate_user($username);
      if ($user_validate) //Validate kung existing yung username sa db
      {
        $data['user'] = $this->Admins->validate_user($username);
        $pass = $data['user']->password;
        if ($pass !== md5($password)) //Check kung tama yung password
        {
          $data['error'] = "Your password is incorrect.";
          $this->load->view('admin/index',$data);
        }
        else
        {
          $this->session->set_userdata('admin_id', $data['user']->admin_id);
          $this->session->set_userdata('username', $data['user']->username);
          $this->session->set_userdata('admin_is_logged_in', true);
          redirect(base_url().'Admin/dashboard');
        }
      }
      else //If hindi existing yung username sa db
      {
        $data['error'] = "The username you entered does not exists.";
        $this->load->view('admin/index',$data);
      }
    }
  }

  public function dashboard()
  {
    $this->load->view('admin/dashboard/index',$this->data);
  }

  public function suppliers()
  {
    $query2= $this->db->get('basic_info');
    $limit = 7;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/suppliers';
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
    $this->data['suppliers'] = $this->Admins->function_pagination_suppliers($limit, $offset);
    $this->load->view('admin/dashboard/suppliers/index',$this->data);
  }

  public function view_supplier($id)
  {
    $this->data['supplier'] = $this->Admins->get_supplier($id);
    $this->load->view('admin/dashboard/suppliers/view',$this->data);
  }

  public function delete_supplier($id)
  {
    $this->db->where('id', $id);
    if ($this->db->delete('basic_info')) {
      echo '<script>alert("Business deleted!");</script>';
      redirect(base_url().'Admin/suppliers', 'refresh');
    }
  }

  public function faves()
  {
    $query2= $this->db->get('votes');
    $limit = 7;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/faves';
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
    $this->data['faves'] = $this->Admins->function_pagination_faves($limit, $offset);
    $this->load->view('admin/dashboard/faves/index',$this->data);
  }

  public function delete_fave($id)
  {
    $this->db->where('vote_id', $id);
    if ($this->db->delete('votes')) {
      echo '<script>alert("Fave deleted!");</script>';
      redirect(base_url().'Admin/faves', 'refresh');
    }
  }

  public function reviews()
  {
    $query2= $this->db->get('reviews');
    $limit = 7;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/reviews';
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
    $this->data['reviews'] = $this->Admins->function_pagination_reviews($limit, $offset);
    $this->load->view('admin/dashboard/reviews/index',$this->data);
  }

  public function view_review($id)
  {
    $this->data['review'] = $this->Admins->get_review($id);
    print_r($this->data['review']);
    // $this->load->view('admin/dashboard/reviews/view',$this->data);
  }

  // LOCALITY
  public function localities()
  {
    $query = $this->db->get('localities','7', $this->uri->segment(3));
		$this->data['localities'] = $query->result();

		$query2= $this->db->get('localities');

		$config['base_url'] = '/Admin/localities';
		$config['total_rows'] = $query2->num_rows();
		$config['per_page'] = 7;

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

    $this->load->view('admin/dashboard/localities/index',$this->data);
  }

  public function add_localities()
  {
    $this->load->view('admin/dashboard/localities/create',$this->data);
  }

  public function create_locality()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'locality', 'Locality',
        'trim|required',
        array(
                'required'      => 'Please enter a locality'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      echo validation_errors();
    }
    else
    {
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/localities/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         $Locality = [
           'locality' => $this->input->post('locality'),
           'description' => $this->input->post('description'),
           'image' => base_url().$path.$image_name
         ];

         if ($this->db->insert('localities',$Locality)) {
           echo "Locality added!";
          //  redirect(base_url().'Admin/localities', 'refresh');
         }else {
           echo "Locality not added";
          //  redirect(base_url().'Admin/localities', 'refresh');
         }
      }
      else
      {
        echo "Please select an image";
      }
    }
  }

  public function view_locality($locality_id)
  {
    $this->data['locality'] = $this->Admins->get_locality($locality_id);
    $this->load->view('admin/dashboard/localities/view', $this->data);
  }

  public function edit_locality($locality_id)
  {
    $this->data['locality'] = $this->Admins->get_locality($locality_id);
    $this->load->view('admin/dashboard/localities/update', $this->data);
  }

  public function update_locality($locality_id)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'locality', 'Locality',
        'required|trim',
        array(
                'required'      => 'Please enter a locality'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim',
        array()
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      // $this->data['locality'] = $this->Admins->get_locality($locality_id);
      // $this->load->view('admin/dashboard/localities/update', $this->data);
      echo validation_errors();
    }
    else
    {
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/localities/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         $Locality = [
           'locality' => $this->input->post('locality'),
           'description' => $this->input->post('description'),
           'image' => base_url().$path.$image_name
         ];

         if ($this->Admins->update_locality($Locality,$locality_id)) {
           echo 'Locality updated!';
         }
         else {
           echo "Locality cannot be updated";
         }
      }
      else
      {
        echo "Please select an image";
      }
    }
  }

  public function delete_locality($locality_id)
  {
    $this->db->where('locality_id', $locality_id);
    if ($this->db->delete('localities')) {
      echo '<script>alert("Locality deleted!");</script>';
      redirect(base_url().'Admin/localities', 'refresh');
    }
  }
  // END OF LOCALITY

  // CATEGORY
  public function categories()
  {
    $query = $this->db->get('categories','7', $this->uri->segment(3));
		$this->data['categories'] = $query->result();

		$query2= $this->db->get('categories');

		$config['base_url'] = '/Admin/categories';
		$config['total_rows'] = $query2->num_rows();
		$config['per_page'] = 7;

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

    $this->load->view('admin/dashboard/categories/index',$this->data);
  }

  public function add_category()
  {
    $this->load->view('admin/dashboard/categories/create',$this->data);
  }

  public function create_category()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'category', 'Category',
        'required|trim',
        array(
                'required'      => 'Please enter a category'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      // $this->load->view('admin/dashboard/categories/create',$this->data);
      echo validation_errors();
    }
    else
    {
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/icons/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         $Category = [
           'category' => $this->input->post('category'),
           'description' => $this->input->post('description'),
           'image' => base_url().$path.$image_name
         ];

         if ($this->db->insert('categories',$Category)) {
           echo 'Category added!';
         }else {
           echo 'Category not added';
         }
      }
      else
      {
        echo "Please select an image";
      }
    }
  }

  public function view_category($category_id)
  {
    $this->data['category'] = $this->Admins->get_category($category_id);
    $this->load->view('admin/dashboard/categories/view', $this->data);
  }

  public function edit_category($category_id)
  {
    $this->data['category'] = $this->Admins->get_category($category_id);
    $this->load->view('admin/dashboard/categories/update', $this->data);
  }

  public function update_category($category_id)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'category', 'Category',
        'required|trim',
        array(
                'required'      => 'Please enter a category'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim',
        array()
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      // $this->data['category'] = $this->Admins->get_category($category_id);
      // $this->load->view('admin/dashboard/categories/update', $this->data);
      echo validation_errors();
    }
    else
    {
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/icons/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         $Category = [
           'category' => $this->input->post('category'),
           'description' => $this->input->post('description'),
           'image' => base_url().$path.$image_name
         ];

         if ($this->Admins->update_category($Category,$category_id)) {
           echo 'Category updated!';
         }else {
           echo 'Category cannot be updated';
         }
      }
      else
      {
        $Category = [
          'category' => $this->input->post('category'),
          'description' => $this->input->post('description'),
        ];

        if ($this->Admins->update_category($Category,$category_id)) {
          echo 'Category updated!';
        }else {
          echo 'Category cannot be updated';
        }
      }
    }
  }

  public function delete_category($category_id)
  {
    $this->db->where('category_id', $category_id);
    if ($this->db->delete('categories')) {
      echo '<script>alert("Category deleted!");</script>';
      redirect(base_url().'Admin/categories', 'refresh');
    }
  }
  // END OF CATEGORY

  // THEMES
  public function themes()
  {
    $query = $this->db->get('themes','7', $this->uri->segment(3));
		$this->data['themes'] = $query->result();

		$query2= $this->db->get('themes');

		$config['base_url'] = '/Admin/themes';
		$config['total_rows'] = $query2->num_rows();
		$config['per_page'] = 7;

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

    $this->load->view('admin/dashboard/themes/index',$this->data);
  }

  public function add_theme()
  {
    $this->load->view('admin/dashboard/themes/create',$this->data);
  }

  public function save_theme()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'theme_name', 'Theme Name',
        'trim|required',
        array(
                'required'      => 'Please enter a theme name'
        )
    );
    $this->form_validation->set_rules(
        'author', 'Author',
        'trim|required',
        array(
                'required'      => 'Please enter the name of the author'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim|required',
        array(
                'required'      => 'Please enter theme description'
        )
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      echo validation_errors();
      // $this->load->view('admin/dashboard/themes/create',$this->data);
    }
    else
    {
      $theme = $this->input->post('theme_name');
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/themes/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         $Theme = [
           'theme' => $this->input->post('theme_name'),
           'author' => $this->input->post('author'),
           'description' => $this->input->post('description'),
           'image' => base_url().$path.$image_name
         ];

         if ($this->db->insert('themes',$Theme)) {
           echo 'Theme added!';
           chmod('./public/', 0777);
           $path   = './public/themes/'.$theme;
           if (!is_dir($path)) { //create the folder if it's not already exists
               mkdir($path, 0755, TRUE);
           }
         }else {
           echo 'Theme not added';
         }
      }
      else
      {
        $Theme = [
          'theme' => $this->input->post('theme_name'),
          'author' => $this->input->post('author'),
          'description' => $this->input->post('description')
        ];

        if ($this->db->insert('themes',$Theme)) {
          echo 'Theme added!';
          chmod('./public/', 0777);
          $path   = './public/themes/'.$theme;
          if (!is_dir($path)) { //create the folder if it's not already exists
              mkdir($path, 0755, TRUE);
          }
        }else {
          echo 'Theme not added';
        }
      }
    }
  }

  public function view_theme($theme_id)
  {
    $this->data['theme'] = $this->Admins->get_theme($theme_id);
    $this->load->view('admin/dashboard/themes/view', $this->data);
  }

  public function edit_theme($theme_id)
  {
    $this->data['theme'] = $this->Admins->get_theme($theme_id);
    $this->load->view('admin/dashboard/themes/update', $this->data);
  }

  public function update_theme($theme_id)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'theme_name', 'Theme Name',
        'required|trim',
        array(
                'required'      => 'Please enter a theme name'
        )
    );
    $this->form_validation->set_rules(
        'author', 'Author',
        'required|trim',
        array(
                'required'      => 'Please enter the name of the author'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'required|trim',
        array(
                'required'      => 'Please enter theme description'
        )
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('admin/dashboard/themes/create',$this->data);
    }
    else
    {
      if(!empty($_FILES['picture']['name'])){ //If may laman na image
          $config['upload_path'] = 'uploads/images/admin/themes';
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Theme = [
                'theme' => $this->input->post('theme_name'),
                'author' => $this->input->post('author'),
                'description' => $this->input->post('description'),
                'image' => $picture
              ];

              $this->Admins->update_theme($Theme,$theme_id);
              echo '<script>alert("Theme updated!");</script>';
              redirect(base_url().'Admin/edit_theme/'.$theme_id, 'refresh');
          }else{
            echo '<script>alert("Something went wrong, theme not updated!");</script>';
            redirect(base_url().'Admin/themes', 'refresh');
          }
      }else{
        $Theme = [
          'theme' => $this->input->post('theme_name'),
          'author' => $this->input->post('author'),
          'description' => $this->input->post('description')
        ];

        $this->Admins->update_theme($Theme,$theme_id);
        echo '<script>alert("Theme updated!");</script>';
        redirect(base_url().'Admin/edit_theme/'.$theme_id, 'refresh');
      }
    }
  }

  public function delete_theme($theme_id)
  {
    $this->db->where('theme_id', $theme_id);
    if ($this->db->delete('themes')) {
      echo '<script>alert("Theme deleted!");</script>';
      redirect(base_url().'Admin/themes', 'refresh');
    }
  }
  // END OF THEMES

  // LAYOUT
  public function image_slider()
  {
    $query2= $this->db->get_where('layout', ['meta_key' => 'image_slider']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/image_slider';
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
    $this->data['image_sliders'] = $this->Admins->image_slider($limit, $offset);
    $this->load->view('admin/dashboard/layout/image_slider/index',$this->data);
  }

  public function add_image_slider()
  {
    $this->load->view('admin/dashboard/layout/image_slider/add',$this->data);
  }

  public function upload_image_slider()
  {
    if (!empty($this->input->post('file'))) {
      $path = 'public/img/layout/';
      $croped_image = $_POST['image'];
       list($type, $croped_image) = explode(';', $croped_image);
       list(, $croped_image)      = explode(',', $croped_image);
       $croped_image = base64_decode($croped_image);
       $image_name = time().'.png';
       // upload cropped image to server
       file_put_contents($path.$image_name, $croped_image);

       $Image_Slider = [
         'meta_key' => 'image_slider',
         'title' => '',
         'value' => base_url().$path.$image_name
       ];

       if ($this->db->insert('layout',$Image_Slider))
       { //KAPAG NAINSERT YUNG LOGO
         echo "Image uploaded!";
       }
       else
       { //KAPAG DI NAUPDATE YUNG LOGO
         echo '<script>alert("Something went wrong...");</script>';
       }
    }
    else
    {
      echo "Please select an image";
    }
  }

  public function view_image_slider($content_id)
  {
    $this->data['image_slider'] = $this->Admins->get_content($content_id);
    $this->load->view('admin/dashboard/layout/image_slider/view',$this->data);
  }

  public function edit_image_slider($content_id)
  {
    $this->data['image_slider'] = $this->Admins->get_content($content_id);
    $this->load->view('admin/dashboard/layout/image_slider/edit',$this->data);
  }

  public function update_image_slider($content_id)
  {
    if (!empty($this->input->post('file'))) {
      $path = 'public/img/layout/';
      $croped_image = $_POST['image'];
       list($type, $croped_image) = explode(';', $croped_image);
       list(, $croped_image)      = explode(',', $croped_image);
       $croped_image = base64_decode($croped_image);
       $image_name = time().'.png';
       // upload cropped image to server
       file_put_contents($path.$image_name, $croped_image);

       $Image_Slider = [
         'value' => base_url().$path.$image_name
       ];
       if ($this->Admins->update_content($Image_Slider,$content_id))
       {
         echo "Image updated!";
       }
       else
       {
         echo "Something went wrong, image cannot be updated...";
       }
    }
    else
    {
      echo "Please select an image";
    }
  }

  public function delete_image_slider($content_id)
  {
    $this->db->where('content_id', $content_id);
    if ($this->db->delete('layout')) {
      echo '<script>alert("Image deleted!");</script>';
      redirect(base_url().'Admin/image_slider', 'refresh');
    }
  }

  public function site_details()
  {
    $this->data['facebook'] = $this->Admins->get_facebook();
    $this->data['instagram'] = $this->Admins->get_instagram();
    $this->data['twitter'] = $this->Admins->get_twitter();
    $this->data['email'] = $this->Admins->get_email_address();
    $this->load->view('admin/dashboard/layout/index',$this->data);
  }

  public function site_icon()
  {
    $this->data['icon'] = $this->Admins->get_icon();
    $this->load->view('admin/dashboard/layout/site_icon',$this->data);
  }

  public function upload_site_icon()
  {
    if (!empty($this->input->post('file'))) {
      $path = 'public/img/layout/';
      $croped_image = $_POST['image'];
       list($type, $croped_image) = explode(';', $croped_image);
       list(, $croped_image)      = explode(',', $croped_image);
       $croped_image = base64_decode($croped_image);
       $image_name = time().'.png';
       // upload cropped image to server
       file_put_contents($path.$image_name, $croped_image);

       $query = $this->db->query("select * from layout where meta_key = 'site_icon'");

       if ($query->num_rows() > 0) //KAPAG MERON NAKITANG LOGO, IUUPDATE
       {
         $data['site_icon'] = $query->row();
         $Site_Icon = [
           'value' => base_url().$path.$image_name
         ];
         if ($this->Admins->update_content($Site_Icon,$data['site_icon']->content_id))
         {
           echo "Icon updated!";
         }
       }
       else //KAPAG WALA II-INSERT YUNG LOGO
       {
         $Site_Icon = [
           'meta_key' => 'site_icon',
           'value' => base_url().$path.$image_name
         ];

         if ($this->db->insert('layout',$Site_Icon))
         { //KAPAG NAINSERT YUNG LOGO
           echo "Image uploaded!";
         }
         else
         { //KAPAG DI NAUPDATE YUNG LOGO
           echo '<script>alert("Something went wrong...");</script>';
         }
       }
    }
    else {
      echo "Please select an image";
    }
  }

  public function site_logo()
  {
    $this->data['logo'] = $this->Admins->get_logo();
    $this->load->view('admin/dashboard/layout/site_logo',$this->data);
  }

  public function upload_site_logo()
  {
    if (!empty($this->input->post('file'))) {
      $path = 'public/img/layout/';
      $croped_image = $_POST['image'];
       list($type, $croped_image) = explode(';', $croped_image);
       list(, $croped_image)      = explode(',', $croped_image);
       $croped_image = base64_decode($croped_image);
       $image_name = time().'.png';
       // upload cropped image to server
       file_put_contents($path.$image_name, $croped_image);

       $query = $this->db->query("select * from layout where meta_key = 'site_logo'");

       if ($query->num_rows() > 0) //KAPAG MERON NAKITANG LOGO, IUUPDATE
       {
         $data['site_logo'] = $query->row();
         $Site_Logo = [
           'value' => base_url().$path.$image_name
         ];
         if ($this->Admins->update_content($Site_Logo,$data['site_logo']->content_id))
         {
           echo "Logo updated!";
         }
       }
       else //KAPAG WALA II-INSERT YUNG LOGO
       {
         $Site_Logo = [
           'meta_key' => 'site_logo',
           'value' => base_url().$path.$image_name
         ];

         if ($this->db->insert('layout',$Site_Logo))
         { //KAPAG NAINSERT YUNG LOGO
           echo "Image uploaded!";
         }
         else
         { //KAPAG DI NAUPDATE YUNG LOGO
           echo '<script>alert("Something went wrong...");</script>';
         }
       }
    }
    else {
      echo "Please select an image";
    }
  }

  public function save_site_settings()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'tagline', 'Tagline',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('title')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'site_title'");
        if ($query->num_rows() > 0)
        {
          $data['title'] = $query->row();
          $Title = [
            'value' => $this->input->post('title')
          ];
          if ($this->Admins->update_content($Title,$data['title']->content_id)) {

          }
        }
        else
        {
          $Title = [
            'meta_key' => 'site_title',
            'value' => $this->input->post('title')
          ];

          if ($this->db->insert('layout',$Title)) {
          }
        }
      }
      if (!empty($this->input->post('tagline')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'site_tagline'");
        if ($query->num_rows() > 0)
        {
          $data['tagline'] = $query->row();
          $Tagline = [
            'value' => $this->input->post('tagline')
          ];
          if ($this->Admins->update_content($Tagline,$data['tagline']->content_id)) {

          }
        }
        else
        {
          $Tagline = [
            'meta_key' => 'site_tagline',
            'value' => $this->input->post('tagline')
          ];

          if ($this->db->insert('layout',$Tagline)) {
          }
        }
      }
      redirect(base_url().'Admin/site_details', 'refresh');
    }
  }

  public function save_social()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'facebook', 'Facebook',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'instagram', 'Instagram',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'twitter', 'Twitter',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'email', 'Email',
        'trim|valid_email',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('facebook')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'facebook_link'");
        if ($query->num_rows() > 0)
        {
          $data['facebook'] = $query->row();
          $Facebook = [
            'value' => $this->input->post('facebook')
          ];
          if ($this->Admins->update_content($Facebook,$data['facebook']->content_id)) {

          }
        }
        else
        {
          $Facebook = [
            'meta_key' => 'facebook_link',
            'value' => $this->input->post('facebook')
          ];

          if ($this->db->insert('layout',$Facebook)) {
          }
        }
      }
      if (!empty($this->input->post('instagram')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'instagram_link'");
        if ($query->num_rows() > 0)
        {
          $data['instagram'] = $query->row();
          $Instagram = [
            'value' => $this->input->post('instagram')
          ];
          if ($this->Admins->update_content($Instagram,$data['instagram']->content_id)) {

          }
        }
        else
        {
          $Instagram = [
            'meta_key' => 'instagram_link',
            'value' => $this->input->post('instagram')
          ];

          if ($this->db->insert('layout',$Instagram)) {
          }
        }
      }
      if (!empty($this->input->post('instagram')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'twitter_link'");
        if ($query->num_rows() > 0)
        {
          $data['twitter'] = $query->row();
          $Twitter = [
            'value' => $this->input->post('twitter')
          ];
          if ($this->Admins->update_content($Twitter,$data['twitter']->content_id)) {

          }
        }
        else
        {
          $Twitter = [
            'meta_key' => 'twitter_link',
            'value' => $this->input->post('twitter')
          ];

          if ($this->db->insert('layout',$Twitter)) {
          }
        }
      }
      if (!empty($this->input->post('google')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'google_link'");
        if ($query->num_rows() > 0)
        {
          $data['google'] = $query->row();
          $Google = [
            'value' => $this->input->post('google')
          ];
          if ($this->Admins->update_content($Google,$data['google']->content_id)) {

          }
        }
        else
        {
          $Google = [
            'meta_key' => 'google_link',
            'value' => $this->input->post('google')
          ];

          if ($this->db->insert('layout',$Google)) {
          }
        }
      }
      if (!empty($this->input->post('email')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'email_address'");
        if ($query->num_rows() > 0)
        {
          $data['email'] = $query->row();
          $Google = [
            'value' => $this->input->post('email')
          ];
          if ($this->Admins->update_content($Google,$data['email']->content_id)) {

          }
        }
        else
        {
          $Email = [
            'meta_key' => 'email_address',
            'value' => $this->input->post('email')
          ];

          if ($this->db->insert('layout',$Email)) {
          }
        }
      }
      redirect(base_url().'Admin/site_details', 'refresh');
    }
  }

  public function about_page()
  {
    $this->data['about_title'] = $this->Admins->get_about_title();
    $this->data['about_subtitle'] = $this->Admins->get_about_subtitle();
    $query2= $this->db->get_where('layout', ['meta_key' => 'about_detail']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/about_page';
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
    $this->data['about_details'] = $this->Admins->function_pagination_about_texts($limit, $offset);
    $this->load->view('admin/dashboard/layout/about',$this->data);
  }

  public function add_point()
  {
    $this->load->view('admin/dashboard/layout/add_point',$this->data);
  }

  public function save_about()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'about_title', 'Title',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'about_subtitle', 'Subtitle',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('about_title')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'about_title'");
        if ($query->num_rows() > 0)
        {
          $data['title'] = $query->row();
          $Title = [
            'value' => $this->input->post('about_title')
          ];
          if ($this->Admins->update_content($Title,$data['title']->content_id)) {

          }
        }
        else
        {
          $Title = [
            'meta_key' => 'about_title',
            'title' => NULL,
            'value' => $this->input->post('about_title')
          ];

          if ($this->db->insert('layout',$Title)) {
          }
        }
      }
      if (!empty($this->input->post('about_subtitle')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'about_subtitle'");
        if ($query->num_rows() > 0)
        {
          $data['subtitle'] = $query->row();
          $Subtitle = [
            'value' => $this->input->post('about_subtitle')
          ];
          if ($this->Admins->update_content($Instagram,$data['subtitle']->content_id)) {

          }
        }
        else
        {
          $Subtitle = [
            'meta_key' => 'about_subtitle',
            'value' => $this->input->post('about_subtitle')
          ];

          if ($this->db->insert('layout',$Subtitle)) {
          }
        }
      }
      redirect(base_url().'Admin/about_page', 'refresh');
    }
  }

  public function save_detail()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'detail_title', 'Title',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'detail_description', 'Description',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('detail_title')) || !empty($this->input->post('detail_description')))
      {
        $Detail = [
          'meta_key' => 'about_detail',
          'title' => $this->input->post('detail_title'),
          'value' => $this->input->post('detail_description')
        ];

        if ($this->db->insert('layout',$Detail)) {
          redirect(base_url().'Admin/about_page', 'refresh');
        }
      }
    }
  }

  public function view_detail($content_id)
  {
    $this->data['detail'] = $this->Admins->get_content($content_id);
    $this->load->view('admin/dashboard/layout/view',$this->data);
  }

  public function edit_detail($content_id)
  {
    $this->data['detail'] = $this->Admins->get_content($content_id);
    $this->load->view('admin/dashboard/layout/edit',$this->data);
  }

  public function update_detail($content_id)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'detail_title', 'Title',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'detail_description', 'Description',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      $Detail = [
        'title' => $this->input->post('detail_title'),
        'value' => $this->input->post('detail_description')
      ];
      if ($this->Admins->update_content($Detail,$content_id)) {

      }
      redirect(base_url().'Admin/about_page', 'refresh');
    }
  }

  public function delete_detail($content_id)
  {
    $this->db->where('content_id', $content_id);
    if ($this->db->delete('layout')) {
      echo '<script>alert("Detail deleted!");</script>';
      redirect(base_url().'Admin/about_page', 'refresh');
    }
  }
  // END OF LAYOUT

  // ADVERTISEMENTS
  public function advertisements()
  {
    $this->data['priorities'] = $this->Admins->get_priority_ad();
    $query2= $this->db->get_where('advertisements', ['type' => 'Regular']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/advertisements';
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
    $this->data['regulars'] = $this->Admins->function_pagination($limit, $offset);
    $this->load->view('admin/dashboard/advertisements/index',$this->data);
    // print_r($this->data['priorities']);
  }

  public function ending()
  {
    $date = new DateTime("tomorrow");
    $tom = $date->format('Y-m-d');
    $cur = new DateTime("now");
    $curdate = $cur->format('Y-m-d');
    $query2= $this->db->get_where('advertisements', ['end_date' => $tom],['or start_date' => $tom]);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/ending';
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
    $this->data['endings'] = $this->Admins->function_pagination_ending($limit, $offset);
    $this->load->view('admin/dashboard/advertisements/ending',$this->data);
    // print_r($this->data['endings']);
  }

  public function notify()
  {
    $email = 'cifercuatro04@gmail.com';
    if ($this->Admins->sendemail($email)) {
      echo '<script>alert("EMail sent!");</script>';
    }else {
      echo $this->email->print_debugger();
    }
  }

  public function add_ad($type)
  {
    if ($type == "Regular")
    {
      $this->load->view('admin/dashboard/advertisements/create',$this->data);
    }
    else
    {
      $this->load->view('admin/dashboard/advertisements/create_priority',$this->data);
    }
  }

  public function save_ad($type)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'start', 'Start Date',
        'required',
        array(
                'required'      => 'Please select start date'
        )
    );
    // $this->form_validation->set_rules(
    //     'end', 'End Date',
    //     'required',
    //     array(
    //             'required'      => 'Please select end date'
    //     )
    // );
    $this->form_validation->set_rules(
        'business_id', 'Business ID',
        'trim|required|callback_BusinessIdExists',
        array(
                'required'      => 'Please enter business id'
        )
    );
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim|required',
        array(
                'required'      => 'Please enter title'
        )
    );
    $this->form_validation->set_rules(
        'subtext', 'Tagline',
        'trim|required',
        array(
                'required'      => 'Please enter a short text for the advertisement'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim|required',
        array(
                'required'      => 'Please enter description for the advertisement'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      if ($type == 'Regular')
      {
        $this->load->view('admin/dashboard/advertisements/create',$this->data);
      }
      else
      {
        $this->load->view('admin/dashboard/advertisements/create_priority',$this->data);
      }
    }
    else
    {
      if ($type == 'Regular')
      {
        if(!empty($_FILES['picture']['name']))
        {
          $config['upload_path'] = 'public/img/advertisements';
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Ad = [
                'business_id' => $this->input->post('business_id'),
                'start_date' => $this->input->post('start'),
                'end_date' => $this->input->post('end'),
                'title' => $this->input->post('title'),
                'subtext' => $this->input->post('subtext'),
                'description' => $this->input->post('description'),
                'image' => '/'.$config['upload_path'].'/'.$picture,
                'type' => $type
              ];

              if ($this->db->insert('advertisements',$Ad)) {
                echo '<script>alert("Advertisement added!");</script>';
                redirect(base_url().'Admin/advertisements', 'refresh');
              }else {
                echo '<script>alert("Advertisement not added!");</script>';
                redirect(base_url().'Admin/advertisements', 'refresh');
              }
          }
          else
          {
            if (empty($this->input->post('end'))) {
              $Ad = [
                'business_id' => $this->input->post('business_id'),
                'start_date' => $this->input->post('start'),
                'end_date' => NULL,
                'title' => $this->input->post('title'),
                'subtext' => $this->input->post('subtext'),
                'description' => $this->input->post('description'),
                'image' => '/public/img/default-img.jpg',
                'type' => $type
              ];
            }else {
              $Ad = [
                'business_id' => $this->input->post('business_id'),
                'start_date' => $this->input->post('start'),
                'end_date' => $this->input->post('end'),
                'title' => $this->input->post('title'),
                'subtext' => $this->input->post('subtext'),
                'description' => $this->input->post('description'),
                'image' => '/public/img/default-img.jpg',
                'type' => $type
              ];
            }

            if ($this->db->insert('advertisements',$Ad)) {
              echo '<script>alert("Advertisement added!");</script>';
              redirect(base_url().'Admin/advertisements', 'refresh');
            }else {
              echo '<script>alert("Advertisement not added!");</script>';
              redirect(base_url().'Admin/advertisements', 'refresh');
            }
          }
        }
        else
        {
          if (empty($this->input->post('end'))) {
            $Ad = [
              'business_id' => $this->input->post('business_id'),
              'start_date' => $this->input->post('start'),
              'end_date' => NULL,
              'title' => $this->input->post('title'),
              'subtext' => $this->input->post('subtext'),
              'description' => $this->input->post('description'),
              'image' => '/public/img/default-img.jpg',
              'type' => $type
            ];
          }else {
            $Ad = [
              'business_id' => $this->input->post('business_id'),
              'start_date' => $this->input->post('start'),
              'end_date' => $this->input->post('end'),
              'title' => $this->input->post('title'),
              'subtext' => $this->input->post('subtext'),
              'description' => $this->input->post('description'),
              'image' => '/public/img/default-img.jpg',
              'type' => $type
            ];
          }

          if ($this->db->insert('advertisements',$Ad)) {
            echo '<script>alert("Advertisement added!");</script>';
            redirect(base_url().'Admin/advertisements', 'refresh');
          }else {
            echo '<script>alert("Advertisement not added!");</script>';
            redirect(base_url().'Admin/advertisements', 'refresh');
          }
        }
      }
      else
      {
        $this->data['priorities'] = $this->Admins->get_priority_ad();
        $count = count($this->data['priorities']);
        if ($count < 5)
        {
          if(!empty($_FILES['picture']['name']))
          {
            $config['upload_path'] = 'public/img/advertisements';
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Ad = [
                  'business_id' => $this->input->post('business_id'),
                  'start_date' => $this->input->post('start'),
                  'end_date' => $this->input->post('end'),
                  'title' => $this->input->post('title'),
                  'subtext' => $this->input->post('subtext'),
                  'description' => $this->input->post('description'),
                  'image' => '/'.$config['upload_path'].'/'.$picture,
                  'type' => $type
                ];

                if ($this->db->insert('advertisements',$Ad)) {
                  echo '<script>alert("Advertisement added!");</script>';
                  redirect(base_url().'Admin/advertisements', 'refresh');
                }else {
                  echo '<script>alert("Advertisement not added!");</script>';
                  redirect(base_url().'Admin/advertisements', 'refresh');
                }
            }
            else
            {
              $Ad = [
                'business_id' => $this->input->post('business_id'),
                'start_date' => $this->input->post('start'),
                'end_date' => $this->input->post('end'),
                'title' => $this->input->post('title'),
                'subtext' => $this->input->post('subtext'),
                'description' => $this->input->post('description'),
                'image' => '/public/img/default-img.jpg',
                'type' => $type
              ];

              if ($this->db->insert('advertisements',$Ad)) {
                echo '<script>alert("Advertisement added!");</script>';
                redirect(base_url().'Admin/advertisements', 'refresh');
              }else {
                echo '<script>alert("Advertisement not added!");</script>';
                redirect(base_url().'Admin/advertisements', 'refresh');
              }
            }
          }
          else
          {
            $Ad = [
              'business_id' => $this->input->post('business_id'),
              'start_date' => $this->input->post('start'),
              'end_date' => $this->input->post('end'),
              'title' => $this->input->post('title'),
              'subtext' => $this->input->post('subtext'),
              'description' => $this->input->post('description'),
              'image' => '/public/img/default-img.jpg',
              'type' => $type
            ];

            if ($this->db->insert('advertisements',$Ad)) {
              echo '<script>alert("Advertisement added!");</script>';
              redirect(base_url().'Admin/advertisements', 'refresh');
            }else {
              echo '<script>alert("Advertisement not added!");</script>';
              redirect(base_url().'Admin/advertisements', 'refresh');
            }
          }
        }
        else
        {
          echo '<script>alert("You have reached the maximum number of priority ads..");</script>';
          redirect(base_url().'Admin/add_ad/'.$type, 'refresh');
        }
      }
    }
  }

  public function BusinessIdExists()
  {
    $business_id = $this->input->post('business_id');
    $exists = $this->Admins->BusinessIdExists($business_id);

    if ($exists)
    {
      $this->form_validation->set_message('BusinessIdExists', 'The id you entered does not exists');
      return false;
    }
    else
    {
      return true;
    }
  }

  public function view_ad($ad_id)
  {
    $this->data['ad'] = $this->Admins->get_ad($ad_id);
    $this->load->view('admin/dashboard/advertisements/view',$this->data);
  }

  public function edit_ad($ad_id)
  {
    $this->data['ad'] = $this->Admins->get_ad($ad_id);
    $this->load->view('admin/dashboard/advertisements/edit',$this->data);
  }

  public function update_ad($ad_id)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'start', 'Start Date',
        'required',
        array(
                'required'      => 'Please select start date'
        )
    );
    $this->form_validation->set_rules(
        'end', 'End Date',
        'required',
        array(
                'required'      => 'Please select end date'
        )
    );
    $this->form_validation->set_rules(
        'business_id', 'Business ID',
        'trim|required',
        array(
                'required'      => 'Please enter business id'
        )
    );
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim|required',
        array(
                'required'      => 'Please enter title'
        )
    );
    $this->form_validation->set_rules(
        'subtext', 'Tagline',
        'trim|required',
        array(
                'required'      => 'Please enter a short text for the advertisement'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim|required',
        array(
                'required'      => 'Please enter description for the advertisement'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->data['ad'] = $this->Admins->get_ad($ad_id);
      $this->load->view('admin/dashboard/advertisements/edit',$this->data);
    }
    else
    {
      if(!empty($_FILES['picture']['name']))
      {
        $config['upload_path'] = 'public/img/advertisements';
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $_FILES['picture']['name'];

        //Load upload library and initialize configuration
        $this->load->library('upload',$config);
        $this->upload->initialize($config);

        if($this->upload->do_upload('picture')){
            $uploadData = $this->upload->data();
            $picture = $uploadData['file_name'];

            $Ad = [
              'business_id' => $this->input->post('business_id'),
              'start_date' => $this->input->post('start'),
              'end_date' => $this->input->post('end'),
              'title' => $this->input->post('title'),
              'subtext' => $this->input->post('subtext'),
              'description' => $this->input->post('description'),
              'image' => '/'.$config['upload_path'].'/'.$picture
            ];

            if ($this->Admins->update_ad($Ad,$ad_id))
            { //KAPAG NAUPDATE YUNG Image at data
              echo '<script>alert("Advertisement updated!");</script>';
              redirect(base_url().'Admin/advertisements', 'refresh');
            }
            else
            { //KAPAG DI NAUPDATE YUNG Image at data
              echo '<script>alert("Please check your image size and image file type...");</script>';
            }
        }
        else
        {
          $Ad = [
            'business_id' => $this->input->post('business_id'),
            'start_date' => $this->input->post('start'),
            'end_date' => $this->input->post('end'),
            'title' => $this->input->post('title'),
            'subtext' => $this->input->post('subtext'),
            'description' => $this->input->post('description'),
            'image' => '/public/img/default-img.jpg'
          ];

          if ($this->Admins->update_ad($Ad,$ad_id))
          { //KAPAG NAUPDATE YUNG Image at data
            echo '<script>alert("Advertisement updated!");</script>';
            redirect(base_url().'Admin/advertisements', 'refresh');
          }
          else
          { //KAPAG DI NAUPDATE YUNG Image at data
            echo '<script>alert("Please check your image size and image file type...");</script>';
          }
        }
      }
      else
      {
        $Ad = [
          'business_id' => $this->input->post('business_id'),
          'start_date' => $this->input->post('start'),
          'end_date' => $this->input->post('end'),
          'title' => $this->input->post('title'),
          'subtext' => $this->input->post('subtext'),
          'description' => $this->input->post('description')
        ];

        if ($this->Admins->update_ad($Ad,$ad_id))
        { //KAPAG NAUPDATE YUNG Image at data
          echo '<script>alert("Advertisement updated!");</script>';
          redirect(base_url().'Admin/advertisements', 'refresh');
        }
        else
        { //KAPAG DI NAUPDATE YUNG Image at data
          echo '<script>alert("Please check your image size and image file type...");</script>';
        }
      }
    }
  }

  public function delete_ad($advertisement_id)
  {
    $this->db->where('advertisement_id', $advertisement_id);
    if ($this->db->delete('advertisements')) {
      echo '<script>alert("Advertisement deleted!");</script>';
      redirect(base_url().'Admin/advertisements', 'refresh');
    }
  }
  // END OF ADVERTISEMENTS

  // EVENTS
  public function events()
  {
    // $query = $this->db->get('events','5', $this->uri->segment(3));
		// $this->data['events'] = $query->result();
    //
		// $query2= $this->db->get('events');
    //
		// $config['base_url'] = '/Admin/events';
		// $config['total_rows'] = $query2->num_rows();
		// $config['per_page'] = 5;
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
    // start_date < curdate()
    $date = new DateTime("now");
    $cur_date = $date->format('Y-m-d');
    $query2= $this->db->get_where('events', ['start_date >=' => $cur_date]);
    $limit = 2;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/events';
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
    $this->data['events'] = $this->Admins->pagination_events($limit, $offset);
    $this->load->view('admin/dashboard/events/index',$this->data);
  }

  public function add_event()
  {
    $this->load->view('admin/dashboard/events/create',$this->data);
  }

  public function save_event()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'start', 'Start Date',
        'required',
        array(
                'required'      => 'Please select start date'
        )
    );
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim|required',
        array(
                'required'      => 'Please enter event title'
        )
    );
    $this->form_validation->set_rules(
        'type', 'Type of event',
        'trim|required',
        array(
                'required'      => 'Please specify what kind of event'
        )
    );
    $this->form_validation->set_rules(
        'place', 'Place',
        'trim|required',
        array(
                'required'      => 'Please enter the location of the event'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim|required',
        array(
                'required'      => 'Please enter description for the event'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      // $this->load->view('admin/dashboard/events/create',$this->data);
      echo validation_errors();
    }
    else
    {
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/events/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         if (empty($this->input->post('end')))
         {
           $Event = [
             'start_date' => $this->input->post('start'),
             'end_date' => NULL,
             'title' => $this->input->post('title'),
             'type' => $this->input->post('type'),
             'place' => $this->input->post('place'),
             'description' => $this->input->post('description'),
             'image' => base_url().$path.$image_name
           ];
         }
         else
         {
           $Event = [
             'start_date' => $this->input->post('start'),
             'end_date' => $this->input->post('end'),
             'title' => $this->input->post('title'),
             'type' => $this->input->post('type'),
             'place' => $this->input->post('place'),
             'description' => $this->input->post('description'),
             'image' => base_url().$path.$image_name
           ];
         }
         if ($this->db->insert('events',$Event)) {
           echo 'Event added!';
         }else {
           echo 'Event cannot be created';
         }
      }
      else
      {
        if (empty($this->input->post('end')))
        {
          $Event = [
            'start_date' => $this->input->post('start'),
            'end_date' => NULL,
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'place' => $this->input->post('place'),
            'description' => $this->input->post('description'),
            'image' => NULL
          ];
        }
        else
        {
          $Event = [
            'start_date' => $this->input->post('start'),
            'end_date' => $this->input->post('end'),
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'place' => $this->input->post('place'),
            'description' => $this->input->post('description'),
            'image' => NULL
          ];
        }
        if ($this->db->insert('events',$Event)) {
          echo 'Event added!';
        }else {
          echo 'Event cannot be created';
        }
      }
    }
  }

  public function view_event($event_id)
  {
    $this->data['event'] = $this->Admins->get_event($event_id);
    $this->load->view('admin/dashboard/events/view',$this->data);
  }

  public function edit_event($event_id='')
  {
    $this->data['event'] = $this->Admins->get_event($event_id);
    $this->load->view('admin/dashboard/events/edit',$this->data);
  }

  public function update_event($event_id)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'start', 'Start Date',
        'required',
        array(
                'required'      => 'Please select start date'
        )
    );
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim|required',
        array(
                'required'      => 'Please enter event title'
        )
    );
    $this->form_validation->set_rules(
        'type', 'Type of event',
        'trim|required',
        array(
                'required'      => 'Please specify what kind of event'
        )
    );
    $this->form_validation->set_rules(
        'place', 'Place',
        'trim|required',
        array(
                'required'      => 'Please enter the location of the event'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim|required',
        array(
                'required'      => 'Please enter description for the event'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('admin/dashboard/events/edit',$this->data);
    }
    else
    {
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/events/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         if (empty($this->input->post('end')))
         {
           $Event = [
             'start_date' => $this->input->post('start'),
             'end_date' => NULL,
             'title' => $this->input->post('title'),
             'type' => $this->input->post('type'),
             'place' => $this->input->post('place'),
             'description' => $this->input->post('description'),
             'image' => base_url().$path.$image_name
           ];
         }
         else
         {
           $Event = [
             'start_date' => $this->input->post('start'),
             'end_date' => $this->input->post('end'),
             'title' => $this->input->post('title'),
             'type' => $this->input->post('type'),
             'place' => $this->input->post('place'),
             'description' => $this->input->post('description'),
             'image' => base_url().$path.$image_name
           ];
         }
         if ($this->Admins->update_event($Event,$event_id))
         {
           echo 'Event updated!';
           // redirect(base_url().'Admin/events', 'refresh');
         }
         else
         {
           echo 'Event cannot be updated';
           // redirect(base_url().'Admin/edit_event/'.$event_id, 'refresh');
         }
      }
      else
      {
        if (empty($this->input->post('end')))
        {
          $Event = [
            'start_date' => $this->input->post('start'),
            'end_date' => NULL,
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'place' => $this->input->post('place'),
            'description' => $this->input->post('description')
          ];
        }
        else
        {
          $Event = [
            'start_date' => $this->input->post('start'),
            'end_date' => $this->input->post('end'),
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'place' => $this->input->post('place'),
            'description' => $this->input->post('description')
          ];
        }
        if ($this->Admins->update_event($Event,$event_id))
        {
          echo 'Event updated!';
          // redirect(base_url().'Admin/events', 'refresh');
        }
        else
        {
          echo 'Event cannot be updated';
          // redirect(base_url().'Admin/edit_event/'.$event_id, 'refresh');
        }
      }
    }
  }

  public function delete_event($event_id)
  {
    $this->db->where('event_id', $event_id);
    if ($this->db->delete('events')) {
      echo '<script>alert("Event deleted!");</script>';
      redirect(base_url().'Admin/events', 'refresh');
    }
  }

  public function finished()
  {
    $date = new DateTime("now");
    $cur_date = $date->format('Y-m-d');
    $query2= $this->db->get_where('events', ['start_date <' => $cur_date]);
    $limit = 7;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/finished';
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
    $this->data['events'] = $this->Admins->pagination_finished_events($limit, $offset);
    $this->load->view('admin/dashboard/events/finished/index',$this->data);
  }

  public function view_finished_event($event_id)
  {
    $this->data['event'] = $this->Admins->get_event($event_id);
    $this->load->view('admin/dashboard/events/finished/view',$this->data);
  }

  public function edit_finished_event($event_id='')
  {
    $this->data['event'] = $this->Admins->get_event($event_id);
    $this->load->view('admin/dashboard/events/finished/edit',$this->data);
  }

  public function update_finished_event($event_id)
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'start', 'Start Date',
        'required',
        array(
                'required'      => 'Please select start date'
        )
    );
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim|required',
        array(
                'required'      => 'Please enter event title'
        )
    );
    $this->form_validation->set_rules(
        'type', 'Type of event',
        'trim|required',
        array(
                'required'      => 'Please specify what kind of event'
        )
    );
    $this->form_validation->set_rules(
        'place', 'Place',
        'trim|required',
        array(
                'required'      => 'Please enter the location of the event'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim|required',
        array(
                'required'      => 'Please enter description for the event'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('admin/dashboard/events/finished/edit',$this->data);
    }
    else
    {
      if (!empty($this->input->post('file'))) {
        $path = 'public/img/events/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);

         if (empty($this->input->post('end')))
         {
           $Event = [
             'start_date' => $this->input->post('start'),
             'end_date' => NULL,
             'title' => $this->input->post('title'),
             'type' => $this->input->post('type'),
             'place' => $this->input->post('place'),
             'description' => $this->input->post('description'),
             'image' => base_url().$path.$image_name
           ];
         }
         else
         {
           $Event = [
             'start_date' => $this->input->post('start'),
             'end_date' => $this->input->post('end'),
             'title' => $this->input->post('title'),
             'type' => $this->input->post('type'),
             'place' => $this->input->post('place'),
             'description' => $this->input->post('description'),
             'image' => base_url().$path.$image_name
           ];
         }
         if ($this->Admins->update_event($Event,$event_id))
         {
           echo 'Event updated!';
           // redirect(base_url().'Admin/events', 'refresh');
         }
         else
         {
           echo 'Event cannot be updated';
           // redirect(base_url().'Admin/edit_event/'.$event_id, 'refresh');
         }
      }
      else
      {
        if (empty($this->input->post('end')))
        {
          $Event = [
            'start_date' => $this->input->post('start'),
            'end_date' => NULL,
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'place' => $this->input->post('place'),
            'description' => $this->input->post('description')
          ];
        }
        else
        {
          $Event = [
            'start_date' => $this->input->post('start'),
            'end_date' => $this->input->post('end'),
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'place' => $this->input->post('place'),
            'description' => $this->input->post('description')
          ];
        }
        if ($this->Admins->update_event($Event,$event_id))
        {
          echo 'Event updated!';
          // redirect(base_url().'Admin/events', 'refresh');
        }
        else
        {
          echo 'Event cannot be updated';
          // redirect(base_url().'Admin/edit_event/'.$event_id, 'refresh');
        }
      }
    }
  }

  public function delete_finished_event($event_id)
  {
    $this->db->where('event_id', $event_id);
    if ($this->db->delete('events')) {
      echo '<script>alert("Event deleted!");</script>';
      redirect(base_url().'Admin/finished', 'refresh');
    }
  }
  // END OF EVENTS

  // FORUM
  public function forum()
  {
    $query2= $this->db->get_where('topics', ['created_by' => 'Admin']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/forum';
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
    $this->data['topics'] = $this->Admins->function_pagination_topics($limit, $offset);
    $this->load->view('admin/dashboard/forums/index',$this->data);
  }

  public function add_topic()
  {
    $this->load->view('admin/dashboard/forums/create',$this->data);
  }

  public function create_topic()
  {
    $this->form_validation->set_rules(
        'topic', 'Topic',
        'trim|required',
        array(
                'required'      => 'Please enter a topic'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('admin/dashboard/forums/create',$this->data);
    }
    else
    {
      $Topic = [
        'topic' => $this->input->post('topic'),
        'date_created' => date("Y-m-d"),
        'created_by' => 'Admin',
        'status' => '1'
      ];

      if ($this->db->insert('topics',$Topic)) {
        echo '<script>alert("Topic added!");</script>';
        redirect(base_url().'Admin/forum', 'refresh');
      }else {
        echo '<script>alert("Cannot save topic...");</script>';
        redirect(base_url().'Admin/add_topic', 'refresh');
      }
    }
  }

  public function edit_topic($topic_id)
  {
    $this->data['topic'] = $this->Admins->get_topic($topic_id);
    $this->load->view('admin/dashboard/forums/update', $this->data);
  }

  public function update_topic($topic_id)
  {
    $this->form_validation->set_rules(
        'topic', 'Topic',
        'trim|required',
        array(
                'required'      => 'Please enter a topic'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->data['topic'] = $this->Admins->get_topic($topic_id);
      $this->load->view('admin/dashboard/forums/update', $this->data);
    }
    else
    {
      $Topic = [
        'topic' => $this->input->post('topic')
      ];

      if ($this->Admins->update_topic($Topic,$topic_id)) {
        echo '<script>alert("Topic updated!");</script>';
        redirect(base_url().'Admin/forum', 'refresh');
      }else {
        echo '<script>alert("Topic cannot be updated...");</script>';
        redirect(base_url().'Admin/edit_topic/'.$topic_id, 'refresh');
      }
    }
  }

  public function delete_topic($topic_id)
  {
    $this->db->where('topic_id', $topic_id);
    if ($this->db->delete('topics')) {
      echo '<script>alert("Topic deleted!");</script>';
      redirect(base_url().'Admin/forum', 'refresh');
    }
  }

  public function approve()
  {
    $query2= $this->db->get_where('topics', ['created_by !=' => 'Admin'],['status' => '0']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/forum';
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
    $this->data['topics'] = $this->Admins->function_pagination_user_topics($limit, $offset);
    $this->load->view('admin/dashboard/forums/approve/index',$this->data);
  }

  public function approve_topic($topic_id)
  {
    if ($this->Admins->approve_topic($topic_id))
    {
      echo '<script>alert("Topic approved!");</script>';
      redirect(base_url().'Admin/approve', 'refresh');
    }
    else
    {
      echo '<script>alert("Cannot approve..");</script>';
      redirect(base_url().'Admin/approve', 'refresh');
    }
  }

  public function delete_user_topic($topic_id)
  {
    $this->db->where('topic_id', $topic_id);
    if ($this->db->delete('topics')) {
      echo '<script>alert("Topic deleted!");</script>';
      redirect(base_url().'Admin/approve', 'refresh');
    }
  }

  public function view_approved()
  {
    $query2= $this->db->get_where('topics', ['created_by !=' => 'Admin'],['status' => '1']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Admin/view_approved';
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
    $this->data['topics'] = $this->Admins->get_approved_user_topics($limit, $offset);
    $this->load->view('admin/dashboard/forums/approve/view',$this->data);
  }

  public function disapprove($topic_id)
  {
    if ($this->Admins->disapprove_topic($topic_id))
    {
      echo '<script>alert("Topic disapproved!");</script>';
      redirect(base_url().'Admin/view_approved', 'refresh');
    }
    else
    {
      echo '<script>alert("Cannot disapprove..");</script>';
      redirect(base_url().'Admin/view_approved', 'refresh');
    }
  }
  // END OF FORUM

  public function logout()
  {
    if ($this->session->userdata('admin_is_logged_in')) {
          $this->session->unset_userdata('admin_id');
          $this->session->unset_userdata('admin_is_logged_in');
          $this->session->unset_userdata('username');
        }
        redirect(base_url().'Admin');
  }
}
