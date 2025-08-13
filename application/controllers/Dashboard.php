<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property User_model $User_model
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property Task_model $Task_model
 * @property CI_Loader $load
 * @property CI_Output $output
 * @property CI_Security $security
 * @property CI_DB_query_builder $db
 */
class Dashboard extends CI_Controller
{
    private $profileData = [];

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }

        $this->load->model('User_model');
        $user_id = $this->session->userdata('user_id');
        $this->profileData = [
            'profile' => $this->User_model->get_user_by_id($user_id)
        ];
    }

    public function user()
    {
        $data = $this->profileData;
        $data['content'] = 'dashboard/user';
        $this->load->view('layouts/layout', $data);
    }

    public function update_profile()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('contact_number', 'Phone', 'required|numeric|min_length[10]|max_length[10]');

        $user_id = $this->session->userdata('user_id');

        if ($this->form_validation->run() == FALSE) {
            $postData = (object) $this->input->post();
            $data = $this->profileData;
            $data['profile'] = $postData;
            $data['open_modal'] = true;
            $data['content'] = 'dashboard/user';
            $this->load->view('layouts/layout', $data);
            return;
        }

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone = $this->input->post('contact_number');
        $password = $this->input->post('password');

        $updateData = [
            'name' => $name,
            'email' => $email,
            'contact_number' => $phone
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!empty($_FILES['profile_image']['name'])) {
            $config['upload_path'] = './uploads/profile/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'profile_' . $user_id . '_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('profile_image')) {
                $upload_data = $this->upload->data();
                $updateData['profile_image'] = 'uploads/profile/' . $upload_data['file_name'];
            } else {
                $data = $this->profileData;
                $data['profile'] = (object) $this->input->post();
                $data['error'] = $this->upload->display_errors();
                $data['open_modal'] = true;
                $data['content'] = 'dashboard/user';
                $this->load->view('layouts/layout', $data);
                return;
            }
        }

        $this->User_model->update_user($user_id, $updateData);

        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect('dashboard/user');
    }

    public function tasks()
    {
        $this->load->model('Task_model');
        $user_id = $this->session->userdata('user_id');
        $data = $this->profileData;
        $data['tasks'] = $this->Task_model->get_tasks_by_user($user_id);

        // Check if edit_task_id is passed in GET
        $edit_task_id = $this->input->get('edit_task_id');
        if ($edit_task_id) {
            $data['edit_task'] = $this->Task_model->get_task_by_id($edit_task_id);
        } else {
            $data['edit_task'] = null;
        }

        $data['content'] = 'dashboard/tasks';
        $this->load->view('layouts/layout', $data);
    }

    public function save_task()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'Due Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect('dashboard/tasks');
            return;
        }

        $user_id = $this->session->userdata('user_id');

        $data = [
            'user_id'     => $user_id,
            'title'       => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'start_date'  => $this->input->post('start_date'),
            'end_date'    => $this->input->post('end_date'),
            'status'      => $this->input->post('status') ?? 'Not Started',
            'sort_order'  => 0,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        $this->load->model('Task_model');
        if ($this->Task_model->add_task($data)) {
            $this->session->set_flashdata('success', 'Task added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to save task.');
        }

        redirect('dashboard/tasks');
    }
    public function update_task_order()
    {
        $this->load->model('Task_model');
        $taskOrder = $this->input->post('order');

        if (!empty($taskOrder) && is_array($taskOrder)) {
            foreach ($taskOrder as $sort => $taskId) {
                $this->Task_model->update_sort_order($taskId, $sort);
            }
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid order data'];
        }

        // Clear any previous output, set JSON header, send response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    public function update_task()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'Due Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect('dashboard/tasks');
            return;
        }

        $task_id = $this->input->post('task_id');

        $data = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'status' => $this->input->post('status') ?? 'Not Started',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->load->model('Task_model');

        if ($this->Task_model->update_task($task_id, $data)) {
            $this->session->set_flashdata('success', 'Task updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update task.');
        }

        redirect('dashboard/tasks');
    }


    public function delete_task($task_id)
    {
        $this->load->model('Task_model');

        if ($this->Task_model->delete_task($task_id)) {
            $this->session->set_flashdata('success', 'Task deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete task.');
        }
        redirect('dashboard/tasks');
    }

    public function update_status()
    {
        $this->load->model('Task_model');

        $task_id = $this->input->post('task_id');
        $status = $this->input->post('status');
        $user_id = $this->session->userdata('user_id');

        if (!$task_id || !$status) {
            show_error('Invalid input', 400);
            return;
        }

        $task = $this->Task_model->get_task_by_id($task_id);

        if ($task && isset($task->user_id) && $task->user_id == $user_id) {
            $updated = $this->Task_model->updateStatus($task_id, $status);
            echo $updated ? 'success' : show_error('Update failed', 500);
        } else {
            show_error('Unauthorized or invalid task', 403);
        }
    }



    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        redirect('login');
    }
}
