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
      $this->data['vote_count'] = $this->Accounts->get_vote_count($this->id);
      $this->data['review_count'] = $this->Accounts->get_review_count($this->id);
      $this->data['rating'] = $this->Accounts->get_rate($this->id);
      $this->data['reviews'] = $this->Accounts->get_reviews($this->id);
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

  public function crop_url()
  {
    $imgUrl = $_POST['imgUrl'];
      // original sizes
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
          // resized sizes
        $imgW = $_POST['imgW'];
        $imgH = $_POST['imgH'];
          // offsets
        $imgY1 = $_POST['imgY1'];
        $imgX1 = $_POST['imgX1'];
          // crop box
        $cropW = $_POST['cropW'];
        $cropH = $_POST['cropH'];
          // rotation angle
        $angle = $_POST['rotation'];

    $jpeg_quality = 100;

    // uploads/'.$this->data['account']->username
     $output_filename = base_url()."/"."uploads/".$this->data['account']->username."/croppedImg_".rand();
    // $output_filename = dirname($imgUrl). "/croppedImg_".rand();

    $what = getimagesize($imgUrl);

    switch(strtolower($what['mime']))
    {
        case 'image/png':
        $img_r = imagecreatefrompng($imgUrl);
        $source_image = imagecreatefrompng($imgUrl);
        $type = '.png';
        break;
        case 'image/jpeg':
        $img_r = imagecreatefromjpeg($imgUrl);
        $source_image = imagecreatefromjpeg($imgUrl);
        error_log("jpg");
        $type = '.jpeg';
        break;
        case 'image/gif':
        $img_r = imagecreatefromgif($imgUrl);
        $source_image = imagecreatefromgif($imgUrl);
        $type = '.gif';
        break;
        default: die('image type not supported');
    }

    if(!is_writable(dirname($output_filename))){
        $response = Array(
            "status" => 'error',
            "message" => 'Can`t write cropped File'
            );
    }else{

// resize the original image to size of editor
        $resizedImage = imagecreatetruecolor($imgW, $imgH);
        imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
// rotate the rezized image
        $rotated_image = imagerotate($resizedImage, -$angle, 0);
// find new width & height of rotated image
        $rotated_width = imagesx($rotated_image);
        $rotated_height = imagesy($rotated_image);
// diff between rotated & original sizes
        $dx = $rotated_width - $imgW;
        $dy = $rotated_height - $imgH;
// crop rotated image to fit into original rezized rectangle
        $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
        imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
        imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
// crop image into selected area
        $final_image = imagecreatetruecolor($cropW, $cropH);
        imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
        imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
// finally output png image
//imagepng($final_image, $output_filename.$type, $png_quality);
        // imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
        // $response = Array(
        // "status" => 'success',
        // "url" => base_url(). $output_filename.$type );
        // $output=str_replace('uploads/'.$this->data['account']->username.'/', '', $output_filename);
        // $file=array(
        // 'image'=>$output,
        // );
        // $this->Accounts->store_logo($file,$this->id);

        // imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
        // $response = Array(
        // "status" => 'success',
        // "url" => base_url(). $output_filename.$type );
        // $output=str_replace('temp/', '', $output_filename);
        // $file=array(
        // 'image'=>$output,
        // );
        // $this->Accounts->store_logo($file,$this->id);
        imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
          $response = Array(
              "status" => 'success',
              "url" => base_url(). $output_filename.$type
        );
    }
    print json_encode($response);
  }

  public function image_upload()
  {
    $imagePath =  "uploads/".$this->data['account']->username."/";


    $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
    $temp = explode(".", $_FILES["img"]["name"]);
    $extension = end($temp);

        //Check write Access to Directory

    if(!is_writable($imagePath)){
        $response = Array(
            "status" => 'error',
            "message" =>  $imagePath
            );
        print json_encode($response);
        return;
    }

    if ( in_array($extension, $allowedExts))
    {
        if ($_FILES["img"]["error"] > 0)
        {
            $response = array(
                "status" => 'error',
                "message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
                );
        }
        else
        {

            $filename = $_FILES["img"]["tmp_name"];
            list($width, $height) = getimagesize( $filename );

            move_uploaded_file($filename,  $imagePath . $_FILES["img"]["name"]);

            $response = array(
                "status" => 'success',
                "url" => base_url(). $imagePath.$_FILES["img"]["name"],
                "width" => $width,
                "height" => $height
                );

        }
    }
    else
    {
        $response = array(
            "status" => 'error',
            "message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
            );
    }

    print json_encode($response);
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
