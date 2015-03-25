<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Model 
{

	function show_categories()
	{
		return $this->db->query("SELECT * FROM categories ORDER BY category;")->result_array();
	}

	function show_meals()
	{
		return $this->db->query("SELECT * FROM meals ORDER BY created_at DESC;")->result_array();
	}

	function show_meals_by_category($category)
	{
		$query = "SELECT * FROM meals WHERE category_id = ? ORDER BY created_at DESC;";
		$values = array($category);
		$result = $this->db->query($query,$values)->result_array();
		return $result;
	}

	function show_meals_by_preferences($prefs)
	{
		$query = "SELECT m.meal FROM meals m INNER JOIN meal_has_options mho on m.id = mho.meal_id INNER JOIN options o on mho.option_id = o.id WHERE o.id IN ($prefs);";
		$values = array($category);
		$result = $this->db->query($query,$values)->result_array();
		return $result;
	}

	function show_meal($id)
	{
		$query = "SELECT * FROM meals WHERE id = ?;";
		$values = array($id);
		$result = $this->db->query($query,$values)->row_array();
		return $result;
	}

  // determine if the item/meal item number is real
  public function meal_exists($item_number)
  {
    return $this->db->where('id', $item_number)->count_all_results('meals');
  }

  // retrieve the date the item will end (acquired by adding 'duration' to 'created_at' in days)
  public function meal_end_time($item_number)
  {
    $interval = $this->db->where('id', $item_number)->get('meals')->row_array()['duration'];
    $query = "SELECT DATE_ADD(created_at, INTERVAL " . $interval . " DAY) AS end_date FROM meals WHERE id=?";
    return $this->db->query($query, array('id'=> $item_number))->row_array()['end_date'];
  }

  //retrieve the date the item ended (may be null)
  public function meal_ended_at($item_number)
  {
    return $this->db->where('id', $item_number)->select('ended_at')->get('meals')->row_array()['ended_at'];
  }

  // retrieve all current data on item/meal
  // public function select_meal($item_number)
  // {
  //   return $this->db->where('id', $item_number)->get('meals')->row_array();
  // }

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

  // update the item/meal
  public function update_meal($meal)
  {		
  	$id = $meal['id'];
  	unset($meal['id']);
  	$this->db->update('meals')->set('updated_at', NOW());
    return $this->db->where('id', $id)->update('meals', $meal);
  }

  //retrieves a single image for display on the errors page
  public function get_meal_img($item_number)
  { 
    $query = "SELECT CONCAT(file_path, image) AS img_path FROM images LEFT JOIN meal_has_images ON meal_has_images.image_id = images.id LEFT JOIN meals ON meal_has_images.meal_id = meals.id WHERE meals.id = ? ORDER BY images.created_at DESC LIMIT 1";

    $returned = $this->db->query($query, array($item_number))->row_array();

    if(!count($returned))
    {
      $returned = $this->default_meal_image();
    }

    return $returned;
  }

  // retrieve default item/meal image
  public function default_meal_image()
  {
    $query = "SELECT CONCAT(file_path, image) AS img_path FROM images WHERE id = 1";
    return $this->db->query($query)->row_array()['img_path'];
  }
}

