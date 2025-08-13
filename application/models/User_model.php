<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class User_model extends CI_Model
{
    // Get user by email
    public function get_user_by_email($email)
    {
        return $this->db->where('email', $email)->get('users')->row();
    }

    // Get user by ID
    public function get_user_by_id($id)
    {
        return $this->db->where('id', $id)->get('users')->row();
    }

    // Get user by phone number (needed for Truecaller)
    public function get_user_by_phone($phone)
    {
        return $this->db->where('contact_number', $phone)->get('users')->row();
    }

    // Insert new user
    public function insert_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id(); 
    }

    // Update existing user
    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
}
