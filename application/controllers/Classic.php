<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Classic extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Classics');
    if (!$this->session->userdata('is_logged_in'))
    {
      $allowed = array(
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
      $this->data['account'] = $this->Classics->get_account_details($this->user_id);
      $this->data['details'] = $this->Classics->get_business_details($this->user_id,$this->BusinessName);
      $this->id = $this->data['details']->id;
      $this->data['theme'] = $this->Classics->get_theme($this->data['business_name']);
      $this->theme = $this->data['theme']->theme;
      $this->data['businesses'] = $this->Classics->get_businesses($this->user_id);
      $this->data['title'] = $this->Classics->get_title();
      $this->data['icon'] = $this->Classics->get_site_icon();
      $this->data['tagline'] = $this->Classics->get_tagline();
      $this->data['facebook'] = $this->Classics->get_facebook();
      $this->data['instagram'] = $this->Classics->get_instagram();
      $this->data['twitter'] = $this->Classics->get_twitter();
      $this->data['google'] = $this->Classics->get_google();
      $this->data['notif_count'] = $this->Classics->get_notif_count($this->id);
      $this->data['notifications'] = $this->Classics->get_notifications($this->id);
    }
	}

  public function index()
  {

  }

  public function home()
  {
    $this->data['home_title'] = $this->Classics->get_home_title($this->user_id,$this->id);
    $this->data['home_description'] = $this->Classics->get_home_description($this->user_id,$this->id);
    $this->load->view('account/themes/'.$this->theme.'/home/index',$this->data);
  }

  public function save_home()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('title')))
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'home_title'");
        if ($query->num_rows() > 0)
        {
          $data['home_title'] = $this->Classics->get_home_title($this->user_id,$this->id);
          $Home_Title = [
            'value' => $this->input->post('title')
          ];
          if ($this->Classics->update_home_title($Home_Title,$this->user_id,$data['home_title']->content_id)) {
            // redirect('/Account/home', 'refresh');
          }
        }
        else
        {
          $Home_Title = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'home_title',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('title')
          ];

          if ($this->db->insert('contents',$Home_Title)) {
            // redirect('/Account/home', 'refresh');
          }
        }
      }

      if (!empty($this->input->post('description')))
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'home_description'");
        if ($query->num_rows() > 0)
        {
          $data['home_description'] = $this->Classics->get_home_description($this->user_id,$this->id);
          $Home_Description = [
            'value' => $this->input->post('description')
          ];
          if ($this->Classics->update_home_description($Home_Description,$this->user_id,$data['home_description']->content_id)) {
            // redirect('/Account/home', 'refresh');
          }
        }
        else
        {
          $Home_Description = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'home_description',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('description')
          ];

          if ($this->db->insert('contents',$Home_Description)) {
            // redirect('/Account/home', 'refresh');
          }
        }
      }
      redirect(base_url().'Classic/home', 'refresh');
    }
  }

  public function about()
  {
    $this->data['featured_image'] = $this->Classics->get_featured_image($this->user_id,$this->id);
    $this->data['about_description'] = $this->Classics->get_about_description($this->user_id,$this->id);
    $this->load->view('account/themes/'.$this->theme.'/about/index',$this->data);
  }

  public function save_about()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('description')))
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'about_description'");
        if ($query->num_rows() > 0) {

          $data['about_description'] = $this->Classics->get_about_description($this->user_id,$this->id);
          $About_Description = [
            'value' => $this->input->post('description')
          ];
          if ($this->Classics->update_about_description($About_Description,$this->user_id,$data['about_description']->content_id)) {
            redirect(base_url().'Classic/about', 'refresh');
          }

        }else {

          $About_Description = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'about_description',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('description')
          ];

          if ($this->db->insert('contents',$About_Description)) {
            redirect(base_url().'Classic/about', 'refresh');
          }

        }
      }
    }
  }

  public function gallery()
  {
    $this->data['gallery_images'] = $this->Classics->get_gallery_images($this->user_id,$this->id);
    $this->load->view('account/themes/'.$this->theme.'/gallery/index',$this->data);
  }

  public function add_image()
  {
    $this->load->view('account/themes/'.$this->theme.'/gallery/add',$this->data);
  }

  public function save_image()
  {
    $query = $this->db->query("select count(value) as count from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'gallery_image'");
    $count = $query->row();
    if ($count->count < 6)
    {
      if(!empty($_FILES['picture']['name']))
      { //If may laman na image
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

              $Image = [
                'user_id' => $this->user_id,
                'id' => $this->id,
                'business_name' => $this->BusinessName,
                'meta_key' => 'gallery_image',
                'content_title' => '',
                'description' => '',
                'value' => '/'.$config['upload_path'].'/'.$picture
              ];

              $this->db->insert('contents',$Image);
              echo "<script>alert('Image added!');document.location='/Classic/gallery'</script>";
          }else{
            echo "<script>alert('Something went wrong, image not uploaded');document.location='/Classic/gallery'</script>";
          }
      }
      else
      {
        redirect(base_url().'Classic/add_image', 'refresh');
      }
    }
    else
    {
      echo "<script>alert('Sorry, you've reached the maximum number of image you can upload for the gallery...');document.location='/Classic/add_image'</script>";
    }
  }

  public function view_image($content_id)
  {
    $this->data['image'] = $this->Classics->get_image($this->user_id,$content_id);
    $this->load->view('account/themes/'.$this->theme.'/gallery/view',$this->data);
  }

  public function edit_image($content_id)
  {
    $this->data['image'] = $this->Classics->get_image($this->user_id,$content_id);
    $this->load->view('account/themes/'.$this->theme.'/gallery/edit',$this->data);
  }

  public function update_image($content_id)
  {
    if(!empty($_FILES['picture']['name'])){ //If may laman na image
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

            $Image = [
              'value' => '/'.$config['upload_path'].'/'.$picture
            ];

            if ($this->Classics->update_gallery_image($Image,$this->user_id,$content_id)) {
              redirect(base_url().'Classic/gallery', 'refresh');
            }
        }else{
          echo "<script>alert('Something went wrong, image cannot be updated..');document.location='/Classic/gallery'</script>";
        }
    }
  }

  public function delete_image($content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $this->user_id);
    $this->db->where('id', $this->id);
    $this->db->where('meta_key', 'gallery_image');
    $this->db->delete('contents');
    echo "<script>alert('Image deleted!');document.location='/Classic/gallery'</script>";
  }

  public function contacts()
  {
    $this->data['facebook'] = $this->Classics->get_facebook_url($this->user_id,$this->id);
    $this->data['instagram'] = $this->Classics->get_instagram_url($this->user_id,$this->id);
    $this->data['twitter'] = $this->Classics->get_twitter_url($this->user_id,$this->id);
    $this->load->view('account/themes/'.$this->theme.'/contacts/index',$this->data);
  }

  public function save_contacts()
  {
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'facebook', 'Facebook',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'twitter', 'Twitter',
        'trim',
        array()
    );
    $this->form_validation->set_rules(
        'instagram', 'Instagram',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if (!empty($this->input->post('facebook')))
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'facebook_url'");

        if ($query->num_rows() > 0)
        {
          $data['facebook'] = $query->row();
          $Facebook = [
            'value' => $this->input->post('facebook')
          ];

          if ($this->Classics->update_facebook_url($Facebook,$this->user_id,$data['facebook']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Classic/contacts'</script>";
          }
        }
        else
        {
          $Facebook = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'facebook_url',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('facebook')
          ];

          if ($this->db->insert('contents',$Facebook))
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Classic/contacts'</script>";
          }
        }
      }
      if (!empty($this->input->post('instagram')))
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'instagram_url'");

        if ($query->num_rows() > 0)
        {
          $data['instagram'] = $query->row();
          $Instagram = [
            'value' => $this->input->post('instagram')
          ];

          if ($this->Classics->update_instagram_url($Instagram,$this->user_id,$data['instagram']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Classic/contacts'</script>";
          }
        }
        else
        {
          $Instagram = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'instagram_url',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('instagram')
          ];

          if ($this->db->insert('contents',$Instagram))
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Classic/contacts'</script>";
          }
        }
      }
      if (!empty($this->input->post('twitter')))
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'twitter_url'");

        if ($query->num_rows() > 0)
        {
          $data['twitter'] = $query->row();
          $Twitter = [
            'value' => $this->input->post('twitter')
          ];

          if ($this->Classics->update_twitter_url($Twitter,$this->user_id,$data['twitter']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Classic/contacts'</script>";
          }
        }
        else
        {
          $Twitter = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'twitter_url',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('twitter')
          ];

          if ($this->db->insert('contents',$Twitter))
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Classic/contacts'</script>";
          }
        }
      }
    }
    redirect(base_url().'Classic/contacts', 'refresh');
  }

  public function image_slider()
  {
    $this->data['slider_images'] = $this->Classics->get_slider_images($this->user_id,$this->id);
    $this->load->view('account/themes/'.$this->theme.'/image_slider/index',$this->data);
  }

  public function add_image_slider()
  {
    $this->load->view('account/themes/'.$this->theme.'/image_slider/add',$this->data);
  }

  public function save_image_slider()
  {
    $query = $this->db->query("select count(value) as count from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'image_slider'");
    $count = $query->row();
    if ($count->count < 3)
    {
      if (!empty($this->input->post('file')))
      {
        $path = 'uploads/'.$this->user_id.'/';
        $croped_image = $_POST['image'];
         list($type, $croped_image) = explode(';', $croped_image);
         list(, $croped_image)      = explode(',', $croped_image);
         $croped_image = base64_decode($croped_image);
         $image_name = time().'.png';
         // upload cropped image to server
         file_put_contents($path.$image_name, $croped_image);
         $Image = [
           'user_id' => $this->user_id,
           'id' => $this->id,
           'business_name' => $this->BusinessName,
           'meta_key' => 'image_slider',
           'content_title' => '',
           'description' => '',
           'value' => base_url().$path.$image_name
         ];

         if ($this->db->insert('contents',$Image)) {
           echo 'Image uploaded!';
         }
      }
      else
      {
        echo 'Please select an image';
      }
    }
    else
    {
      echo "Sorry, you have reached the maximum number of image you can upload for the image slider..";
    }
  }

  public function view_slider_image($content_id)
  {
    $this->data['image'] = $this->Classics->get_image_slider($this->user_id,$content_id);
    $this->load->view('account/themes/'.$this->theme.'/image_slider/view',$this->data);
  }

  public function edit_slider_image($content_id)
  {
    $this->data['image_slider'] = $this->Classics->get_image_slider($this->user_id,$content_id);
    $this->load->view('account/themes/'.$this->theme.'/image_slider/edit',$this->data);
  }

  public function update_image_slider($content_id)
  {
    if (!empty($this->input->post('file')))
    {
      $path = 'uploads/'.$this->user_id.'/';
      $croped_image = $_POST['image'];
       list($type, $croped_image) = explode(';', $croped_image);
       list(, $croped_image)      = explode(',', $croped_image);
       $croped_image = base64_decode($croped_image);
       $image_name = time().'.png';
       // upload cropped image to server
       file_put_contents($path.$image_name, $croped_image);

       $Image = [
         'value' => base_url().$path.$image_name
       ];

       if ($this->Classics->update_image_slider($Image,$this->user_id,$content_id)) {
         echo "Image updated!";
       }
    }
    else
    {
      echo 'Please select an image';
    }
  }

  public function delete_slider_image($content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $this->user_id);
    $this->db->where('id', $this->id);
    $this->db->where('meta_key', 'image_slider');
    $this->db->delete('contents');
    echo "<script>alert('Image deleted.');document.location='/Classic/image_slider'</script>";
  }

  public function theme()
  {
    $this->data['themes'] = $this->Classics->get_themes();
    $this->load->view('account/themes/'.$this->theme.'/theme/index',$this->data);
  }

  public function save_template()
  {
    $template = $this->input->post('template');
    $Template = [
      'theme' => $this->input->post('template')
    ];

    if ($this->Classics->update_user_template($Template,$this->user_id,$this->id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
    {
      redirect(base_url().$template.'/theme', 'refresh');

    }
    else
    {
      echo "<script>alert('Cannot activate the theme...');document.location='/Classic/theme'</script>";
    }
  }

  public function upload_about_featured_img()
  {
    if (!empty($this->input->post('file')))
    {
      $path = 'uploads/'.$this->user_id.'/';
      $croped_image = $_POST['image'];
       list($type, $croped_image) = explode(';', $croped_image);
       list(, $croped_image)      = explode(',', $croped_image);
       $croped_image = base64_decode($croped_image);
       $image_name = time().'.png';
       // upload cropped image to server
       file_put_contents($path.$image_name, $croped_image);

       $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'about_featured_image'");
       if ($query->num_rows() > 0)
       {
         $data['featured_image'] = $query->row();
         $Featured_Image = [
           'value' => base_url().$path.$image_name
         ];
          if ($this->Classics->update_featured_image($Featured_Image,$this->user_id,$data['featured_image']->content_id))
          {
            echo "Image successfully updated!";
          }
       }
       else
       {
         $Featured_Image = [
           'user_id' => $this->user_id,
           'id' => $this->id,
           'business_name' => $this->BusinessName,
           'meta_key' => 'about_featured_image',
           'content_title' => '',
           'description' => '',
           'value' => base_url().$path.$image_name
         ];
         if ($this->db->insert('contents',$Featured_Image))
         {
           echo "Image successfully uploaded!";
         }
       }
    }
    else
    {
      echo "Please select an image";
    }
  }
}
