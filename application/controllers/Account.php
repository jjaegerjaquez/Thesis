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
	}

  public function index()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Accounts->get_account_details($user_id);
    $data['business'] = $this->Accounts->get_business_template($user_id);
    $website = $data['account']->website;
    if ($website == 'Yes')
    {
      $data['business'] = $this->Accounts->get_business_details($user_id);
      $this->load->view('account/dashboard/index',$data);
    }
    else
    {
      $data['business'] = $this->Accounts->get_business_details($user_id);
      $theme = $data['business']->template;
      $this->load->view('account/themes/'.$theme.'/dashboard/index',$data);
    }
  }

  public function themes()
  {
    $data['themes'] = $this->Accounts->get_themes();
    $this->load->view('template/index',$data);
  }

  public function save_template()
  {
    $user_id = $_SESSION['user_id'];
    $data['business'] = $this->Accounts->get_business_details($user_id);
    $data['account'] = $this->Accounts->get_account_details($user_id);
    $template = $this->input->post('template');
    $Template = [
      'template' => $this->input->post('template')
    ];

    if ($this->Accounts->update_user_template($Template,$user_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
    {
      redirect('/Account', 'refresh');

    }
    else
    {
      echo '<script>alert("Something went wrong...");</script>';
      redirect('/Account/themes', 'refresh');
    }
  }

  public function dashboard()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Accounts->get_account_details($user_id);
    $business_details = $this->Accounts->get_business_details($user_id);
    if ($business_details) {
      // $data['business'] = $this->Accounts->get_business_details($user_id);
      // $this->load->view('account/dashboard/index',$data);
    }
    else {
      $data['business'] = 'NULL';
      $this->load->view('account/dashboard/index',$data);
    }

  }

  public function profile()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Accounts->get_account_details($user_id);
    $data['business'] = $this->Accounts->get_business_details($user_id);
    $data['localities'] = $this->Accounts->get_localities();
    $data['categories'] = $this->Accounts->get_categories();
    $theme = $data['business']->template;
    if ($data['account']->website == 'Yes')
    {
      $this->load->view('account/profile/index',$data);
    }
    else
    {
      $this->load->view('account/themes/'.$theme.'/profile/index',$data);
    }
  }

  public function save_profile()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Accounts->get_account_details($user_id);
    $data['business'] = $this->Accounts->get_business_details($user_id);
    $website = $data['account']->website;
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'category', 'Category',
        'required',
        array(
                'required'      => 'Please select your business category'
        )
    );
    $this->form_validation->set_rules(
        'city_province', 'City/Province',
        'required',
        array(
                'required'      => 'Please select a city or province'
        )
    );
    $this->form_validation->set_rules(
        'username', 'Username',
        'required|trim',
        array(
                'required'      => 'Please enter your username'
        )
    );
    $this->form_validation->set_rules(
        'business_name', 'Business Name',
        'required|trim',
        array(
                'required'      => 'Please enter your business name'
        )
    );
    $this->form_validation->set_rules(
        'address', 'Address',
        'required|trim',
        array(
                'required'      => 'Please enter your business address'
        )
    );
    $this->form_validation->set_rules(
        'cellphone_number', 'Cellphone Number',
        'required|trim|numeric',
        array(
                'required'      => 'Please enter your business cellphone number',
                'numeric'      => 'Please enter numeric characters only'
        )
    );
    $this->form_validation->set_rules(
        'telephone_number', 'Telephone Number',
        'required|trim|alpha_dash',
        array(
                'required'      => 'Please enter your business telephone number',
                'alpha_dash'      => 'Please enter alphanumeric characters and dash.'
        )
    );

    if ($website == 'Yes') {
      $this->form_validation->set_rules(
          'website_address', 'Website Address',
          'required|trim',
          array(
                  'required'      => 'Please enter your business website URL'
          )
      );
    }
    // END OF FORM VALIDATION
    if ($this->form_validation->run() == FALSE)
    {
      $user_id = $_SESSION['user_id'];
      $data['account'] = $this->Accounts->get_account_details($user_id);
      $data['business'] = $this->Accounts->get_business_details($user_id);
      $data['localities'] = $this->Accounts->get_localities();
      $data['categories'] = $this->Accounts->get_categories();
      $theme = $data['business']->template;
      if ($data['account']->website == 'Yes')
      {
        $this->load->view('account/profile/index',$data);
      }
      else
      {
        $this->load->view('account/themes/'.$theme.'/profile/index',$data);
      }
    }
    else
    {
      if ($website == 'Yes')
      { //Kapag may website kukunin yung laman ng website na input
        // If may laman na image
        if(!empty($_FILES['picture']['name'])){
            $config['upload_path'] = 'uploads/images/';
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
                  'user_id' => $user_id,
                  'username' => $this->input->post('username'),
                  'business_name' => $this->input->post('business_name'),
                  'category' => $this->input->post('category'),
                  'locality' => $this->input->post('city_province'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone_number'),
                  'telephone' => $this->input->post('telephone_number'),
                  'website_url' => $this->input->post('website_address'),
                  'image' => $picture
                ];

                $this->Accounts->save_profile($Business_Details,$user_id);
                echo '<script>alert("Profile updated!");</script>';
                redirect('/Account', 'refresh');
            }else{
              $Business_Details = [
                'user_id' => $user_id,
                'username' => $this->input->post('username'),
                'business_name' => $this->input->post('business_name'),
                'category' => $this->input->post('category'),
                'locality' => $this->input->post('city_province'),
                'address' => $this->input->post('address'),
                'cellphone' => $this->input->post('cellphone_number'),
                'telephone' => $this->input->post('telephone_number'),
                'website_url' => $this->input->post('website_address'),
                'image' => 'default-img.jpg'
              ];

              $this->Accounts->save_profile($Business_Details,$user_id);
              echo '<script>alert("Profile updated!");</script>';
              redirect('/Account', 'refresh');
            }
        } //END NG KAPAG MAY LAMAN NA IMAGE
        else //KAPAG WALANG LAMAN NA IMAGE
        {
          $Business_Details = [
            'user_id' => $user_id,
            'username' => $this->input->post('username'),
            'business_name' => $this->input->post('business_name'),
            'category' => $this->input->post('category'),
            'locality' => $this->input->post('city_province'),
            'address' => $this->input->post('address'),
            'cellphone' => $this->input->post('cellphone_number'),
            'telephone' => $this->input->post('telephone_number'),
            'website_url' => $this->input->post('website_address')
          ];
          $this->Accounts->save_profile($Business_Details,$user_id);
          echo '<script>alert("Profile updated!");</script>';
          redirect('/Account', 'refresh');
        }
      }
      else //Kapag walang website lalagyan ng NA yung website URL sa db
      {
        // If may laman na image
        if(!empty($_FILES['picture']['name'])){
            $config['upload_path'] = 'uploads/images/';
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
                  'user_id' => $user_id,
                  'username' => $this->input->post('username'),
                  'business_name' => $this->input->post('business_name'),
                  'category' => $this->input->post('category'),
                  'locality' => $this->input->post('city_province'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone_number'),
                  'telephone' => $this->input->post('telephone_number'),
                  'website_url' => 'NA',
                  'image' => $picture
                ];

                $this->Accounts->save_profile($Business_Details,$user_id);
                echo '<script>alert("Profile updated!");</script>';
                redirect('/Account', 'refresh');
            }else{
              $Business_Details = [
                'user_id' => $user_id,
                'username' => $this->input->post('username'),
                'business_name' => $this->input->post('business_name'),
                'category' => $this->input->post('category'),
                'locality' => $this->input->post('city_province'),
                'address' => $this->input->post('address'),
                'cellphone' => $this->input->post('cellphone_number'),
                'telephone' => $this->input->post('telephone_number'),
                'website_url' => 'NA',
                'image' => 'default-img.jpg'
              ];

              $this->Accounts->save_profile($Business_Details,$user_id);
              echo '<script>alert("Profile updated!");</script>';
              redirect('/Account', 'refresh');
            }
        } //END NG KAPAG MAY LAMAN NA IMAGE
        else //KAPAG WALANG LAMAN NA IMAGE
        {
          $Business_Details = [
            'user_id' => $user_id,
            'username' => $this->input->post('username'),
            'business_name' => $this->input->post('business_name'),
            'category' => $this->input->post('category'),
            'locality' => $this->input->post('city_province'),
            'address' => $this->input->post('address'),
            'cellphone' => $this->input->post('cellphone_number'),
            'telephone' => $this->input->post('telephone_number'),
            'website_url' => 'NA'
          ];
          $this->Accounts->save_profile($Business_Details,$user_id);
          echo '<script>alert("Profile updated!");</script>';
          redirect('/Account', 'refresh');
        }
      }
    }
  }

  public function site_identity()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Accounts->get_account_details($user_id);
    $data['business'] = $this->Accounts->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['site_title'] = $this->Accounts->get_site_title($user_id);
    $data['site_tagline'] = $this->Accounts->get_site_tagline($user_id);
    $data['site_logo'] = $this->Accounts->get_site_logo($user_id);
    $this->load->view('account/themes/'.$theme.'/site_identity/index',$data);
  }

  public function save_site_identity()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Accounts->get_account_details($user_id);
    $data['business'] = $this->Accounts->get_business_details($user_id);
    $theme = $data['business']->template;

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
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'site_logo'");

        if ($query->num_rows() > 0)
        {
          $data['site_logo'] = $query->row();
          $config['upload_path'] = 'uploads/themes/'.$theme;
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
                'value' => $picture
              ];

              if ($this->Accounts->update_site_logo($Site_Logo,$user_id,$data['site_logo']->content_id))
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
          $config['upload_path'] = 'uploads/themes/'.$theme;
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
                'user_id' => $user_id,
                'meta_key' => 'site_logo',
                'content_title' => '',
                'description' => '',
                'value' => $picture
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

        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'site_title'");
        if ($query->num_rows() > 0) {
          $data['site_title'] = $this->Accounts->get_site_title($user_id);
          $Site_Title = [
            'value' => $this->input->post('site_title')
          ];
          if ($this->Accounts->update_site_title($Site_Title,$user_id,$data['site_title']->content_id)) {
            // redirect('/Account/site_identity', 'refresh');
          }

        }else {

          $Site_Title = [
            'user_id' => $user_id,
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

        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'site_tagline'");
        if ($query->num_rows() > 0) {

          $data['site_tagline'] = $this->Accounts->get_site_tagline($user_id);
          $Site_Tagline = [
            'value' => $this->input->post('site_tagline')
          ];
          if ($this->Accounts->update_site_tagline($Site_Tagline,$user_id,$data['site_tagline']->content_id)) {
            // redirect('/Account/site_identity', 'refresh');
          }
        }else {

          $Site_Tagline = [
            'user_id' => $user_id,
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
