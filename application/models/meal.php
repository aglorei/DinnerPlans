<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Model 
{

	// return all categories
	function show_categories()
	{
		return $this->db->query("SELECT * FROM categories ORDER BY category;")->result_array();
	}

	// return all (dietary) options
	function show_options()
	{
		return $this->db->query("SELECT * FROM options;")->result_array();
	}

	// return all meals
	function show_meals()
	{
		return $this->db->query("SELECT m.*,GROUP_CONCAT(' ',o.option) AS options FROM meals m INNER JOIN meal_has_options mho on m.id = mho.meal_id INNER JOIN options o on mho.option_id = o.id ORDER BY meal_date;")->result_array();
	}

	// return meals based on category
	function show_meals_by_category($category)
	{
		$query = "SELECT m.*,GROUP_CONCAT(' ',o.option) AS options FROM meals m INNER JOIN meal_has_options mho on m.id = mho.meal_id INNER JOIN options o on mho.option_id = o.id WHERE category_id = ? ORDER BY meal_date;";
		$values = array($category);
		$result = $this->db->query($query,$values)->result_array();
		return $result;
	}

	// return meals based on string of preferences passed in
	function show_meals_by_preferences($prefs,$prices,$ratings)
	{
		echo "prefs: ";
		var_dump($prefs);
		echo "prices:";
		var_dump($prices);
		echo "ratings";
		var_dump($ratings);
		

		$valueArr = array();
		
		$query = "SELECT m.* , GROUP_CONCAT(' ',o.option) AS options FROM meals m";
		$query .= " INNER JOIN meal_has_options mho on m.id = mho.meal_id INNER JOIN options o on mho.option_id = o.id";
		// $query .= " INNER JOIN users u on m.user_id = u.id ";
		$query .= " WHERE (0 = 0)";

		if(strlen($prefs) > 0)
		{
			$query .= " AND mho.id IN (?)";
			array_push($valueArr,$prefs);
		}

		if(count($prices) > 0)
		{
			$query .= " AND (m.initial_price > ? AND m.initial_price <= ?)";
			array_push($valueArr,$prices["lowPrice"],$prices["highPrice"]);
		}

		// hold on to this
		// if(strlen($ratings) > 0)
		// {
		// 	$query .= "AND u.rating >= ?";
		// 	array_push($valueArr,$rating);
		// }

		$values = $valueArr;

		// var_dump($query);
		// var_dump($values);
		// die("query in model");

		$result = $this->db->query($query,$values)->result_array();
				
		var_dump($result);
		die("in model");
		return $result;
	}

	// return meal based on id. (if for some reason meals.user_id isn't set or can't be found, use left join to pull meal info regardless.)
	function show_meal($id)
	{
		$query = "SELECT m.*,u.description AS bio, CONCAT_WS(' ',u.first_name, u.last_name) AS host, ";
		$query .= "GROUP_CONCAT(' ',o.option) AS options FROM meals m ";
		$query .= "INNER JOIN meal_has_options mho on m.id = mho.meal_id ";
		$query .= "INNER JOIN options o on mho.option_id = o.id LEFT JOIN users u on m.user_id = u.id ";
		$query .= "WHERE m.id = ?;";
		$values = array($id);
		$result = $this->db->query($query,$values)->row_array();
		return $result;
	}
	
  // determine if the item/meal item number is real
  public function meal_exsits($item_number)
  {
    return $this->db->where('id', $item_number)->count_all_results('meals');
  }

  // retrieve the date the item will end (acquired by adding 'duration' to 'created_at' in days)
  public function meal_end_time($item_number)
  {
    $interval = $this->db->where('id', $item_number)->get('meals')->row_array()['duration'];
    $query = "SELECT DATE_ADD(created_at, INTERVAL " . $interval . " DAY) AS end_date FROM meals WHERE id=?";
    return $this->db->query($query, array('id'=> $item_number))->row_array();
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
    return $this->db->where('id', $id)->update('meals', $meal);
  }

  //retrieves a single image for display on the errors page
  public function get_meal_img($item_number)
 { 
   $query = "SELECT file_path AS img_path FROM images LEFT JOIN meal_has_images ON meal_has_images.image_id = images.id LEFT JOIN meals ON meal_has_images.meal_id = meals.id WHERE meals.id = ? ORDER BY images.created_at DESC LIMIT 1";

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
   $query = "SELECT file_path AS img_path FROM images WHERE id = 1";
   return $this->db->query($query)->row_array()['img_path'];
 }
}

