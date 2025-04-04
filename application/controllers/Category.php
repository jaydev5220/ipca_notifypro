<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 4  || $this->session->userdata('logged_in') != true) {
            redirect('admin/login');
        }
        $this->load->model('Category_model');
        $this->load->model('user_model');
    }

    //category list view
    public function category_list()
    {

        $data = [];
        $data['title'] = 'Category List';
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));
        $this->load->view('header', $data);
        $this->load->view('category/list');
        $this->load->view('footer');
    }

    //category add view
    public function add_category()
    {

        $data = [];
        $data['title'] = 'Add Category';

        if ($this->input->post()) {
            $response['status'] = 0;
            $post_data = $this->input->post();
            $post_data['date_created'] = date('Y-m-d');
            $post_data['user_id'] = $this->session->userdata('id');
            if ($this->Category_model->insert_data($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Category added successfully';
            } else {
                $response['message'] = 'Error adding category';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }

        $this->load->view('header', $data);
        $this->load->view('category/add');
        $this->load->view('footer');
    }

    public function get_category_list()
    {
        if ($this->session->userdata('role') == 1) {
            $categories = $this->Category_model->get_category_list();
        } else {
            $categories = $this->Category_model->get_category_list($this->session->userdata('id'));
        }

        $table_data = array();
        foreach ($categories as $key => $category) {
            $action = '<a href="' . base_url() . 'category/edit/' . $category['id'] . '">Edit</a> <a href="javascript:void(0);" class="delete-category" data-id="' . $category['id'] . '" >Delete</a>';
            $table_data[] = array(
                'SrNo' => $key + 1,
                'Name' => $category['category_name'],
                'Created Date' => $category['date_created'],
                'action' => $action
            );
        }

        $response['data'] = $table_data;
        echo json_encode($response);
    }

    //delete category
    public function deleteCategory()
    {
        $category_id = $this->input->post('category_id');

        if ($category_id) {
            $this->Category_model->delete_category($category_id);
            echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Category ID not provided']);
        }
    }

    //edit category view
    public function edit_category($category_id)
    {

        //UPDATE CATEGORY DATA
        if ($this->input->post()) {
            $response['status'] = 0;
            $post_data = $this->input->post();
            if ($this->Category_model->insert_data($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'Category updated successfully';
            } else {
                $response['message'] = 'Error update category';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }

        $categoryData = $this->Category_model->get_category_by_id($category_id);

        $data['categoryData'] = $categoryData;
        $data['title'] = 'Edit Category';

        $this->load->view('header', $data);
        $this->load->view('category/add');
        $this->load->view('footer');
    }
}
