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
    $this->data['icon'] = $this->Homes->get_site_icon();
    $this->data['image_sliders'] = $this->Homes->get_image_sliders();
    $this->data['tagline'] = $this->Homes->get_tagline();
    $this->data['facebook'] = $this->Homes->get_facebook();
    $this->data['instagram'] = $this->Homes->get_instagram();
    $this->data['twitter'] = $this->Homes->get_twitter();
    $this->data['google'] = $this->Homes->get_google();
    $this->data['localities'] = $this->Homes->get_localities();
    $this->data['priority_ads'] = $this->Homes->get_priority_ad();
    $this->data['events'] = $this->Homes->get_events();
    $this->data['event_count'] = count($this->data['events']);
    $this->data['topics'] = $this->Homes->get_topics();
    if (!$this->session->userdata('is_logged_in') && !$this->session->userdata('traveller_is_logged_in'))
    {
      $allowed = array(
            'index',
            'login',
            'register',
            'logout',
            'vote',
            'look_result',
            'search',
            'search_location'
        );
        if ( ! in_array($this->router->fetch_method(), $allowed))
        {
          redirect(base_url().'Home');
        }
    }
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['image_crop'] = "";
      $this->data['traveller_details'] = $this->Homes->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Homes->get_traveller_profile($this->traveller_id);
      $this->data['notif_count'] = $this->Homes->get_notif_count($this->traveller_id);
      $this->data['notifications'] = $this->Homes->get_notifications($this->traveller_id);
    }
	}

  public function index()
  {
    $count = 0;
    foreach ($this->data['localities'] as $key => $result) {
      $count++;
    }

    for ($i=0; $i <$count ; $i++) {
      $this->data['counts'][$i] = $this->Homes->get_counts($this->data['localities'][$i]->locality);
    }

    $this->data['counter']=$count;

    if ($this->session->userdata('is_logged_in'))
    {
      $email = $_SESSION['email'];
      $this->data['account'] = $this->Homes->validate_email($email);
      $set_up = $data['account']->set_up;
      if ($set_up == '0')
        {
          redirect(base_url().'Home/set_up');
        }else {
          redirect(base_url().'Home/redirect');
        }
    }
    $this->load->view('home/index',$this->data);
  }

  public function register()
  {
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
                $data['BusinessName'] = $this->Homes->fetch_basic_info($data['account']->user_id);
                $this->session->set_userdata('business', $data['BusinessName']->business_name);
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
        redirect(base_url().'Account', 'refresh');
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
      $this->session->set_userdata('primary_website', 'Yes');
      $this->session->set_userdata('business', '');
      redirect(base_url().'Account/start', 'refresh');
    }
    else
    {
      $this->session->set_userdata('primary_website', 'No');
      $this->session->set_userdata('business', '');
      redirect(base_url().'Account/start', 'refresh');
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
      redirect(base_url().'Home/profile', 'refresh');
    }
  }

  public function image()
  {
    $this->load->view('traveller/profile_image/index',$this->data);
  }

  // public function upload_img()
  // {
  //   if(!empty($_FILES['picture']['name']))
  //     {
  //           $config['upload_path'] = 'uploads/'.$this->data['traveller_details']->username;
  //           $config['overwrite'] = TRUE;
  //           $config['allowed_types'] = 'jpg|jpeg|png|gif';
  //           $config['file_name'] = $_FILES['picture']['name'];
  //
  //           //Load upload library and initialize configuration
  //           $this->load->library('upload',$config);
  //           $this->upload->initialize($config);
  //
  //           if($this->upload->do_upload('picture')){ // Kapag successful ang pag-upload ng image
  //               $uploadData = $this->upload->data();
  //               $picture = $uploadData['file_name'];
  //               // $this->data['image_crop'] = '/'.$config['upload_path'].'/'.$picture;
  //                 $this->session->set_userdata('image_crop', '/'.$config['upload_path'].'/'.$picture);
  //                 $this->session->set_userdata('image_name', $picture);
  //                echo '<script>alert("Image uploaded!");</script>';
  //                redirect('/Home/image', 'refresh');
  //           }
  //         }
  // }

  public function upload_img()
 {
   $path = 'uploads/'.$this->data['traveller_details']->username.'/';
   $croped_image = $_POST['image'];
    list($type, $croped_image) = explode(';', $croped_image);
    list(, $croped_image)      = explode(',', $croped_image);
    $croped_image = base64_decode($croped_image);
    $image_name = time().'.png';
    // upload cropped image to server
    file_put_contents($path.$image_name, $croped_image);
    $Profile = [
                'image' => base_url().'/uploads'.'/'.$this->data['traveller_details']->username.'/'.$image_name
              ];
              if ($this->Homes->update_traveller_profile($Profile,$this->traveller_id)) {
                echo 'Profile image updated!';
              }

 }

  public function crop()
  {

  }

  public function security()
  {
    $this->load->view('traveller/security/index',$this->data);
  }

  public function IfEmailExists()
  {
    $email = $this->input->post('email');
    $exists = $this->Homes->EmailExists($email);

    if ($exists) {
        $this->form_validation->set_message('IfEmailExists', 'Email address is taken already.');
        return false;
    } else {
        return true;
    }
  }

  public function update_email()
  {
    $this->form_validation->set_rules(
        'email', 'Email',
        'trim|callback_IfEmailExists',
        array()
    );
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('traveller/security/index',$this->data);
    }
    else
    {
      $Email = [
        'email' => $this->input->post('email')
      ];
      if ($this->Homes->update_email($Email,$this->traveller_id)) {
        $this->session->unset_userdata('traveller_email');
        $this->session->set_userdata('traveller_email', $this->input->post('email'));
        redirect(base_url().'Home/security', 'refresh');
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
          redirect(base_url().'Home/security', 'refresh');
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

  public function details()
  {
    $this->load->view('traveller/details/index',$this->data);
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

  public function search_location(){
        $keyword=$this->input->post('keyword');
        $data=$this->Homes->GetRow($keyword);
        echo json_encode($data);
    }


    public function look_result(){
          $keyword=$this->input->post('keyword');
          $data=$this->Homes->get_look_result($keyword);
          echo json_encode($data);
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

  // public function search()
  // {
  //   $this->load->view('home/search');
  // }

  public function get_notif()
  {
    $this->data['notif__count'] = $this->Homes->get_notif_count($this->input->post('user_id'));
    if ($this->data['notif__count']->notif_count == 0)
    {
      echo $this->data['notif__count']->notif_count;
    }
    else
    {
      $this->data['notifications'] = $this->Homes->get_notifications($this->input->post('user_id'));
      echo '
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bell-o"></i>';
          if (!empty($this->data['notif__count'])) {
            echo '<span class="label label-warning" id="notif-count">'.$this->data['notif__count']->notif_count.'</span>';
          }
        echo '</a>';
        echo '<ul class="dropdown-menu">
          <li>
            <ul class="menu">';
            foreach ($this->data['notifications'] as $key => $notification) {
              if ($notification->type_of_notification == 'Comment') {
                echo '
                <li>
                  <a href="'.$notification->href.'">
                    <i class="ion-chatbubble"></i> '.$notification->title_content.'
                  </a>
                </li>
                ';
              }elseif ($notification->type_of_notification == 'Reply') {
                echo '
                <li>
                  <a href="'.$notification->href.'">
                    <i class="ion-chatbubbles"></i> '.$notification->title_content.'
                  </a>
                </li>
                ';
              }
            }
            echo '
              </ul>
            </li>
          </ul>
        ';
    }
  }

  public function is_unread()
  {
    $Notif = [
      'is_unread' => '1'
    ];
    if ($this->Homes->set_read($Notif,$this->input->post('user_id'))) {
        echo '0';
    }
  }

  public function logout()
  {
    if ($this->session->userdata('traveller_is_logged_in')) {
          $this->session->unset_userdata('traveller_email');
          $this->session->unset_userdata('traveller_is_logged_in');
          $this->session->unset_userdata('traveller_id');
        }
        redirect(base_url().'Home');
  }
}
