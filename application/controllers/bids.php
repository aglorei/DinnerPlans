<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bids extends CI_Controller
{
  public function __contruct()
  {
    parent::__contruct();
    $this->load->model('meal');
    $this->load->model('bid');
  }


  public function failed_bid()
  {
    $meal = $this->session->flashdata('meal');
    $meal['img'] = $this->get_meal_img($meal['id']);
    $errors = $this->session->flashdata('error');
    $this->load->view('bids/failure', array('meal' => $meal, 'error' => $errors));
  }

  // place a new bid
  public function place_bid()
  {
    $this->load->helper('form');

    // do some validation
    $this->form_validation->set_rules('bid-amount', 'Bid Amount', 'required'); 
    $this->form_validation->set_rules('meal-id', 'Meal', 'required');
    $this->form_validation->set_rules('id', 'ID', 'required');
    $this->form_validation->set_rules('item-number', 'Item Number', 'required');

    // redirect on failure
    if(!$this->form_validation->run())
    {
      redirect($_SERVER['HTTP_REFERER']);
    }

    $item_number = $this->input->post('item-number');
    $bid_amount = $this->input->post('bid-amount');
    $user_id = $this->input->post('id');
    $meal = $this->meal->select_meal($item_number);
    $this->session->set_flashdata('meal', $meal);


    if(!bidable($item_number))
    {
      $this->session->set_flashdata('error', "You may not bid on this item");
      redirect("failed_bid");
      return false;
    }

    $bid_count = $this->bid->item_bid_count($item_number);

    // determine if the bid is valid
    if(!valid_bid($bid_amount, $meal, $user_id))
    {
      $this->session->set_flashdata('error', "You have not submitted a valid bid, please try again");
      redirect("failed_bid");
      return false;
    }

    if($bid_count)
    {
      $current_max_bid = $this->bid->current_max_bid($item_number);
    }
    else 
    {
      $current_max_bid = 0;
    }

    // record the new bet into the database
    if(!$this->bid->add_new_bid(array('user_id' => $user_id, 'meal_id' => $item_number , "bid" => $bid_amount)))
    {
      $this->session->set_flashdata("error", "An error occurred, please contact a site administrator");
      redirect("failed_bid");
      return false;
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

    $this->meal->update_current_price($meal);
    $this->session->set_flashdata('meal', $meal);
    $this->session->set_flashdata('winner', $winner);
    redirect("/bid_success");
  }


  // make sure an item is able to take bids (auction has not ended, item exists)
  public function bidable($item_number)
  {
    if(!$this->meal->item_exsits($item_number))
    {
      return false;
    }

    $dbtime = strtotime($this->meal->item_end_time($item_number));
    $curtime = time();

    if($dbtime - $curtime <= 0 || $this->meal->item_ended_at($item_number) != NULL)
    {
      return false;
    }

    return true;
  }

  // determine if the bid is valid (item/meal owner is not bidding, the bid amount is >= current price + incrementor || == initial price if first bid)
  public function valid_bid($bid_amount, $meal, $user_id)
  {
    if($user_id == $meals['user_id']) {
      return false;
    }
    if(!($meal['initial_price'] == $meal['current_price'] && $meal['current_price'] <= $bid_amount) && $bid_amount < $meal['current_price'] + 5)
    {
      return false;
    }
    return true;
  }
}