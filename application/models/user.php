<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{
	public function get_all_users()
	{
		return $this->db->query("SELECT id, first_name, last_name, email, CASE level WHEN 9 THEN 'Admin' WHEN 4 THEN 'User' END AS level, created_at FROM users ORDER BY id DESC;")->result_array();
	}

	public function register_user($user)
	{
		return $this->db->query("INSERT INTO users (first_name, last_name, email, password, level, created_at, updated_at) VALUES (?,?,?,?,?,NOW(),NOW());", array($user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['level']));
	}

	public function login_user($user_email)
	{
		return $this->db->query("SELECT id, first_name, last_name, email, password, CASE level WHEN 9 THEN 'admin' WHEN 4 THEN 'user' END AS level FROM users WHERE email=?;", array($user_email))->row_array();
	}

	public function get_user_by_id($user_id)
	{
		return $this->db->query("SELECT first_name, last_name, email, CASE level WHEN 9 THEN 'Admin' WHEN 4 THEN 'User' END AS level, DATEDIFF(NOW(), created_at) days FROM users WHERE id = ?;", array($user_id))->row_array();
	}

	public function update_user($user)
	{
		return $this->db->query("UPDATE users SET first_name=?, last_name=?, email=?, updated_at=NOW() WHERE id=?;", array($user['first_name'], $user['last_name'], $user['email'], $user['user_id']));
	}
}

?>