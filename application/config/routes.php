<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* admin routes */

$route[ADMIN_WITHOUT_SLASH_PATH] = ADMIN_PATH.'login_controller/create';
$route[ADMIN_PATH.'login'] = ADMIN_PATH.'login_controller/create';
$route[ADMIN_PATH.'get-login'] = ADMIN_PATH.'login_controller/get_login';
$route[ADMIN_PATH.'logout'] = ADMIN_PATH.'login_controller/get_logout';

$route[ADMIN_PATH.'change-password'] = ADMIN_PATH.'changepassword_controller/create';
$route[ADMIN_PATH.'change-password-'.ADMIN_WITHOUT_SLASH_PATH] = ADMIN_PATH.'changepassword_controller/update_change_password';

$route[ADMIN_PATH.'forgot-password'] = ADMIN_PATH.'forgotpassword_controller/create';
$route[ADMIN_PATH.'get-forgot-password'] = ADMIN_PATH.'forgotpassword_controller/get_forgot_password';
$route[ADMIN_PATH.'reset-password/(:any)'] = ADMIN_PATH.'forgotpassword_controller/reset_password/$1';
$route[ADMIN_PATH.'reset-password-'.ADMIN_WITHOUT_SLASH_PATH] = ADMIN_PATH.'forgotpassword_controller/update_reset_password';

$route[ADMIN_PATH.'my-account'] = ADMIN_PATH.'myaccount_controller/create';
$route[ADMIN_PATH.'update-my-account'] = ADMIN_PATH.'myaccount_controller/update_my_acoount';

$route[ADMIN_PATH.'dashboard'] = ADMIN_PATH.'dashboard_controller/create';

$route[ADMIN_PATH.'banners'] = ADMIN_PATH.'banner_controller/create';
$route[ADMIN_PATH.'banner-data-list'] = ADMIN_PATH.'banner_controller/ajax_data_list';
$route[ADMIN_PATH.'add-banner'] = ADMIN_PATH.'banner_controller/add_banner';
$route[ADMIN_PATH.'insert-banner'] = ADMIN_PATH.'banner_controller/store';
$route[ADMIN_PATH.'edit-banner/(:num)'] = ADMIN_PATH.'banner_controller/edit_banner/$1';
$route[ADMIN_PATH.'update-banner'] = ADMIN_PATH.'banner_controller/storeEdit';
$route[ADMIN_PATH.'change-status-banner/(:num)/(:any)'] = ADMIN_PATH.'banner_controller/change_status/$1/$2';
$route[ADMIN_PATH.'delete-banner'] = ADMIN_PATH.'banner_controller/change_delete_status';

$route[ADMIN_PATH.'banner-images/(:num)'] = ADMIN_PATH.'bannerimage_controller/create/$1';
$route[ADMIN_PATH.'add-banner-image/(:num)'] = ADMIN_PATH.'bannerimage_controller/add_banner_image/$1';
$route[ADMIN_PATH.'insert-banner-image'] = ADMIN_PATH.'bannerimage_controller/store';
$route[ADMIN_PATH.'edit-banner-image/(:num)/(:num)'] = ADMIN_PATH.'bannerimage_controller/edit_banner_image/$1/$2';
$route[ADMIN_PATH.'update-banner-image'] = ADMIN_PATH.'bannerimage_controller/storeEdit/$1/$2';
$route[ADMIN_PATH.'change-status-banner-image/(:num)/(:num)/(:any)'] = ADMIN_PATH.'bannerimage_controller/change_status/$1/$2/$3';
$route[ADMIN_PATH.'delete-banner-image'] = ADMIN_PATH.'bannerimage_controller/change_delete_status/';

$route[ADMIN_PATH.'pages/(:num)'] = ADMIN_PATH.'page_controller/create/$1';
$route[ADMIN_PATH.'add-page'] = ADMIN_PATH.'page_controller/add_page';
$route[ADMIN_PATH.'insert-page'] = ADMIN_PATH.'page_controller/store';
$route[ADMIN_PATH.'edit-page/(:num)'] = ADMIN_PATH.'page_controller/edit_page/$1';
$route[ADMIN_PATH.'update-page'] = ADMIN_PATH.'page_controller/storeEdit';
$route[ADMIN_PATH.'view-page/(:num)'] = ADMIN_PATH.'page_controller/view_page/$1';
$route[ADMIN_PATH.'change-status-page/(:num)/(:any)/(:num)'] = ADMIN_PATH.'page_controller/change_status/$1/$2/$3';
$route[ADMIN_PATH.'delete-page'] = ADMIN_PATH.'page_controller/change_delete_status';

