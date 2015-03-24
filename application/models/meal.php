<?php 
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

	function show_max_bid($id)
	{
		$query = "SELECT MAX(value) AS max_bid FROM bids WHERE meal_id = ?;";
		$values = array($id);
		$result = $this->db->query($query,$values)->row_array();
		return $result;
	}
}
?>