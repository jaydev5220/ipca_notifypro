<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model
{


    //update setting data 
    public function update_upload_type_size($data)
    {

        if (!empty($data)) {
            foreach ($data as $key => $value) {

                // Check if a record with the same name and date exists
                $existingRecord = $this->db->get_where('settings', array('name' => $key))->row();
                if ($existingRecord) {
                    // Update the existing record
                    $this->db->where('id', $existingRecord->id);
                    $updateData = array(
                        'value' => $value
                    );
                    $this->db->update('settings', $updateData);
                } else {
                    // Insert a new record
                    $postdata = array(
                        'name' => $key,
                        'value' => $value,
                        'date_created' => date('Y-m-d'),
                    );


                    $this->db->insert('settings', $postdata);
                }
            }
            return true;
        }
        return false;
    }


    //get data from settings table
    public function get_setting_data()
    {
        $query = $this->db->get('settings');
        return $query->result();
    }

    //add_upload_number
    public function add_upload_number($data)
    {

        if (isset($data['id']) &&   $data['id'] > 0) {
            $this->db->where('id', $data['id']);
            $this->db->update('upload_number', $data);
            return $data['id'];
        } else {
            $this->db->insert('upload_number', $data);
            return $this->db->insert_id();
        }
        return false;
    }

    //get upload number
    public function get_upload_number($user_id)
    {
        if ($user_id > 0) {
            $this->db->where('user_id', $user_id);
        }
        $query = $this->db->get('upload_number');

        return $query->result_array();
    }

    //get_upload_number_by_id
    public function get_upload_number_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('upload_number');
        return $query->row();
    }

    //delete upload number
    public function delete_upload_number($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('upload_number');
        return true;
    }

    //add notification date number
    public function add_notification_date_number($data)
    {
        if (isset($data['id']) &&   $data['id'] > 0) {
            $this->db->where('id', $data['id']);
            $this->db->update('reminder_notification', $data);
            return $data['id'];
        } else {
            $this->db->insert('reminder_notification', $data);
            return $this->db->insert_id();
        }
        return false;
    }

    //get notification date number
    public function get_notification_date_number($user_id)
    {
        if ($user_id > 0) {
            $this->db->where('user_id', $user_id);
        }
        $query = $this->db->get('reminder_notification');

        return $query->result_array();
    }

    //get_notification_date_number_by_id
    public function get_notification_date_number_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('reminder_notification');
        return $query->row();
    }

    //delete notification date number
    public function delete_notification_date_number($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('reminder_notification');
        return true;
    }

    //permision table list
    public function get_permission_list()
    {
        $this->db->select('*');
        $this->db->from('user_role');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
          return $query->result();
        }
        return false;
    }

    //add role and permission
    public  function add_role_permission($data){
 
        if(isset($data['permission'])){
            $data['permission'] = json_encode($data['permission']);
        }else{
            $extra_data = [
                'category' => 'off',
                'companies' => 'off'
            ];
            $data['permission'] = json_encode($extra_data);
        }

        if (isset($data['id']) &&   $data['id'] > 0) {
            $this->db->where('id', $data['id']);
            $this->db->update('user_role', $data);
            return $data['id'];
        } else {      
            $this->db->insert('user_role', $data);
            return $this->db->insert_id();
        }
        return false;
    }

    //get role permission 
    public function get_role_permission($id){
        if ($id > 0) {
            $this->db->where('id', $id);
            $query = $this->db->get('user_role');
            $row = $query->row();

            if ($row) {
                $row->permission = json_decode($row->permission, true);
            }
    
            return $row;
        }

        return null;
    }

    // Delete Role Permission

    public function delete_role_permission($id) {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
    
        return $this->db->affected_rows() > 0;
    }
    
}
