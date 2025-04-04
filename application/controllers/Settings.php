<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    // index function 
    public function index()
    {

        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        $data = [];
        $data['title'] = 'Settings';
        $this->load->view('header', $data);
        $this->load->view('settings/settings');
        $this->load->view('footer');
    }

    //upload size and type 
    public function upload_type_size()
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        if ($this->input->post()) {
            $response['status'] = 0;
            $post_data = $this->input->post();
            if ($this->settings_model->update_upload_type_size($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Upload type and size updated successfully';
            } else {
                $response['message'] = 'Something went wrong';
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }
        $data = [];
        $data['title'] = 'Upload Type and Size';

        //get setting data
        $setting_data = $this->settings_model->get_setting_data();
        foreach ($setting_data as $setting) {
            $data['setting_data'][$setting->name] = $setting->value;
        }

        $this->load->view('header', $data);
        $this->load->view('settings/upload_type_size');
        $this->load->view('footer');
    }

    //upload_number
    public function upload_number()
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        $data = [];
        $data['title'] = 'Upload Number';
        $this->load->view('header', $data);
        $this->load->view('settings/upload_number');
        $this->load->view('footer');
    }

    //add upload number
    public function add_upload_number()
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        if ($this->input->post()) {
            $response['status'] = 0;
            $post_data = $this->input->post();
            $post_data['user_id'] = $this->session->userdata('id');
            $post_data['date_created'] = date('Y-m-d');
            if ($this->settings_model->add_upload_number($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Upload number added successfully';
            } else {
                $response['message'] = 'Something went wrong';
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }
        $data = [];
        $data['title'] = 'Add Upload Number';
        $this->load->view('header', $data);
        $this->load->view('settings/add_upload_number');
        $this->load->view('footer');
    }

    //edit upload number
    public function edit_upload_number($id)
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        $data = [];
        $data['title'] = 'Edit Upload Number';
        $data['upload_number'] = $this->settings_model->get_upload_number_by_id($id);
        $this->load->view('header', $data);
        $this->load->view('settings/add_upload_number');
        $this->load->view('footer');
    }

    //get upload number
    public function get_upload_number()
    {
        $upload_number = $this->settings_model->get_upload_number($this->session->userdata('id'));
        $data = array();
        foreach ($upload_number as $key => $value) {
            $data[] = array(
                'id' => $key+1,
                'upload_number' => $value['upload_number'],
                'date_created' => $value['date_created'],
                'action' => '<a href="' . base_url('admin/settings/edit_upload_number/' . $value['id']) . '">Edit</a> <a href="javascript:void(0);" data-id="' . $value['id'] . '" class="delete-upload_number">Delete</a>'
            );
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }

    //delete upload number
    public function delete_upload_number($id)
    {
        $response['status'] = 0;
        if ($this->settings_model->delete_upload_number($id)) {
            $response['status'] = 1;
            $response['message'] = 'Upload number deleted successfully';
        } else {
            $response['message'] = 'Something went wrong';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }

    //notification_date_number
    public function notification_date_number()
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }
        $data = [];
        $data['title'] = 'Notification Date Number';
        $this->load->view('header', $data);
        $this->load->view('settings/notification_date_number');
        $this->load->view('footer');
    }

    //add notification date number
    public function add_notification_date_number()
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        if ($this->input->post()) {
            $response['status'] = 0;
            $post_data = $this->input->post();
            $post_data['user_id'] = $this->session->userdata('id');
            $post_data['date_created'] = date('Y-m-d');
            if ($this->settings_model->add_notification_date_number($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Notification date number added successfully';
            } else {
                $response['message'] = 'Something went wrong';
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }
        $data = [];
        $data['title'] = 'Add Notification Date Number';
        $this->load->view('header', $data);
        $this->load->view('settings/add_notification_date_number');
        $this->load->view('footer');
    }

    //edit notification date number
    public function edit_notification_date_number($id)
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true  || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        $data = [];
        $data['title'] = 'Edit Notification Date Number';
        $data['notification_date_number'] = $this->settings_model->get_notification_date_number_by_id($id);
        $this->load->view('header', $data);
        $this->load->view('settings/add_notification_date_number');
        $this->load->view('footer');
    }

    //get notification date number
    public function get_notification_date_number()
    {
        $notification_date_number = $this->settings_model->get_notification_date_number($this->session->userdata('id'));
        $data = array();
        foreach ($notification_date_number as $key => $value) {
            $data[] = array(
                'id' => $key+1,
                'notification_name' => $value['notification_name'],
                'date_created' => $value['date_created'],
                'action' => '<a href="' . base_url('admin/settings/edit_notification_date_number/' . $value['id']) . '">Edit</a> <a href="javascript:void(0);" data-id="' . $value['id'] . '" class="delete-notification_name">Delete</a>'
            );
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }

    //delete notification date number
    public function delete_notification_date_number($id)
    {
        $response['status'] = 0;
        if ($this->settings_model->delete_notification_date_number($id)) {
            $response['status'] = 1;
            $response['message'] = 'Notification date number deleted successfully';
        } else {
            $response['message'] = 'Something went wrong';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }


    //permission
    public function permission()
    {
        //make admin login validation 
        if (!$this->session->userdata('id') || $this->session->userdata('role') != 1  || $this->session->userdata('logged_in') != true) {
            redirect('admin/login');
        }
        $data = [];
        $data['title'] = 'Permission';
        $this->load->view('header', $data);
        $this->load->view('settings/permission');
        $this->load->view('footer');
    }

    //permission list table 
    public function permission_list()
    {
        $permission_list = $this->settings_model->get_permission_list();
        $data = array();

        foreach ($permission_list as $key => $value) {
            $data[] = array(
                'id' => $key+1,
                'role_name' => $value->role_name,
                'action' => '<a href="' . base_url('admin/settings/edit_role_permission/' . $value->id) . '">Edit</a> <a href="javascript:void(0);" data-id="' . $value->id . '" class="delete-role_permission">Delete</a>'
            );
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }

    //add role permission
    public function add_role_permission()
    {

        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        if ($this->input->post()) {
            $response['status'] = 0;
            $post_data = $this->input->post();
            if ($this->settings_model->add_role_permission($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Notification date number added successfully';
            } else {
                $response['message'] = 'Something went wrong';
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }

        $data = [];
        $data['title'] = 'Add Role';
        $this->load->view('header', $data);
        $this->load->view('settings/add_role_permission');
        $this->load->view('footer');
    }

    //edit role
    public function edit_role_permission($id)
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }

        if ($this->input->post()) {
            $response['status'] = 0;
            $post_data = $this->input->post();
            $post_data['id'] = $id;
            if ($this->settings_model->add_role_permission($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Notification date number added successfully';
            } else {
                $response['message'] = 'Something went wrong';
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }

        $data = [];
        $data['title'] = 'Edit Role';
        $data['permission'] = $this->settings_model->get_role_permission($id);
        $this->load->view('header', $data);
        $this->load->view('settings/add_role_permission');
        $this->load->view('footer');
    }
    public function delete_role_permission($id)
    {
        $response = array();

        if (!empty($id)) {
            if ($this->settings_model->delete_role_permission($id)) {
                $response['status'] = 1;
                $response['message'] = 'Role permission deleted successfully';
            } else {
                $response['status'] = 0;
                $response['message'] = 'Failed to delete role permission';
            }
        } else {
            $response['status'] = 0;
            $response['message'] = 'Invalid request';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
