<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Model
{

  function __construct()
  {
    parent::__construct();

  }

  public function get_category_result($category)
  {
    $query = $this->db->query("SELECT * FROM `basic_info` WHERE category = '$category'");
    return $query->result();
  }

}
