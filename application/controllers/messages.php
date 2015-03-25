<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller
{
	public function send($id)
	{
		// set validation rules
		$this->form_validation->set_rules('to', 'to', 'trim|required');
		$this->form_validation->set_rules('message', 'message', 'required|max_length[1000]');

		// query database for matching user name
		$this->load->model('user');
		$to = $this->user->match_name($this->input->post('to'));

		// if form fails to validate or user does not exist
		if (!$this->form_validation->run() || !$to)
		{
			// error collection
			$errors = array(
				'to' => '<label class="text-danger">There are no users by that name.</label>',
				'message' => form_error('message')
			);
			$this->session->set_flashdata('errors', $errors);

			// field entry collection
			$errors_input = array(
				'to' => $this->input->post('to'),
				'message' => $this->input->post('message')
			);
			$this->session->set_flashdata('errors_input', $errors_input);
		}
		else
		{
			// field entry collection
			$mail = array(
				'to_user_id' => $to,
				'from_user_id' => $id,
				'message' => $this->input->post('message')
			);

			// load message model and send mail
			$this->load->model('message');
			$this->message->send($mail);
		}

		$this->session->set_flashdata('tab', 'messages');
		$this->session->set_flashdata('message_controls', $this->session->flashdata('message_controls'));
		redirect('/account');
	}

}