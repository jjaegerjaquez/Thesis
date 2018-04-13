<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Light extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Lights');
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
      $this->data['account'] = $this->Lights->get_account_details($this->user_id);
      $this->data['details'] = $this->Lights->get_business_details($this->user_id,$this->BusinessName);
      $this->id = $this->data['details']->id;
      $this->data['theme'] = $this->Lights->get_theme($this->data['business_name']);
      $this->theme = $this->data['theme']->theme;
      $this->data['businesses'] = $this->Lights->get_businesses($this->user_id);
      $this->data['title'] = $this->Lights->get_title();
      $this->data['icon'] = $this->Lights->get_site_icon();
      $this->data['tagline'] = $this->Lights->get_tagline();
      $this->data['facebook'] = $this->Lights->get_facebook();
      $this->data['instagram'] = $this->Lights->get_instagram();
      $this->data['twitter'] = $this->Lights->get_twitter();
      $this->data['google'] = $this->Lights->get_google();
    }
	}

  public function index()
  {

  }

  public function home()
  {
    $this->data['home_title'] = $this->Lights->get_home_title($this->user_id,$this->id);
    $this->data['home_description'] = $this->Lights->get_home_description($this->user_id,$this->id);
    $this->data['home_bg'] = $this->Lights->get_home_background_image($this->user_id,$this->id);
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
          $data['home_title'] = $this->Lights->get_home_title($this->user_id,$this->id);
          $Home_Title = [
            'value' => $this->input->post('title')
          ];
          if ($this->Lights->update_home_title($Home_Title,$this->user_id,$data['home_title']->content_id)) {
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
          $data['home_description'] = $this->Lights->get_home_description($this->user_id,$this->id);
          $Home_Description = [
            'value' => $this->input->post('description')
          ];
          if ($this->Lights->update_home_description($Home_Description,$this->user_id,$data['home_description']->content_id)) {
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
      redirect(base_url().'Light/home', 'refresh');
    }
  }

  public function about()
  {
    $this->data['about_bg'] = $this->Lights->get_about_background_image($this->user_id,$this->id);
    $this->data['about_title'] = $this->Lights->get_about_title($this->user_id,$this->id);
    $this->data['about_description'] = $this->Lights->get_about_description($this->user_id,$this->id);
    $this->load->view('account/themes/'.$this->theme.'/about/index',$this->data);
  }

  public function save_about()
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
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'about_title'");
        if ($query->num_rows() > 0) {

          $data['about_title'] = $this->Lights->get_about_title($this->user_id,$this->id);
          $Title = [
            'value' => $this->input->post('title')
          ];
          if ($this->Lights->update_about_title($Title,$this->user_id,$data['about_title']->content_id)) {
            // redirect('/Account/about', 'refresh');
          }

        }else {

          $Title = [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'business_name' => $this->BusinessName,
            'meta_key' => 'about_title',
            'content_title' => '',
            'description' => '',
            'value' => $this->input->post('title')
          ];

          if ($this->db->insert('contents',$Title)) {
            // redirect('/Account/about', 'refresh');
          }

        }
      }

      if (!empty($this->input->post('description')))
      {
        $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'about_description'");
        if ($query->num_rows() > 0) {

          $data['about_description'] = $this->Lights->get_about_description($this->user_id,$this->id);
          $About_Description = [
            'value' => $this->input->post('description')
          ];
          if ($this->Lights->update_about_description($About_Description,$this->user_id,$data['about_description']->content_id)) {
            // redirect('/Account/about', 'refresh');
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
            // redirect('/Account/about', 'refresh');
          }

        }
      }
      redirect(base_url().'Light/about', 'refresh');
    }
  }

  public function gallery()
  {
    $this->data['gallery_images'] = $this->Lights->get_gallery_images($this->user_id,$this->id);
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
    if ($count->count < 9)
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
           'meta_key' => 'gallery_image',
           'content_title' => '',
           'description' => '',
           'value' => base_url().$path.$image_name
         ];

         $this->db->insert('contents',$Image);
         echo 'Image uploaded!';
      }
      else
      {
        echo 'Please select an image';
      }
    }
    else
    {
      echo "Sorry, you have reached the maximum number of image you can upload for the gallery..";
    }
  }

  public function view_image($content_id)
  {
    $this->data['image'] = $this->Lights->get_image($this->user_id,$content_id);
    $this->load->view('account/themes/'.$this->theme.'/gallery/view',$this->data);
  }

  public function edit_image($content_id)
  {
    $this->data['image'] = $this->Lights->get_image($this->user_id,$content_id);
    $this->load->view('account/themes/'.$this->theme.'/gallery/edit',$this->data);
  }

  public function update_image($content_id)
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

       if ($this->Lights->update_gallery_image($Image,$this->user_id,$content_id)) {
         echo "Image updated!";
       }
    }
    else
    {
      echo 'Please select an image';
    }
  }

  public function delete_image($content_id)
  {
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $this->user_id);
    $this->db->where('id', $this->id);
    $this->db->where('meta_key', 'gallery_image');
    $this->db->delete('contents');
    echo "<script>alert('Image has been deleted.');document.location='/Light/gallery'</script>";
  }

  public function contacts()
  {
    $this->data['facebook'] = $this->Lights->get_facebook_url($this->user_id,$this->id);
    $this->data['instagram'] = $this->Lights->get_instagram_url($this->user_id,$this->id);
    $this->data['twitter'] = $this->Lights->get_twitter_url($this->user_id,$this->id);
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

          if ($this->Lights->update_facebook_url($Facebook,$this->user_id,$data['facebook']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Light/contacts'</script>";
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
            echo "<script>alert('Something went wrong...');document.location='/Light/contacts'</script>";
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

          if ($this->Lights->update_instagram_url($Instagram,$this->user_id,$data['instagram']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Light/contacts'</script>";
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
            echo "<script>alert('Something went wrong...');document.location='/Light/contacts'</script>";
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

          if ($this->Lights->update_twitter_url($Twitter,$this->user_id,$data['twitter']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo "<script>alert('Something went wrong...');document.location='/Light/contacts'</script>";
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
            echo "<script>alert('Something went wrong...');document.location='/Light/contacts'</script>";
          }
        }
      }
    }
    redirect(base_url().'Light/contacts', 'refresh');
  }

  public function theme()
  {
    $this->data['themes'] = $this->Lights->get_themes();
    $this->load->view('account/themes/'.$this->theme.'/theme/index',$this->data);
  }

  public function save_template()
  {
    $template = $this->input->post('template');
    $Template = [
      'theme' => $this->input->post('template')
    ];

    if ($this->Lights->update_user_template($Template,$this->user_id,$this->id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
    {
      redirect(base_url().$template.'/theme', 'refresh');
    }
    else
    {
      echo "<script>alert('Cannot activate the theme...');document.location='/Light/theme'</script>";
    }
  }

  public function upload_home_bg()
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

       $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'home_background_image'");
       if ($query->num_rows() > 0)
       {
         $data['home_bg'] = $query->row();
         $Bg = [
           'value' => base_url().$path.$image_name
         ];

         if ($this->Lights->update_home_background_image($Bg,$this->user_id,$data['home_bg']->content_id))
         { //KAPAG NAUPDATE YUNG LOGO
           echo "Image successfully updated!";
         }
       }
       else
       {
         $Bg = [
           'user_id' => $this->user_id,
           'id' => $this->id,
           'business_name' => $this->BusinessName,
           'meta_key' => 'home_background_image',
           'content_title' => '',
           'description' => '',
           'value' => base_url().$path.$image_name
         ];
         if ($this->db->insert('contents',$Bg))
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

  public function upload_about_bg()
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

       $query = $this->db->query("select * from contents where user_id = '$this->user_id' and id = '$this->id' and meta_key = 'about_background_image'");       if ($query->num_rows() > 0)
       {
         $data['about_bg'] = $query->row();
         $Bg = [
           'value' => base_url().$path.$image_name
         ];
         if ($this->Lights->update_about_background_image($Bg,$this->user_id,$data['about_bg']->content_id))
         {
           echo "Image successfully updated!";
         }
       }
       else
       {
         $Bg = [
           'user_id' => $this->user_id,
           'id' => $this->id,
           'business_name' => $this->BusinessName,
           'meta_key' => 'about_background_image',
           'content_title' => '',
           'description' => '',
           'value' => base_url().$path.$image_name
         ];
         if ($this->db->insert('contents',$Bg))
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
