<?php
defined("BASEPATH") OR exit("No direct script access allowed");

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined("SHOW_DEBUG_BACKTRACE") OR define("SHOW_DEBUG_BACKTRACE", TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined("FILE_READ_MODE")  OR define("FILE_READ_MODE", 0644);
defined("FILE_WRITE_MODE") OR define("FILE_WRITE_MODE", 0666);
defined("DIR_READ_MODE")   OR define("DIR_READ_MODE", 0755);
defined("DIR_WRITE_MODE")  OR define("DIR_WRITE_MODE", 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined("FOPEN_READ")                           OR define("FOPEN_READ", "rb");
defined("FOPEN_READ_WRITE")                     OR define("FOPEN_READ_WRITE", "r+b");
defined("FOPEN_WRITE_CREATE_DESTRUCTIVE")       OR define("FOPEN_WRITE_CREATE_DESTRUCTIVE", "wb"); // truncates existing file data, use with care
defined("FOPEN_READ_WRITE_CREATE_DESTRUCTIVE")  OR define("FOPEN_READ_WRITE_CREATE_DESTRUCTIVE", "w+b"); // truncates existing file data, use with care
defined("FOPEN_WRITE_CREATE")                   OR define("FOPEN_WRITE_CREATE", "ab");
defined("FOPEN_READ_WRITE_CREATE")              OR define("FOPEN_READ_WRITE_CREATE", "a+b");
defined("FOPEN_WRITE_CREATE_STRICT")            OR define("FOPEN_WRITE_CREATE_STRICT", "xb");
defined("FOPEN_READ_WRITE_CREATE_STRICT")       OR define("FOPEN_READ_WRITE_CREATE_STRICT", "x+b");

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined("EXIT_SUCCESS")        OR define("EXIT_SUCCESS", 0); // no errors
defined("EXIT_ERROR")          OR define("EXIT_ERROR", 1); // generic error
defined("EXIT_CONFIG")         OR define("EXIT_CONFIG", 3); // configuration error
defined("EXIT_UNKNOWN_FILE")   OR define("EXIT_UNKNOWN_FILE", 4); // file not found
defined("EXIT_UNKNOWN_CLASS")  OR define("EXIT_UNKNOWN_CLASS", 5); // unknown class
defined("EXIT_UNKNOWN_METHOD") OR define("EXIT_UNKNOWN_METHOD", 6); // unknown class member
defined("EXIT_USER_INPUT")     OR define("EXIT_USER_INPUT", 7); // invalid user input
defined("EXIT_DATABASE")       OR define("EXIT_DATABASE", 8); // database error
defined("EXIT__AUTO_MIN")      OR define("EXIT__AUTO_MIN", 9); // lowest automatically-assigned error code
defined("EXIT__AUTO_MAX")      OR define("EXIT__AUTO_MAX", 125); // highest automatically-assigned error code


/* custom constants */

if (!defined("CURRENT_DATETIME")) {
	define("CURRENT_DATETIME", date("Y-m-d H:i:s"));
}

if (!defined("ROLE_SUPER_ADMIN")) {
	define("ROLE_SUPER_ADMIN", "super-admin");
}

if (!defined("ROLE_SUB_ADMIN")) {
	define("ROLE_SUB_ADMIN", "sub-admin");
}

if (!defined("ROLE_USER")) {
	define("ROLE_USER", "user");
}

if (!defined("CUSTOM_ENCRYPTION_KEY")) {
	define("CUSTOM_ENCRYPTION_KEY", 'kLSr9NdDaXmN3efYDGWnrJE9NTBEDtr');
}

if (!defined("COOKIE_TIME")) {
	define("COOKIE_TIME", time() + 360000000);
}

if (!defined("ADMIN_COOKIE_USERNAME")) {
	define("ADMIN_COOKIE_USERNAME", "practice_admin_username");
}

if (!defined("ADMIN_COOKIE_PASSWORD")) {
	define("ADMIN_COOKIE_PASSWORD", "practice_admin_password");
}

if (!defined("ADMIN_SESSION_ID")) {
	define("ADMIN_SESSION_ID", "practice_admin_id");
}


/* path set constants */

if (!defined("ADMIN_WITHOUT_SLASH_PATH")) {
	define("ADMIN_WITHOUT_SLASH_PATH", "ci-admin");
}

if (!defined("ADMIN_PATH")) {
	define("ADMIN_PATH", "ci-admin/");
}

if (!defined("ASSET_PATH")) {
	define("ASSET_PATH", "assets/");
}

if (!defined("IMAGES_PATH")) {
	define("IMAGES_PATH", ASSET_PATH."images/");
}

if (!defined("FAVION_IMAGE_PATH")) {
	define("FAVION_IMAGE_PATH", IMAGES_PATH."favicon/");
}

if (!defined("WEBSITE_LOGO_PATH")) {
	define("WEBSITE_LOGO_PATH", IMAGES_PATH."logo/");
}

if (!defined("NO_IMAGE_THUMB_PATH")) {
	define("NO_IMAGE_THUMB_PATH", IMAGES_PATH."no-image/no-image-200-x-200.png");
}

if (!defined("STORAGE_PATH")) {
	define("STORAGE_PATH", ASSET_PATH."storage/");
}

if (!defined("THUMB_WIDTH_BANNER_IMAGE")) {
	define("THUMB_WIDTH_BANNER_IMAGE", "150");
}

if (!defined("THUMB_HEIGHT_BANNER_IMAGE")) {
	define("THUMB_HEIGHT_BANNER_IMAGE", "100");
}

if (!defined("BANNER_IMAGE_THUMB_PATH")) {
	define("BANNER_IMAGE_THUMB_PATH", STORAGE_PATH."banner-images/thumbnail/");
}

if (!defined("BANNER_IMAGE_PATH")) {
	define("BANNER_IMAGE_PATH", STORAGE_PATH."banner-images/");
}

if (!defined("SAMPLE_EXCEL_PATH")) {
	define("SAMPLE_EXCEL_PATH", STORAGE_PATH."sample_excel/sample.xls");
}

if (!defined("IMPORT_EXCEL_PATH")) {
	define("IMPORT_EXCEL_PATH", STORAGE_PATH."excel/");
}

if (!defined("EXPORT_ZIP_PATH")) {
	define("EXPORT_ZIP_PATH", STORAGE_PATH."zip/");
}

if (!defined("CSS_PATH")) {
	define("CSS_PATH", ASSET_PATH."css/");
}

if (!defined("PLUGINS_PATH")) {
	define("PLUGINS_PATH", ASSET_PATH."plugins/");
}


/* btn constant */

if (!defined("BACK_BUTTON")) {
	define("BACK_BUTTON", "<div class='pull-right'><button class='btn' onclick='goBack();'>Back</button></div>");
}

if (!defined("ADD_NEW_BUTTON")) {
	define("ADD_NEW_BUTTON", "Add New <i class='fa fa-plus' aria-hidden='true'></i>");
}

if (!defined("DELETE_BUTTON")) {
	define("DELETE_BUTTON", "Delete <i class='fa fa-trash-o' aria-hidden='true'></i>");
}


/* icon constants */

if (!defined("LOADER")) {
	define("LOADER", "<i class='fa fa-spinner fa-spin fa-4x loading'></i>");
}

if (!defined("ACTIVATE_ICON")) {
	// define("ACTIVATE_ICON", "<i class='fa fa-times-circle-o fa-2x' aria-hidden='true'></i>");
	define("ACTIVATE_ICON", "<i class='fa fa-times fa-2x' aria-hidden='true'></i>");
}

if (!defined("DEACTIVATE_ICON")) {
	// define("DEACTIVATE_ICON", "<i class='fa fa-check-circle fa-2x' aria-hidden='true'></i>");
	define("DEACTIVATE_ICON", "<i class='fa fa-check fa-2x' aria-hidden='true'></i>");
}

if (!defined("VIEW_ICON")) {
	define("VIEW_ICON", "<i class='fa fa-eye fa-2x' aria-hidden='true'></i>");
}

if (!defined("EDIT_ICON")) {
	define("EDIT_ICON", "<i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i>");
}

if (!defined("DELETE_ICON")) {
	define("DELETE_ICON", "<i class='fa fa-trash-o fa-2x' aria-hidden='true'></i>");
}

if (!defined("CALENDER_ICON")) {
	define("CALENDER_ICON", "<i class='fa fa-calendar fa-1x margin-left-minus-25px' aria-hidden='true'></i>");
}

if (!defined("IMAGE_ICON")) {
	define("IMAGE_ICON", "<i class='fa fa-picture-o fa-2x' aria-hidden='true'></i>");
}

if (!defined("CHANGE_PASSWORD_ICON")) {
	define("CHANGE_PASSWORD_ICON", "<i class='fa fa-lock fa-2x' aria-hidden='true'></i>");
}


/* status constant */

if (!defined("YES")) {
	define("YES", "Y");
}

if (!defined("NO")) {
	define("NO", "N");
}

if (!defined("SAME_TAB")) {
	define("SAME_TAB", "S");
}

if (!defined("NEW_TAB")) {
	define("NEW_TAB", "N");
}

if (!defined("ACTIVE")) {
	define("ACTIVE", "Active");
}

if (!defined("DEACTIVE")) {
	define("DEACTIVE", "Deactive");
}


/* validation regular expression constants */

if (!defined("ALPHA_SPACE_REG")) {
	define("ALPHA_SPACE_REG", "/^[a-zA-Z ]+$/");
}

if (!defined("NUMERIC_REG")) {
	define("NUMERIC_REG", "/^[0-9]+$/");
}

if (!defined("ALPHA_NUMERIC_REG")) {
	define("ALPHA_NUMERIC_REG", "/^[a-zA-Z0-9]+$/");
}

if (!defined("ALPHA_NUMERIC_SPACE_REG")) {
	define("ALPHA_NUMERIC_SPACE_REG", "/^[a-zA-Z0-9 ]+$/");
}

if (!defined("EMAIL_REG")) {
	define("EMAIL_REG", "/^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})$/");
}


/* text constant */

if (!defined("LOADER_TEXT")) {
	define("LOADER_TEXT", "Please wait...");
}

if (!defined("REQUIRED_CONSTANT")) {
	define("REQUIRED_CONSTANT", "<span class='color-red'>* </span>");
}

if (!defined("NOT_REQUIRED_CONSTANT")) {
	define("NOT_REQUIRED_CONSTANT", "<span>&nbsp;&nbsp;&nbsp;</span>");
}

if (!defined("BANNER_IMAGE_SIZE_CONSTANT")) {
	define("BANNER_IMAGE_SIZE_CONSTANT", "<span class='font-size-12px'>&nbsp;&nbsp;&nbsp;</span>(1300 X 800)");
}

if (!defined("EXCEL_ONLY_CONSTANT")) {
	define("EXCEL_ONLY_CONSTANT", "<span class='font-size-12px'>&nbsp;&nbsp;&nbsp;(xls, xlsx or csv only)</span>");
}

if (!defined("WEBSITE_LOGO_SIZE_CONSTANT")) {
	define("WEBSITE_LOGO_SIZE_CONSTANT", "<span class='font-size-12px'>&nbsp;&nbsp;&nbsp;</span>(250 X 150)");
}

if (!defined("FAVICON_ICON_SIZE_CONSTANT")) {
	define("FAVICON_ICON_SIZE_CONSTANT", "<span class='font-size-12px'>&nbsp;&nbsp;&nbsp;</span>(50 X 50)");
}

if (!defined("IS_REQUIRED")) {
	define("IS_REQUIRED", " is required");
}

if (!defined("NOT_SAME")) {
	define("NOT_SAME", "New Password and Confirm Password is not same");
}

if (!defined("NOT_SPECIAL_CHARECTER_OR_SPACE")) {
	define("NOT_SPECIAL_CHARECTER_OR_SPACE", "Please dont enter and special charecter or space");
}

if (!defined("NOT_SPECIAL_CHARECTER")) {
	define("NOT_SPECIAL_CHARECTER", "Please dont enter and special charecter");
}

if (!defined("NOT_VALID_EMAIL")) {
	define("NOT_VALID_EMAIL", "Please enter valid email address");
}

if (!defined("NOT_VALID_PHONE")) {
	define("NOT_VALID_PHONE", "Please enter valid phone number");
}

if (!defined("ALREADY_EXIST")) {
	define("ALREADY_EXIST", " already exists");
}

if (!defined("NOT_VALID_NUMBER_OF_CHARECTER")) {
	define("NOT_VALID_NUMBER_OF_CHARECTER", "Please enter more then 5 Charecters");
}

if (!defined("ONLY_ALPHA")) {
	define("ONLY_ALPHA", "Please enter any alphabets");
}

if (!defined("ONLY_ALPHA_AND_SPACE")) {
	define("ONLY_ALPHA_AND_SPACE", "Please enter Alphabets and Space Only");
}

if (!defined("ERROR_IMAGE")) {
	define("ERROR_IMAGE", "Image have some errors");
}

if (!defined("ERROR_EXCEL")) {
	define("ERROR_EXCEL", "Excel have some errors");
}

if (!defined("SELECT_ONE")) {
	define("SELECT_ONE", "Please select one image");
}

if (!defined("VALID_EXTENSION")) {
	define("VALID_EXTENSION", "Please select Jpg or Png Image Only");
}

if (!defined("VALID_EXTENSION_EXCEL")) {
	define("VALID_EXTENSION_EXCEL", "Please select xls, xlsx or csv Only");
}

if (!defined("NOT_EMAIL_EXIST")) {
	define("NOT_EMAIL_EXIST", "This email is not exist");
}

if (!defined("TRY_AGAIN_LATER")) {
	define("TRY_AGAIN_LATER", "Please try again later");
}

if (!defined("INVALID_LOGIN")) {
	define("INVALID_LOGIN", "Username or Password is incorrect");
}

if (!defined("VALID_LOGIN")) {
	define("VALID_LOGIN", "Sign in Successfully");
}

if (!defined("OLD_PASSWORD_INCORRECT")) {
	define("OLD_PASSWORD_INCORRECT", "Old Password is incorrect");
}

if (!defined("PASSWORD_CHANGED")) {
	define("PASSWORD_CHANGED", "Password Successfully Changed");
}

if (!defined("EMAIL_SEND_RESET_LINK")) {
	define("EMAIL_SEND_RESET_LINK", "Please check your e-mail we have sent a password reset link to your registered email");
}