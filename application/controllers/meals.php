<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Meals extends CI_Controller
{
	public function __construct()
	{
	    parent::__construct();
	    // load model
	    $this->load->model("Meal");
	}

	// will load all meals, order by category if needed
	public function index($category=0)
	{
		if(!empty($this->input->post()))
		{
			$meals = $this->filter_listing($this->input->post());
			// die("filtered by prefs");
		}

		// (set $category to 0 as default)
		else if($category)
		{
			$meals = $this->Meal->show_meals_by_category($category);
			// die("filtered by category");
		}
		else
		{
			$meals = $this->Meal->show_meals();
			// die("no filter");
		}

		var_dump($meals);

		$categories = $this->Meal->show_categories();
		$options = $this->Meal->show_options();

		$view_data = array(
			"meals" => $meals,
			"categories" => $categories,
			"options" => $options
		);

		$this->load->view('meals/listings', $view_data);
	}

	// show a single meal
	public function show_listing($id)
	{
		// retrieve meal info
		$meal = $this->Meal->show_meal($id);

		$bid_phrase = "Make your bid!";

		$this->load->model('Bid');
		$meal['bid_count'] = $this->Bid->item_bid_count($meal['id']);
		$meal['chef'] = $this->Meal->chef_name($meal['id']);
		$meal['end_time'] = strtotime($this->Meal->meal_end_time($meal['id']));
		$meal['img'] = $this->Meal->get_meal_img($meal['id']);

		if(!$meal['bid_count'])
		{
			$bid_phrase = "Be the first to bid!";
		}

		$view_data = array(
			"meal" => $meal,
			"bid_phrase" => $bid_phrase
		);

		// var_dump($view_data);
		// die("current");

		$this->load->view('meals/listing',$view_data);
	}

	public function filter_listing()
	{
		$prefsArr = array();
		$pricesArr = array();
		$ratingsArr = array();

		$prefs = "";
		$ratings = "";

		// loop through checkboxes submitted
		foreach($this->input->post() as $pref => $value)
		{
			// extract name of preference
			if(substr($pref,0,-2) == "dietary")
			{
				// push value to array
				array_push($prefsArr,$value);
			}
			// extract name of preference
			if(substr($pref,0,-2) == "price")
			{
				// push value to array
				array_push($pricesArr,$value);
			}
			// extract name of preference
			if(substr($pref,0,-2) == "rating")
			{
				// push value to array
				array_push($pricesArr,$value);
			}
		}

		// var_dump(count($pricesArr));
		// var_dump($pricesArr[count($pricesArr) - 1]);

		// order prices from low to high
		sort($pricesArr);

		// find low and high end
		if (count($pricesArr) > 0)
		{
			$lowPrice = $pricesArr[0];
			$highPrice = $pricesArr[count($pricesArr) - 1];

			// set corresponding dollar amounts for prices
			switch($lowPrice)
			{
				case 1: $lowPrice = 0;
				break;
				case 2: $lowPrice = 50;
				break;
				case 3: $lowPrice = 100;
				break;
				case 4: $lowPrice = 150;
			}

			switch($highPrice)
			{
				case 1: $highPrice = 50;
				break;
				case 2: $highPrice = 100;
				break;
				case 3: $highPrice = 150;
				break;
				case 4: $highPrice = 200;
			}
		}
		else
		{
			// set default values (to lowest and highest end of range)
			$lowPrice = 0;
			$highPrice = 200;
		}

		// create comma delimited string from array
		if(count($prefsArr))
		{
			$prefs = implode(",",$prefsArr);
		}

		if(count($ratingsArr))
		{
			$ratings = implode(",",$ratingsArr);
		}

		$prices = array(
			"lowPrice" => $lowPrice,
			"highPrice" => $highPrice
		);

		// echo $lowPrice;
		// echo $highPrice;
		// var_dump($prefs);
		// var_dump($prices);
		// var_dump($ratings);
		// die();

		// pass prefs to query
		$meals = $this->Meal->show_meals_by_preferences($prefs,$prices,$ratings);
		return $meals;
	}
}