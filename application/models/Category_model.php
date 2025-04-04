<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model
{
    // Category Insert
    public function insert_data($data)
    {
        if(!empty($data)){
            if($data['hid'] != '' && $data['hid'] != 0){
                $id =  $data['hid']; 
                unset($data['hid']);
                $this->db->where('id', $id);
                $this->db->update('category', $data);
                return true;
            }else{
                unset($data['hid']);
                $this->db->insert('category', $data);
                return true;
            }
        }else{
            return false;
        }
        
    }

    // Category Get List
    public function get_category_list($user_id = '')
    {
        $get_all_parent_child = get_all_parent_child($user_id);
        $this->db->select('*');
        $this->db->from('category');
        if($user_id != ''){
            $this->db->where_in('user_id', $get_all_parent_child);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

   

    // Category Delete
    public function delete_category($category_id)
    {
        if($category_id > 0){
            $this->db->where('id', $category_id);
            $this->db->delete('category');
            return true;
        }
        return false;
    }

    // Category Get Data By Id
    public function get_category_by_id($category_id)
    {
        $this->db->where('id', $category_id);
        $query = $this->db->get('category');
        return $query->row_array();
    }

    // company Get data by id
    public function get_company_by_id($company_id)
    {
        $this->db->where('id', $company_id);
        $query = $this->db->get('companies');
        return $query->row_array();
    }
}
