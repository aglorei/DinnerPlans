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
	public function index($category)
	{
		if($category)
		{
			$meals = $this->Meal->show_meals_by_category($category);
		}
		else
		{
			$meals = $this->Meal->show_meals();
		}

		$categories = $this->Meal->show_categories();
		
		$view_data = array(
			"meals" => $meals,
			"categories" => $categories
		);

		$this->load->view('meals/listings', $view_data);
	}

	// show a single meal
	public function show_listing($id)
	{
		$meal = $this->Meal->show_meal($id);

		$bid_phrase = "Make your bid!";

		$this->load->model('Bid');
		$meal['bid_count'] = $this->Bid->item_bid_count($meal['id']);
		$meal['chef'] = $this->Meal->chef_name($meal['id']);
		$meal['end_time'] = strtotime($this->Meal->meal_end_time($meal['id']));

		if(!$meal['bid_count'])
		{
			$bid_phrase = "Be the first to bid!";
		}

		$view_data = array(
			"meal" => $meal,
			"bid_phrase" => $bid_phrase
		);

		$this->load->view('meals/listing',$view_data);
	}

	public function filter_listing()
	{

		$prefsString = "";

		foreach($this->input->post() as $pref)
		{
			
			if(substr($pref,0,-2) == "dietary")
			{
				$prefsString .= $value;
			}
		}

		$meal = $this->Meal->show_meals_by_preferences($prefs);

		$view_data = array(
			"meal" => $meal
		);

		$this->load->view('meals/listing');
	}
}