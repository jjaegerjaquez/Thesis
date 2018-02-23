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
          redirect('/Admin');
        }
    }
    else
    {
      $username = $_SESSION['username'];
      $this->data['user'] = $this->Admins->validate_user($username);
      $this->data['title'] = $this->Admins->get_title();
      $this->data['tagline'] = $this->Admins->get_tagline();
    }
	}

  public function index()
  {
    if ($this->session->userdata('admin_is_logged_in'))
    {
      redirect('/Admin/dashboard');
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
          redirect('/Admin/dashboard');
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

  // LOCALITY
  public function localities()
  {
    $username = $_SESSION['username'];
    $this->data['user'] = $this->Admins->validate_user($username);

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
        'required|trim',
        array(
                'required'      => 'Please enter a locality'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'required|trim',
        array(
                'required'      => 'Please enter a locality'
        )
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('admin/dashboard/localities/create',$this->data);
    }
    else
    {
      if(!empty($_FILES['picture']['name'])){
          $config['upload_path'] = 'public/img/locality-img';
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Locality = [
                'locality' => $this->input->post('locality'),
                'description' => $this->input->post('description'),
                'image' => $picture
              ];

              if ($this->db->insert('localities',$Locality)) {
                echo '<script>alert("Locality added!");</script>';
                redirect('/Admin/localities', 'refresh');
              }else {
                echo '<script>alert("Locality not added!");</script>';
                redirect('/Admin/localities', 'refresh');
              }
          }else{
            $Locality = [
              'locality' => $this->input->post('locality'),
              'description' => $this->input->post('description'),
              'image' => 'default-img.jpg'
            ];

            if ($this->db->insert('localities',$Locality)) {
              echo '<script>alert("Locality added!");</script>';
              redirect('/Admin/localities', 'refresh');
            }else {
              echo '<script>alert("Locality not added!");</script>';
              redirect('/Admin/localities', 'refresh');
            }
          }
      }else{
        $Locality = [
          'locality' => $this->input->post('locality'),
          'description' => $this->input->post('description'),
          'image' => 'default-img.jpg'
        ];

        if ($this->db->insert('localities',$Locality)) {
          echo '<script>alert("Locality added!");</script>';
          redirect('/Admin/localities', 'refresh');
        }else {
          echo '<script>alert("Locality not added!");</script>';
          redirect('/Admin/localities', 'refresh');
        }
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
        'required|trim',
        array(
                'required'      => 'Please enter locality description'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->data['locality'] = $this->Admins->get_locality($locality_id);
      $this->load->view('admin/dashboard/localities/update', $this->data);
    }
    else
    {
      // If may laman na image
      if(!empty($_FILES['picture']['name'])){
          $config['upload_path'] = 'public/img/locality-img';
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Locality = [
                'locality' => $this->input->post('locality'),
                'description' => $this->input->post('description'),
                'image' => $picture
              ];

              $this->Admins->update_locality($Locality,$locality_id);
              echo '<script>alert("Locality updated!");</script>';
              redirect('/Admin/localities', 'refresh');
          }else{
            $Locality = [
              'locality' => $this->input->post('locality'),
              'description' => $this->input->post('description')
            ];

            $this->Admins->update_locality($Locality,$locality_id);
            echo '<script>alert("Your image size is not appropriate..");</script>';
            redirect('/Admin/localities', 'refresh');
          }
      } //END NG KAPAG MAY LAMAN NA IMAGE
      else //KAPAG WALANG LAMAN NA IMAGE
      {
        $Locality = [
          'locality' => $this->input->post('locality'),
          'description' => $this->input->post('description')
        ];

        $this->Admins->update_locality($Locality,$locality_id);
        echo '<script>alert("Locality updated!");</script>';
        redirect('/Admin/localities', 'refresh');
      }
    }
  }

  public function delete_locality($locality_id)
  {
    $this->db->where('locality_id', $locality_id);
    $this->db->delete('localities');
     echo '<script>alert("Locality deleted!");</script>';
     redirect('/Admin/localities', 'refresh');
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
                'required'      => 'Please enter a locality'
        )
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'required|trim',
        array(
                'required'      => 'Please enter category description'
        )
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('admin/dashboard/categories/create',$this->data);
    }
    else
    {
      if(!empty($_FILES['picture']['name'])){
          $config['upload_path'] = 'public/img/icons';
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Category = [
                'category' => $this->input->post('category'),
                'description' => $this->input->post('description'),
                'image' => $picture
              ];

              if ($this->db->insert('categories',$Category)) {
                echo '<script>alert("Category added!");</script>';
                redirect('/Admin/categories', 'refresh');
              }else {
                echo '<script>alert("Category not added!");</script>';
                redirect('/Admin/categories', 'refresh');
              }
          }else{
            $Category = [
              'category' => $this->input->post('category'),
              'description' => $this->input->post('description'),
              'image' => 'default-img.jpg'
            ];

            if ($this->db->insert('categories',$Category)) {
              echo '<script>alert("Category added!");</script>';
              redirect('/Admin/categories', 'refresh');
            }else {
              echo '<script>alert("Category not added!");</script>';
              redirect('/Admin/categories', 'refresh');
            }
          }
      }else{
        $Category = [
          'category' => $this->input->post('category'),
          'description' => $this->input->post('description'),
          'image' => 'default-img.jpg'
        ];

        if ($this->db->insert('categories',$Category)) {
          echo '<script>alert("Category added!");</script>';
          redirect('/Admin/categories', 'refresh');
        }else {
          echo '<script>alert("Category not added!");</script>';
          redirect('/Admin/categories', 'refresh');
        }
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
        'required|trim',
        array(
                'required'      => 'Please enter category description'
        )
    );
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $this->data['category'] = $this->Admins->get_category($category_id);
      $this->load->view('admin/dashboard/categories/update', $this->data);
    }
    else
    {
      // If may laman na image
      if(!empty($_FILES['picture']['name'])){
          $config['upload_path'] = 'public/img/icons';
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Category = [
                'category' => $this->input->post('category'),
                'description' => $this->input->post('description'),
                'image' => $picture
              ];

              $this->Admins->update_category($Category,$category_id);
              echo '<script>alert("Category updated!");</script>';
              redirect('/Admin/categories', 'refresh');
          }else{
            $Category = [
              'category' => $this->input->post('category'),
              'description' => $this->input->post('description')
            ];

            $this->Admins->update_category($Category,$category_id);
            echo '<script>alert("Your image size is not appropriate..");</script>';
            redirect('/Admin/categories', 'refresh');
          }
      } //END NG KAPAG MAY LAMAN NA IMAGE
      else //KAPAG WALANG LAMAN NA IMAGE
      {
        $Category = [
          'category' => $this->input->post('category'),
          'description' => $this->input->post('description')
        ];

        $this->Admins->update_category($Category,$category_id);
        echo '<script>alert("Category updated!");</script>';
        redirect('/Admin/categories', 'refresh');
      }
    }
  }

  public function delete_category($category_id)
  {
    $this->db->where('category_id', $category_id);
    $this->db->delete('categories');
     echo '<script>alert("Category deleted!");</script>';
     redirect('/Admin/categories', 'refresh');
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
      $theme = $this->input->post('theme_name');
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

              if ($this->db->insert('themes',$Theme)) {
                echo '<script>alert("Theme added!");</script>';
                chmod('./uploads/', 0777);
                $path   = './uploads/themes/'.$theme;
                if (!is_dir($path)) { //create the folder if it's not already exists
                    mkdir($path, 0755, TRUE);
                }
                redirect('/Admin/add_theme', 'refresh');
              }else {
                echo '<script>alert("Theme not added!");</script>';
                redirect('/Admin/add_theme', 'refresh');
              }
          }else{
            $Theme = [
              'theme' => $this->input->post('theme_name'),
              'author' => $this->input->post('author'),
              'description' => $this->input->post('description'),
              'image' => 'default-img.jpg'
            ];

            if ($this->db->insert('themes',$Theme)) {
              echo '<script>alert("Theme added!");</script>';
              chmod('./uploads/', 0777);
              $path   = './uploads/themes/'.$theme;
              if (!is_dir($path)) { //create the folder if it's not already exists
                  mkdir($path, 0755, TRUE);
              }
              redirect('/Admin/add_theme', 'refresh');
            }else {
              echo '<script>alert("Theme not added!");</script>';
              redirect('/Admin/add_theme', 'refresh');
            }
          }
      }else{
        $Theme = [
          'theme' => $this->input->post('theme_name'),
          'author' => $this->input->post('author'),
          'description' => $this->input->post('description'),
          'image' => 'default-img.jpg'
        ];

        if ($this->db->insert('themes',$Theme)) {
          echo '<script>alert("Theme added!");</script>';
          chmod('./uploads/', 0777);
          $path   = './uploads/themes/'.$theme;
          if (!is_dir($path)) { //create the folder if it's not already exists
              mkdir($path, 0755, TRUE);
          }
          redirect('/Admin/add_theme', 'refresh');
        }else {
          echo '<script>alert("Theme not added!");</script>';
          redirect('/Admin/add_theme', 'refresh');
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
              redirect('/Admin/edit_theme/'.$theme_id, 'refresh');
          }else{
            echo '<script>alert("Something went wrong, theme not updated!");</script>';
            redirect('/Admin/themes', 'refresh');
          }
      }else{
        $Theme = [
          'theme' => $this->input->post('theme_name'),
          'author' => $this->input->post('author'),
          'description' => $this->input->post('description')
        ];

        $this->Admins->update_theme($Theme,$theme_id);
        echo '<script>alert("Theme updated!");</script>';
        redirect('/Admin/edit_theme/'.$theme_id, 'refresh');
      }
    }
  }

  public function delete_theme($theme_id)
  {
    $this->db->where('theme_id', $theme_id);
    $this->db->delete('themes');
     echo '<script>alert("Theme deleted!");</script>';
     redirect('/Admin/themes', 'refresh');
  }
  // END OF THEMES

  // LAYOUT
  public function layout()
  {
    $this->data['logo'] = $this->Admins->get_logo();
    $this->data['icon'] = $this->Admins->get_icon();
    $this->data['facebook'] = $this->Admins->get_facebook();
    $this->data['instagram'] = $this->Admins->get_instagram();
    $this->data['twitter'] = $this->Admins->get_twitter();
    $this->data['google'] = $this->Admins->get_google();
    // print_r($this->data['icon']);
    $this->load->view('admin/dashboard/layout/index',$this->data);
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
      if(!empty($_FILES['picture']['name']))
      {
        $query = $this->db->query("select * from layout where meta_key = 'site_logo'");
        if ($query->num_rows() > 0)
        {
           $data['logo'] = $query->row();
           $config['upload_path'] = 'public/img/logo';
           $config['overwrite'] = TRUE;
           $config['allowed_types'] = 'jpg|jpeg|png|gif';
          //  $config['min_width']            = 500;
          //  $config['min_height']           = 300;
          //  $config['max_width']            = 1000;
          //  $config['max_height']           = 600;
           $config['file_name'] = $_FILES['picture']['name'];

           //Load upload library and initialize configuration
           $this->load->library('upload',$config);
           $this->upload->initialize($config);

           if($this->upload->do_upload('picture')){
               $uploadData = $this->upload->data();
               $picture = $uploadData['file_name'];

               $Logo = [
                 'value' => $picture
               ];

               if ($this->Admins->update_site_logo($Logo,$data['logo']->content_id)) {
               }
           }
           else
           {
             echo '<script>alert("Please check your image size and image file type (allowed:jpg,jpeg,png,gif).");</script>';
           }
        }
        else
        {
            $config['upload_path'] = 'public/img/logo';
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['min_width']            = 500;
            $config['min_height']           = 300;
            // $config['max_width']            = 1000;
            // $config['max_height']           = 600;
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Logo = [
                  'meta_key' => 'site_logo',
                  'value' => $picture
                ];

                if ($this->db->insert('layout',$Logo)) {
                }
            }
            else
            {
              echo '<script>alert("Please check your image size and image file type (allowed:jpg,jpeg,png,gif).");</script>';
            }
        }
      }
      if(!empty($_FILES['icon']['name']))
      {
        $query = $this->db->query("select * from layout where meta_key = 'site_icon'");
        if ($query->num_rows() > 0)
        {
           $data['icon'] = $query->row();
           $config['upload_path'] = 'public/img/logo';
           $config['overwrite'] = TRUE;
           $config['allowed_types'] = 'jpg|jpeg|png|gif';
           $config['min_width']            = 300;
           $config['min_height']           = 300;
           $config['max_width']            = 900;
           $config['max_height']           = 900;
           $config['file_name'] = $_FILES['icon']['name'];

           //Load upload library and initialize configuration
           $this->load->library('upload',$config);
           $this->upload->initialize($config);

           if($this->upload->do_upload('icon')){
               $uploadData = $this->upload->data();
               $picture = $uploadData['file_name'];

               $Icon = [
                 'value' => $picture
               ];

               if ($this->Admins->update_site_icon($Icon,$data['icon']->content_id)) {
               }
           }
           else
           {
             echo '<script>alert("Please check your image size and image file type (allowed:jpg,jpeg,png,gif).");</script>';
           }
        }
        else
        {
            $config['upload_path'] = 'public/img/logo';
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['min_width']            = 300;
            $config['min_height']           = 300;
            $config['max_width']            = 900;
            $config['max_height']           = 900;
            $config['file_name'] = $_FILES['icon']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('icon')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Icon = [
                  'meta_key' => 'site_icon',
                  'value' => $picture
                ];

                if ($this->db->insert('layout',$Icon)) {
                }
            }
            else
            {
              echo '<script>alert("Please check your image size and image file type (allowed:jpg,jpeg,png,gif).");</script>';
            }
        }
      }
      if (!empty($this->input->post('title')))
      {
        $query = $this->db->query("select * from layout where meta_key = 'site_title'");
        if ($query->num_rows() > 0)
        {
          $data['title'] = $query->row();
          $Title = [
            'value' => $this->input->post('title')
          ];
          if ($this->Admins->update_site_title($Title,$data['title']->content_id)) {

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
          if ($this->Admins->update_site_tagline($Tagline,$data['tagline']->content_id)) {

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
      redirect('/Admin/layout', 'refresh');
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
        'google', 'Google',
        'trim',
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
          if ($this->Admins->update_facebook_url($Facebook,$data['facebook']->content_id)) {

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
          if ($this->Admins->update_instagram_url($Instagram,$data['instagram']->content_id)) {

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
          if ($this->Admins->update_twitter_url($Twitter,$data['twitter']->content_id)) {

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
          if ($this->Admins->update_google_url($Google,$data['google']->content_id)) {

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
      redirect('/Admin/layout', 'refresh');
    }
  }
  // END OF LAYOUT

  // ADVERTISEMENTS
  public function advertisements()
  {
    $this->data['priorities'] = $this->Admins->get_priority_ad();
    // $this->data['regulars'] = $this->Admins->get_regular_ad();
    $query2= $this->db->get_where('advertisements', ['type' => 'Regular']);
    // echo $query2->num_rows();
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
    $this->form_validation->set_rules(
        'end', 'End Date',
        'required',
        array(
                'required'      => 'Please select end date'
        )
    );
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
                redirect('/Admin/advertisements', 'refresh');
              }else {
                echo '<script>alert("Advertisement not added!");</script>';
                redirect('/Admin/advertisements', 'refresh');
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
              redirect('/Admin/advertisements', 'refresh');
            }else {
              echo '<script>alert("Advertisement not added!");</script>';
              redirect('/Admin/advertisements', 'refresh');
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
            redirect('/Admin/advertisements', 'refresh');
          }else {
            echo '<script>alert("Advertisement not added!");</script>';
            redirect('/Admin/advertisements', 'refresh');
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
                  redirect('/Admin/advertisements', 'refresh');
                }else {
                  echo '<script>alert("Advertisement not added!");</script>';
                  redirect('/Admin/advertisements', 'refresh');
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
                redirect('/Admin/advertisements', 'refresh');
              }else {
                echo '<script>alert("Advertisement not added!");</script>';
                redirect('/Admin/advertisements', 'refresh');
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
              redirect('/Admin/advertisements', 'refresh');
            }else {
              echo '<script>alert("Advertisement not added!");</script>';
              redirect('/Admin/advertisements', 'refresh');
            }
          }
        }
        else
        {
          echo '<script>alert("You have reached the maximum number of priority ads..");</script>';
          redirect('/Admin/add_ad/'.$type, 'refresh');
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
              redirect('/Admin/advertisements', 'refresh');
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
            redirect('/Admin/advertisements', 'refresh');
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
          redirect('/Admin/advertisements', 'refresh');
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
    $this->db->delete('advertisements');
    echo '<script>alert("Advertisement deleted!");</script>';
    redirect('/Admin/advertisements', 'refresh');
  }
  // END OF ADVERTISEMENTS

  public function logout()
  {
    if ($this->session->userdata('admin_is_logged_in')) {
          $this->session->unset_userdata('admin_id');
          $this->session->unset_userdata('admin_is_logged_in');
          $this->session->unset_userdata('username');
        }
        redirect('/Admin');
  }
}
