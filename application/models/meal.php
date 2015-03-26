<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Model
{
	// list all current categories
	function show_categories()
	{
		return $this->db->query("SELECT * FROM categories ORDER BY category;")->result_array();
	}

	// return all (dietary) options
	function show_options()
	{
		return $this->db->query("SELECT * FROM options;")->result_array();
	}

	// return all options for this meal
	function show_options_by_meal($id)
	{
		$query = "SELECT GROUP_CONCAT(' ',o.option) AS options FROM options o INNER JOIN meal_has_options mho on o.id = mho.option_id WHERE mho.meal_id = ?;";
		$values = array($id);
		$result = $this->db->query($query,$values)->row_array();
		// (query returns and array of 1 result - issue with group_concat? force function to return a string instead)
		$options = $result["options"];
		return $options;
	}

	// return all meals
	function show_meals()
	{
		return $this->db->query("SELECT m.* FROM meals m LEFT JOIN meal_has_options mho on m.id = mho.meal_id WHERE ended_at IS NULL GROUP BY m.id ORDER BY m.meal_date;")->result_array();
	}

	function show_meals_by_category($category)
	{
		$query = "SELECT m.* FROM meals m LEFT JOIN meal_has_options mho on m.id = mho.meal_id WHERE m.category_id = ? AND ended_at IS NULL GROUP BY m.id ORDER BY m.meal_date;";
		$values = array($category);
		$result = $this->db->query($query,$values)->result_array();
		return $result;
	}

	// order meals by preference
	function show_meals_by_preferences($prefs,$prices,$ratings)
	{
		$valueArr = array();

		$query = "SELECT m.* FROM meals m  LEFT JOIN meal_has_options mho on m.id = mho.meal_id";
		// $query .= " INNER JOIN users u on m.user_id = u.id ";
		$query .= " WHERE (0 = 0) AND (ended_at IS NULL) ";

		if(strlen($prefs) > 0)
		{
			$query .= " AND mho.option_id IN (?)";
			array_push($valueArr,$prefs);
		}

		if(count($prices) > 0)
		{
			$query .= " AND (m.initial_price > ? AND m.initial_price <= ?)";
			array_push($valueArr,$prices["lowPrice"],$prices["highPrice"]);
		}

		// for future ratings - hold on to this
		// if(strlen($ratings) > 0)
		// {
		// 	$query .= "AND u.rating >= ?";
		// 	array_push($valueArr,$rating);
		// }

		$query .= " GROUP BY m.id ORDER BY meal_date";

		$values = $valueArr;

		$result = $this->db->query($query,$values)->result_array();

		// var_dump($query);
		// var_dump($values);
		// var_dump($result);
		// die("query in model");

		return $result;
	}


	// return meal based on id. (if for some reason meals.user_id isn't set or can't be found, use left join to pull meal info regardless.)
	function show_meal($id)
	{
		$query = "SELECT m.*,u.description AS bio, CONCAT_WS(' ',u.first_name, u.last_name) AS host, GROUP_CONCAT(' ',o.option) AS options FROM meals m LEFT JOIN meal_has_options mho on m.id = mho.meal_id INNER JOIN options o on mho.option_id = o.id LEFT JOIN users u on m.user_id = u.id WHERE m.id = ?;";
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
		$query = "SELECT DATE_ADD(created_at, INTERVAL duration DAY) AS end_date FROM meals WHERE id=?";

		return $this->db->query($query, array('id'=> $item_number))->row_array()['end_date'];
	}

	//retrieve the date the item ended (may be null)
	public function meal_ended_at($item_number)
	{
		return $this->db->where('id', $item_number)->select('ended_at')->get('meals')->row_array()['ended_at'];
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

	// get the name of the chef
	public function chef_name($id)
	{
		$query = "SELECT CONCAT_WS(' ', first_name, last_name) AS chef FROM users LEFT JOIN meals ON meals.user_id = users.id WHERE meals.id = ?";
		return $this->db->query($query, array($id))->row_array()['chef'];
	}

	// update the item/meal
	public function update_meal($meal)
	{
		$id = $meal['id'];
		unset($meal['id']);
		return $this->db->where('id', $id)->update('meals', $meal);
	}

	public function update_current_price($price, $id)
	{
		return $this->db->where('id', $id)->set('current_price', $price)->update('meals');
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
		return $this->db->query($query)->row_array();

	}

	// return all meals for a single user_id
	public function show_meals_by_user($id)
	{
		return $this->db->query("SELECT m.id, m.meal, m.description, m.initial_price, c.category, DATE_FORMAT(m.created_at,'%M %e, %Y at %h:%i %p') AS created_at, m.current_price, DATE_FORMAT(m.ended_at,'%M %e, %Y at %h:%i %p') AS ended_at, DATE_FORMAT(m.meal_date,'%M %e, %Y') AS meal_date, DATEDIFF(DATE_ADD(m.created_at, INTERVAL m.duration DAY), NOW()) AS remaining_days FROM meals m JOIN categories c ON m.category_id = c.id WHERE m.user_id = ? ORDER BY m.id DESC;", array($id))->result_array();
	}

	// retrieve all active meal listings
	public function active_meals()
	{
		return $this->db->query("SELECT *, DATE_ADD(created_at, INTERVAL duration DAY) AS end_date FROM meals WHERE ended_at IS NULL ORDER BY end_date;")->result_array();
	}

	// create a new listing
	public function create_meal($meal)
	{
		// create listing in meals table
		$this->db->query('INSERT INTO meals (meal, description, user_id, initial_price, category_id, created_at, current_price, meal_date, duration) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?);', array($meal['meal'], $meal['description'], $meal['user_id'], $meal['initial_price'], $meal['category_id'], $meal['current_price'], $meal['meal_date'], $meal['duration']));

		// set meal id
		$meal_id = $this->db->insert_id();

		// create image in images table
		$this->db->query('INSERT INTO images (image, file_path, created_at) VALUES (?, ?, NOW());', array($meal['file_name'], '/uploads/'.$meal['file_name']));

		// set image id
		$image_id = $this->db->insert_id();

		// link meal and image in meal_has_images table
		$this->db->query('INSERT INTO meal_has_images (meal_id, image_id) VALUES (?, ?);', array($meal_id, $image_id));

		// for each option, insert into database
		foreach ($meal['options'] as $option)
		{
			$this->db->query('INSERT INTO meal_has_options (meal_id, option_id) VALUES (?, ?);', array($meal_id, $option));
		}
	}

	// will close a listing after the auction expires
	public function end_listing($id)
	{
		$query = "UPDATE meals SET ended_at = NOW() WHERE id= ?";
		return $this->db->query($query, array($id));
	}

	public function update_highest_bidder($user_id, $meal_id)
	{
		return $this->db->where('id', $meal_id)->set("highest_bidder", $user_id)->update('meals');
	}
}

