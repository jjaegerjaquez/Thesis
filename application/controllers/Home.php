<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Home extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Homes');

    $this->data['categories'] = $this->Homes->get_categories();
    $this->data['title'] = $this->Homes->get_title();
    $this->data['tagline'] = $this->Homes->get_tagline();
    $this->data['facebook'] = $this->Homes->get_facebook();
    $this->data['instagram'] = $this->Homes->get_instagram();
    $this->data['twitter'] = $this->Homes->get_twitter();
    $this->data['google'] = $this->Homes->get_google();
    $this->data['title'] = $this->Homes->get_title();
    $this->data['tagline'] = $this->Homes->get_tagline();
    $this->data['title'] = $this->Homes->get_title();
    $this->data['tagline'] = $this->Homes->get_tagline();
    $this->data['localities'] = $this->Homes->get_localities();
    $this->data['priority_ads'] = $this->Homes->get_priority_ad();
    if (!$this->session->userdata('is_logged_in') && !$this->session->userdata('traveller_is_logged_in'))
    {
      $allowed = array(
            'index',
            'login',
            'register',
            'logout',
            'vote'
        );
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
          redirect('/Home');
        }
    }
    // if (!$this->session->userdata('traveller_is_logged_in'))
    // {
    //   $allowed = array(
    //         'index',
    //         'login',
    //         'register',
    //         'logout'
    //     );
    //     if ( ! in_array($this->router->fetch_method(), $allowed))
    //     {
    //       redirect('/Home');
    //     }
    // }
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Homes->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Homes->get_traveller_profile($this->traveller_id);
    }
	}

  public function index()
  {
    // $this->session->unset_userdata('traveller_email');
    // $this->session->unset_userdata('traveller_is_logged_in');
    // $this->session->unset_userdata('traveller_id');
    $count = 0;
    foreach ($this->data['localities'] as $key => $result) {
      $count++;
    }

    for ($i=0; $i <$count ; $i++) {
      $this->data['counts'][$i] = $this->Homes->get_counts($this->data['localities'][$i]->locality);
    }

    $this->data['ctr']=$count;

    if ($this->session->userdata('is_logged_in'))
    {
      $email = $_SESSION['email'];
      $this->data['account'] = $this->Homes->validate_email($email);
      $set_up = $data['account']->set_up;
      if ($set_up == '0')
        {
          redirect('/Home/set_up');
        }else {
          redirect('/Home/redirect');
        }
    }
    // elseif ($this->session->userdata('traveller_is_logged_in'))
    // {
    //   $this->load->view('home/index',$this->data);
    // }
    // else
    // {
    //   $this->load->view('home/index',$this->data);
    // }
    $this->load->view('home/index',$this->data);
  }

  public function register()
  {
    // $email = $this->input->post('register_email');
    // $password = $this->input->post('register_password');
    // $confirm_password = $this->input->post('register_confirm_password');
    $type = $this->input->post('type');
    if ($type == 'Supplier')
    {
      $this->form_validation->set_rules(
          'register_email', 'Email',
          'trim|required',
          array(
                  'required'      => 'Please enter your email'
          )
      );
      $this->form_validation->set_rules(
          'username', 'Username',
          'trim|required',
          array(
                  'required'      => 'Please enter your username'
          )
      );
      $this->form_validation->set_rules(
          'register_password', 'Password',
          'trim|required',
          array(
                  'required'      => 'Please enter your password'
          )
      );
      $this->form_validation->set_rules(
          'register_confirm_password', 'Confirm Password',
          'trim|required',
          array(
                  'required'      => 'Please enter your email'
          )
      );
      // $this->form_validation->set_rules('register_email', 'Email', 'trim|required');
      // $this->form_validation->set_rules('register_password', 'Password', 'trim|required');
      // $this->form_validation->set_rules('register_confirm_password', 'Confrim Password', 'trim|required');
      if ($this->form_validation->run() == FALSE)
      {
        echo validation_errors();
      }
      else
      {
        $this->form_validation->set_rules('register_email', 'Email', 'valid_email');
        if ($this->form_validation->run() == FALSE)
        {
          echo "Please enter a valid email";
        }
        else
        {
          $this->form_validation->set_rules('email', 'Email', 'callback_EmailExists');
          if ($this->form_validation->run() == FALSE)
          {
            echo validation_errors();
          }
          else
          {
            // $this->form_validation->set_rules('username', 'Username', 'alpha_numeric|callback_UsernameExists');
            $this->form_validation->set_rules(
                'username', 'Username',
                'alpha_numeric|callback_UsernameExists|trim',
                array(
                        'alpha_numeric'      => 'Space is not allowed.'
                )
            );
            if ($this->form_validation->run() == FALSE)
            {
              echo validation_errors();
            }
            else
            {
              $this->form_validation->set_rules('register_confirm_password', 'Confrim Password', 'matches[register_password]');
              if ($this->form_validation->run() == FALSE)
              {
                echo "Passwords do not matched";
              }
              else
              {
                $RegisterData = array(
                  'email' => $this->input->post('register_email'),
                  'username' => $this->input->post('username'),
                  'password' => md5($this->input->post('register_password')),
                  'date_joined' => date("Y-m-d"),
                  'website' => 'No',
                  'set_up' => '0',
                  'status' => '1',
                  'type' => $this->input->post('type')
                );
                $email = $this->input->post('register_email');
                $code = md5($email);
                // $this->sendemail($email,$code);
                if ($this->db->insert('users',$RegisterData))
                {
                  // $data['email_details'] = $this->Homes->get_email($email);
                  // $Business_Data = array(
                  //   'user_id' => $data['email_details']->user_id,
                  //   'username' => $this->input->post('username'),
                  //   'business_name' => '',
                  //   'category' => '',
                  //   'locality' => '',
                  //   'address' => '',
                  //   'cellphone' => '',
                  //   'telephone' => '',
                  //   'website_url' => '',
                  //   'template' => '0',
                  //   'image' => ''
                  // );
                  chmod('./uploads/', 0777);
                  $path   = './uploads/'.$this->input->post('username');
                  if (!is_dir($path)) { //create the folder if it's not already exists
                      mkdir($path, 0755, TRUE);
                  }
                  echo "Successful";
                  // // if ($this->db->insert('basic_info',$Business_Data)) {
                  // //   chmod('./uploads/', 0777);
                  // //   $path   = './uploads/'.$this->input->post('username');
                  // //   if (!is_dir($path)) { //create the folder if it's not already exists
                  // //       mkdir($path, 0755, TRUE);
                  // //   }
                  // //   echo "Successful";
                  // }else {
                  //   $this->db->where('user_id', $data['email_details']->user_id);
                  //   $this->db->delete('users');
                  //   echo "Unsucessful";
                  // }
                }
                else
                {
                  echo "Unsucessful";
                }
                // if($this->Registers->sendemail($email,$code))
                // {
                //   $this->db->insert('users',$RegisterData);
                //   echo "Successful";
                // }
                // else
                // {
                //   echo "Unsucessful";
                // }
              }
            }
          }
        }
      }
    }
    elseif ($type == 'Traveller')
    {
      $this->form_validation->set_rules(
          'register_email', 'Email',
          'trim|required',
          array(
                  'required'      => 'Please enter your email'
          )
      );
      $this->form_validation->set_rules(
          'username', 'Username',
          'trim|required',
          array(
                  'required'      => 'Please enter your username'
          )
      );
      $this->form_validation->set_rules(
          'register_password', 'Password',
          'trim|required',
          array(
                  'required'      => 'Please enter your password'
          )
      );
      $this->form_validation->set_rules(
          'register_confirm_password', 'Confirm Password',
          'trim|required',
          array(
                  'required'      => 'Please enter your email'
          )
      );
      // $this->form_validation->set_rules('register_email', 'Email', 'trim|required');
      // $this->form_validation->set_rules('register_password', 'Password', 'trim|required');
      // $this->form_validation->set_rules('register_confirm_password', 'Confrim Password', 'trim|required');
      if ($this->form_validation->run() == FALSE)
      {
        echo validation_errors();
      }
      else
      {
        $this->form_validation->set_rules('register_email', 'Email', 'valid_email');
        if ($this->form_validation->run() == FALSE)
        {
          echo "Please enter a valid email";
        }
        else
        {
          $this->form_validation->set_rules('register_email', 'Email', 'callback_EmailExists');
          if ($this->form_validation->run() == FALSE)
          {
            echo validation_errors();
          }
          else
          {
            // $this->form_validation->set_rules('username', 'Username', 'alpha_numeric|callback_UsernameExists');
            $this->form_validation->set_rules(
                'username', 'Username',
                'alpha_numeric|callback_UsernameExists|trim',
                array(
                        'alpha_numeric'      => 'Space is not allowed.'
                )
            );
            if ($this->form_validation->run() == FALSE)
            {
              echo validation_errors();
            }
            else
            {
              $this->form_validation->set_rules('register_confirm_password', 'Confrim Password', 'matches[register_password]');
              if ($this->form_validation->run() == FALSE)
              {
                echo "Passwords do not matched";
              }
              else
              {
                $RegisterData = array(
                  'email' => $this->input->post('register_email'),
                  'username' => $this->input->post('username'),
                  'password' => md5($this->input->post('register_password')),
                  'date_joined' => date("Y-m-d"),
                  'website' => 'NA',
                  'template' => 'NA',
                  'set_up' => '1',
                  'status' => '1',
                  'type' => $this->input->post('type')
                );
                $email = $this->input->post('register_email');
                $code = md5($email);
                // $this->sendemail($email,$code);
                if ($this->db->insert('users',$RegisterData))
                {
                  // $data['email_details'] = $this->Homes->get_email($email);
                  // $Business_Data = array(
                  //   'user_id' => $data['email_details']->user_id,
                  //   'username' => $this->input->post('username'),
                  //   'business_name' => '',
                  //   'category' => '',
                  //   'locality' => '',
                  //   'address' => '',
                  //   'cellphone' => '',
                  //   'telephone' => '',
                  //   'website_url' => '',
                  //   'template' => '0',
                  //   'image' => ''
                  // );
                  chmod('./uploads/', 0777);
                  $path   = './uploads/'.$this->input->post('username');
                  if (!is_dir($path)) { //create the folder if it's not already exists
                      mkdir($path, 0755, TRUE);
                  }
                  echo "Successful";
                  // // if ($this->db->insert('basic_info',$Business_Data)) {
                  // //   chmod('./uploads/', 0777);
                  // //   $path   = './uploads/'.$this->input->post('username');
                  // //   if (!is_dir($path)) { //create the folder if it's not already exists
                  // //       mkdir($path, 0755, TRUE);
                  // //   }
                  // //   echo "Successful";
                  // }else {
                  //   $this->db->where('user_id', $data['email_details']->user_id);
                  //   $this->db->delete('users');
                  //   echo "Unsucessful";
                  // }
                }
                else
                {
                  echo "Unsucessful";
                }
                // if($this->Registers->sendemail($email,$code))
                // {
                //   $this->db->insert('users',$RegisterData);
                //   echo "Successful";
                // }
                // else
                // {
                //   echo "Unsucessful";
                // }
              }
            }
          }
        }
      }
    }
  }

  public function EmailExists()
  {
    $email = $this->input->post('register_email');
    $exists = $this->Homes->EmailExists($email);

    if ($exists) {
        $this->form_validation->set_message('EmailExists', 'Email address is taken already.');
        return false;
    } else {
        return true;
    }
  }

  public function UsernameExists()
  {
    $username = $this->input->post('username');
    $exists = $this->Homes->UsernameExists($username);

    if ($exists) {
        $this->form_validation->set_message('UsernameExists', 'Username is already taken.');
        return false;
    } else {
        return true;
    }
  }

  public function login()
  {
    $this->form_validation->set_rules(
        'email', 'Email',
        'trim|required|valid_email',
        array(
                'required'      => 'Please enter your email',
                'valid_email'      => 'Please enter a valid email'
        )
    );
    $this->form_validation->set_rules(
        'password', 'Password',
        'trim|required',
        array(
                'required'      => 'Please enter your password'
        )
    );
    if ($this->form_validation->run() == FALSE)
    { echo validation_errors(); }
    else
    {
      $email = $this->input->post('email');
      $pass = $this->input->post('password');
      $email_validate = $this->Homes->validate_email($email);
      if ($email_validate) { //Kapag may record yung email sa db
        $data['account'] = $this->Homes->validate_email($email);
        // print_r($data['account']->password);
        $status = $data['account']->status; //Kukunin yung status kung naconfirm na yung account
        if ($status == '0')
        {
          echo "Unconfirmed"; //Kapag di pa confirm yung account
        }
        elseif ($status == '1')
        { //Kapag naconfirm na
          $password = $data['account']->password;
          if($password !== md5($pass)) //Check kung match yung password na nakasave sa db
          {
            echo "Incorrect";
          }
          else
          { //KAPAG TAMA YUNG PASSWORD
            $set_up = $data['account']->set_up;
            if ($set_up == '0')
            {
              echo "Set up";
              $this->session->set_userdata('email', $email);
              $this->session->set_userdata('user_id', $data['account']->user_id);
              $this->session->set_userdata('is_logged_in', true);
            }
            elseif ($set_up == '1')
            {
              $position = $data['account']->type;
              if ($position == 'Traveller')
              {
                echo "Login";
                $this->session->set_userdata('traveller_email', $email);
                $this->session->set_userdata('traveller_id', $data['account']->user_id);
                $this->session->set_userdata('traveller_is_logged_in', true);
              }
              elseif ($position == 'Supplier')
              {
                echo "Dashboard";
                $this->session->set_userdata('email', $email);
                $this->session->set_userdata('user_id', $data['account']->user_id);
                $this->session->set_userdata('is_logged_in', true);
              }
            }
          }
        }
      }
      else
      {
        echo "Invalid";
      }
    }
  }

  public function redirect()
  {
    $email = $_SESSION['email'];
    $email_validate = $this->Homes->validate_email($email);
    if ($email_validate)
    {
      $data['account'] = $this->Homes->validate_email($email);
      $set_up = $data['account']->set_up;
      if ($set_up == '0')
      {
        $this->load->view('/home/setup/index');
      }
      elseif ($set_up == '1')
      {
        redirect('/Account', 'refresh');
      }
    }
  }

  public function set_up()
  {
    $this->load->view('home/setup/index');
  }

  public function set_up_save()
  {
    $user_id = $_SESSION['user_id'];
    $status = $this->input->post('select');
    if ($status == 'Yes')
    {
      if($this->Homes->update_set_up($user_id,$status))
      {
        $Template = [
          'template' => 'NA'
        ];
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Okay! You are good to go!</div>');
        if ($this->Homes->update_user_template($Template,$user_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
        {
          redirect('/Account', 'refresh');
        }
        // redirect('/Account', 'refresh');
      }
      else
      {
          $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Something went wrong...</div>');
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
          redirect('/Home', 'refresh');
      }
    }
    else
    {
      if($this->Homes->update_set_up($user_id,$status))
      {
          $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Okay! You are good to go!</div>');
          redirect('/Account/themes', 'refresh');
      }
      else
      {
          $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Something went wrong...</div>');
          $this->session->unset_userdata('email');
          $this->session->unset_userdata('is_logged_in');
          $this->session->unset_userdata('user_id');
          redirect('/Home', 'refresh');
      }
    }
  }

  public function profile()
  {
    $this->load->view('traveller/profile/index',$this->data);
  }

  public function save_profile()
  {
    $this->form_validation->set_rules(
        'locality', 'Locality',
        'required',
        array(
                'required'      => 'Please select where you live'
        )
    );
    $this->form_validation->set_rules(
        'firstname', 'Firstname',
        'trim|required',
        array(
                'required'      => 'Please enter your firstname'
        )
    );
    $this->form_validation->set_rules(
        'middlename', 'Middlename',
        'trim|required',
        array(
                'required'      => 'Please enter your middlename'
        )
    );
    $this->form_validation->set_rules(
        'lastname', 'Lastname',
        'trim|required',
        array(
                'required'      => 'Please enter your lastname'
        )
    );
    $this->form_validation->set_rules(
        'gender', 'Gender',
        'required',
        array(
                'required'      => 'Please select your gender'
        )
    );
    $this->form_validation->set_rules(
        'address', 'Address',
        'trim|required',
        array(
                'required'      => 'Please enter your address'
        )
    );
    $this->form_validation->set_rules(
        'cellphone', 'Cellphone',
        'trim|required|numeric',
        array(
                'required'      => 'Please enter your cellphone number',
                'numeric'      => 'Please enter numeric character on your cellphone number'
        )
    );
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('traveller/profile/index',$this->data);
    }
    else
    {
      if(!empty($_FILES['picture']['name']))
      {
        $query = $this->db->query("select * from profile where user_id = '$this->traveller_id'");
        if ($query->num_rows() > 0)
        {
          $data['traveller_profile'] = $query->row();
          if (empty($data['traveller_profile']->image))
          {
            $config['upload_path'] = 'uploads/'.$this->data['traveller_details']->username;
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){ // Kapag successful ang pag-upload ng image
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Profile = [
                  'firstname' => $this->input->post('firstname'),
                  'middlename' => $this->input->post('middlename'),
                  'lastname' => $this->input->post('lastname'),
                  'locality' => $this->input->post('locality'),
                  'gender' => $this->input->post('gender'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone'),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->Homes->update_traveller_profile($Profile,$this->traveller_id)) {
                  // redirect('/Account/home', 'refresh');
                }
            }
          }
          else
          {
            $config['upload_path'] = 'uploads/'.$this->data['traveller_details']->username;
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = $_FILES['picture']['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('picture')){ // Kapag successful ang pag-upload ng image
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];

                $Profile = [
                  'firstname' => $this->input->post('firstname'),
                  'middlename' => $this->input->post('middlename'),
                  'lastname' => $this->input->post('lastname'),
                  'locality' => $this->input->post('locality'),
                  'gender' => $this->input->post('gender'),
                  'address' => $this->input->post('address'),
                  'cellphone' => $this->input->post('cellphone'),
                  'image' => '/'.$config['upload_path'].'/'.$picture
                ];
                if ($this->Homes->update_traveller_profile($Profile,$this->traveller_id)) {
                  // redirect('/Account/home', 'refresh');
                }
            }
          }
        }
        else
        {
          $config['upload_path'] = 'uploads/'.$this->data['traveller_details']->username;
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){ // Kapag successful ang pag-upload ng image
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Profile = [
                'user_id' => $this->traveller_id,
                'firstname' => $this->input->post('firstname'),
                'middlename' => $this->input->post('middlename'),
                'lastname' => $this->input->post('lastname'),
                'locality' => $this->input->post('locality'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'cellphone' => $this->input->post('cellphone'),
                'image' => '/'.$config['upload_path'].'/'.$picture
              ];
              if ($this->db->insert('profile',$Profile)) {
                // redirect('/Account/home', 'refresh');
              }
          }
          else {
            echo "Mali yung path";
          }
        }
      }
      else
      {
        $query = $this->db->query("select * from profile where user_id = '$this->traveller_id'");
        if ($query->num_rows() > 0)
        {
          $data['traveller_profile'] = $query->row();
          $Profile = [
            'firstname' => $this->input->post('firstname'),
            'middlename' => $this->input->post('middlename'),
            'lastname' => $this->input->post('lastname'),
            'locality' => $this->input->post('locality'),
            'gender' => $this->input->post('gender'),
            'address' => $this->input->post('address'),
            'cellphone' => $this->input->post('cellphone')
          ];
          if ($this->Homes->update_traveller_profile($Profile,$this->traveller_id)) {
            // redirect('/Account/home', 'refresh');
          }
        }
        else
        {
          $Profile = [
            'user_id' => $this->traveller_id,
            'firstname' => $this->input->post('firstname'),
            'middlename' => $this->input->post('middlename'),
            'lastname' => $this->input->post('lastname'),
            'locality' => $this->input->post('locality'),
            'gender' => $this->input->post('gender'),
            'address' => $this->input->post('address'),
            'cellphone' => $this->input->post('cellphone')
          ];
          if ($this->db->insert('profile', $Profile))
          {

          }
        }
      }
      redirect('/Home/profile', 'refresh');
    }
  }

  public function security()
  {
    $this->load->view('traveller/security/index',$this->data);
  }

  public function update_username()
  {
    $this->form_validation->set_rules(
        'username', 'Username',
        'trim',
        array()
    );
    if ($this->form_validation->run() == TRUE)
    {
      $Username = [
        'username' => $this->input->post('username')
      ];
      if ($this->Homes->update_username($Username,$this->traveller_id)) {
        redirect('/Home/security', 'refresh');
      }
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
      $this->load->view('traveller/security/index',$this->data);
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
        $this->load->view('traveller/security/index',$this->data);
      }
      else
      {
        $Password = [
          'password' => md5($this->input->post('new_password'))
        ];
        if ($this->Homes->update_password($Password,$this->traveller_id)) {
          redirect('/Home/security', 'refresh');
        }
      }
    }
  }

  public function ValidateOldPassword()
  {
    $old = $this->data['traveller_details']->password;
    if ($old !== md5($this->input->post('old_password')))
    {
      $this->form_validation->set_message('ValidateOldPassword', 'The old password you entered is incorrect');
      return false;
    }
    else
    {
      return true;
    }
    // if ($exists) {
    //     $this->form_validation->set_message('UsernameExists', 'Username is already taken.');
    //     return false;
    // } else {
    //     return true;
    // }
  }

  public function vote()
  {
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $business_id = $this->input->post('business_id');
      $query = $this->db->query("select * from votes where voter_id = '$this->traveller_id' and business_id = '$business_id'");
      if ($query->num_rows() > 0)
      {
        echo "Meron na";
      }
      else
      {
        $Vote = [
          'voter_id' => $this->traveller_id,
          'business_id' => $this->input->post('business_id')
        ];
        if ($this->db->insert('votes',$Vote)) {
          $this->data['vote'] = $this->Homes->get_vote($business_id);
          // redirect('/Account/home', 'refresh');
          echo $this->data['vote']->vote;
        }
        else
        {
          echo "Unsucessful";
        }
      }
    }
    else
    {
      echo "Not logged in";
    }
  }

  public function unvote()
  {
    $this->db->where('voter_id', $this->traveller_id);
    $this->db->where('business_id', $this->input->post('business_id'));
    $this->db->delete('votes');
    $this->data['vote'] = $this->Homes->get_vote($this->input->post('business_id'));
    // redirect('/Account/home', 'refresh');
    echo $this->data['vote']->vote;
    //  echo '<script>alert("Locality deleted!");</script>';
    //  redirect('/Admin/localities', 'refresh');
  }

  public function search()
  {
    $this->load->view('home/search');
  }

  public function logout()
  {
    if ($this->session->userdata('traveller_is_logged_in')) {
          $this->session->unset_userdata('traveller_email');
          $this->session->unset_userdata('traveller_is_logged_in');
          $this->session->unset_userdata('traveller_id');
        }
        redirect('/Home');
  }
}
