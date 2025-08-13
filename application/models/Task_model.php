<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task_model extends CI_Model
{

    public function add_task($data)
    {
        return $this->db->insert('tasks', $data);
    }

    public function get_tasks_by_user($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->order_by('sort_order', 'ASC')
            ->get('tasks')
            ->result();
    }
    public function update_sort_order($task_id, $sort_order)
    {
        return $this->db->where('id', $task_id)
            ->update('tasks', ['sort_order' => $sort_order]);
    }
    public function get_task_by_id($task_id)
    {
        return $this->db->where('id', $task_id)->get('tasks')->row();
    }
    public function update_task($task_id, $data)
    {
        return $this->db->where('id', $task_id)->update('tasks', $data);
    }

    public function delete_task($task_id)
    {
        return $this->db->where('id', $task_id)->delete('tasks');
    }

        public function updateStatus($task_id, $status) {
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', ['status' => $status]);
    }
}

