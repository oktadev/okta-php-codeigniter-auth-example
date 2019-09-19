<?php
class Users_model extends CI_Model
{

    public function __construct()
    {
            $this->load->database();
    }

    public function find_or_create($email)
    {
        $data = [
            'email' => $email
        ];

        $query = $this->db->get_where('users', $data);
        $result = $query->row_array();

        if (! $result) {
            $this->db->insert('users', $data);
            return $this->db->insert_id();
        };

        return $result['id'];
    }
}