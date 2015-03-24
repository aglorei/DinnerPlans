<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bets extends CI_Controller
{
  public function __contruct()
  {
    parent::__contruct();
    $this->load->model('meal');
  }


  public function failed_bet()
  {
    $meal = $this->session->flashdata('meal');
    $meal['img'] = $this->get_meal_img($meal['id']);
    $errors = $this->session->flashdata('error');
    $this->load->view('failure', array('meal' => $meal, 'error' => $errors));
  }

  // place a new bet
  public function place_bet()
  {
    $this->load->helper('form');

    // do some validation
    $this->form_validation->set_rules('bet-amount', 'Bet Amount', 'required'); 
    $this->form_validation->set_rules('meal-id', 'Meal', 'required');
    $this->form_validation->set_rules('id', 'ID', 'required');
    $this->form_validation->set_rules('item-number', 'Item Number', 'required');

    // redirect on failure
    if(!$this->form_validation->run())
    {
      redirect($_SERVER['HTTP_REFERER']);
    }

    $item_number = $this->input->post('item-number');
    $bet_amount = $this->input->post('bet-amount');
    $user_id = $this->input->post('id');
    $meal = $this->bet->select_meal($item_number);
    $this->session->set_flashdata('meal', $meal);


    if(!betable($item_number))
    {
      $this->session->set_flashdata('error', "You may not bet on this item");
      redirect("failed_bet");
      return false;
    }

    $bid_count = $this->item_bid_count($item_number);

    // determine if the bet is valid
    if(!valid_bet($bet_amount, $meal, $user_id)
    {
      $this->session->set_flashdata('error', "You have not submitted a valid bet, please try again");
      redirect("failed_bet");
      return false;
    }

    if($bid_count)
    {
      $current_max_bet = $this->bet->current_max_bet($item_number);
    }
    else 
    {
      $current_max_bet = 0;
    }

    // record the new bet into the database
    if(!$this->bet->add_new_bet(array('user_id' => $user_id), 'meal_id' => $item_number , "bid" => $bet_amount))
    {
      $this->session->set_flashdata("error", "An error occurred, please contact a site administrator");
      redirect("failed_bet");
      return false;
    }


    // determine if the new bet is the highest bid
    if($bet_amount > $current_max_bet || (!$bid_count && $bet_amount >= $current_max_bet))
    {
      $meal['current_price'] = $current_max_bet;
      $winner = true;
    }
    else 
    {
      $meal['current_price'] = $bet_amount;
      $winner = false;
    }

    $this->bet->update_current_price($meal);
    $this->session->set_flashdata('meal', $meal);
    $this->session->set_flashdata('winner', $winner);
    redirect("/bid_success");
  }


  // make sure an item is able to take bets (auction has not ended, item exists)
  public function betable($item_number)
  {
    if(!$this->bet->item_exsits($item_number))
    {
      return false;
    }

    $dbtime = strtotime($this->bet->item_end_time($item_number));
    $curtime = time();

    if($dbtime - $curtime <= 0 || $this->bet->item_ended_at($item_number) != NULL)
    {
      return false;
    }

    return true;
  }

  // determine if the bet is valid (item/meal owner is not bidding, the bet amount is >= current price + incrementor || == initial price if first bid)
  public function valid_bet($bet_amount, $meal, $user_id)
  {
    if($user_id == $meals['user_id']) {
      return false;
    }
    if(!($meal['initial_price'] == $meal['current_price'] && $meal['current_price'] <= $bet_amount) && $bet_amount < $meal['current_price'] + 5)
    {
      return false;
    }
    return true;
  }
}