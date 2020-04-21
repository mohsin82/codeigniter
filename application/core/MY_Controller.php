<?php

/* 

location :- application/core/MY_Controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

/* this controller is used in all side */
class MY_Controller extends CI_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		// $this->load->model('main_model');
	}
	
	/* loggedin redirect to dashboard */
	public function goToAdminDashboard() {
		
		if($this->session->userdata(ADMIN_SESSION_ID)) {
			
			redirect(base_url(ADMIN_PATH.'dashboard/'));
			exit();
		}
	}
	
	/* not loggedin redirect to login */
	public function goToAdminLogin() {
		
		if(!$this->session->userdata(ADMIN_SESSION_ID)) {

			redirect(base_url(ADMIN_PATH.'login/'));
			exit();
		}
	}
	
	/* not ajax direct allowed */
	public function notAjaxDirect() {
		
		if (!$this->input->is_ajax_request()) {
			
			show_404();
			exit();
		}
	}
	
	/* no data found */
	public function show404Page($checkData) {
		
		if($checkData == false) {
			
			show_404();
			exit();
		}
	}

	/* encryption */
	public function encryptIt($string) {
		
		$cryptKey = CUSTOM_ENCRYPTION_KEY;
		$qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $string, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
		
		$qEncod = str_replace("/",":",$qEncoded);
		return($qEncod);
	}
	
	/* decryption */
	public function decryptIt($string) {
		
		$q = str_replace(":","/",$string);
		$cryptKey = CUSTOM_ENCRYPTION_KEY;
		$qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
		return($qDecoded);
	}
	
	/* default encryption of codeigniter */
	public function encodeIt($string) {
		
		$encrypted_string = $this->encrypt->encode($string);
		return($encrypted_string);
	}

	/* default decryption of codeigniter */
	public function decodeIt($string) {
		
		$decrypted_string = $this->encrypt->decode($string);
		return($decrypted_string);
	}

	/* remove special charecter */
	public function removeSpecialCharecter($fileName) {
		
		$array = array (' ', '!', '#', '$', '%', '&', '(', ')', '*', '+', ',', '-', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '`', '{', '|', '}', '~', '"', '\'');
		$newFileName = str_replace($array, '', $fileName);
		return $newFileName;
	}

	/* date format conversion */
	public function convertDateFormat($date_format,$date) {
		
		$strDate = strtotime($date);
		$convertDateFormat = date($date_format,$strDate);
		return $convertDateFormat;
	}

	/* compress image */
	public function compressImage($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') {
			
			$image = imagecreatefromjpeg($source);

		} else if ($info['mime'] == 'image/gif') {
			
			$image = imagecreatefromgif($source);

		} else if ($info['mime'] == 'image/png') {
			
			$image = imagecreatefrompng($source);
		}

		imagejpeg($image, $destination, $quality);

		return $destination;
	}
	
	/* upload main image */
	public function uploadImage($uniqueString, $field_name = '', $target_folder = '', $file_name = '') {

		/* folder path setup */
		$target_path = $target_folder;
		
		/* file name setup */
		$filename_err = explode(".",$_FILES[$field_name]['name']);
		$filename_err_count = count($filename_err);
		$file_ext = $filename_err[$filename_err_count-1];
		
		if($file_name != '') {
			$fileName = $uniqueString.'_'.$file_name.'.'.$file_ext;
		} else {
			$fileName = $uniqueString.'_'.$_FILES[$field_name]['name'];
		}
		
		/* remove special charecters */
		$fileName = $this->removeSpecialCharecter($fileName);
		
		/* upload image path */
		$upload_image = $target_path.basename($fileName);
		
		/* upload image */
		$source_img = $_FILES[$field_name]['tmp_name'];
		$destination_img = $_FILES[$field_name]['tmp_name'];
		
		/* compress image */
		$this->compressImage($source_img, $destination_img, 90);

		if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image)) {
			
			return $fileName;
		
		} else {
			
			return false;
		}
	}

	/* thumbnail */
	public function createThumbnail($uniqueString, $field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = '') {

		/* folder path setup */
		$target_path = $target_folder;
		$thumb_path = $thumb_folder;
		
		/* file name setup */
		$filename_err = explode(".",$_FILES[$field_name]['name']);
		$filename_err_count = count($filename_err);
		$file_ext = $filename_err[$filename_err_count-1];
		
		if($file_name != '') {
			$fileName = $uniqueString.'_'.$file_name.'.'.$file_ext;
		} else {
			$fileName = $uniqueString.'_'.$_FILES[$field_name]['name'];
		}
		
		/* remove special charecters */
		$fileName = $this->removeSpecialCharecter($fileName);
		
		/* upload image path */
		$upload_image = $target_path.basename($fileName);
		
		/* upload image */
		$source_img = $_FILES[$field_name]['tmp_name'];
		$destination_img = $_FILES[$field_name]['tmp_name'];
		
		/* compress image */
		$this->compressImage($source_img, $destination_img, 90);

		if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image)) {
			
			/* thumbnail creation */
			if($thumb == TRUE) {
				
				$thumbnail = $thumb_path.$fileName;
				list($width,$height) = getimagesize($upload_image);
				$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
				switch($file_ext) {
					case 'jpg':
						$source = imagecreatefromjpeg($upload_image);
						break;
					case 'jpeg':
						$source = imagecreatefromjpeg($upload_image);
						break;

					case 'png':
						$source = imagecreatefrompng($upload_image);
						break;
					case 'gif':
						$source = imagecreatefromgif($upload_image);
						break;
					default:
						$source = imagecreatefromjpeg($upload_image);
				}

				imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
				switch($file_ext) {
					case 'jpg' || 'jpeg':
						imagejpeg($thumb_create,$thumbnail,100);
						break;
					case 'png':
						imagepng($thumb_create,$thumbnail,100);
						break;

					case 'gif':
						imagegif($thumb_create,$thumbnail,100);
						break;
					default:
						imagejpeg($thumb_create,$thumbnail,100);
				}

			}

			return $fileName;
		
		} else {
			
			return false;
		}
	}

	/* upload excel */
	public function uploadExcel($uniqueString, $field_name, $target_folder, $file_name = '') {
		
		/* folder path setup */
		$target_path = $target_folder;
		
		/* file name setup */
		$filename_err = explode(".",$_FILES[$field_name]['name']);
		$filename_err_count = count($filename_err);
		$file_ext = $filename_err[$filename_err_count-1];
		
		if($file_name != '') {
			$fileName = $uniqueString.'_'.$file_name.'.'.$file_ext;
		} else {
			$fileName = $uniqueString.'_'.$_FILES[$field_name]['name'];
		}
		
		/* remove special charecters */
		$fileName = $this->removeSpecialCharecter($fileName);
		
		/* upload excel path */
		$upload_excel = $target_path.basename($fileName);
		
		/* upload excel */
		if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_excel)) {
			
			return $fileName;
		
		} else {
			
			return false;
		}
	}
	
	/* generate word file */
	public function generateWord($file_name,$html) {
		
		/* mime type */
		header("Content-type: application/vnd.ms-word");
		
		/* tell browser what's the file name */
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
	
		/* no cache */
		header('Cache-Control: max-age=0');
	}
	
	/* send mail */ 
	public function sendMail($to, $subject, $content) {
		
		$content = wordwrap($content);

		$headers = 'From: webmaster@example.com'."\r\n".
			'Reply-To: webmaster@example.com'."\r\n".
			'X-Mailer: PHP/'.phpversion();
			
		mail($to, $subject, $content, $headers);
	}
}

/* 

End of file :- 

location :- application/core/MY_Controller.php

*/

?>