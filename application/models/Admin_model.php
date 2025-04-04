<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //get city list
    public function get_city_list($id = '')
    {
        $this->db->select('*');
        $this->db->from('cities');
        if ($id != '') {
            $this->db->where('state_id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //get state list
    public function get_state_list()
    {
        $this->db->select('*');
        $this->db->from('states');
        $query = $this->db->get();
        return $query->result_array();
    }

    //add company
    public function add_company($data)
    {

        if (isset($data['id']) && $data['id'] > 0) {
            //  update company
            $id =  $data['id'];
            unset($data['id']);
            $this->db->where('id', $id);
            $this->db->update('companies', $data);
            return true;
        } else {
            //  add company
            $data['date_created'] = date('Y-m-d');
            $data['user_id'] = $this->session->userdata('id');
            $this->db->insert('companies', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id > 0) {
                return $insert_id; // Return the insert ID on success
            } else {
                return false; // Return false on error
            }
        }
    }

    //get company list
    public function get_company_list($id = '', $user_id = '')
    {

        $get_all_parent_child = get_all_parent_child($user_id);

        $this->db->select('companies.*, cities.city as city_name, states.name as state_name');
        //left join 
        $this->db->join('cities', 'cities.id = companies.city', 'left');
        $this->db->join('states', 'states.id = companies.state', 'left');
        $this->db->from('companies');
        if ($id != '') {
            $this->db->where('companies.id', $id);
        }
        if ($user_id != '') {
            $this->db->where_in('companies.user_id', $get_all_parent_child);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

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

    //delete company
    public function delete_company($company_id)
    {
        if ($company_id > 0) {
            $this->db->where('id', $company_id);
            $this->db->delete('companies');
            return true;
        }
        return false;
    }

    //add user
    public function add_user($data)
    {

        if (isset($data['id']) && $data['id'] > 0) {
            //  update user
            $id =  $data['id'];
            unset($data['id']);
            $this->db->where('id', $id);
            $this->db->update('user', $data);
            return true;
        } else {
            $this->db->insert('user', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id > 0) {
                return $insert_id; // Return the insert ID on success
            } else {
                return false; // Return false on error
            }
        }
    }

    //get user list
    public function get_user_list($user_id = '')
    {
        $this->db->select('*');
        $this->db->from('user');
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //get user data 
    public function get_user_data($id)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    //delete user
    public function delete_user($id)
    {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete('user');
            return true;
        }
        return false;
    }

    // Save User Token
    public function save_token($email, $token)
    {
        $this->db->where('email', $email);
        $this->db->update('user', ['token' => $token]);
        return $this->db->affected_rows() > 0;
    }

    // User Update Password
    public function update_password($reset_token, $new_password)
    {
        $user = $this->db->get_where('user', array('token' => $reset_token))->row();
        if ($user) {
            $this->db->where('token', $reset_token);
            $this->db->update('user', array('password' => password_hash($new_password, PASSWORD_DEFAULT), 'token' => null));
            return true;
        } else {
            return false;
        }
    }

    public function update_password_user_password($id, $new_password)
    {
        $user = $this->db->get_where('user', array('id' => $id))->row();
        if ($user) {
            $this->db->where('id', $id);
            $this->db->update('user', array('password' => password_hash($new_password, PASSWORD_DEFAULT)));
            return true;
        } else {
            return false;
        }
    }

    //email exits check
    public function user_email_check($email, $id)
    {

        //check email
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        if ($id > 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }


    //check token
    public function check_token($token)
    {
        $user = $this->db->get_where('user', array('token' => $token))->row();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }


    // For Email is Exists

    public function email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // For Email Not Exist

    public function not_exist_email($email)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $result = $query->row_array();

        if (!empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    //get user role permission 
    public function get_user_role_permission($user_role)
    {
        $get_permission = $this->db->get_where('user_role', array('id' => $user_role))->row();

        if ($get_permission->permission != '') {
            return json_decode($get_permission->permission);
        }
        return false;
    }

    //add_user_hierarchy
    public function add_user_hierarchy($data)
    {

        $this->db->insert('user_hierarchy', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id > 0) {
            return $insert_id; // Return the insert ID on success
        } else {
            return false; // Return false on error
        }
    }

    public function get_contacts_by_company($company_id)
    {
        $this->db->select('id, notification_name');
        $this->db->from('notification');
        $this->db->where('company_id', $company_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
}
