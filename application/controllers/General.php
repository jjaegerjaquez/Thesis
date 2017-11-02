<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class General extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Generals');
    if (!$this->session->userdata('is_logged_in')) {
      redirect('/User');
    }
	}

  public function index()
  {
    // $user_id = $_SESSION['user_id'];
    $this->load->view('general/index');
  }

  public function insert_general()
  {
    $this->form_validation->set_rules('image', 'Image', 'callback_FileSelected');
    $this->form_validation->set_rules('business_name', 'Business Name', 'required');
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('general/index');
    }
    else
    {
      $config['upload_path'] = 'uploads/images/';
      $config['overwrite'] = TRUE;
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['file_name'] = $_FILES['image']['name'];

      $this->load->library('upload',$config);
      $this->upload->initialize($config);

        if($this->upload->do_upload('image')){
            $uploadData = $this->upload->data();
            $picture = $uploadData['file_name'];
        }else{
            $picture = '';
        }
          $generalData = array(
              'user_id' => $_SESSION['user_id'],
              'business_name' => $this->input->post('business_name'),
              'image' => $picture
          );

          $this->db->insert('general',$generalData);
          echo '<script>alert("Saved!");</script>';
          redirect('/General', 'refresh');
      // $this->db->insert('users',$RegisterData);
      // echo '<script>alert("Successfully registered!");</script>';
      // redirect('/User', 'refresh');
    }
  }

  public function FileSelected()
  {
    $this->form_validation->set_message('FileSelected', 'Please select file.');
    if (empty($_FILES['image']['name']))
    {
        return false;
    }
    else
    {
      return true;
    }
  }
}
