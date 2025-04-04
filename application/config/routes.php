<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



$route['notifypro'] = 'Notify_pro/notifypro';
$route['user/home_page'] = 'User/home_page';
$route['user/login'] = 'User/login';
$route['admin'] = 'Admin/index';
$route['admin/login'] = 'Admin/login';
$route['admin/admin_reset_password'] = 'Reset_password/admin_reset_password';
$route['user/admin_reset_password'] = 'Reset_password/admin_reset_password';
$route['user_password_reset/(:any)'] = 'Admin/user_password_reset_by_id/$1';


//company routes
$route['companies'] = 'Company/index';
$route['add_company'] = 'Company/add_company';
$route['companies_list'] = 'Company/get_company_list';
$route['company/delete'] = 'Company/delete_company';
$route['company/edit/(:any)'] = 'Company/edit_company/$1';



$route['admin/users'] = 'Admin/users_list';
$route['admin/user/delete'] = 'Admin/delete_user';
$route['admin/user/edit/(:any)'] = 'Admin/edit_user/$1';
$route['admin/users/list_table'] = 'Admin/user_list_table';
$route['admin/add_user'] = 'Admin/add_user';
$route['admin/reset_password/(:any)'] = 'Admin/reset_password/$1';
$route['admin/list'] = 'Admin/list';
$route['admin/document_confirmation/(:any)'] = 'Admin/document_confirmation/$1';
$route['admin/document_confirmation'] = 'Admin/document_confirmation';
$route['admin/document_list/(:any)'] = 'Admin/document_list/$1';
$route['admin/log_out'] = 'Admin/Logout';

//category routes
$route['category'] = 'Category/category_list';
$route['category/add'] = 'Category/add_category';
$route['get_category_list'] = 'Category/get_category_list';
$route['category/delete'] = 'Category/deleteCategory';
$route['category/edit/(:any)'] = 'Category/edit_category/$1';



$route['thank_you'] = 'Vendor/thank_you';
$route['user/list'] = 'User/list';
$route['user/document_list/(:any)'] = 'User/document_list/$1';
$route['user/create_notification'] = 'User/create_notification';
$route['user/list_table'] = 'User/list_table';
$route['user/document_confirmation/(:any)'] = 'User/document_confirmation/$1';
$route['user/document_confirmation'] = 'User/document_confirmation';
$route['vendor'] = 'Vendor/index';
$route['n/(:any)'] = 'Vendor/expense/$1';
$route['document_add'] = 'Vendor/document_add';
$route['do_upload'] = 'Vendor/do_upload';
$route['addmore/(:any)'] = 'Vendor/addmore/$1';
$route['vendor/remove_document'] = 'Vendor/remove_document';
$route['user/logout'] = 'User/logout';

//download document
$route['download_file/(:any)'] = 'Vendor/download_file/$1';
$route['view_file/(:any)'] = 'Vendor/view_file/$1';

//settings routes
$route['admin/settings'] = 'Settings';
$route['admin/settings/upload_type_size'] = 'Settings/upload_type_size';
$route['admin/settings/upload_number'] = 'Settings/upload_number';
$route['admin/settings/add_upload_number'] = 'Settings/add_upload_number';
$route['admin/settings/get_upload_number'] = 'Settings/get_upload_number';
$route['admin/settings/edit_upload_number/(:any)'] = 'Settings/edit_upload_number/$1';
$route['admin/settings/delete_upload_number/(:any)'] = 'Settings/delete_upload_number/$1';

$route['admin/settings/notification_date_number'] = 'Settings/notification_date_number';
$route['admin/settings/add_notification_date_number'] = 'Settings/add_notification_date_number';
$route['admin/settings/get_notification_date_number'] = 'Settings/get_notification_date_number';
$route['admin/settings/edit_notification_date_number/(:any)'] = 'Settings/edit_notification_date_number/$1';
$route['admin/settings/delete_notification_date_number/(:any)'] = 'Settings/delete_notification_date_number/$1';

$route['admin/settings/permission'] = 'Settings/permission';
$route['admin/settings/permission_list'] = 'Settings/permission_list';
$route['admin/settings/add_role_permission'] = 'Settings/add_role_permission';
$route['admin/settings/edit_role_permission/(:any)'] = 'Settings/edit_role_permission/$1';
$route['admin/settings/delete_role_permission/(:any)'] = 'Settings/delete_role_permission/$1';

//for seeder
$route['seeder'] = 'Seeder/seed';

//user email check
$route['user_email_check'] = 'Admin/user_email_check';

//get contact list
$route['get_contact_list'] = 'User/get_contact_list';
$route['get_contact_details'] = 'User/get_contact_details';
$route['get_contacts_by_company'] = 'User/get_contacts_by_company';