$route[ADMIN_PATH.'email-templates'] = ADMIN_PATH.'emailtemplate_controller/create';
$route[ADMIN_PATH.'email-template-data-list'] = ADMIN_PATH.'emailtemplate_controller/ajax_data_list';
$route[ADMIN_PATH.'add-email-template'] = ADMIN_PATH.'emailtemplate_controller/add_email_template';
$route[ADMIN_PATH.'insert-email-template'] = ADMIN_PATH.'emailtemplate_controller/store';
$route[ADMIN_PATH.'edit-email-template/(:num)'] = ADMIN_PATH.'emailtemplate_controller/edit_email_template/$1';
$route[ADMIN_PATH.'update-email-template'] = ADMIN_PATH.'emailtemplate_controller/storeEdit';
$route[ADMIN_PATH.'view-email-template/(:num)'] = ADMIN_PATH.'emailtemplate_controller/view_email_template/$1';
$route[ADMIN_PATH.'change-status-email-template/(:num)/(:any)'] = ADMIN_PATH.'emailtemplate_controller/change_status/$1/$2';
$route[ADMIN_PATH.'delete-email-template'] = ADMIN_PATH.'emailtemplate_controller/change_delete_status';

$route[ADMIN_PATH.'newsletter-content'] = ADMIN_PATH.'newslettercontent_controller/create';
$route[ADMIN_PATH.'get-newsletter-content-data/(:num)'] = ADMIN_PATH.'newslettercontent_controller/get_newsletter_content_data/$1';
$route[ADMIN_PATH.'add-newsletter-content'] = ADMIN_PATH.'newslettercontent_controller/add_newsletter_content';
$route[ADMIN_PATH.'insert-newsletter-content'] = ADMIN_PATH.'newslettercontent_controller/store';
$route[ADMIN_PATH.'edit-newsletter-content/(:num)'] = ADMIN_PATH.'newslettercontent_controller/edit_newsletter_content/$1';
$route[ADMIN_PATH.'update-newsletter-content'] = ADMIN_PATH.'newslettercontent_controller/storeEdit';
$route[ADMIN_PATH.'view-newsletter-content/(:num)'] = ADMIN_PATH.'newslettercontent_controller/view_newsletter_content/$1';
$route[ADMIN_PATH.'change-status-newsletter-content/(:num)/(:any)/(:num)'] = ADMIN_PATH.'newslettercontent_controller/change_status/$1/$2/$3';
$route[ADMIN_PATH.'delete-newsletter-content'] = ADMIN_PATH.'newslettercontent_controller/change_delete_status';

$route[ADMIN_PATH.'contact-us'] = ADMIN_PATH.'contactus_controller/create';
$route[ADMIN_PATH.'contact-us-data-list'] = ADMIN_PATH.'contactus_controller/ajax_data_list';
$route[ADMIN_PATH.'edit-contact-us/(:num)'] = ADMIN_PATH.'contactus_controller/edit_contact_us/$1';
$route[ADMIN_PATH.'update-contact-us'] = ADMIN_PATH.'contactus_controller/storeEdit';
$route[ADMIN_PATH.'view-contact-us/(:num)'] = ADMIN_PATH.'contactus_controller/view_contact_us/$1';
$route[ADMIN_PATH.'change-status-contact-us/(:num)/(:any)'] = ADMIN_PATH.'contactus_controller/change_status/$1/$2';
$route[ADMIN_PATH.'delete-contact-us'] = ADMIN_PATH.'contactus_controller/change_delete_status';

