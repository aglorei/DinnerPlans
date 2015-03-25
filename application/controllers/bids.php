<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bids extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Meal', 'Bid'));
  }

  public function after_bid()
  {
    $meal = $this->session->flashdata('meal');
    $meal['img'] = $this->Meal->get_meal_img($meal['id']);
    $meal['end_time'] = strtotime($this->Meal->meal_end_time($meal['id']));
    $header = $this->session->flashdata('header');
    $bid_message = $this->session->flashdata('bid_message');
    $array = array('meal' => $meal, 'bid_message' => $bid_message, 'header' => $header);

    if($this->session->flashdata('winner'))
    {
      $array['winner'] = $this->session->flashdata('winner');
    }

    $this->load->view('bids/after', $array);
  }

  // place a new bid
  public function place_bid()
  {
    if(!$this->input->post() || !$this->session->userdata('id'))
    {
      if(isset($_SERVER['HTTP_REFERER']))
      {
        redirect($_SERVER['HTTP_REFERER']);
      }
      else 
      {
        redirect("/");
      }
    }
    $this->load->helper('form');


    // do some validation
    $this->form_validation->set_rules('bid-amount', 'Bid Amount', 'required|numeric'); 
    $this->form_validation->set_rules('meal-id', 'Meal', 'required|integer');
    $user_id = $this->session->userdata('id');


    // redirect on failure
    if(!$this->form_validation->run())
    {
      redirect($_SERVER['HTTP_REFERER']);
    }

    // need to test for current high bidder is increasing bid amount, currently adds to total price and increases bid amount
    // which is wrong ....

    $item_number = $this->input->post('meal-id');
    $bid_amount = $this->input->post('bid-amount');

    //testing purposes
    // $user_id = 2;

    $meal = $this->Meal->show_meal($item_number);

    $this->session->set_flashdata('meal', $meal);
    $this->session->set_flashdata('header', "Bid Failure");

    if(!$this->bidable($item_number))
    {
      redirect("after_bid");
      return false;
    }

    // determine if the bid is valid
    if(!$this->valid_bid($bid_amount, $meal, $user_id))
    {
      redirect("after_bid");
      return false;
    }

    $highest_bid = $this->Bid->current_max_bid($item_number);
    $bid_count = $this->Bid->item_bid_count($item_number);
    
    // record the new bet into the database
    if(!$this->Bid->add_new_bid(array("bid" => $bid_amount, 'user_id' => $user_id, 'meal_id' => $item_number)))
    {
      $this->session->set_flashdata("bid_message", "An error occurred, please contact a site administrator");
      redirect("after_bid");
      return false;
    }

    if($user_id == $highest_bid['user_id']) {
      $this->session->set_flashdata('header', 'Bid Update Success');
      $this->session->set_flashdata('bid_message', 'Your bid amount has been updated');
      redirect("after_bid");
    }

    if($bid_count)
    {
      $current_max_bid = $highest_bid['bid'];
    }
    else 
    {
      $current_max_bid = 0;
    }

    // determine if the new bid is the highest bid
    if($bid_amount > $current_max_bid || (!$bid_count && $bid_amount >= $current_max_bid))
    {
      $meal['current_price'] = $current_max_bid;
      $winner = true;
    }
    else 
    {
      $meal['current_price'] = $bid_amount;
      $winner = false;
    }

    $this->Meal->update_meal($meal);
    $this->session->set_flashdata('meal', $meal);
    $this->session->set_flashdata('header', "Bid Success");
    $this->session->set_flashdata('bid_message', 'Your bid was successful');
    $this->session->set_flashdata('winner', $winner);
    redirect("after_bid");
  }

  // make sure an item is able to take bids (auction has not ended, item exists)
  public function bidable($item_number)
  {
    if(!$this->Meal->meal_exists($item_number))
    {
      $this->session->set_flashdata('bid_message', 'An error has occurred, the item you are bidding on does not exist');
      return false;
    }

    $dbtime = strtotime($this->Meal->meal_end_time($item_number));
    $curtime = time();

    if($curtime - $dbtime <= 0 || $this->Meal->meal_ended_at($item_number) != NULL)
    {
      $this->session->set_flashdata('bid_message', 'This auction has already ended');
      return false;
    }

    return true;
  }

  // determine if the bid is valid (item/meal owner is not bidding, the bid amount is >= current price + incrementor || == initial price if first bid)
  public function valid_bid($bid_amount, $meal, $user_id)
  {
    if($user_id == $meal['user_id']) {
      $this->session->set_flashdata('bid_message', 'You may not bid on your own listing');
      return false;
    }
    if(!($meal['initial_price'] == $meal['current_price'] && $meal['current_price'] <= $bid_amount) && $bid_amount < $meal['current_price'] + 5)
    {
      $this->session->set_flashdata('bid_message', 'You have not enter an appropriate bid amount');      
      return false;
    }

    // if the user has bid on the item previously, the current bid must be more than the last
    $past_bids = $this->Bid->user_meal_bid_history($user_id, $meal['id']);

    if(count($past_bids)) 
    {
      if($bid_amount <= $past_bids[0]['bid'])
      {
        $this->session->set_flashdata('bid_message', 'You must enter an amount higher than your previous bid');
        return false;
      }
    }
    return true;
  }
}