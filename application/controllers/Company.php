<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 4  || $this->session->userdata('logged_in') != true) {
            redirect('admin/login');
        }
        $this->load->model('admin_model');
        $this->load->model('user_model');
    }

    public function index()
    {

        $data = [];
        $data['title'] = 'Companies List';
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));
        $this->load->view('header', $data);
        $this->load->view('companies/list');
        $this->load->view('footer');
    }

    public function add_company()
    {

        $data = [];
        $data['title'] = 'Add Company';
        $response = array('status' => 0, 'message' => '');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $post_data = $this->input->post();
            $post_data['user_id'] = $this->session->userdata('id');
            $post_data['date_created'] = date('Y-m-d');

            if ($this->admin_model->add_company($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Company added successfully';
            } else {
                $response['message'] = 'Error adding company';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }
        $data['city_list'] = $this->admin_model->get_city_list(1);
        $data['state_list'] = $this->admin_model->get_state_list();
        $this->load->view('header', $data);
        $this->load->view('companies/add');
        $this->load->view('footer');
    }

    //get company list
    public function get_company_list()
    {

        if ($this->session->userdata('role') == 1) {
            $companies = $this->admin_model->get_company_list();
        } else {
            $companies = $this->admin_model->get_company_list(false, $this->session->userdata('id'));
        }
        $data = array();
        foreach ($companies as $key => $value) {
            $action = '<a href="' . base_url() . 'company/edit/' . $value['id'] . '">Edit</a> <a href="javascript:void(0);" class="delete_compnay" data-id="' . $value['id'] . '" >Delete</a>';
            $data[] = array(
                'id' => $key + 1, // Add 'id' here
                'company_name' => $value['company_name'],
                'date_created' => $value['date_created'],
                'city_name' => $value['city_name'],
                'state_name' => $value['state_name'],
                'action' => $action
            );
        }

        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }

    //edit company
    public function edit_company($id)
    {
        $data = [];
        $data['title'] = 'Edit Company';
        $response = array('status' => 0, 'message' => '');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $post_data = $this->input->post();

            if ($this->admin_model->add_company($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Company update successfully';
            } else {
                $response['message'] = 'Error update company';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }
        $data['company'] = $this->admin_model->get_company_list($id, false)[0];
        $data['city_list'] = $this->admin_model->get_city_list();
        $data['state_list'] = $this->admin_model->get_state_list();
        $this->load->view('header', $data);
        $this->load->view('companies/add');
        $this->load->view('footer');
    }

    //delete company
    public function delete_company()
    {
        $company_id = $this->input->post('company_id');
        $response = array('status' => 0, 'message' => '');
        if ($company_id) {
            $this->admin_model->delete_company($company_id);
            $response['status'] = 1;
            $response['message'] = 'Company deleted successfully';
        } else {
            $response['message'] = 'Company ID not provided';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }
}
