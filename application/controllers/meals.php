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

	public function show_listing($id)
	{
		$meal = $this->Meal->show_meal($id);

		$bid_phrase = "Make your bid!";

		if($meal['current_price'] == $meal['initial_price'])
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

		var_dump($this->input->post());
		die("");
		$prefsString = "";

		foreach($this->input->post() as $pref)
		{
			// $value = substr($pref, -1, 1); // gets id of preference from end of name
			
			if(substr($pref,0,-2) == "dietary")
			{
				$prefsString .= $value;
			}
		}

		// var_dump($prefsString);
		// die("prefs");

		$meal = $this->Meal->show_meals_by_preferences($prefs);

		// var_dump($max_bid);
		// die("bid");

		$view_data = array(
			"meal" => $meal
		);

		$this->load->view('meals/listing');
	}

	

	public function logout()
	{
		$this->session->sess_destroy();

		redirect('/');
	}
}