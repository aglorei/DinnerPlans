<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bid extends CI_Model
{

  // retrieve the current highest bid
  public current_max_bid($item_number)
  {
    return $this->db->select('bid, id')->from('bids')->where('meal_id', $item_number)->order_by('bid', 'desc')->limit(1)->get()->row_array();
  }


  // retrieve the total number of bids on item/meal
  public function item_bid_count($item_number)
  {
    return $this->db->where('meal_id', $item_number)->select('count(id) AS total_bids')->from('bids')->get()->row_array()['total_bids'];
  }

  // insert a new bid into the database
  public function add_new_bid($array)
  {
    $query = "INSERT INTO bids (bid, user_id, meal_id, created_at) VALUES(?, ?, ?, NOW())";
    return $this->db->query($query, $array);
  }


}