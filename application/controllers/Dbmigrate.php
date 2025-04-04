<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dbmigrate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function migrate() {
        // Call the functions one after the other
        $this->create_user_table();
        $this->create_companies_table();
        $this->create_user_role_table();    
        $this->create_category_table();
        $this->create_notification_table();
        $this->create_upload_number_table();
        $this->create_reminder_notification_table();
        $this->create_settings_table();
    }

    public function create_companies_table() {
        // Check if the 'companies' table already exists
        $table_exists = $this->db->table_exists('companies');
    
        if (!$table_exists) {
            $sql = "CREATE TABLE IF NOT EXISTS `companies` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `company_name` VARCHAR(100) NOT NULL,
            `date_created` DATE NOT NULL,
            `user_id` INT(11) NOT NULL,
            `city` INT(11) NULL,
            `state` INT(11) NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
    
            $this->db->query($sql);
            echo "Table 'companies' created successfully.";
        } else {
            echo "Table 'companies' already exists.";
        }
    }
    

    //user tabel
    public function create_user_table() {
        // Check if the 'user' table already exists
        $table_exists = $this->db->table_exists('user');
    
        if (!$table_exists) {
            $user = "CREATE TABLE IF NOT EXISTS `user` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `first_name` VARCHAR(250) NOT NULL,
                `username` VARCHAR(250) NULL,
                `last_name` VARCHAR(250) NULL,
                `email` VARCHAR(250) NOT NULL,
                `mobile` VARCHAR(250) NULL,
                `password` VARCHAR(250) NOT NULL,
                `role` INT(11) NOT NULL,
                `user_id` INT(11) NOT NULL,
                `date_created` DATE NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
    
            $this->db->query($user);
            echo "Table 'user' created successfully.";
        } else {
            echo "Table 'user' already exists.";
        }
    }

    //user role tabel
    public function create_user_role_table() {
        // Check if the 'user_role' table already exists
        $table_exists = $this->db->table_exists('user_role');
    
        if (!$table_exists) {
            $user_role = "CREATE TABLE IF NOT EXISTS `user_role` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `role_name` VARCHAR(250) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
    
            $this->db->query($user_role);
            echo "Table 'user_role' created successfully.";
        } else {
            echo "Table 'user_role' already exists.";
        }
    }   

    //category tabel
    public function create_category_table(){

        $table_exists = $this->db->table_exists('category');

        if(!$table_exists){
            $category = "CREATE TABLE IF NOT EXISTS `category` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `category_name` VARCHAR(250) NOT NULL,
                `user_id` INT(11) NOT NULL,
                `date_created` DATE NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

            $this->db->query($category);
            echo "Table 'category' created successfully.";
        }else{
            echo "Table 'category' already exists.";
        }
    }

    //notification tabel
    public function create_notification_table(){

        $table_exists = $this->db->table_exists('notification');

        if(!$table_exists){
            $notification = "CREATE TABLE IF NOT EXISTS `notification` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `notification_name` VARCHAR(250) NOT NULL,
                `user_id` INT(11) NOT NULL,
                `date_sent` DATE NOT NULL,
                `category_id` INT(11) NOT NULL,
                `company_id` INT(11) NOT NULL,
                `wp_number` VARCHAR(250) NOT NULL,
                `email_id` VARCHAR(250) NOT NULL,
                `status_1` VARCHAR(250) NOT NULL,
                `date_received` DATE NOT NULL,
                `document` VARCHAR(250) NOT NULL,
                `status_2` VARCHAR(250) NOT NULL,
                `date_created` DATE NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

            $this->db->query($notification);
            echo "Table 'notification' created successfully.";
        }else{
            echo "Table 'notification' already exists.";
        }
    }

    //upload number tabel
     public function create_upload_number_table(){

        $table_exists = $this->db->table_exists('upload_number');

        if(!$table_exists){
            $upload_number = "CREATE TABLE IF NOT EXISTS `upload_number` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `upload_number` VARCHAR(250) NOT NULL,
                `user_id` INT(11) NOT NULL,
                `date_created` DATE NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

            $this->db->query($upload_number);
            echo "Table upload number created successfully.";
        }else{
            echo "Table upload number already exists.";
        }
     }


     //Reminder Notification List tabel
     public function create_reminder_notification_table(){

        $table_exists = $this->db->table_exists('reminder_notification');

        if(!$table_exists){
            $reminder_notification = "CREATE TABLE IF NOT EXISTS `reminder_notification` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `notification_name` VARCHAR(250) NOT NULL,
                `user_id` INT(11) NOT NULL,
                `date_created` DATE NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

            $this->db->query($reminder_notification);
            echo "Table reminder notification created successfully.";
        }else{
            echo "Table reminder notification already exists.";
        }
     }

     //settings tabel
        public function create_settings_table(){
    
            $table_exists = $this->db->table_exists('settings');
    
            if(!$table_exists){
                $settings = "CREATE TABLE IF NOT EXISTS `settings` (
                    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(250) NOT NULL,
                    `value` VARCHAR(250) NOT NULL,
                    `date_created` DATE NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
    
                $this->db->query($settings);
                echo "Table settings created successfully.";
            }else{
                echo "Table settings already exists.";
            }
        }
    
}
