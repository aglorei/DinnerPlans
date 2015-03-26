<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bid extends CI_Model
{

  // retrieve the current highest bid
  public function current_max_bid($item_number)
  {
    return $this->db->where('meal_id', $item_number)->order_by('bid', 'desc')->limit(1)->get('bids')->row_array();
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
    return $this->db->query($query,  $array );
  }

  // get user bid history for a specific meal
  public function user_meal_bid_history($user, $meal)
  {
    $query = "SELECT * FROM bids WHERE user_id = ? AND meal_id = ? ORDER BY bid DESC";
    return $this->db->query($query, array($user, $meal))->result_array();
  }

  // get user items bid history (unique items only)
  public function user_bid_history($user_id)
  {
    $query = "SELECT b.bid, m.meal, m.description, m.current_price, m.ended_at, DATEDIFF(DATE_ADD(m.created_at, INTERVAL m.duration DAY), NOW()) AS remaining_days FROM (SELECT * FROM bids WHERE user_id = ? ORDER BY bid DESC) AS b JOIN meals m ON b.meal_id = m.id GROUP BY b.meal_id;";
    return $this->db->query($query, array($user_id))->result_array();
  }

  // get the current highest bidder for a specific meal
  public function highest_bidder($id)
  {
    $max = $this->current_max_bid($id);
    $query = "SELECT users.*, CONCAT_WS(' ', users.first_name, users.last_name) AS user_name FROM users JOIN bids ON bids.user_id = users.id WHERE bids.id = ?";
    return $this->db->query($query, array('id' =>$max['id']))->row_array();
  }
}