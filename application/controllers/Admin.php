<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('admin_model');
        $this->load->model('user_model');
        $this->load->model('Notification_model');
    }
    public function index()
    {

        //check if user is logged in
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }
        $data = [];
        $data['title'] = 'Admin';
        $data['permission'] = $this->admin_model->get_user_role_permission($this->session->userdata('role'));
        $this->load->view('header', $data);
        $this->load->view('admin/index');
        $this->load->view('footer');
    }

    //login view
    public function login()
    {
        $data = [];
        $data['title'] = 'Login';
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['password'] = $post_data['password'];
            $user_data = $this->admin_model->get_user($post_data);
            if (!empty($user_data) && ($user_data['role'] == 1 || $user_data['role'] == 2) &&  password_verify($post_data['password'], $user_data['password'])) {
                $session_data = array(
                    'id' => $user_data['id'],
                    'email' => $user_data['email'],
                    'role' => $user_data['role'],
                    'user_id' => $user_data['user_id'],
                    'logged_in' => true,
                );
                $this->session->set_userdata($session_data);
                $response['status'] = 1;
                $response['message'] = 'Login successfully';
            } else {
                $response['message'] = 'Invalid username or password';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }

        $this->load->view('header', $data);
        $this->load->view('admin/login');
        $this->load->view('footer');
    }

    public function users_list()
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }
        $data = [];
        $data['title'] = 'Users List';

        $this->load->view('header', $data);
        $this->load->view('admin/users/list');
        $this->load->view('footer');
    }


    //user table list
    public function user_list_table()
    {
        $users = $this->admin_model->get_user_list($this->session->userdata('id'));
        $data = array();
        foreach ($users as $key => $user) {
            $data[] = array(
                'id' => $key + 1,
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $user['email'],
                'mobile' => $user['mobile'],
                'date_created' => $user['date_created'],
                'action' => '<a href="' . base_url('admin/user/edit/' . $user['id']) . '">Edit</a> <a href="javascript:void(0);" data-id="' . $user['id'] . '" class="delete-user">| Delete </a><a href="' . base_url('user_password_reset/' . $user['id']) . '">| Reset Password</a>'
            );
        }
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }

    //edit user
    public function edit_user($id)
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }
        $data = [];
        $data['title'] = 'Edit User';
        $response = array('status' => 0, 'message' => '');

        //update user record
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['id'] = $id;
            if ($this->admin_model->add_user($post_data)) {
                $response['status'] = 1;
                $response['message'] = 'User updated successfully';
            } else {
                $response['message'] = 'Error updating user';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }

        $data['user_data'] = $this->admin_model->get_user_data($id);
        $this->load->view('header', $data);
        $this->load->view('admin/users/add');
        $this->load->view('footer');
    }

    //add user
    public function add_user()
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }
        $data = [];
        $data['title'] = 'Add User';
        $response = array('status' => 0, 'message' => '');
        if ($this->input->post()) {
            $post_data = $this->input->post();
            if (!isset($post_data['role'])) {
                $post_data['role'] = 3;
            }
            $post_data['password'] = password_hash(123456, PASSWORD_DEFAULT);
            $post_data['date_created'] = date('Y-m-d');
            $post_data['user_id'] = $this->session->userdata('id');
            $user_id = $this->admin_model->add_user($post_data);
            if ($user_id) {

                //user hierarchy insert
                $user_hierarchy = array(
                    'child_id' => $user_id,
                    'parent_id' => $this->session->userdata('id')
                );
                $this->admin_model->add_user_hierarchy($user_hierarchy);



                $this->load->library('email');
                $reset_token = bin2hex(random_bytes(32));
                $this->admin_model->save_token($post_data['email'], $reset_token);
                $this->email->from('mapatel90@gmail.com', 'Notify Pro');
                $this->email->to($post_data['email']);
                $this->email->subject('Please Enter Your Password Here');
                $this->email->message('Please click the following link to set your password: ' . base_url('admin/reset_password/' . $reset_token));

                if ($this->email->send()) {
                    $response['status'] = 1;
                    $response['message'] = 'User added successfully. An email has been sent with login details.';
                } else {
                    $response['message'] = 'Error adding user. Email could not be sent.';
                }

                header('Content-Type: application/json');
                echo json_encode($response);
                die;
            } else {
                $response['message'] = 'Error adding user';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }

        $this->load->view('header', $data);
        $this->load->view('admin/users/add');
        $this->load->view('footer');
    }


    public function reset_password($token)
    {

        //token check if exits
        if (!$this->admin_model->check_token($token)) {
            redirect('user/login');
        }

        if ($this->input->post()) {
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            $reset_token = $this->input->post('token');

            $response = array();

            if ($new_password === $confirm_password) {
                if ($this->admin_model->update_password($reset_token, $new_password)) {
                    $response['status'] = 1;
                    $response['message'] = 'Password Update Successfully';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Error updating password.';
                }
            } else {
                $response['status'] = 0;
                $response['message'] = 'Passwords do not match.';
            }

            echo json_encode($response);
            return;
        }

        $data = [];
        $data['title'] = 'Update Password';
        $data['token'] = $token;

        $this->load->view('header', $data);
        $this->load->view('admin/users/reset_password');
        $this->load->view('footer');
    }

    public function user_password_reset_by_id($id)
    {

        if ($this->input->post()) {
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            $id = $this->input->post('token');

            $response = array();

            if ($new_password === $confirm_password) {
                if ($this->admin_model->update_password_user_password($id, $new_password)) {
                    $response['status'] = 1;
                    $response['message'] = 'Password Update Successfully';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Error updating password.';
                }
            } else {
                $response['status'] = 0;
                $response['message'] = 'Passwords do not match.';
            }

            echo json_encode($response);
            return;
        }

        $data = [];
        $data['title'] = 'Update Password';
        $data['token'] = $id;

        $this->load->view('header', $data);
        $this->load->view('admin/users/reset_password');
        $this->load->view('footer');
    }

    //delete user
    public function delete_user()
    {
        $response = array('status' => 0, 'message' => '');
        $id = $this->input->post('id');
        if ($this->admin_model->delete_user($id)) {
            $response['status'] = 1;
            $response['message'] = 'User deleted successfully';
        } else {
            $response['message'] = 'Error deleting user';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }


    //get city list by state id
    public function get_city_list()
    {
        $state_id = $this->input->post('state_id');
        $city_list = $this->admin_model->get_city_list($state_id);
        $html = '';
        if (!empty($city_list)) {
            foreach ($city_list as $key => $value) {
                $html .= '<option value="' . $value['id'] . '">' . $value['city'] . '</option>';
            }
        }
        echo $html;
    }

    //email check
    // Controller method
    public function user_email_check()
    {
        $email = $this->input->post('email');
        $id = $this->input->post('id');

        if ($this->admin_model->user_email_check($email, $id)) {
            echo "false";
        } else {
            echo "true";
        }
    }

    // User List Table
    public function list()
    {
        $data = [];
        $data['title'] = 'List';
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));
        $this->load->view('header', $data);
        $this->load->view('admin/user_data_list');
        $this->load->view('footer');
    }

    // User Data List 
    public function user_data_list_table()
    {
        if ($this->session->userdata('role') == 1) {
            $list_table = $this->Notification_model->list_table();
        } else {
            $list_table = $this->Notification_model->list_table($this->session->userdata('id'));
        }

        $data = array();
        if (!empty($list_table)) {
            foreach ($list_table as $key => $value) {

                $user = $value->first_name . ' ' . $value->last_name;
                
                $status = '';
                if ($value->status_1 == 'accept') {
                    $status = '<span class="text text-success">' . $value->status_1 . '</span>';
                } elseif ($value->status_1 == 'reject') {
                    $status = '<span class="text text-danger">' . $value->status_1 . '</span>';
                } elseif ($value->status_1 == 'pending') {
                    $status = '<span class="text text-warning">' . $value->status_1 . '</span>';
                }

                if($value->document_count == 0){
                    $document_link = $value->document_count;
                }else{
                   $document_link = '<a href="' . base_url() . 'admin/document_list/' . base64_encode($value->id) . '">' . $value->document_count . '</a>';
                }

                $status_2 = '';
                if ($value->status_2 == 'success') {
                    $status_2 = '<span class="text text-success">' . $value->status_2 . '</span>';
                } else {
                    $status_2 = '<span class="text text-danger">' . $value->status_2 . '</span>';
                }

                $data[] = array(
                    'id' => $key + 1, // Add 'id' here
                    'user' => $user,
                    'date_sent' => $value->date_sent,
                    'category' => $value->category_name,
                    'contact' => $value->notification_name,
                    'company' => $value->company_name,
                    'wp_number' => $value->wp_number,
                    'email_id' => $value->email_id,
                    'status' => $status,
                    'date_recieved' => $value->date_received,
                    'document' => $document_link,
                    'status_2' => $status_2,
                );
            }
        }

        $output = array(
            "data" => $data
        );
        echo json_encode($output);
    }
    public function document_confirmation($id = null)
    {
        $data = [];
        $data['title'] = 'Admin Document Confirmation';

        if ($id) {
            $id = base64_decode($id);

            $data['notification_id'] = $id;
            $document_list = $this->Notification_model->get_notification_document($data['notification_id']);
            $data['document_list'] = $document_list;
        }

        if ($this->input->post()) {
            $post_data = $this->input->post();

            $post_data['notification_id'] = $post_data['notification_id'];
            $notification_details = $this->Notification_model->get_notification_details($post_data['notification_id']);

            $data_update = array(
                'status_1' => $post_data['reject_type'],
                'bitly_url' => '',
            );

            if ($this->Notification_model->update_notification($data_update, $post_data['notification_id'])) {

                //if reject then send mail to user
                if ($post_data['reject_type'] == 'reject') {

                    $document_list = $post_data['document_list'];
                    //unlick document and delete from database
                    if (!empty($document_list)) {
                        foreach ($document_list as $key => $value) {
                            //upload document REMOVE
                            $document_list = $this->Notification_model->get_notification_document_by_id($value);
                            if ($this->Notification_model->delete_document($value)) {
                                $filepath = FCPATH . 'uploads/' . $document_list['notification_id'] . '/' . $document_list['document'];
                                if (file_exists($filepath)) {
                                    unlink($filepath);
                                }
                            }
                        }
                    }
                    $bitly_url_token = generateUniqueToken();
                    //get bitly url
                    $bitly_url = base_url('n/' . $bitly_url_token);

                    $this->email->from('mapatel90@gmail.com', 'NotifyPro'); //email
                    $this->email->to($notification_details['email_id']);
                    $this->email->subject('Document Rejected');
                    $this->email->message('Dear ' . $notification_details['notification_name'] . ' from ' . get_compnay_name($notification_details['company_id']) . ' Company Your Document has been rejected by ' . $this->session->userdata('username') . 'Reject reason is ' . $post_data['reason_textarea'] . ' and please upload again ' . $bitly_url);

                    if ($this->email->send()) {
                        $data_update = array(
                            'bitly_url' => $bitly_url_token,
                        );
                        if ($post_data['reject_type'] == 'reject') {
                            $data_update['status_2'] = 'pending';
                        }
                        $this->Notification_model->update_notification($data_update, $post_data['notification_id']);
                    }
                }

                $response['status'] = 1;
                $response['message'] = 'Notification updated successfully';
            } else {
                $response['message'] = 'Error updating notification';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            die;
        }
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));

        $this->load->view('header', $data);
        $this->load->view('admin/document_confirmation');
        $this->load->view('footer');
    }
    public function document_list($id = null)
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 3  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 4) {
            redirect('admin/login');
        }
        $data = [];
        $data['title'] = 'Admin Document List';

        if ($id) {
            $id = base64_decode($id);

            $data['notification_id'] = $id;
            $document_list = $this->Notification_model->get_notification_document($data['notification_id']);
            $user_data = $this->Notification_model->get_notification_details($id);
            $data['status_1'] = isset($user_data['status_1']) ? $user_data['status_1'] : '';
            $data['document_list'] = $document_list;
        }

        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));

        $this->load->view('header', $data);
        $this->load->view('admin/document_list');
        $this->load->view('footer');
    }
    public function Logout()
    {
        session_destroy();

        redirect(base_url());
    }
}
