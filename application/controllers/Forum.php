<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Forum extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pagination');
    $this->load->library('session');
		$this->load->model('Forums');
    // $this->data['advertisements'] = $this->Advertisements->get_advertisements();
    $this->data['title'] = $this->Forums->get_title();
    $this->data['site_icon'] = $this->Forums->get_site_icon();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Forums->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Forums->get_traveller_profile($this->traveller_id);
    }
	}

  public function index()
  {

  }

  public function topic($topic_id)
  {
    $count =0;
    $this->data['topic'] = $this->Forums->get_topic($topic_id);
    $this->data['comments'] = $this->Forums->get_topic_comments($topic_id);
    foreach ($this->data['comments'] as $key => $comment) {
        $count++;
    }
    for ($i=0; $i <$count ; $i++) {
      $this->data['replies'.$i] = $this->Forums->get_replies($this->data['comments'][$i]->post_id);
    }

    // print_r($this->data['0']);
    // echo "<br>";
    // print_r($this->data['Bring your own food. Most of the times, the food in the place is very expensive, so bringing you own food will save you alot, and in result, you can use it for the actual trip expense.']);
    // $replies = '$replies';
    // echo $replies.$count;
    $this->data['reply_count'] = $this->Forums->get_reply_count($topic_id);
    $this->data['count'] = $count;
    $this->load->view('forum/view_topic/index',$this->data);
  }

  public function all()
  {
    $query = $this->db->get('topics','10', $this->uri->segment(3));
		$this->data['topics'] = $query->result();

		$query2= $this->db->get('topics');

		$config['base_url'] = '/Forum/all';
		$config['total_rows'] = $query2->num_rows();
		$config['per_page'] = 10;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';

		$config['first_tag_open'] = '<li>';
		$config['last_tag_open'] = '<li>';

		$config['next_tag_open'] = '<li>';
		$config['prev_tag_open'] = '<li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['first_tag_close'] = '</li>';
		$config['last_tag_close'] = '</li>';

		$config['next_tag_close'] = '</li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class=\"active\"><span><b>';
		$config['cur_tag_close'] = '</b></span></li>';

		$this->pagination->initialize($config);
    $this->load->view('forum/all',$this->data);
  }

  public function result()
  {
    $keyword = $this->input->post('keyword');
    $this->data['topics'] = $this->Forums->get_search_result($keyword);
    $this->load->view('forum/result/index',$this->data);
  }

  public function search()
  {
    if (!empty($this->input->get('keyword')))
    {
      if ($this->input->get('keyword') =='all') {
        $this->data['topics'] = $this->Forums->get_topics();
        if (!empty($this->data['topics']))
        {
          foreach ($this->data['topics'] as $key => $topic) {
            echo '
              <tr>
                <td>'.$topic->topic.'</td>
                <td>'.date('F j Y',$date = strtotime($topic->date_created)).'</td>
              </tr>
            ';
          }
        }
        else {
          echo "
            <tr>
              <td>0 results</td>
            </tr>
          ";
        }
      }
      else {
        $this->data['results'] = $this->Forums->get_search_result($this->input->get('keyword'));
        if (!empty($this->data['results']))
        {
          foreach ($this->data['results'] as $key => $result) {
            echo '
              <tr>
                <td>'.$result->topic.'</td>
                <td>'.date('F j Y',$date = strtotime($result->date_created)).'</td>
              </tr>
            ';
          }
        }
        else {
          echo "
            <tr>
              <td>0 results</td>
            </tr>
          ";
        }
      }
    }
  }

  public function submit_comment()
  {
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      // echo $this->input->get('comment');
      $this->form_validation->set_rules(
          'comment', 'Comment',
          'trim|required',
          array(
                  'required'      => 'Please enter your comment'
          )
      );
      if ($this->form_validation->run() == FALSE)
      {
        echo "Error";
      }
      else
      {
        $Post = [
          'topic_id' => $this->input->post('topic_id'),
          'user_id' => $this->traveller_id,
          'content' => $this->input->post('comment'),
          'date_created' => date("Y-m-d"),
          'date_updated' => NULL
        ];
        if ($this->db->insert('posts',$Post)) {
          echo "Successful";
        }
      }
    }
    else
    {
      echo "Not logged in";
    }
  }

  public function submit_reply($topic_id='')
  {
    $this->form_validation->set_rules(
        'reply', 'Reply',
        'trim|required',
        array(
                'required'      => 'Please enter your reply'
        )
    );
    if ($this->form_validation->run() == FALSE)
    {
      $this->data['topic'] = $this->Forums->get_topic($topic_id);
      $this->data['comments'] = $this->Forums->get_topic_comments($topic_id);
      $this->load->view('forum/view_topic/index',$this->data);
    }
    else
    {
      $Comment = [
        'topic_id' => $topic_id,
        'post_id' => $this->input->get('post_id'),
        'user_id' => $this->traveller_id,
        'reply_to_id' => $this->input->get('user_id'),
        'comment' => '@'.$this->input->get('username').'- '.$this->input->post('reply'),
        'date_created' => date("Y-m-d"),
        'date_updated' => NULL
      ];
      if ($this->db->insert('comments',$Comment)) {
        echo '<script>alert("Reply sucessfully submitted!");</script>';
        redirect('/Forum/topic/'.$topic_id, 'refresh');
      }
    }
  }

}
