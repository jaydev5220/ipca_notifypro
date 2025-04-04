<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = [
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 465,
    'smtp_user' => 'dhamo2509@gmail.com',
    'smtp_pass' => 'bovnzyvtewheyzvj',
    'smtp_crypto' => 'ssl',
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'smtp_timeout' => '5',
    'wordwrap' => TRUE,
    'validate' => TRUE,
    'crlf' => "\r\n",
    'newline' => "\r\n",
    'smtp_from_email' => 'sys.admins@anant.co.in',
    'smtp_from_name' => '${APP_NAME}',
];