$route[ADMIN_PATH.'newsletter-users'] = ADMIN_PATH.'newsletteruser_controller/create';
$route[ADMIN_PATH.'newsletter-user-data-list/(:any)/(:any)'] = ADMIN_PATH.'newsletteruser_controller/ajax_data_list/$1/$2';
$route[ADMIN_PATH.'add-newsletter-user'] = ADMIN_PATH.'newsletteruser_controller/add_newsletter_user';
$route[ADMIN_PATH.'insert-newsletter-user'] = ADMIN_PATH.'newsletteruser_controller/store';
$route[ADMIN_PATH.'edit-newsletter-user/(:num)'] = ADMIN_PATH.'newsletteruser_controller/edit_newsletter_user/$1';
$route[ADMIN_PATH.'update-newsletter-user'] = ADMIN_PATH.'newsletteruser_controller/storeEdit';
$route[ADMIN_PATH.'view-newsletter-user/(:num)'] = ADMIN_PATH.'newsletteruser_controller/view_newsletter_user/$1';
$route[ADMIN_PATH.'change-status-newsletter-user/(:num)/(:any)'] = ADMIN_PATH.'newsletteruser_controller/change_status/$1/$2';
$route[ADMIN_PATH.'delete-newsletter-user'] = ADMIN_PATH.'newsletteruser_controller/change_delete_status';

$route[ADMIN_PATH.'users'] = ADMIN_PATH.'user_controller/create';
$route[ADMIN_PATH.'user-data-list'] = ADMIN_PATH.'user_controller/ajax_data_list';
$route[ADMIN_PATH.'add-user'] = ADMIN_PATH.'user_controller/add_user';
$route[ADMIN_PATH.'insert-user'] = ADMIN_PATH.'user_controller/store';
$route[ADMIN_PATH.'edit-user/(:num)'] = ADMIN_PATH.'user_controller/edit_user/$1';
$route[ADMIN_PATH.'update-user'] = ADMIN_PATH.'user_controller/storeEdit';
$route[ADMIN_PATH.'view-user/(:num)'] = ADMIN_PATH.'user_controller/view_user/$1';
$route[ADMIN_PATH.'change-status-user/(:num)/(:any)'] = ADMIN_PATH.'user_controller/change_status/$1/$2';
$route[ADMIN_PATH.'delete-user'] = ADMIN_PATH.'user_controller/change_delete_status';
$route[ADMIN_PATH.'change-password-user/(:num)'] = ADMIN_PATH.'user_controller/change_password/$1';
$route[ADMIN_PATH.'update-change-password-user'] = ADMIN_PATH.'user_controller/update_change_password';

$route[ADMIN_PATH.'site-setting'] = ADMIN_PATH.'setting_controller/create';
$route[ADMIN_PATH.'update-site-setting'] = ADMIN_PATH.'setting_controller/update_site_setting';

$route[ADMIN_PATH.'send-mail'] = ADMIN_PATH.'SendMailController/create';

$route[ADMIN_PATH.'import'] = ADMIN_PATH.'advance_controller/import';
$route[ADMIN_PATH.'insert-import-file'] = ADMIN_PATH.'advance_controller/store_import_file';
$route[ADMIN_PATH.'export'] = ADMIN_PATH.'advance_controller/export';
$route[ADMIN_PATH.'export-pdf'] = ADMIN_PATH.'advance_controller/exportPdf';
$route[ADMIN_PATH.'export-excel'] = ADMIN_PATH.'advance_controller/exportExcel';
$route[ADMIN_PATH.'export-word'] = ADMIN_PATH.'advance_controller/exportWord';
$route[ADMIN_PATH.'export-zip'] = ADMIN_PATH.'advance_controller/exportZip';
$route[ADMIN_PATH.'print-view'] = ADMIN_PATH.'advance_controller/printView';
$route[ADMIN_PATH.'editors'] = ADMIN_PATH.'advance_controller/editors';
$route[ADMIN_PATH.'dynamic-generate-box'] = ADMIN_PATH.'advance_controller/dynamicGenerateBox';
$route[ADMIN_PATH.'form-design'] = ADMIN_PATH.'advance_controller/formDesign';

/* admin routes */


/* basic routes */

$route['get-states'] = 'global_controller/getStateList';
$route['get-cities'] = 'global_controller/getCityList';

/* basic routes */


/* user routes */

$route['default_controller'] = '';

/* user routes */


/* error routes */

$route['404_override'] = '';

/* error routes */


$route['translate_uri_dashes'] = FALSE;

?>