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
    $this->load->library('google');
    $this->load->library('facebook');
		$this->load->model('Forums');
    // $this->data['advertisements'] = $this->Advertisements->get_advertisements();
    $this->data['title'] = $this->Forums->get_title();
    $this->data['icon'] = $this->Forums->get_site_icon();
    $this->data['tagline'] = $this->Forums->get_tagline();
    $this->data['facebook'] = $this->Forums->get_facebook();
    $this->data['instagram'] = $this->Forums->get_instagram();
    $this->data['twitter'] = $this->Forums->get_twitter();
    $this->data['google'] = $this->Forums->get_google();
    $this->data['google_login_url']=$this->google->get_login_url();
    $this->data['fb_login_url'] =  $this->facebook->login_url();
    if ($this->session->userdata('traveller_is_logged_in'))
    {
      $this->traveller_id = $_SESSION['traveller_id'];
      $this->data['traveller_details'] = $this->Forums->get_traveller_details($this->traveller_id);
      $this->data['traveller_profile'] = $this->Forums->get_traveller_profile($this->traveller_id);
      $this->data['notif_count'] = $this->Forums->get_notif_count($this->traveller_id);
      $this->data['notifications'] = $this->Forums->get_notifications($this->traveller_id);
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
    // $query = $this->db->get('topics','5', $this->uri->segment(3));
		// $this->data['topics'] = $query->result();
    //
		// $query2= $this->db->get('topics');
    //
		// $config['base_url'] = '/Forum/all';
		// $config['total_rows'] = $query2->num_rows();
		// $config['per_page'] = 5;
    //
		// $config['full_tag_open'] = '<ul class="pagination">';
		// $config['full_tag_close'] = '</ul>';
    //
		// $config['first_tag_open'] = '<li>';
		// $config['last_tag_open'] = '<li>';
    //
		// $config['next_tag_open'] = '<li>';
		// $config['prev_tag_open'] = '<li>';
    //
		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';
    //
		// $config['first_tag_close'] = '</li>';
		// $config['last_tag_close'] = '</li>';
    //
		// $config['next_tag_close'] = '</li>';
		// $config['prev_tag_close'] = '</li>';
    //
		// $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
		// $config['cur_tag_close'] = '</b></span></li>';
    //
		// $this->pagination->initialize($config);
    // // $query2= $this->db->get_where('topics', ['created_by !=' => 'Admin']);
    // // $limit = 2;
    // // $offset = $this->uri->segment(3);
    // // $config['uri_segment'] = 3;
    // // $config['base_url'] = '/Forum/all';
    // // $config['total_rows'] = $query2->num_rows();
    // // $config['per_page'] = $limit;
    // // $config['full_tag_open'] = '<ul class="pagination">';
    // // $config['full_tag_close'] = '</ul>';
    // //
    // // $config['first_tag_open'] = '<li>';
    // // $config['last_tag_open'] = '<li>';
    // //
    // // $config['next_tag_open'] = '<li>';
    // // $config['prev_tag_open'] = '<li>';
    // //
    // // $config['num_tag_open'] = '<li>';
    // // $config['num_tag_close'] = '</li>';
    // //
    // // $config['first_tag_close'] = '</li>';
    // // $config['last_tag_close'] = '</li>';
    // //
    // // $config['next_tag_close'] = '</li>';
    // // $config['prev_tag_close'] = '</li>';
    // //
    // // $config['cur_tag_open'] = '<li class=\"active\"><span><b>';
    // // $config['cur_tag_close'] = '</b></span></li>';
    // // $this->pagination->initialize($config);
    // // $this->data['topics'] = $this->Forums->function_pagination($limit, $offset);
    // $this->load->view('forum/all',$this->data);

    $query2= $this->db->get_where('topics', ['created_by !=' => 'Admin'],['status' => '1']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Forum/all';
    $config['total_rows'] = $query2->num_rows();
    $config['per_page'] = $limit;
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
    $this->data['topics'] = $this->Forums->function_pagination($limit, $offset);
    $this->load->view('forum/topics/all',$this->data);
  }

  public function faqs()
  {
    $query2= $this->db->get_where('topics', ['created_by' => 'Admin']);
    $limit = 5;
    $offset = $this->uri->segment(3);
    $config['uri_segment'] = 3;
    $config['base_url'] = '/Forum/faqs';
    $config['total_rows'] = $query2->num_rows();
    $config['per_page'] = $limit;
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
    $this->data['faqs'] = $this->Forums->function_pagination_faqs($limit, $offset);
    $this->load->view('forum/faqs/all',$this->data);
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
      if ($this->input->get('filter') == 'all')
      {
        $this->data['results'] = $this->Forums->get_search_result($this->input->get('keyword'));
        if (!empty($this->data['results']))
        {
          foreach ($this->data['results'] as $key => $result) {
            echo '
              <tr>
                <td>
                  <ul class="topics">
                    <li><a href="/Forum/topic/'.$result->topic_id.'"><h4>'.$result->topic.'</h4></a></li>
                    <ul class="list-inline topic-details">
                      <li><span><i class="ion-android-person"></i> </span>Added by: '.$result->username.'</li>
                      <li><span><i class="ion-ios-calendar"></i> </span>'.date("F j Y",$date = strtotime($result->date_created)).'</li>
                    </ul>
                  </ul>
                </td>
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
      else
      {
        $this->data['results'] = $this->Forums->get_faqs_search_result($this->input->get('keyword'));
        if (!empty($this->data['results']))
        {
          foreach ($this->data['results'] as $key => $result) {
            echo '
              <tr>
                <td>
                  <ul class="topics">
                    <li><a href="/Forum/topic/'.$result->topic_id.'"><h4>'.$result->topic.'</h4></a></li>
                    <ul class="list-inline topic-details">
                      <li><span><i class="ion-android-person"></i> </span>Added by: '.$result->created_by.'</li>
                      <li><span><i class="ion-ios-calendar"></i> </span>'.date("F j Y",$date = strtotime($result->date_created)).'</li>
                    </ul>
                  </ul>
                </td>
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
        $data['topic_info'] = $this->Forums->get_topic_info($this->input->post('topic_id'));
        $my_date = date("Y-m-d h:i:s");
        $Post = [
          'topic_id' => $this->input->post('topic_id'),
          'user_id' => $this->traveller_id,
          'content' => $this->input->post('comment'),
          'date_created' => date("Y-m-d"),
          'date_updated' => NULL
        ];
        $my_date = date("Y-m-d h:i:s");
        $Notif = [
          'sender_id' => $this->traveller_id,
          'type_of_notification' => 'Comment',
          'title_content' => $this->data['traveller_details']->username.' commented on your post.',
          'body_content' => $this->input->post('comment'),
          'href' => base_url().'Forum/topic/'.$this->input->post('topic_id'),
          'recipient_id' => $data['topic_info']->created_by,
          'is_unread' => '0',
          'created_time' => $my_date
        ];
        if ($this->db->insert('posts',$Post) && $this->db->insert('notifications', $Notif)) {
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
      $my_date = date("Y-m-d h:i:s");
      $Notif = [
        'sender_id' => $this->traveller_id,
        'type_of_notification' => 'Reply',
        'title_content' => $this->data['traveller_details']->username.' replied on your comment.',
        'body_content' => '@'.$this->input->get('username').'- '.$this->input->post('reply'),
        'href' => base_url().'Forum/topic/'.$topic_id,
        'recipient_id' => $this->input->get('user_id'),
        'is_unread' => '0',
        'created_time' => $my_date
      ];
      if ($this->db->insert('comments',$Comment) && $this->db->insert('notifications',$Notif)) {
        echo "<script>alert('Reply sent!');document.location='/Forum/topic/".$topic_id."'</script>";
      }
    }
  }

  public function add_topic()
  {
    $this->load->view('forum/add/index',$this->data);
  }

  public function save_topic()
  {
    $this->form_validation->set_rules(
        'title', 'Title',
        'trim|required',
        array(
                'required'      => 'Please enter a descriptive title for your question'
        )
    );
    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('forum/add/index',$this->data);
    }
    else
    {
      $Topic = [
        'created_by' => $this->traveller_id,
        'topic' => $this->input->post('title'),
        'description' => $this->input->post('description'),
        'date_created' => date("Y-m-d"),
        'status' => '0'
      ];
      if ($this->db->insert('topics',$Topic)) {
        echo "<script>alert('The topic you created has been sent and will undergo review');document.location='/Forum/add_topic'</script>";
      }
    }
  }

}
