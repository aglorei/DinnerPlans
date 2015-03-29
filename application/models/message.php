<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Model
{
	public function inbox($id)
	{
		return $this->db->query("SELECT m.id, m.message, CONCAT_WS(' ', t.first_name, t.last_name) AS to_user, CONCAT_WS(' ', f.first_name, f.last_name) AS from_user, DATE_FORMAT(m.created_at,'%M %e, %Y at %h:%i %p') AS created_at FROM messages m JOIN users AS t ON m.to_user_id = t.id JOIN users AS f ON m.from_user_id = f.id WHERE t.id = ? ORDER BY m.id DESC;", array($id))->result_array();
	}

	public function sent($id)
	{
		return $this->db->query("SELECT m.id, m.message, CONCAT_WS(' ', t.first_name, t.last_name) AS to_user, CONCAT_WS(' ', f.first_name, f.last_name) AS from_user, DATE_FORMAT(m.created_at,'%M %e, %Y at %h:%i %p') AS created_at FROM messages m JOIN users AS t ON m.to_user_id = t.id JOIN users AS f ON m.from_user_id = f.id WHERE f.id = ? ORDER BY m.id DESC;", array($id))->result_array();
	}

	public function send($mail)
	{
		return $this->db->query("INSERT INTO messages (to_user_id, from_user_id, message, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW());", array($mail['to_user_id'], $mail['from_user_id'], $mail['message']));
	}
}

?>