<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bids extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Meal', 'Bid'));
  }

  public function failed_bid()
  {
    $meal = $this->session->flashdata('meal');
    $meal['img'] = $this->Meal->get_meal_img($meal['id']);
    $errors = $this->session->flashdata('error');
    $this->load->view('bids/failure', array('meal' => $meal, 'error' => $errors));
  }

  // place a new bid
  public function place_bid()
  {
    if(!$this->input->post())
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


    // redirect on failure
    if(!$this->form_validation->run())
    {
      redirect($_SERVER['HTTP_REFERER']);
    }

    // need to test for current high bidder is increasing bid amount, currently adds to total price and increases bid amount
    // which is wrong ....

    $item_number = $this->input->post('meal-id');
    $bid_amount = $this->input->post('bid-amount');
    $user_id = $this->session->userdata('id');

    //testing purposes
    // $user_id = 2;

    $meal = $this->Meal->show_meal($item_number);

    $this->session->set_flashdata('meal', $meal);

    if(!$this->bidable($item_number))
    {
      $this->session->set_flashdata('error', "You may not bid on this item");
      redirect("failed_bid");
      return false;
    }

    $bid_count = $this->Bid->item_bid_count($item_number);

    // determine if the bid is valid
    if(!$this->valid_bid($bid_amount, $meal, $user_id))
    {
      $this->session->set_flashdata('error', "You have not submitted a valid bid, please try again");
      redirect("failed_bid");
      return false;
    }

    if($bid_count)
    {
      $current_max_bid = $this->Bid->current_max_bid($item_number);
    }
    else 
    {
      $current_max_bid = 0;
    }

    // record the new bet into the database
    if(!$this->Bid->add_new_bid(array("bid" => $bid_amount, 'user_id' => $user_id, 'meal_id' => $item_number)))
    {
      $this->session->set_flashdata("error", "An error occurred, please contact a site administrator");
      redirect("failed_bid");
      return false;
    }

    // determine if the new bid is the highest bid
    if($bid_amount > $current_max_bid || ($bid_count && $bid_amount >= $current_max_bid))
    {
      $meal['current_price'] = $current_max_bid;
      $winner = true;
    }
    else 
    {
      echo "this shit is happening ";
      $meal['current_price'] = $bid_amount;
      $winner = false;
    }

    $this->Meal->update_meal($meal);
    $this->session->set_flashdata('meal', $meal);
    $this->session->set_flashdata('winner', $winner);
    redirect("bid_success");
  }

  // load the bid success page
  public function bid_success()
  {
    $meal = $this->session->flashdata('meal');
    $winner = $this->session->flashdata('winner');
    $this->load->view("bids/success", array("meal" => $meal, 'winner' => $winner));
  }


  // make sure an item is able to take bids (auction has not ended, item exists)
  public function bidable($item_number)
  {
    if(!$this->Meal->meal_exists($item_number))
    {
      return false;
    }

    $dbtime = strtotime($this->Meal->meal_end_time($item_number));
    $curtime = time();

    if($dbtime - $curtime <= 0 || $this->Meal->meal_ended_at($item_number) != NULL)
    {
      return false;
    }

    return true;
  }

  // determine if the bid is valid (item/meal owner is not bidding, the bid amount is >= current price + incrementor || == initial price if first bid)
  public function valid_bid($bid_amount, $meal, $user_id)
  {
    if($user_id == $meal['user_id']) {
      return false;
    }
    if(!($meal['initial_price'] == $meal['current_price'] && $meal['current_price'] <= $bid_amount) && $bid_amount < $meal['current_price'] + 5)
    {
      return false;
    }

    // if the user has bid on the item previously, the current bid must be more than the last
    $past_bids = $this->Bid->user_meal_bid_history($user_id, $meal['id']);

    if(count($past_bids)) 
    {
      if($bid_amount <= $past_bids[0]['bid'])
      {
        return false;
      }
    }
    return true;
  }
}