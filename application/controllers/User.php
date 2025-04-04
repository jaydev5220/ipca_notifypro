<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        //load helper
        parent::__construct();
        //load model
        $this->load->model('user_model');
        $this->load->model('Notification_model');
        $this->load->model('Category_model');
        $this->load->model('admin_model');
        $this->load->library('email');
    }

    public function home_page()
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 1  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 2 || $this->session->userdata('role') == 4) {
            redirect('user/login');
        }
        $data = [];
        $data['title'] = 'Home Page';

        //get user name
        $data['user_name'] = $this->session->userdata('username');
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));
        $this->load->view('header', $data);
        $this->load->view('user/home_page');
        $this->load->view('footer');
    }

    public function login()
    {
        $data = [];
        $data['title'] = 'Login';

        if ($this->input->post()) {
            $post_data = $this->input->post();
            $user_data = $this->user_model->get_user($post_data);
            if (!empty($user_data) && $user_data['role'] == 3 &&  password_verify($post_data['password'], $user_data['password'])) {
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
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));

        $this->load->view('header', $data);
        $this->load->view('user/login');
        $this->load->view('footer');
    }


    //create notification
    public function create_notification()
    {
        $data = [];
        $data['title'] = 'Create Notification';

        if ($this->input->post()) {
            $response['status'] = 0;
            $user_id = $this->session->userdata('id');
            $user_details = $this->user_model->get_user_details_by_id($user_id);

            if ($user_details) {
                $first_name = $user_details['first_name'];
                $last_name = $user_details['last_name'];
                $user = $first_name . ' ' . $last_name;

                $data = array(
                    'notification_name' => $this->input->post('contact_name'),
                    'user_id' => $this->session->userdata('id'),
                    'date_sent' => date('Y-m-d'),
                    'type_text' => $this->input->post('type_text'),
                    'category_id' => $this->input->post('category_id'),
                    'company_id' => $this->input->post('company_id'),
                    'wp_number' => $this->input->post('whatsapp_no'),
                    'email_id' => $this->input->post('email_id'),
                    'reminder_period' => $this->input->post('reminder_id'),
                    'no_of_attachments' => $this->input->post('upload_number_id'),
                    'status_1' => 'pending',
                    'date_received' => '',
                    'document' => '',
                    'status_2' => 'pending',
                    'date_created' => date('Y-m-d')
                );

                $insert_id = $this->Notification_model->insert_notification($data);

                if ($insert_id) {
                    $bitly_url_token = generateUniqueToken();
                    //get bitly url
                    $bitly_url = base_url('n/' . $bitly_url_token);
                    if ($bitly_url) {
                        $this->email->from('mapatel90@gmail.com', 'Notify Pro');
                        $this->email->to($data['email_id']);
                        $this->email->subject('Please Upload Document');
                        $this->email->message('Dear ' . $this->input->post('contact_name') . ', <br>' .
                            ' From ' . $user . '  Requests You To Upload The Following  Documents , <br>' .  get_type_text($this->input->post('type_text'))  . ' , <br>' . $bitly_url . '');

                        if ($this->email->send()) {
                            //after mail update bitly url
                            $data = array(
                                'bitly_url' => $bitly_url_token,
                            );
                            $this->Notification_model->update_notification($data, $insert_id);
                        }
                    }
                    $response['status'] = 1;
                    $response['message'] = "Notification inserted successfully.";
                } else {
                    $response['message'] = "Failed to insert notification.";
                }

                header('Content-Type: application/json');
                echo json_encode($response);
                die;
            }
        }
        //get category list
        $data['category_list'] = $this->Category_model->get_category_list($this->session->userdata('id'));
        //get company list
        $data['company_list'] = $this->admin_model->get_company_list(false, $this->session->userdata('id'));
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));


        $data['no_of_attachments_list'] = $this->user_model->no_of_attachments_list();
        $data['reminder_list'] = $this->user_model->reminder_list();
        $this->load->view('header', $data);
        $this->load->view('user/create_notification');
        $this->load->view('footer');
    }

    //list table 
    public function list_table()
    {
        $list_table = $this->Notification_model->list_table($this->session->userdata('id'));
        $data = array();
        if (!empty($list_table)) {
            foreach ($list_table as $key => $value) {

                // if ($value->status_2 == 'success') {
                //     if ($value->status_1 == 'accept') {
                //         $user = $value->first_name . ' ' . $value->last_name;
                //     } else {
                //         $user = '<a href="' . base_url() . 'user/document_confirmation/' . base64_encode($value->id) . '">' . $value->first_name . ' ' . $value->last_name . '</a>';
                //     }
                // } else {
                //     $user = $value->first_name . ' ' . $value->last_name;
                // }

                if ($value->document_count == 0) {
                    $document_link = $value->document_count;
                } else {
                    $document_link = '<a href="' . base_url() . 'user/document_list/' . base64_encode($value->id) . '">' . $value->document_count . '</a>';
                }

                $status = '';
                if ($value->status_1 == 'accept') {
                    $status = '<span class="text text-success">' . $value->status_1 . '</span>';
                } elseif ($value->status_1 == 'reject') {
                    $status = '<span class="text text-danger">' . $value->status_1 . '</span>';
                } elseif ($value->status_1 == 'pending') {
                    $status = '<span class="text text-warning">' . $value->status_1 . '</span>';
                }

                $status_2 = '';
                if ($value->status_2 == 'success') {
                    $status_2 = '<span class="text text-success">' . $value->status_2 . '</span>';
                } else {
                    $status_2 = '<span class="text text-danger">' . $value->status_2 . '</span>';
                }

                $data[] = array(
                    'id' => $key + 1, // Add 'id' here
                    'user' => $value->first_name . ' ' . $value->last_name,
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
        $data['title'] = 'Document Confirmation';

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
                    $this->email->message('Dear ' . $notification_details['notification_name'] . ' from ' . get_company_name($notification_details['company_id']) . ' Company Your Document has been rejected by ' . $this->session->userdata('username') . 'Reject reason is ' . $post_data['reason_textarea'] . ' and please upload again ' . $bitly_url);

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
        $this->load->view('user/document_confirmation');
        $this->load->view('footer');
    }

    //document list
    public function document_list($id = null)
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 1  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 2 || $this->session->userdata('role') == 4) {
            redirect('user/login');
        }
        $data = [];
        $data['title'] = 'Document List';

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
        $this->load->view('user/document_list', $data);
        $this->load->view('footer');
    }

    public function list()
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 1  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 2 || $this->session->userdata('role') == 4) {
            redirect('user/login');
        }
        $data = [];
        $data['title'] = 'List';
        $data['permission'] = $this->user_model->get_user_role_permission($this->session->userdata('role'));
        $this->load->view('header', $data);
        $this->load->view('user/list');
        $this->load->view('footer');
    }

    //get contact list 
    public function get_contact_list()
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 1  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 2 || $this->session->userdata('role') == 4) {
            redirect('user/login');
        }
        $data = $this->input->post();
        if ($data) {
            $contact_list = $this->user_model->get_contact_list($data['company_id'], $data['category_id']);
            if (!empty($contact_list)) {
                $response['status'] = 1;
                $response['contact_list'] = $contact_list;
            } else {
                $response['status'] = 0;
                $response['message'] = 'No contact found';
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }

    //get contact details
    public function get_contact_details()
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 1  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 2 || $this->session->userdata('role') == 4) {
            redirect('user/login');
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            $contact_details = $this->user_model->get_contact_details($data['contact_id']);
            if (!empty($contact_details)) {
                $response['status'] = 1;
                $response['contact_details'] = $contact_details;
            } else {
                $response['status'] = 0;
                $response['message'] = 'No contact found';
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }
    public function logout()
    {
        session_destroy();

        redirect(base_url());
    }
    public function get_contacts_by_company()
    {
        if (!$this->session->userdata('id') || $this->session->userdata('role') == 1  || $this->session->userdata('logged_in') != true || $this->session->userdata('role') == 2 || $this->session->userdata('role') == 4) {
            redirect('user/login');
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            $company_details = $this->admin_model->get_contacts_by_company($data['company_id']);
            if (!empty($company_details)) {
                $response['status'] = 1;
                $response['company_details'] = $company_details;
            } else {
                $response['status'] = 0;
                $response['message'] = 'No contact found';
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }
}
