<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reset_password extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('admin_model');
    }
    public function admin_reset_password()
    {
        $data = [];
        $data['title'] = 'Admin Reset Password';

        if ($this->input->post()) {
            $email = $this->input->post('email');

            if ($this->admin_model->email_exists($email)) {

                $this->load->library('email');

                $reset_token = bin2hex(random_bytes(32));

                $this->admin_model->save_token($email, $reset_token);

                $this->email->from('mapatel90@gmail.com','Notify Pro');
                $this->email->to($email);
                $this->email->subject('Password Reset Request');
                $this->email->message('Please click the following link to reset your password: ' . base_url('admin/reset_password/' . $reset_token));

                if ($this->email->send()) {
                    $response['status'] = 1;
                    $response['message'] = 'User added successfully. An email has been sent with login details.';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Error sending email. Please try again later.';
                }

                header('Content-Type: application/json');
                echo json_encode($response);
                die;
            } else {
                $response['status'] = 0;
                $response['message'] = 'Email not found. Please check your email address.';

                header('Content-Type: application/json');
                echo json_encode($response);
                die;
            }
        }

        $this->load->view('header', $data);
        $this->load->view('admin/admin_reset_password', $data);
        $this->load->view('footer');
    }
    public function email_not_exists()
    {
        $email = $this->input->post('email');

        if ($this->admin_model->not_exist_email($email)) {
            echo "false";
        } else {
            echo "true";
        }
    }
}
