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
	}

  public function index()
  {

  }

  public function home()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['home_title'] = $this->Classics->get_home_title($user_id);
    $data['home_description'] = $this->Classics->get_home_description($user_id);
    // print_r($data['home_title']);
    $this->load->view('account/themes/'.$theme.'/home/index',$data);
  }

  public function save_home()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
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
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'home_title'");
        if ($query->num_rows() > 0)
        {
          $data['home_title'] = $this->Classics->get_home_title($user_id);
          $Home_Title = [
            'value' => $this->input->post('title')
          ];
          if ($this->Classics->update_home_title($Home_Title,$user_id,$data['home_title']->content_id)) {
            // redirect('/Account/home', 'refresh');
          }
        }
        else
        {
          $Home_Title = [
            'user_id' => $user_id,
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
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'home_description'");
        if ($query->num_rows() > 0)
        {
          $data['home_description'] = $this->Classics->get_home_description($user_id);
          $Home_Description = [
            'value' => $this->input->post('description')
          ];
          if ($this->Classics->update_home_description($Home_Description,$user_id,$data['home_description']->content_id)) {
            // redirect('/Account/home', 'refresh');
          }
        }
        else
        {
          $Home_Description = [
            'user_id' => $user_id,
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
      redirect('/Classic/home', 'refresh');
    }
  }

  public function about()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['featured_image'] = $this->Classics->get_featured_image($user_id);
    $data['about_description'] = $this->Classics->get_about_description($user_id);
    $this->load->view('account/themes/'.$theme.'/about/index',$data);
  }

  public function save_about()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    // FORM VALIDATION
    $this->form_validation->set_rules(
        'description', 'Description',
        'trim',
        array()
    );
    //END OF FORM VALIDATION
    if ($this->form_validation->run() == TRUE)
    {
      if(!empty($_FILES['picture']['name'])){ //If may laman na image
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'about_featured_image'");
        if ($query->num_rows() > 0)
        {
          $data['featured_image'] = $query->row();
          $config['upload_path'] = 'uploads/themes/'.$theme;
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){ // Kapag successful ang pag-upload ng image
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Featured_Image = [
                'value' => $picture
              ];

              if ($this->Classics->update_featured_image($Featured_Image,$user_id,$data['featured_image']->content_id))
              { //KAPAG NAUPDATE YUNG LOGO

              }
          }
        }
        else
        {
          $config['upload_path'] = 'uploads/themes/'.$theme;
          $config['overwrite'] = TRUE;
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = $_FILES['picture']['name'];

          //Load upload library and initialize configuration
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('picture')){ // Kapag successful ang pag-upload ng image
              $uploadData = $this->upload->data();
              $picture = $uploadData['file_name'];

              $Featured_Image = [
                'user_id' => $user_id,
                'meta_key' => 'about_featured_image',
                'content_title' => '',
                'description' => '',
                'value' => $picture
              ];
              if ($this->db->insert('contents',$Featured_Image))
              {

              }
          }
        }
      }

      if (!empty($this->input->post('description')))
      {
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'about_description'");
        if ($query->num_rows() > 0) {

          $data['about_description'] = $this->Classics->get_about_description($user_id);
          $About_Description = [
            'value' => $this->input->post('description')
          ];
          if ($this->Classics->update_about_description($About_Description,$user_id,$data['about_description']->content_id)) {
            // redirect('/Account/about', 'refresh');
          }

        }else {

          $About_Description = [
            'user_id' => $user_id,
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
      redirect('/Classic/about', 'refresh');
    }
  }

  public function gallery()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['gallery_images'] = $this->Classics->get_gallery_images($user_id);
    $this->load->view('account/themes/'.$theme.'/gallery/index',$data);
  }

  public function add_image()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $this->load->view('account/themes/'.$theme.'/gallery/add',$data);
  }

  public function save_image()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $query = $this->db->query("select count(value) as count from contents where user_id = '$user_id' and meta_key = 'gallery_image'");
    $count = $query->row();
    if ($count->count < 6)
    {
      if(!empty($_FILES['picture']['name']))
      { //If may laman na image
          $config['upload_path'] = 'uploads/themes/'.$theme;
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
                'user_id' => $user_id,
                'meta_key' => 'gallery_image',
                'content_title' => '',
                'description' => '',
                'value' => $picture
              ];

              $this->db->insert('contents',$Image);
              echo '<script>alert("Image added!");</script>';
              redirect('/Classic/gallery/', 'refresh');
          }else{
            echo '<script>alert("Something went wrong, image not uploaded...");</script>';
            redirect('/Classic/gallery', 'refresh');
          }
      }
      else
      {
        redirect('/Classic/add_image', 'refresh');
      }
    }
    else
    {
      echo '<script>alert("Sorry, you have reached the maximum number of image you can upload for the gallery..");</script>';
      redirect('/Classic/add_image', 'refresh');
    }
  }

  public function view_image($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['image'] = $this->Classics->get_image($user_id,$content_id);
    $this->load->view('account/themes/'.$theme.'/gallery/view',$data);
  }

  public function edit_image($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['image'] = $this->Classics->get_image($user_id,$content_id);
    $this->load->view('account/themes/'.$theme.'/gallery/edit',$data);
  }

  public function update_image($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;

    if(!empty($_FILES['picture']['name'])){ //If may laman na image
        $config['upload_path'] = 'uploads/themes/'.$theme;
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
              'value' => $picture
            ];

            if ($this->Classics->update_gallery_image($Image,$user_id,$content_id)) {
              redirect('/Classic/gallery', 'refresh');
            }
        }else{
          echo '<script>alert("Something went wrong, image cannot be updated..");</script>';
          redirect('/Classic/gallery', 'refresh');
        }
    }
  }

  public function delete_image($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $user_id);
    $this->db->where('meta_key', 'gallery_image');
    $this->db->delete('contents');
     echo '<script>alert("Image deleted!");</script>';
     redirect('/Classic/gallery', 'refresh');
  }

  public function contacts()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['facebook'] = $this->Classics->get_facebook_url($user_id);
    $data['instagram'] = $this->Classics->get_instagram_url($user_id);
    $data['twitter'] = $this->Classics->get_twitter_url($user_id);
    $this->load->view('account/themes/'.$theme.'/contacts/index',$data);
  }

  public function save_contacts()
  {
    $user_id = $_SESSION['user_id'];
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
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'facebook_url'");

        if ($query->num_rows() > 0)
        {
          $data['facebook'] = $query->row();
          $Facebook = [
            'value' => $this->input->post('facebook')
          ];

          if ($this->Classics->update_facebook_url($Facebook,$user_id,$data['facebook']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo '<script>alert("Something went wrong...");</script>';
            redirect('/Classic/contacts', 'refresh');
          }
        }
        else
        {
          $Facebook = [
            'user_id' => $user_id,
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
            echo '<script>alert("Something went wrong...");</script>';
            redirect('/Classic/contacts', 'refresh');
          }
        }
      }
      if (!empty($this->input->post('instagram')))
      {
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'instagram_url'");

        if ($query->num_rows() > 0)
        {
          $data['instagram'] = $query->row();
          $Instagram = [
            'value' => $this->input->post('instagram')
          ];

          if ($this->Classics->update_instagram_url($Instagram,$user_id,$data['instagram']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo '<script>alert("Something went wrong...");</script>';
            redirect('/Classic/contacts', 'refresh');
          }
        }
        else
        {
          $Instagram = [
            'user_id' => $user_id,
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
            echo '<script>alert("Something went wrong...");</script>';
            redirect('/Classic/contacts', 'refresh');
          }
        }
      }
      if (!empty($this->input->post('twitter')))
      {
        $query = $this->db->query("select * from contents where user_id = '$user_id' and meta_key = 'twitter_url'");

        if ($query->num_rows() > 0)
        {
          $data['twitter'] = $query->row();
          $Twitter = [
            'value' => $this->input->post('twitter')
          ];

          if ($this->Classics->update_twitter_url($Twitter,$user_id,$data['twitter']->content_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
          {

          }
          else
          {
            echo '<script>alert("Something went wrong...");</script>';
            redirect('/Classic/contacts', 'refresh');
          }
        }
        else
        {
          $Twitter = [
            'user_id' => $user_id,
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
            echo '<script>alert("Something went wrong...");</script>';
            redirect('/Classic/contacts', 'refresh');
          }
        }
      }
    }
    redirect('/Classic/contacts', 'refresh');
  }

  public function image_slider()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['slider_images'] = $this->Classics->get_slider_images($user_id);
    $this->load->view('account/themes/'.$theme.'/image_slider/index',$data);
  }

  public function add_image_slider()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $this->load->view('account/themes/'.$theme.'/image_slider/add',$data);
  }

  public function save_image_slider()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $query = $this->db->query("select count(value) as count from contents where user_id = '$user_id' and meta_key = 'image_slider'");
    $count = $query->row();
    if ($count->count < 3)
    {
      if(!empty($_FILES['picture']['name']))
      { //If may laman na image
          $config['upload_path'] = 'uploads/themes/'.$theme;
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
                'user_id' => $user_id,
                'meta_key' => 'image_slider',
                'content_title' => '',
                'description' => '',
                'value' => $picture
              ];

              $this->db->insert('contents',$Image);
              echo '<script>alert("Image added!");</script>';
              redirect('/Classic/image_slider', 'refresh');
          }else{
            echo '<script>alert("Something went wrong, image not uploaded...");</script>';
            redirect('/Classic/image_slider', 'refresh');
          }
      }
      else
      {
        redirect('/Classic/add_image_slider', 'refresh');
      }
    }
    else
    {
      echo '<script>alert("Sorry, you have reached the maximum number of image you can upload for the image slider..");</script>';
      redirect('/Classic/image_slider', 'refresh');
    }
  }

  public function view_slider_image($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['image'] = $this->Classics->get_image_slider($user_id,$content_id);
    $this->load->view('account/themes/'.$theme.'/image_slider/view',$data);
  }

  public function edit_slider_image($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['image_slider'] = $this->Classics->get_image_slider($user_id,$content_id);
    $this->load->view('account/themes/'.$theme.'/image_slider/edit',$data);
  }

  public function update_image_slider($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;

    if(!empty($_FILES['picture']['name'])){ //If may laman na image
        $config['upload_path'] = 'uploads/themes/'.$theme;
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
              'value' => $picture
            ];

            if ($this->Classics->update_image_slider($Image,$user_id,$content_id)) {
              redirect('/Classic/image_slider', 'refresh');
            }
        }else{
          echo '<script>alert("Something went wrong, image cannot be updated..");</script>';
          redirect('/Classic/edit_slider_image', 'refresh');
        }
    }
  }

  public function delete_slider_image($content_id)
  {
    $user_id = $_SESSION['user_id'];
    $this->db->where('content_id', $content_id);
    $this->db->where('user_id', $user_id);
    $this->db->where('meta_key', 'image_slider');
    $this->db->delete('contents');
     echo '<script>alert("Image deleted!");</script>';
     redirect('/Classic/image_slider', 'refresh');
  }

  public function theme()
  {
    $user_id = $_SESSION['user_id'];
    $data['account'] = $this->Classics->get_account_details($user_id);
    $data['business'] = $this->Classics->get_business_details($user_id);
    $theme = $data['business']->template;
    $data['themes'] = $this->Classics->get_themes();
    $this->load->view('account/themes/'.$theme.'/theme/index',$data);
  }

  public function save_template()
  {
    $user_id = $_SESSION['user_id'];
    $data['business'] = $this->Classics->get_business_details($user_id);
    $data['account'] = $this->Classics->get_account_details($user_id);
    $template = $this->input->post('template');
    $Template = [
      'template' => $this->input->post('template')
    ];

    if ($this->Classics->update_user_template($Template,$user_id)) //KAPAG SUCCESSFULLY NAGUPDATE ANG TEMPLATE
    {
      redirect('/Classic/theme', 'refresh');

    }
    else
    {
      echo '<script>alert("Cannot activate the theme...");</script>';
      redirect('/Classic/theme', 'refresh');
    }
  }
}
