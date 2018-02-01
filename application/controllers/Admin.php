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
    // if (!$this->session->userdata('admin_is_logged_in')) {
    //   redirect('/Home');
    // }else {
    //   redirect('/Admin/dashboard');
    // }
	}

  public function index()
  {
    if (!$this->session->userdata('admin_is_logged_in')) {
      $data['error'] = '';
      $this->load->view('admin/index',$data);
    }else {
      // $this->redirect();
      redirect('/Admin/dashboard');
    }
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
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $this->load->view('admin/dashboard/index',$data);
  }

  // LOCALITY
  public function localities()
  {
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);

    $query = $this->db->get('localities','7', $this->uri->segment(3));
		$data['localities'] = $query->result();

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

    $this->load->view('admin/dashboard/localities/index',$data);
  }

  public function add_localities()
  {
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $this->load->view('admin/dashboard/localities/create',$data);
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
      $username = $_SESSION['username'];
      $data['user'] = $this->Admins->validate_user($username);
      $this->load->view('admin/dashboard/localities/create',$data);
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
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $data['locality'] = $this->Admins->get_locality($locality_id);
    $this->load->view('admin/dashboard/localities/view', $data);
  }

  public function edit_locality($locality_id)
  {
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $data['locality'] = $this->Admins->get_locality($locality_id);
    $this->load->view('admin/dashboard/localities/update', $data);
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
      $username = $_SESSION['username'];
      $data['user'] = $this->Admins->validate_user($username);
      $data['locality'] = $this->Admins->get_locality($locality_id);
      $this->load->view('admin/dashboard/localities/update', $data);
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
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);

    $query = $this->db->get('categories','7', $this->uri->segment(3));
		$data['categories'] = $query->result();

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

    $this->load->view('admin/dashboard/categories/index',$data);
  }

  public function add_category()
  {
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $this->load->view('admin/dashboard/categories/create',$data);
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
      $username = $_SESSION['username'];
      $data['user'] = $this->Admins->validate_user($username);
      $this->load->view('admin/dashboard/categories/create',$data);
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
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $data['category'] = $this->Admins->get_category($category_id);
    $this->load->view('admin/dashboard/categories/view', $data);
  }

  public function edit_category($category_id)
  {
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $data['category'] = $this->Admins->get_category($category_id);
    $this->load->view('admin/dashboard/categories/update', $data);
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
      $username = $_SESSION['username'];
      $data['user'] = $this->Admins->validate_user($username);
      $data['category'] = $this->Admins->get_category($category_id);
      $this->load->view('admin/dashboard/categories/update', $data);
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
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);

    $query = $this->db->get('themes','7', $this->uri->segment(3));
		$data['themes'] = $query->result();

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

    $this->load->view('admin/dashboard/themes/index',$data);
  }

  public function add_theme()
  {
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $this->load->view('admin/dashboard/themes/create',$data);
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
      $username = $_SESSION['username'];
      $data['user'] = $this->Admins->validate_user($username);
      $this->load->view('admin/dashboard/themes/create',$data);
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
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $data['theme'] = $this->Admins->get_theme($theme_id);
    $this->load->view('admin/dashboard/themes/view', $data);
  }

  public function edit_theme($theme_id)
  {
    $username = $_SESSION['username'];
    $data['user'] = $this->Admins->validate_user($username);
    $data['theme'] = $this->Admins->get_theme($theme_id);
    $this->load->view('admin/dashboard/themes/update', $data);
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
      $username = $_SESSION['username'];
      $data['user'] = $this->Admins->validate_user($username);
      $this->load->view('admin/dashboard/themes/create',$data);
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
