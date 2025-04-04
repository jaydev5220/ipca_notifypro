<?php


function get_company_name($id)
{
    $CI = &get_instance();
    $CI->load->model('category_model');
    $company = $CI->category_model->get_company_by_id($id);
    if (!empty($company)) {
        return $company['company_name'];
    }
    return false;
}

function get_type_text($id)
{
    $CI = &get_instance();
    $CI->load->model('Notification_model');
    $notification = $CI->Notification_model->get_type_text_by_id($id);

    if (!empty($notification)) {
        return $notification['type_text'];
    }

    return false;
}

//get parent and child from user_hierarchy
function get_all_parent_child($user_id)
{
    $CI = &get_instance();
    $CI->db->select('parent_id, child_id');
    $CI->db->from('user_hierarchy');
    $CI->db->where('parent_id', $user_id);
    $CI->db->or_where('child_id', $user_id);
    $query = $CI->db->get();
    $result = $query->result_array();
    $outputArray = array();

    foreach ($result as $innerArray) {
        $outputArray[] = $innerArray["parent_id"];
        $outputArray[] = $innerArray["child_id"];
    }

    if (!empty($outputArray)) {
        $outputArray = array_unique($outputArray);
    }

    return $outputArray;
}


function generateUniqueToken($length = 1)
{
    // Define characters to use in the token
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Get the current timestamp
    $timestamp = microtime(true) * 10000;

    // Initialize an empty token
    $token = '';

    // Generate the token
    for ($i = 0; $i < $length; $i++) {
        // Append a random character from the character set
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }

    // Add a timestamp to make it unique
    $token .= $timestamp;

    // Make sure the token is unique by adding a random number
    $token .= rand(1000, 9999);

    return $token;
}

function get_category_name($category_id)
{
    // Load the CI instance to use CI functions
    $CI = &get_instance();

    // Load the database
    $CI->load->database();

    // Query to get the category name
    $query = $CI->db->select('category_name')->where('id', $category_id)->get('category');

    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->category_name;
    } else {
        return null;
    }
}
