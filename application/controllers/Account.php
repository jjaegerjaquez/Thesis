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
          redirect('/Home');
        }
    }
    else
    {
      $this->user_id = $_SESSION['user_id'];
      $this->data['business_name'] = $_SESSION['business'];
      $this->BusinessName = $_SESSION['business'];
      $this->data['account'] = $this->Accounts->get_account_details($this->user_id);
      $this->data['details'] = $this->Accounts->get_business_template($this->user_id,$this->BusinessName);
      $this->id = $this->data['details']->id;
      $this->data['theme'] = $this->Accounts->get_theme($this->data['business_name']);
      $this->data['businesses'] = $this->Accounts->get_businesses($this->user_id);
      $this->data['localities'] = $this->Accounts->get_localities();
      $this->data['categories'] = $this->Accounts->get_categories();
      $this->data['themes'] = $this->Accounts->get_themes();
    }
	}

  public function index()
  {
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

  public function switch()
  {
    $this->session->unset_userdata('business');
    $this->session->set_userdata('business', $this->input->get('business'));
    redirect('/Account', 'refresh');
  }

  public function start()
  {
    $this->load->view('start/index');
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
          redirect('/Account', 'refresh');
        }
        else
        {
          echo '<script>alert("Something went wrong, logging you out..");</script>';
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
          $this->session->unset_userdata('business');
          $this->session->unset_userdata('primary_website');
          redirect('/Home');
        }
      }
      else
      {
        $this->session->set_userdata('primary_business_name', $this->input->post('business_name'));
        redirect('/Account/themes', 'refresh');
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
      redirect('/Account', 'refresh');
    }
    else
    {
      echo '<script>alert("Something went wrong, logging you out..");</script>';
      $this->session->unset_userdata('email');
      $this->session->unset_userdata('is_logged_in');
      $this->session->unset_userdata('user_id');
      $this->session->unset_userdata('business');
      $this->session->unset_userdata('primary_website');
      redirect('/Home');
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
    $this->form_validation->set_rules(
        'business_name', 'Business Name',
        'trim|required|callback_BusinessNameExists',
        array(
                'required'      => 'Please enter your business name'
        )
    );
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
        'telephone_number', 'Telephone Number',
        'trim|required|alpha_dash',
        array(
                'required'      => 'Please enter your business telephone number',
                'alpha_dash'      => 'Please enter alphanumeric characters and dash.'
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
        // If may laman na image
        if(!empty($_FILES['picture']['name']))
        {
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id' and business_name = '$this->BusinessName'");
          if ($query->num_rows() > 0)
          {
            $config['upload_path'] = 'uploads/'.$this->data['account']->username;
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Business_Details = [
                  'user_id' => $this->user_id,
                  'username' => $this->data['account']->username,
                  'business_name' => $this->input->post('business_name'),
                  'category' => $this->input->post('category'),
                  'locality' => $this->input->post('city_province'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone_number'),
                  'telephone' => $this->input->post('telephone_number'),
                  'contact_person' => $this->input->post('contact_person'),
                  'website_url' => $this->input->post('website_address'),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->Accounts->save_profile($Business_Details,$this->user_id,$this->BusinessName)) {
                  $this->session->unset_userdata('business');
                  $this->session->set_userdata('business', $this->input->post('business_name'));
                  redirect('/Account/profile', 'refresh');
                }
            }
          }
          else
          {
            $config['upload_path'] = 'uploads/'.$this->data['account']->username;
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Business_Details = [
                  'user_id' => $this->user_id,
                  'username' => $this->data['account']->username,
                  'business_name' => $this->input->post('business_name'),
                  'category' => $this->input->post('category'),
                  'locality' => $this->input->post('city_province'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone_number'),
                  'telephone' => $this->input->post('telephone_number'),
                  'contact_person' => $this->input->post('contact_person'),
                  'website_url' => $this->input->post('website_address'),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->db->insert('basic_info', $Business_Details)) {
                  $this->session->unset_userdata('business');
                  $this->session->set_userdata('business', $this->input->post('business_name'));
                  redirect('/Account/profile', 'refresh');
                }
            }
          }
        } //END NG KAPAG MAY LAMAN NA IMAGE
        else //KAPAG WALANG LAMAN NA IMAGE
        {
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id' and business_name = '$this->BusinessName'");
          if ($query->num_rows() > 0)
          {
            $Business_Details = [
              'user_id' => $this->user_id,
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
              redirect('/Account/profile', 'refresh');
            }
          }
          else
          {
            $Business_Details = [
              'user_id' => $this->user_id,
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
            if ($this->db->insert('basic_info', $Business_Details)) {
              $this->session->unset_userdata('business');
              $this->session->set_userdata('business', $this->input->post('business_name'));
              redirect('/Account/profile', 'refresh');
            }
          }
        }
      }
      else //Kapag walang website lalagyan ng NA yung website URL sa db
      {
        if(!empty($_FILES['picture']['name']))
        {
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id' and business_name = '$this->BusinessName'");
          if ($query->num_rows() > 0)
          {
            $config['upload_path'] = 'uploads/'.$this->data['account']->username;
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Business_Details = [
                  'user_id' => $this->user_id,
                  'username' => $this->data['account']->username,
                  'business_name' => $this->input->post('business_name'),
                  'category' => $this->input->post('category'),
                  'locality' => $this->input->post('city_province'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone_number'),
                  'telephone' => $this->input->post('telephone_number'),
                  'contact_person' => $this->input->post('contact_person'),
                  'website_url' => base_url().'View/home/'.str_replace(' ', '_', $this->input->post('business_name')),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->Accounts->save_profile($Business_Details,$this->user_id,$this->BusinessName)) {
                  $this->session->unset_userdata('business');
                  $this->session->set_userdata('business', $this->input->post('business_name'));
                  redirect('/Account/profile', 'refresh');
                }
            }
          }
          else
          {
            $config['upload_path'] = 'uploads/'.$this->data['account']->username;
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Business_Details = [
                  'user_id' => $this->user_id,
                  'username' => $this->data['account']->username,
                  'business_name' => $this->input->post('business_name'),
                  'category' => $this->input->post('category'),
                  'locality' => $this->input->post('city_province'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone_number'),
                  'telephone' => $this->input->post('telephone_number'),
                  'contact_person' => $this->input->post('contact_person'),
                  'website_url' => base_url().'View/home/'.str_replace(' ', '_', $this->input->post('business_name')),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->db->insert('basic_info', $Business_Details)) {
                  $this->session->unset_userdata('business');
                  $this->session->set_userdata('business', $this->input->post('business_name'));
                  redirect('/Account/profile', 'refresh');
                }
            }
          }
        } //END NG KAPAG MAY LAMAN NA IMAGE
        else //KAPAG WALANG LAMAN NA IMAGE
        {
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id' and business_name = '$this->BusinessName'");
          if ($query->num_rows() > 0)
          {
            $Business_Details = [
              'user_id' => $this->user_id,
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
              redirect('/Account/profile', 'refresh');
            }
          }
          else
          {
            $Business_Details = [
              'user_id' => $this->user_id,
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
            if ($this->db->insert('basic_info', $Business_Details)) {
              $this->session->unset_userdata('business');
              $this->session->set_userdata('business', $this->input->post('business_name'));
              redirect('/Account/profile', 'refresh');
            }
          }
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
      if(!empty($_FILES['logo']['name'])) //If may laman na image
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'site_logo'");

        if ($query->num_rows() > 0)
        {
          $data['site_logo'] = $query->row();
          $config['upload_path'] = 'uploads/'.$this->data['account']->username;
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['logo']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('logo')){ // Kapag successful ang pag-upload ng image
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Site_Logo = [
                'value' => '/'.$config['upload_path'].'/'.$picture
              ];

              if ($this->Accounts->update_site_logo($Site_Logo,$this->user_id,$data['site_logo']->content_id))
              { //KAPAG NAUPDATE YUNG LOGO

              }
              else
              { //KAPAG DI NAUPDATE YUNG LOGO
                echo '<script>alert("Something went wrong...");</script>';
                // redirect('/Account/site_identity', 'refresh');
              }

          }// END ng kapag SUCCESSFUL na NAGUPLOAD ANG IMAGE
          else //KAPAG DI NAGUPLOAD YUNG IMAGE
          {
            echo '<script>alert("Something went wrong...");</script>';
            // redirect('/Account/site_identity', 'refresh');
          }
        }
        else //Kapag wala pa siyang nauupload na logo
        {
          $config['upload_path'] = 'uploads/'.$this->data['account']->username;
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['logo']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('logo')){ // Kapag successful ang pag-upload ng image
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Site_Logo = [
                'user_id' => $this->user_id,
                'id' => $this->id,
                'business_name' => $this->BusinessName,
                'meta_key' => 'site_logo',
                'content_title' => '',
                'description' => '',
                'value' => '/'.$config['upload_path'].'/'.$picture
              ];

              if ($this->db->insert('contents',$Site_Logo))
              { //KAPAG NAINSERT YUNG LOGO

              }
              else
              { //KAPAG DI NAUPDATE YUNG LOGO
                echo '<script>alert("Something went wrong...");</script>';
                // redirect('/Account/site_identity', 'refresh');
              }

          }// END ng kapag SUCCESSFUL na NAGUPLOAD ANG IMAGE
          else //KAPAG DI NAGUPLOAD YUNG IMAGE
          {
            echo '<script>alert("Something went wrong...");</script>';
            // redirect('/Account/site_identity', 'refresh');
          }
        }

      } //END NG KAPAG MAY LAMAN YUNG FILE //

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
      redirect('/Account/site_identity', 'refresh');
    }
  }

  public function new()
  {
    $this->load->view('account/new/step1/index');
  }

  public function save_step_one()
  {
    $status = $this->input->post('select');
    if ($status == 'Yes') {
      $this->session->set_userdata('secondary_website', 'Yes');
      redirect('/Account/step_two', 'refresh');
    }
    elseif ($status == 'No') {
      $this->session->set_userdata('secondary_website', 'No');
      redirect('/Account/step_two', 'refresh');
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
          redirect('/Account', 'refresh');
        }
        else
        {
          echo '<script>alert("Something went wrong");</script>';
          $this->session->unset_userdata('secondary_website');
          redirect('/Account', 'refresh');
        }
      }
      else
      {
        $this->session->set_userdata('secondary_business_name', $this->input->post('business_name'));
        redirect('/Account/step_three', 'refresh');
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
      redirect('/Account', 'refresh');
    }
    else
    {
      echo '<script>alert("Something went wrong..");</script>';
      $this->session->unset_userdata('secondary_website');
      $this->session->unset_userdata('secondary_business_name');
      redirect('/Account');
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
        redirect('/Home');
  }
}
