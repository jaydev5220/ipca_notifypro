<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_notification($data)
    {
        if (!empty($data)) {
            $this->db->insert('notification', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

    //list table 
    public function list_table($user_id = '')
    {
        $get_all_parent_child = get_all_parent_child($user_id);

        $this->db->select('notification.*,user.first_name,user.last_name,companies.company_name as company_name,category.category_name as category_name');
        $this->db->select('(SELECT COUNT(id) FROM notification_document_list WHERE notification_document_list.notification_id = notification.id) as document_count', FALSE);
        //make join
        $this->db->join('user', 'user.id = notification.user_id');
        $this->db->join('companies', 'companies.id = notification.company_id');
        $this->db->join('category', 'category.id = notification.category_id');
        //get data last insert is first
        $this->db->order_by('notification.id', 'DESC');
        $this->db->from('notification');
        if ($user_id !== '') {
            $this->db->where_in('notification.user_id', $get_all_parent_child);
        }
        $query = $this->db->get();
        return $query->result();
    }

    //update notification
    public function update_notification($data, $id)
    {
        if (!empty($data)) {
            if (isset($data['reason_textarea'])) {
                unset($data['reason_textarea']);
            }
            $this->db->where('id', $id);
            $this->db->update('notification', $data);
            return true;
        }
        return false;
    }

    //get notification details
    public function get_notification_details($id)
    {
        if ($id > 0) {
            $this->db->select('notification.*,user.first_name,user.last_name,companies.company_name as company_name,category.category_name as category_name');
            //make join
            $this->db->join('user', 'user.id = notification.user_id');
            $this->db->join('companies', 'companies.id = notification.company_id');
            $this->db->join('category', 'category.id = notification.category_id');
            $this->db->where('notification.id', $id);
            $this->db->from('notification');
            $query = $this->db->get();
            return $query->row_array();
        }
    }

    //get notification details by token
    public function get_notification_details_by_token($token)
    {
        if ($token) {
            $this->db->select('notification.*,user.first_name,user.last_name,companies.company_name as company_name,category.category_name as category_name');
            $this->db->select('(SELECT COUNT(id) FROM notification_document_list WHERE notification_document_list.notification_id = notification.id) as document_count', FALSE);
            //make join
            $this->db->join('user', 'user.id = notification.user_id');
            $this->db->join('companies', 'companies.id = notification.company_id');
            $this->db->join('category', 'category.id = notification.category_id');
            $this->db->where('notification.bitly_url', $token);
            $this->db->from('notification');
            $query = $this->db->get();
            return $query->row_array();
        }
    }

    //get get_upload_type 
    public function get_upload_type()
    {
        //get upload type from seeting table 
        $this->db->select('settings.*');
        $this->db->where('settings.id', 1);
        $this->db->from('settings');
        $query = $this->db->get();
        return $query->row_array();
    }

    //get upload size
    public function get_upload_size()
    {
        //get upload type from seeting table 
        $this->db->select('settings.*');
        $this->db->where('settings.id', 2);
        $this->db->from('settings');
        $query = $this->db->get();
        return $query->row_array();
    }

    //insert document  data
    public function insert_document($data)
    {
        if (!empty($data)) {
            $this->db->insert('notification_document_list', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

    //get notification document
    public function get_notification_document($id)
    {
        if ($id > 0) {
            $this->db->select('notification_document_list.*');
            $this->db->where('notification_document_list.notification_id', $id);
            $this->db->from('notification_document_list');
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    //delete document 
    public function delete_document($id)
    {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete('notification_document_list');
            return true;
        }
        return false;
    }

    //get notification document
    public function get_notification_document_by_id($id)
    {
        if ($id > 0) {
            $this->db->select('notification_document_list.*');
            $this->db->where('notification_document_list.id', $id);
            $this->db->from('notification_document_list');
            $query = $this->db->get();
            return $query->row_array();
        }
    }

    public function get_type_text_by_id($notification_id)
    {
        $this->db->where('type_text', $notification_id);
        $query = $this->db->get('notification');
        return $query->row_array();
    }
}
