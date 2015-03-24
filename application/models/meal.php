<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Model
{
  // determine if the item/meal item number is real
  public function item_exsits($item_number)
  {
    return $this->db->where('id', $item_number)->count_all_results('meals');
  }

  // retrieve the date the item will end (acquired by adding 'duration' to 'created_at' in days)
  public function item_end_time($item_number)
  {
    $interval = $this->db->where('id', $item_number)->get('meals')->row_array()['duration'];
    $query = "SELECT DATE_ADD(created_at, INTERVAL " . $interval . " DAY) AS end_date FROM meals WHERE id=?";
    return $this->db->query($query, array('id'=> $item_number))->row_array());
  }

  //retrieve the date the item ended (may be null)
  public function item_ended_at($item_number)
  {
    return $this->db->where('id', $item_number)->select('ended_at')->get('meals')->row_array()['ended_at'];
  }

  // retrieve all current data on item/meal
  public select_meal($item_number)
  {
    return $this->db->where('id', $item_number)->get('meals')->row_array();
  }



  // retrieve the current price of the item/meal
  public function current_price($item_number)
  {
    return $this->db->where('id', $item_number)->get('meals')->row_array()['current_price'];
  }

  // retrieve the initial starting price of the item/meal
  public function initial_price($item_number)
  {
    return $this->db->where('id', $item_number)->get('meals')->row_array()['initial_price'];
  }

  // retrieve the current highest bet 
  public current_max_bet($item_number)
  {
    return $this->db->select('bid, id')->from('bids')->where('meal_id', $item_number)->order_by('bid', 'desc')->limit(1)->get()->row_array();
  }

  // retrieve the total number of bids on item/meal
  public function item_bid_count($item_number)
  {
    return $this->db->where('meal_id', $item_number)->select('count(id) AS total_bids')->from('bids')->get()->row_array()['total_bids'];
  }

  // insert a new bet into the database
  public function add_new_bet($array)
  {
    return $this->db->insert('')
  }

  // update the item/meal
  public function update_meal($meal)
  {
    return $this->db->where('id', $meal['id'])->update('meals', $meal);
  }

  //retrieves a single image for display on the errors page
  public function get_meal_img($item_number)
  { 
    $query = "SELECT *, CONCAT(file_path, image) AS img_path FROM images " +
    "LEFT JOIN meal_has_images ON images.id = meal_has_images.images_id " +
    "LEFT JOIN meals ON meal_has_images.meal_id = meals.id " +
    "WHERE meals.id = ? ORDER BY created_at LIMIT 1 DESC";

    $returned = $this->db->query($query, array("id", $item_number))->row_array();

    if(!count($returned))
    {
      $returned = $this->default_meal_image();
    }

    return $returned;
  }

  // retrieve default item/meal image
  public function default_meal_image()
  {
    return $this->db->select("CONCAT(file_path, image) AS img_path")->from('images')->where('id', 0)->row_array();
  }
}