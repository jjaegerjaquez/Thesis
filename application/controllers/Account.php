<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Account extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Accounts');
    if (!$this->session->userdata('is_logged_in'))
    {
      $allowed = array(
          'themes'
        );
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
          redirect(base_url().'Home');
        }
    }
    else
    {
      $this->user_id = $_SESSION['user_id'];
      $this->data['business_name'] = $_SESSION['business'];
      $this->BusinessName = $_SESSION['business'];
      $this->data['account'] = $this->Accounts->get_account_details($this->user_id);
      $this->data['details'] = $this->Accounts->get_business_template($this->user_id,$this->BusinessName);
      if (!empty($this->data['details']->id)) {
        $this->id = $this->data['details']->id;
      }
      else {
        $this->id = "0";
      }
      $this->data['theme'] = $this->Accounts->get_theme($this->data['business_name']);
      $this->data['businesses'] = $this->Accounts->get_businesses($this->user_id);
      $this->data['vote_count'] = $this->Accounts->get_vote_count($this->id);
      $this->data['review_count'] = $this->Accounts->get_review_count($this->id);
      $this->data['rating'] = $this->Accounts->get_rate($this->id);
      $this->data['localities'] = $this->Accounts->get_localities();
      $this->data['categories'] = $this->Accounts->get_categories();
      $this->data['themes'] = $this->Accounts->get_themes();
      $this->data['title'] = $this->Accounts->get_title();
      $this->data['icon'] = $this->Accounts->get_site_icon();
      $this->data['tagline'] = $this->Accounts->get_tagline();
      $this->data['facebook'] = $this->Accounts->get_facebook();
      $this->data['instagram'] = $this->Accounts->get_instagram();
      $this->data['twitter'] = $this->Accounts->get_twitter();
      $this->data['google'] = $this->Accounts->get_google();
      $this->data['notif_count'] = $this->Accounts->get_notif_count($this->user_id);
      $this->data['notifications'] = $this->Accounts->get_notifications($this->user_id);
    }
	}

  public function index()
  {
    $query2= $this->db->get_where('reviews', ['business_id' => $this->id,'is_read' => '0']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = base_url().'Account/index';
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
    $this->data['reviews'] = $this->Accounts->function_pagination($limit, $offset,$this->id);
    if ($this->data['details']->website == 'Yes')
    {
      $this->load->view('account/dashboard/index',$this->data);
    }
    else
    {
      $theme = $this->data['theme']->theme;
      $this->load->view('account/themes/'.$theme.'/dashboard/index',$this->data);
    }
  }

  public function mark_reviews_read()
  {
    $Review = [
      'is_read' => '1'
    ];
    if ($this->Accounts->set_read_reviews($Review,$this->id)) {
      redirect(base_url().'Account', 'refresh');
    }
  }

  public function view_all_reviews()
  {
    $query2= $this->db->get_where('reviews', ['business_id' => $this->id,'is_read' => '1']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = base_url().'Account/view_all_reviews';
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
    $this->data['reviews'] = $this->Accounts->function_pagination_read_reviews($limit, $offset,$this->id);
    if ($this->data['details']->website == 'Yes')
    {
      $this->load->view('account/dashboard/all_reviews',$this->data);
    }
    else
    {
      $theme = $this->data['theme']->theme;
      $this->load->view('account/themes/'.$theme.'/dashboard/all_reviews',$this->data);
    }
  }

  public function get_notif()
  {

  }

  public function switch_business()
  {
    $this->session->unset_userdata('business');
    $this->session->set_userdata('business', $this->input->get('business'));
    redirect(base_url().'Account', 'refresh');
  }

  public function start()
  {
    $this->load->view('start/index',$this->data);
  }

  public function save_start()
  {
    $this->form_validation->set_rules('business_name', 'Business Name', 'trim|callback_BusinessNameExists');
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('start/index');
    }
    else
    {
      if ($_SESSION['primary_website'] == 'Yes')
      {
        $Business_information = [
          'user_id' => $_SESSION['user_id'],
          'business_name' => $this->input->post('business_name'),
          'theme' => 'NA',
          'position' => 'Primary',
          'website' => 'Yes'
        ];
        if ($this->db->insert('basic_info',$Business_information))
        {
          $this->session->set_userdata('business', $this->input->post('business_name'));
          $setup = array('set_up' => '1' );
          $this->db->where('user_id', $_SESSION['user_id']);
          $this->db->update('users', $setup);
          $this->session->unset_userdata('primary_website');
          redirect(base_url().'Account', 'refresh');
        }
        else
        {
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
          $this->session->unset_userdata('business');
          $this->session->unset_userdata('primary_website');
          echo "<script>alert('Something went wrong, logging you out..');document.location='/Home'</script>";
        }
      }
      else
      {
        $this->session->set_userdata('primary_business_name', $this->input->post('business_name'));
        redirect(base_url().'Account/themes', 'refresh');
      }
    }
  }

  public function BusinessNameExists()
  {
    $business_name = $this->input->post('business_name');
    $exists = $this->Accounts->BusinessNameExists($business_name);

    if ($exists) {
        $this->form_validation->set_message('BusinessNameExists', 'Business name is already taken');
        return false;
    } else {
        return true;
    }
  }

  public function themes()
  {
    $data['themes'] = $this->Accounts->get_themes();
    $this->load->view('template/index',$data);
  }

  public function save_template()
  {
    $template = $this->input->post('template');
    $Business_information = [
      'user_id' => $_SESSION['user_id'],
      'business_name' => $_SESSION['primary_business_name'],
      'theme' => $this->input->post('template'),
      'position' => 'Primary',
      'website' => 'No'
    ];

    if ($this->db->insert('basic_info',$Business_information))
    {
      $this->session->set_userdata('business', $_SESSION['primary_business_name']);
      $setup = array('set_up' => '1' );
      $this->db->where('user_id', $_SESSION['user_id']);
      $this->db->update('users', $setup);
      $this->session->unset_userdata('primary_website');
      $this->session->unset_userdata('primary_business_name');
      redirect(base_url().'Account', 'refresh');
    }
    else
    {
      $this->session->unset_userdata('email');
      $this->session->unset_userdata('is_logged_in');
      $this->session->unset_userdata('user_id');
      $this->session->unset_userdata('business');
      $this->session->unset_userdata('primary_website');
      echo "<script>alert('Something went wrong, logging you out..');document.location='/Home'</script>";
    }
  }

  public function profile()
  {
    if ($this->data['details']->website == 'Yes')
    {
      $this->load->view('account/profile/index',$this->data);
    }
    else
    {
      $theme = $this->data['theme']->theme;
      $this->load->view('account/themes/'.$theme.'/profile/index',$this->data);
    }
  }

  public function save_profile()
  {
    $website = $this->data['details']->website;
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'category', 'Category',
        'trim|required',
        array(
                'required'      => 'Please select your business category'
        )
    );
    $this->form_validation->set_rules(
        'city_province', 'City/Province',
        'trim|required',
        array(
                'required'      => 'Please select a city or province'
        )
    );
    if ($this->input->post('business_name') == $this->BusinessName) {
      $this->form_validation->set_rules(
          'business_name', 'Business Name',
          'trim|required',
          array(
                  'required'      => 'Please enter your business name'
          )
      );
    }else {
      $this->form_validation->set_rules(
          'business_name', 'Business Name',
          'trim|required|callback_BusinessNameExists',
          array(
                  'required'      => 'Please enter your business name'
          )
      );
    }
    $this->form_validation->set_rules(
        'address', 'Address',
        'trim|required',
        array(
                'required'      => 'Please enter your business address'
        )
    );

    $this->form_validation->set_rules(
        'cellphone_number', 'Cellphone Number',
        'trim|required|numeric',
        array(
                'required'      => 'Please enter your business cellphone number',
                'numeric'      => 'Please enter numeric characters only'
        )
    );

    $this->form_validation->set_rules(
        'contact_person', 'Contact Person',
        'trim|required',
        array(
                'required'      => 'Please enter your contact person'
        )
    );

    if ($website == 'Yes') {
      $this->form_validation->set_rules(
          'website_address', 'Website Address',
          'trim|required',
          array(
                  'required'      => 'Please enter your business website URL'
          )
      );
    }
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      if ($this->data['details']->website == 'Yes')
      {
        $this->load->view('account/profile/index',$this->data);
      }
      else
      {
        $theme = $this->data['theme']->theme;
        $this->load->view('account/themes/'.$theme.'/profile/index',$this->data);
      }
    }
    else
    {
      if ($website == 'Yes')
      { //Kapag may website kukunin yung laman ng website na input
        $Business_Details = [
          'username' => $this->data['account']->username,
          'business_name' => $this->input->post('business_name'),
          'category' => $this->input->post('category'),
          'locality' => $this->input->post('city_province'),
          'address' => $this->input->post('address'),
          'cellphone' => $this->input->post('cellphone_number'),
          'telephone' => $this->input->post('telephone_number'),
          'contact_person' => $this->input->post('contact_person'),
          'website_url' => $this->input->post('website_address')
        ];
        if ($this->Accounts->save_profile($Business_Details,$this->user_id,$this->BusinessName)) {
          $this->session->unset_userdata('business');
          $this->session->set_userdata('business', $this->input->post('business_name'));
          redirect(base_url().'Account/profile', 'refresh');
        }
      }
      else //Kapag walang website lalagyan ng NA yung website URL sa db
      {
        $Business_Details = [
          'username' => $this->data['account']->username,
          'business_name' => $this->input->post('business_name'),
          'category' => $this->input->post('category'),
          'locality' => $this->input->post('city_province'),
          'address' => $this->input->post('address'),
          'cellphone' => $this->input->post('cellphone_number'),
          'telephone' => $this->input->post('telephone_number'),
          'contact_person' => $this->input->post('contact_person'),
          'website_url' => base_url().'View/home/'.str_replace(' ', '_', $this->input->post('business_name'))
        ];
        if ($this->Accounts->save_profile($Business_Details,$this->user_id,$this->BusinessName)) {
          $this->session->unset_userdata('business');
          $this->session->set_userdata('business', $this->input->post('business_name'));
          redirect(base_url().'Account/profile', 'refresh');
        }
      }
    }
  }

  public function site_identity()
  {
    $theme = $this->data['theme']->theme;
    $this->data['site_title'] = $this->Accounts->get_site_title($this->user_id,$this->id);
    $this->data['site_tagline'] = $this->Accounts->get_site_tagline($this->user_id,$this->id);
    $this->data['site_logo'] = $this->Accounts->get_site_logo($this->user_id,$this->id);
    $this->load->view('account/themes/'.$theme.'/site_identity/index',$this->data,$this->BusinessName);
  }

  public function save_site_identity()
  {
    $theme = $this->data['theme']->theme;
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'site_title', 'Site Title',
        'trim',
        array(

        )
    );
    $this->form_validation->set_rules(
        'site_tagline', 'Site Tagline',
        'trim',
        array(

        )
    );
    // END VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('site_title'))) {

        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'site_title'");
        if ($query->num_rows() > 0) {
          $data['site_title'] = $this->Accounts->get_site_title($this->user_id,$this->id);
          $Site_Title = [
            'value' => $this->input->post('site_title')
          ];
          if ($this->Accounts->update_site_title($Site_Title,$this->user_id,$data['site_title']->content_id)) {
            // redirect('/Account/site_identity', 'refresh');
          }

        }else {

          $Site_Title = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'site_title',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('site_title')
          ];

          if ($this->db->insert('contents',$Site_Title)) {
            // redirect('/Account/site_identity', 'refresh');
          }

        }

      }

      if (!empty($this->input->post('site_tagline'))) {

        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'site_tagline'");
        if ($query->num_rows() > 0) {

          $data['site_tagline'] = $this->Accounts->get_site_tagline($this->user_id,$this->id);
          $Site_Tagline = [
            'value' => $this->input->post('site_tagline')
          ];
          if ($this->Accounts->update_site_tagline($Site_Tagline,$this->user_id,$data['site_tagline']->content_id)) {
            // redirect('/Account/site_identity', 'refresh');
          }
        }else {

          $Site_Tagline = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'site_tagline',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('site_tagline')
          ];

          if ($this->db->insert('contents',$Site_Tagline)) {
            // redirect('/Account/site_identity', 'refresh');
          }

        }

      }
      redirect(base_url().'Account/site_identity', 'refresh');
    }
  }

  public function new_business()
  {
    $this->load->view('account/new/step1/index');
  }

  public function save_step_one()
  {
    $status = $this->input->post('select');
    if ($status == 'Yes') {
      $this->session->set_userdata('secondary_website', 'Yes');
      redirect(base_url().'Account/step_two', 'refresh');
    }
    elseif ($status == 'No') {
      $this->session->set_userdata('secondary_website', 'No');
      redirect(base_url().'Account/step_two', 'refresh');
    }
  }


  public function step_two()
  {
    $this->load->view('account/new/step2/index');
  }

  public function save_step_two()
  {
    $this->form_validation->set_rules('business_name', 'Business Name', 'trim|callback_BusinessNameExists');
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('account/new/step2/index');
    }
    else
    {
      if ($_SESSION['secondary_website'] == 'Yes')
      {
        $Business_information = [
          'user_id' => $_SESSION['user_id'],
          'business_name' => $this->input->post('business_name'),
          'theme' => 'NA',
          'position' => 'Secondary',
          'website' => 'Yes'
        ];
        if ($this->db->insert('basic_info',$Business_information))
        {
          $this->session->set_userdata('business', $this->input->post('business_name'));
          $this->session->unset_userdata('secondary_website');
          redirect(base_url().'Account', 'refresh');
        }
        else
        {
          $this->session->unset_userdata('secondary_website');
          echo "<script>alert('Something went wrong.');document.location='/Account'</script>";
        }
      }
      else
      {
        $this->session->set_userdata('secondary_business_name', $this->input->post('business_name'));
        redirect(base_url().'Account/step_three', 'refresh');
      }
    }
  }

  public function step_three()
  {
    $this->load->view('account/new/step3/index',$this->data);
  }

  public function save_new()
  {
    $Business_information = [
      'user_id' => $_SESSION['user_id'],
      'business_name' => $_SESSION['secondary_business_name'],
      'theme' => $this->input->post('template'),
      'position' => 'Secondary',
      'website' => 'No'
    ];

    if ($this->db->insert('basic_info',$Business_information))
    {
      $this->session->set_userdata('business', $_SESSION['secondary_business_name']);
      $this->session->unset_userdata('secondary_website');
      $this->session->unset_userdata('secondary_business_name');
      redirect(base_url().'Account', 'refresh');
    }
    else
    {
      $this->session->unset_userdata('secondary_website');
      $this->session->unset_userdata('secondary_business_name');
      echo "<script>alert('Something went wrong.');document.location='/Account'</script>";
    }
  }


  public function security()
  {
    $this->load->view('account/security/index', $this->data);
  }

  public function test()
  {

  }

  public function update_username()
  {
    // $this->form_validation->set_rules(
    //     'username', 'Username',
    //     'trim|callback_UsernameExists',
    //     array()
    // );
    // if ($this->form_validation->run() == FALSE)
    // {
    //
    //   $this->load->view('account/security/index', $this->data);
    // }
    // else
    // {
    //   // $Username = [
    //   //   'username' => $this->input->post('username')
    //   // ];
    //   // if ($this->Accounts->update_username($Username,$this->user_id)) {
    //   //   redirect('/Account/security', 'refresh');
    //   // }
    // }
    $this->form_validation->set_rules(
        'username', 'Username',
        'trim|callback_UsernameExists',
        array()
    );
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('account/security/index', $this->data);
    }
    else
    {
      $old_username = $this->data['account']->username;
      $Username = [
          'username' => $this->input->post('username')
        ];
        if ($this->Accounts->update_username($Username,$this->user_id)) {
          rename('./uploads/'.$old_username, './uploads/'.$this->input->post('username'));
          redirect(base_url().'Account/security', 'refresh');

        }
    }
  }

  public function UsernameExists()
  {
    $username = $this->input->post('username');
    $exists = $this->Accounts->UsernameExists($username);

    if ($exists) {
        $this->form_validation->set_message('UsernameExists', 'Username is already taken.');
        return false;
    } else {
        return true;
    }
  }

  public function update_password()
  {
    $this->form_validation->set_rules(
        'old_password', 'Old Password',
        'trim|required',
        array(
                'required'      => 'Please enter your old password'
        )
    );
    $this->form_validation->set_rules(
        'new_password', 'New Password',
        'trim|required',
        array(
                'required'      => 'Please enter your new password'
        )
    );
    $this->form_validation->set_rules(
        'confirm', 'Confirm Password',
        'trim|required',
        array(
                'required'      => 'Please confirm your new password'
        )
    );
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('account/security/index', $this->data);
    }
    else
    {
      $this->form_validation->set_rules(
          'old_password', 'Old Password',
          'callback_ValidateOldPassword',
          array()
      );
      $this->form_validation->set_rules(
          'confirm', 'Confirm Password',
          'matches[new_password]',
          array(
                  'matches'      => 'The new password does not match with confirm password'
          )
      );
      if ($this->form_validation->run() == FALSE)
      {
        $this->load->view('account/security/index', $this->data);
      }
      else
      {
        $Password = [
          'password' => md5($this->input->post('new_password'))
        ];
        if ($this->Accounts->update_password($Password,$this->user_id)) {
          redirect(base_url().'Account/security', 'refresh');
        }
      }
    }
  }

  public function ValidateOldPassword()
  {
    $old = $this->data['account']->password;
    if ($old !== md5($this->input->post('old_password')))
    {
      $this->form_validation->set_message('ValidateOldPassword', 'The old password you entered is incorrect');
      return false;
    }
    else
    {
      return true;
    }
  }

  public function details()
  {
    $this->load->view('account/details/index', $this->data);
  }

  public function update_email()
  {
    $this->form_validation->set_rules(
        'email', 'Email',
        'trim|callback_EmailExists',
        array()
    );
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('account/security/index', $this->data);
    }
    else
    {
      $Email = [
        'email' => $this->input->post('email')
      ];
      if ($this->Accounts->update_email($Email,$this->user_id)) {
        $this->session->unset_userdata('email');
        $this->session->set_userdata('email', $this->input->post('email'));
        redirect(base_url().'Account/security', 'refresh');
      }
    }
  }

  public function EmailExists()
  {
    $email = $this->input->post('email');
    $exists = $this->Accounts->EmailExists($email);

    if ($exists) {
        $this->form_validation->set_message('EmailExists', 'Email address is taken already.');
        return false;
    } else {
        return true;
    }
  }

  public function upload_profile_img()
  {
    if (!empty($this->input->post('file'))) {
      $path = 'uploads/'.$this->data['account']->username.'/';
      $croped_image = $_POST['image'];
       list($type, $croped_image) = explode(';', $croped_image);
       list(, $croped_image)      = explode(',', $croped_image);
       $croped_image = base64_decode($croped_image);
       $image_name = time().'.png';
       // upload cropped image to server
       file_put_contents($path.$image_name, $croped_image);
       $Profile = [
         'image' => base_url().'uploads'.'/'.$this->data['account']->username.'/'.$image_name
       ];
       if ($this->Accounts->save_profile($Profile,$this->user_id,$this->BusinessName)) {
         echo 'Profile image updated!';
       }
    }
    else {
      echo "Please select an image";
    }
  }

 public function upload_site_logo()
 {
   if (!empty($this->input->post('file'))) {
     $path = 'uploads/'.$this->data['account']->username.'/';
     $croped_image = $_POST['image'];
      list($type, $croped_image) = explode(';', $croped_image);
      list(, $croped_image)      = explode(',', $croped_image);
      $croped_image = base64_decode($croped_image);
      $image_name = time().'.png';
      // upload cropped image to server
      file_put_contents($path.$image_name, $croped_image);

      $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'site_logo'");

      if ($query->num_rows() > 0) //KAPAG MERON NAKITANG LOGO, IUUPDATE
      {
        $data['site_logo'] = $query->row();
        $Site_Logo = [
          'value' => base_url().$path.$image_name
        ];
        if ($this->Accounts->update_site_logo($Site_Logo,$this->user_id,$data['site_logo']->content_id))
        {
          echo "Logo updated!";
        }
      }
      else //KAPAG WALA II-INSERT YUNG LOGO
      {
        $Site_Logo = [
          'user_id' => $this->user_id,
          'id' => $this->id,
          'business_name' => $this->BusinessName,
          'meta_key' => 'site_logo',
          'content_title' => '',
          'description' => '',
          'value' => base_url().$path.$image_name
        ];

        if ($this->db->insert('contents',$Site_Logo))
        { //KAPAG NAINSERT YUNG LOGO
          echo "Logo successfully uploaded!";
        }
        else
        { //KAPAG DI NAUPDATE YUNG LOGO
          echo '<script>alert("Something went wrong...");</script>';
          // redirect('/Account/site_identity', 'refresh');
        }
      }
   }
   else {
     echo "Please select an image";
   }
 }


  public function logout()
  {
    if ($this->session->userdata('is_logged_in')) {
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
          $this->session->unset_userdata('business');
        }
        redirect(base_url().'Home');
  }
}
