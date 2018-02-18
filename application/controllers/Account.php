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
      $this->data['account'] = $this->Accounts->get_account_details($this->user_id);
      $this->data['business'] = $this->Accounts->get_business_template($this->user_id);
      $this->data['localities'] = $this->Accounts->get_localities();
      $this->data['categories'] = $this->Accounts->get_categories();
    }
	}

  public function index()
  {
    // $user_id = $_SESSION['user_id'];
    // $data['account'] = $this->Accounts->get_account_details($user_id);
    // $data['business'] = $this->Accounts->get_business_template($user_id);
    $website = $this->data['account']->website;
    if ($website == 'Yes')
    {
      // $data['business'] = $this->Accounts->get_business_details($user_id);
      $this->load->view('account/dashboard/index',$this->data);
    }
    else
    {
      // echo $this->data['business']->image;
      // $data['business'] = $this->Accounts->get_business_details($user_id);
      $theme = $this->data['account']->template;
      $this->load->view('account/themes/'.$theme.'/dashboard/index',$this->data);
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
    $Template = [
      'template' => $this->input->post('template')
    ];

    if ($this->Accounts->update_user_template($Template,$this->user_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
    {
      redirect('/Account', 'refresh');

    }
    else
    {
      echo '<script>alert("Something went wrong...");</script>';
      redirect('/Account/themes', 'refresh');
    }
  }

  public function profile()
  {
    if ($this->data['account']->website == 'Yes')
    {
      $this->load->view('account/profile/index',$this->data);
    }
    else
    {
      $theme = $this->data['account']->template;
      $this->load->view('account/themes/'.$theme.'/profile/index',$this->data);
    }
  }

  public function save_profile()
  {
    $website = $this->data['account']->website;
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
        'trim|required',
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
      if ($this->data['account']->website == 'Yes')
      {
        $this->load->view('account/profile/index',$this->data);
      }
      else
      {
        $theme = $this->data['account']->template;
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
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id'");
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
                  'website_url' => $this->input->post('website_address'),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->Accounts->save_profile($Business_Details,$this->user_id)) {
                  // redirect('/Account/home', 'refresh');
                  redirect('/Account/profile', 'refresh');
                }
                // $this->Accounts->save_profile($Business_Details,$this->user_id);
                // echo '<script>alert("Profile updated!");</script>';
                // redirect('/Account/profile', 'refresh');
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
                  'website_url' => $this->input->post('website_address'),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->db->insert('basic_info', $Business_Details)) {
                  // redirect('/Account/home', 'refresh');
                  redirect('/Account/profile', 'refresh');
                }
                // $this->Accounts->save_profile($Business_Details,$this->user_id);
                // echo '<script>alert("Profile updated!");</script>';
                // redirect('/Account/profile', 'refresh');
            }
          }
        } //END NG KAPAG MAY LAMAN NA IMAGE
        else //KAPAG WALANG LAMAN NA IMAGE
        {
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id'");
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
              'website_url' => $this->input->post('website_address')
            ];
            if ($this->Accounts->save_profile($Business_Details,$this->user_id)) {
              // redirect('/Account/home', 'refresh');
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
              'website_url' => $this->input->post('website_address')
            ];
            if ($this->db->insert('basic_info', $Business_Details)) {
              // redirect('/Account/home', 'refresh');
              redirect('/Account/profile', 'refresh');
            }
          }
        }
      }
      else //Kapag walang website lalagyan ng NA yung website URL sa db
      {
        if(!empty($_FILES['picture']['name']))
        {
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id'");
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
                  'website_url' => base_url().'View/home/'.$this->data['account']->username,
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->Accounts->save_profile($Business_Details,$this->user_id)) {
                  // redirect('/Account/home', 'refresh');
                  redirect('/Account/profile', 'refresh');
                }
                // $this->Accounts->save_profile($Business_Details,$this->user_id);
                // echo '<script>alert("Profile updated!");</script>';
                // redirect('/Account/profile', 'refresh');
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
                  'website_url' => base_url().'View/home/'.$this->data['account']->username,
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->db->insert('basic_info', $Business_Details)) {
                  // redirect('/Account/home', 'refresh');
                  redirect('/Account/profile', 'refresh');
                }
                // $this->Accounts->save_profile($Business_Details,$this->user_id);
                // echo '<script>alert("Profile updated!");</script>';
                // redirect('/Account/profile', 'refresh');
            }
          }
        } //END NG KAPAG MAY LAMAN NA IMAGE
        else //KAPAG WALANG LAMAN NA IMAGE
        {
          $query = $this->db->query("select * from basic_info where user_id = '$this->user_id'");
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
              'website_url' => base_url().'View/home/'.$this->data['account']->username
            ];
            if ($this->Accounts->save_profile($Business_Details,$this->user_id)) {
              // redirect('/Account/home', 'refresh');
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
              'website_url' => base_url().'View/home/'.$this->data['account']->username
            ];
            if ($this->db->insert('basic_info', $Business_Details)) {
              // redirect('/Account/home', 'refresh');
              redirect('/Account/profile', 'refresh');
            }
          }
        }
      }
    }
  }

  public function site_identity()
  {
    $theme = $this->data['account']->template;
    $this->data['site_title'] = $this->Accounts->get_site_title($this->user_id);
    $this->data['site_tagline'] = $this->Accounts->get_site_tagline($this->user_id);
    $this->data['site_logo'] = $this->Accounts->get_site_logo($this->user_id);
    $this->load->view('account/themes/'.$theme.'/site_identity/index',$this->data);
  }

  public function save_site_identity()
  {
    $theme = $this->data['account']->template;

    $count = count($this->input->post('value'));

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

    if ($this->form_validation->run() == TRUE)
    {
      if(!empty($_FILES['logo']['name'])) //If may laman na image
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and meta_key = 'site_logo'");

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

        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and meta_key = 'site_title'");
        if ($query->num_rows() > 0) {
          $data['site_title'] = $this->Accounts->get_site_title($this->user_id);
          $Site_Title = [
            'value' => $this->input->post('site_title')
          ];
          if ($this->Accounts->update_site_title($Site_Title,$this->user_id,$data['site_title']->content_id)) {
            // redirect('/Account/site_identity', 'refresh');
          }

        }else {

          $Site_Title = [
            'user_id' => $this->user_id,
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

        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and meta_key = 'site_tagline'");
        if ($query->num_rows() > 0) {

          $data['site_tagline'] = $this->Accounts->get_site_tagline($this->user_id);
          $Site_Tagline = [
            'value' => $this->input->post('site_tagline')
          ];
          if ($this->Accounts->update_site_tagline($Site_Tagline,$this->user_id,$data['site_tagline']->content_id)) {
            // redirect('/Account/site_identity', 'refresh');
          }
        }else {

          $Site_Tagline = [
            'user_id' => $this->user_id,
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

  public function logout()
  {
    if ($this->session->userdata('is_logged_in')) {
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
        }
        redirect('/Home');
  }
}
