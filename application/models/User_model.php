<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{

    //get user
    public function get_user($data)
    {
        unset($data['password']);
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $data['username']);
        $query = $this->db->get();
        return $query->row_array();
    }

    //get user category
    public function get_category_list($id)
    {
        if ($id > 0) {
            $this->db->select('*');
            $this->db->from('category');
            $this->db->where('user_id', $id);
            $query = $this->db->get();
            return $query->result_array();
        }
        return false;
    }

    //get user company
    public function get_company_list($id)
    {
        if ($id > 0) {
            $this->db->select('*');
            $this->db->from('companies');
            $this->db->where('user_id', $id);
            $query = $this->db->get();
            return $query->result_array();
        }
        return false;
    }

    //get user contact
    public function get_contact_list($company_id, $catagory_id)
    {
        if ($company_id > 0 || $catagory_id > 0) {
            $this->db->select('notification.id,notification.notification_name');
            $this->db->from('notification');
            $this->db->where('company_id', $company_id);
            $this->db->where('category_id', $catagory_id);
            //group by name
            $this->db->group_by('notification_name');
            $query = $this->db->get();
            return $query->result_array();
        }
        return false;
    }


    //get list no_of_attachments_list
    public function no_of_attachments_list()
    {
        $this->db->select('*');
        $this->db->from('upload_number');
        $query = $this->db->get();
        return $query->result_array();
    }

    //reminder_list
    public function reminder_list()
    {
        $this->db->select('*');
        $this->db->from('reminder_notification');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get user role permission 
    public function get_user_role_permission($user_role)
    {
        $get_permission = $this->db->get_where('user_role', array('id' => $user_role))->row();
        if ($get_permission) {
            if ($get_permission->permission != '') {
                return json_decode($get_permission->permission);
            }
        }
        return false;
    }

    //get contact details
    public function get_contact_details($conact_id)
    {
        $this->db->select('notification.notification_name as contact_name,notification.wp_number as whatsapp_no,notification.email_id as email_id');
        $this->db->from('notification');
        $this->db->where('id', $conact_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_user_details_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            return $query->row_array(); 
        } else {
            return null;
        }
    }
}
