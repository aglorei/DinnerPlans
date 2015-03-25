<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function index()
	{
		$view_data = $this->session->flashdata();
		$this->load->view('/users/home', $view_data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	public function login()
	{
		// load model user
		$this->load->model('user');

		// match email in query
		$user_info = $this->user->login_user($this->input->post('email', TRUE));

		// encrypt the post input with the database password as the salt
		$encrypted_password = (crypt($this->input->post('password', TRUE), $user_info['password']));

		// if they match, assign id, first name, and level to session and redirect to dashboard method
		if ($encrypted_password == $user_info['password'])
		{
			$this->session->set_userdata('id', $user_info['id']);
			$this->session->set_userdata('first_name', $user_info['first_name']);
			$this->session->set_userdata('last_name', $user_info['last_name']);
			$this->session->set_userdata('level', $user_info['level']);
		}
		else
		{
			$alert['login'] = 'There are no users with these credentials.';
			$this->session->set_flashdata('alert', $alert);
		}

		redirect('/');
	}

	public function register()
	{
		// set validation rules
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required|alpha_dash|min_length[2]');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|required|alpha_dash|min_length[2]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[12]');
		$this->form_validation->set_rules('password_confirm', 'password confirmation', 'trim|required|matches[password]');

		// if form fails to validate, redirect back
		if (!$this->form_validation->run())
		{
			// error collection
			$errors = array(
				'first_name' => form_error('first_name'),
				'last_name' => form_error('last_name'),
				'email' => form_error('email'),
				'password' => form_error('password'),
				'password_confirm' => form_error('password_confirm')
			);
			$this->session->set_flashdata('errors', $errors);

			// field entry collection
			$errors_input = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
			);
			$this->session->set_flashdata('errors_input', $errors_input);

			redirect('/');
		}
		else
		{
			// encrypt password
			$salt = bin2hex(openssl_random_pseudo_bytes(22));
			$encrypted_password = crypt($this->input->post('password'), $salt);

			// field entry collection
			$user = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'password' => $encrypted_password
			);

			// load model
			$this->load->model('user');

			// if no users exist in database, assign this user as administrator level
			if (!count($this->user->get_all_users()))
			{
				$user['level'] = 9;
			}
			// else, assign user as user level
			else
			{
				$user['level'] = 4;
			}

			// add user to database
			$this->user->register_user($user);

			// assign user id, first name, and level in session
			$this->session->set_userdata('id', $this->db->insert_id());
			$this->session->set_userdata('first_name', $user['first_name']);
			$this->session->set_userdata('last_name', $user['last_name']);
			$this->session->set_userdata('level', $user['level']);

			redirect('/');
		}
	}

	public function account()
	{
		$this->load->helper('form');

		// redirect any users who are not logged in
		if (!$this->session->userdata('level'))
		{
			redirect('/');
		}
		// load flashdata if errors exist
		$view_data = $this->session->flashdata();

		// load user model and query for information
		$this->load->model('user');
		$view_data['user_info'] = $this->user->get_user_by_id($this->session->userdata['id']);

		$this->load->view('/users/account', $view_data);
	}

	public function upload_picture()
	{
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
				'id' => $this->session->userdata['id'],
				'file_name' => $this->upload->data('file_name')
			);

			$this->load->model('user');
			$this->user->upload_picture($upload);

			redirect('/account');
		}
	}

	public function update($id)
	{
		// if request is not admin or current user, logout
		if ($this->session->userdata('level') != 'admin' && $this->session->userdata('id') != $id)
		{
			redirect('/logout');
		}

		// set validation rules
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required|alpha_dash|min_length[2]');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|required|alpha_dash|min_length[2]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');

		// if form fails to validate, redirect to edit($id)
		if (!$this->form_validation->run())
		{
			// error collection
			$errors = array(
				'first_name' => form_error('first_name'),
				'last_name' => form_error('last_name'),
				'email' => form_error('email'),
			);
			$this->session->set_flashdata('errors', $errors);

			// field entry collection
			$errors_input = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
			);
			$this->session->set_flashdata('errors_input', $errors_input);

			redirect('/account');
		}
		else
		{
			// field entry collection
			$user = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'id' => $id
			);

			// load model and update profile information
			$this->load->model('user');
			$this->user->update_user($user);

			redirect('/account');
		}
	}
}