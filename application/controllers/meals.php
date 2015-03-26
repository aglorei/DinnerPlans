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
		else if ($this->session->flashdata('meals'))
		{
			$meals = $this->session->flashdata('meals');
		}
		else
		{
			$meals = $this->Meal->show_meals();
			// die("no filter");
		}

		// find all (meal) categories 
		$categories = $this->Meal->show_categories();

		// return all (dietary) options
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
		// retrieve mealinfo
		$meal = $this->Meal->show_meal($id);

		$bid_phrase = "Make your bid!";

		$this->load->model('Bid');
		$meal['bid_count'] = $this->Bid->item_bid_count($meal['id']);
		$meal['end_time'] = strtotime($this->Meal->meal_end_time($meal['id']));
		$meal['img'] = $this->Meal->get_meal_img($meal['id'])['img_path'];

		if(!$meal['bid_count'])
		{
			$bid_phrase = "Be the first to bid!";
			$highest_bidder = NULL;
		}
		else 
		{
			$highest_bidder = $this->Bid->highest_bidder($meal['id']);
		}

		$view_data = array(
			"meal" => $meal,
			"bid_phrase" => $bid_phrase,
			"highest_bidder" => $highest_bidder
		);

		$this->load->view('meals/listing',$view_data);
	}

	public function filter_listing()
	{
		// concatenate values of checkboxes
		$prefsArr = array();
		$pricesArr = array();
		$ratingsArr = array();

		// store names of checkboxes that were submitted
		// $checkboxArr = array();

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
				// save name of checkbox
				// array_push($checkboxArr,$pref);
			}
			// extract name of preference
			if(substr($pref,0,-2) == "price")
			{
				// push value to array
				array_push($pricesArr,$value);
				// save name of checkbox
				// array_push($checkboxArr,$pref);
			}
			// extract name of preference
			if(substr($pref,0,-2) == "rating")
			{
				// push value to array
				array_push($pricesArr,$value);
				// save name of checkbox
				// array_push($checkboxArr,$pref);
			}
		}

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

		// pass prefs to query
		$meals = $this->Meal->show_meals_by_preferences($prefs,$prices,$ratings);

		$this->session->set_flashdata('meals',$meals);
		$this->session->set_flashdata('checkboxes',$this->input->post());

		redirect("/meals/listings");
	}

	public function create_listing($id)
	{
		// set validation rules
		$this->form_validation->set_rules('meal', 'meal title', 'trim|required|alpha_dash|min_length[2]');
		$this->form_validation->set_rules('description', 'meal description', 'required|max_length[350]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[12]');
		$this->form_validation->set_rules('password_confirm', 'password confirmation', 'trim|required|matches[password]');
		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 500;
		$config['max_width'] = 2400;
		$config['max_height'] = 2400;

		// load upload library with above config rules
		$this->load->library('upload', $config);

		// if upload fails to validate, redirect back
		if (!$this->upload->do_upload())
		{
			$errors['upload'] = $this->upload->display_errors();

			$this->session->set_flashdata('errors', $errors);

			redirect('/account');
		}
		// else, upload and update database with filepath
		else
		{
			$data = $this->upload->data();

			// var_dump($data);

			$upload = array(
				'id' => $id,
				'file_name' => $this->upload->data('file_name')
			);

			$this->load->model('user');
			$this->user->upload_picture($upload);

			redirect('/account');
		}
	}
}