<?php

/* 

location :- application/controllers/advance_controller.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Advance_controller extends MY_Controller {

	/* function construct */
	function __construct() {
		
		parent::__construct();
		
		$this->goToAdminLogin();
		
		$this->load->library('Pdf', '', 'pdf');
		$this->load->library('excel');
		$this->load->library('zip');
	}
	
	/* create import display */
	public function import() {
		
		$data = array();
		$data['title'] = 'Import';
		$data['active_tab'] = ADMIN_PATH.'import';
		$data['page_content'] = ADMIN_PATH.'advance/import';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* insert import file */
	public function store_import_file() {
		
		$this->notAjaxDirect();

		$uniqueString = uniqid();

		$arr = array();
		$excelFileName = $this->input->post("fileName");
		if(!empty($excelFileName) || $excelFileName == 'undefined') {
			
			$arr['response'] = false;
			$arr['msg'] = "File".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}

		$fileName = $this->removeSpecialCharecter($_FILES["fileName"]["name"]);
	
		$excelName = $uniqueString.'_'.$fileName;
		$excelTempName = $_FILES["fileName"]["tmp_name"];
		$excelTempType = $_FILES["fileName"]["type"];
		$excelTempSize = $_FILES["fileName"]["size"];

		if(isset($_FILES) || !empty($_FILES)) {
			
			$validextensions = array("xls", "xlsx", "csv");
			$temporary = explode(".",$excelName);
			$file_extension = end($temporary);
			if(in_array($file_extension, $validextensions)) {
			
				if($_FILES["fileName"]["error"] > 0) {
					
					$arr['response'] = false;
					$arr['msg'] = ERROR_EXCEL;
					echo json_encode($arr);
					exit();
				
				} else {
					
					if(file_exists(IMPORT_EXCEL_PATH.$excelName)) {
					
						$arr['response'] = false;
						$arr['msg'] = "File is".ALREADY_EXIST;
						echo json_encode($arr);
						exit();

					} else {
						
						$fieldName = 'fileName';
						$mainPath = IMPORT_EXCEL_PATH;
						
						$this->uploadExcel($uniqueString,$fieldName,$mainPath,'');
					}
				}
				
			} else {
			
				$arr['response'] = false;
				$arr['msg'] = VALID_EXTENSION_EXCEL;
				echo json_encode($arr);
				exit();
			}
			
		} else {
			
			$arr['response'] = false;
			$arr['msg'] = "File".IS_REQUIRED;
			echo json_encode($arr);
			exit();
		}
		
		$inputFileName = IMPORT_EXCEL_PATH.$excelName;
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);

		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

		$arrayCount = count($allDataInSheet);

		$insert_multiple = array();		
		/* for loop for data insert */
		for ($i = 4; $i <= $arrayCount; $i++) {
		
			$email = trim($allDataInSheet[$i]['B']);

			$emailReg = EMAIL_REG;

			if(empty($email)) {
				
				continue;
			
			}  else if(!preg_match($emailReg, $email)) {

				continue;
			} 
			
			/* check email first then insert data into table */
			$tableName = 'newsletter_users';
			$selectEmail = 'count(newsletter_user_id) as count_newsletter_user';
			$emailWhere = array(
							'email' => $email
						);

			$get_row = $this->main_model->get_first_row($selectEmail,$emailWhere,$tableName);
			$count_newsletter_user = $get_row->count_newsletter_user;
			if($count_newsletter_user > 0) {

				continue;
					
			} else {
					
				$status = YES;
				$delete_status = NO;
				
				$insert = array(
							'email' => $email,
							'created_at' => CURRENT_DATETIME,
							'modified_at' => CURRENT_DATETIME,
							'status' => $status,
							'delete_status' => $delete_status
						);
					
				$insert_multiple[] = $insert;
			}
		}

		$unique_insert_multiple = array_unique($insert_multiple,SORT_REGULAR);
		
		if(!empty($unique_insert_multiple)) {

			$type = "multiple";
			$inserted_data = $this->main_model->insert_data($unique_insert_multiple,$tableName,$type);
		}

		unlink(IMPORT_EXCEL_PATH.$excelName);
        
        	$arr['response'] = true;
		$arr['msg'] = "File Imported Successfully";
		echo json_encode($arr);
		exit();
	}

	/* create export display */
	public function export() {
		
		$data = array();
		$data['title'] = 'Export';
		$data['active_tab'] = ADMIN_PATH.'export';
		$data['page_content'] = ADMIN_PATH.'advance/export';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}
	
	/* create export pdf */
	public function exportPdf() { 
	
		$html = '<style>'.file_get_contents(base_url(CSS_PATH.'pdf_style.css')).'</style>';
		$html .= '<table border="1" class="exportPdfCss">'.
					'<thead>'.
						'<tr>'.
							'<td width="10%">#</td>'.
							'<td width="90%">Email</td>'.
						'</tr>'.
					'</thead>'.
					'<tbody>';
					
		/* retrieve newsletter users data */
		$tableName = 'newsletter_users';
		$select = 'email';
		$where = array(
					'delete_status' => NO
				);

		$result = $this->main_model->get_result_where($select,$where,$tableName);
		if($result != false) {
			
			$i = 0;
			foreach($result as $row) {
				
				$i++;
				$email = $row->email;
				
				$html .= '<tr>'.
							'<td width="10%">'.$i.'</td>'.
							'<td width="90%">'.$email.'</td>'.
						'</tr>';
			}
		}	
					
		$html .= '</tbody>'.
			'</table>';
		
		$file_name = 'test.pdf';
		$type = 'D';
		
		$this->pdf->generatePdf($file_name,$type,$html);
	}
	
	/* create export excel */
	public function exportExcel() {
		
		$this->excel->setActiveSheetIndex(0);
               
		/* name the worksheet */
		$this->excel->getActiveSheet()->setTitle('Newsletter Users');
        
		/* set width to cell */
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
			
		/* set cell A1 content with some text */
		$this->excel->getActiveSheet()->setCellValue('A1', 'Users Excel Sheet');
		$this->excel->getActiveSheet()->setCellValue('A3', '#');
		$this->excel->getActiveSheet()->setCellValue('B3', 'Email');
                
		$this->excel->getActiveSheet()->getStyle('A3:B3')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FF0000')
				),
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 15,
					'name'  => 'Verdana'
				)
			)
		);
				
		/* merge cell A1 until C1 */
		$this->excel->getActiveSheet()->mergeCells('A1:B1');
              
		/* set aligment to center for that merged cell (A1 to C1) */
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
		/* make the font become bold */
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       
		/* set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true); */
		for($col = ord('A'); $col <= ord('B'); $col++){ 
			
			/* change the font size */
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		
		/* retrive newsletter users data */
		$tableName = 'newsletter_users';
		$select = 'email';
		$where = array(
					'delete_status' => NO
				);

		$result = $this->main_model->get_result_where($select,$where,$tableName);
		if($result != false) {
			
			$i = 0;
			$hashId = 0;
			$exceldata = array();
			foreach($result as $row) {
				
				$hashId++;
				$email = $row->email;
				
				$exceldata[$i]['hashId'] = $hashId;
				$exceldata[$i]['email'] = $email;
				
				$i++;
			}
			
			/* Fill data */
			$this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
			
			$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		
		/* save our workbook as this file name */
		$filename='test.xls';
		
		/* mime type */
		header('Content-Type: application/vnd.ms-excel');
		
		/* tell browser what's the file name */
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		
		/* no cache */
		header('Cache-Control: max-age=0');
 
		/* save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			if you want to save it as .XLSX Excel 2007 format */
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');   
		
		/* force user to download the Excel file without writing it to server's HD */
		$objWriter->save('php://output');
	}
	
	/* create export word */
	public function exportWord() {
		
		$html = '<table border="1" class="exportWordCss">'.
					'<thead>'.
						'<tr>'.
							'<th width="10%">#</th>'.
							'<th width="90%">Email</th>'.
						'</tr>'.
					'</thead>'.
					'<tbody>';
					
		$tableName = 'newsletter_users';
		$select = 'email';
		$where = array(
					'delete_status' => NO
				);
					
		$result = $this->main_model->get_result_where($select,$where,$tableName);
		if($result != false) {
			
			$i = 0;
			$exceldata = array();
			foreach($result as $row) {
				
				$i++;
				$email = $row->email;
				
				$html .= '<tr>'.
							'<td width="10%">'.$i.'</td>'.
							'<td width="90%">'.$email.'</td>'.
						'</tr>';
			}
		
		} else {
			
			$html .= '<tr>'.
						'<td colspan="2">No Records Found</td>'.
					'</tr>';
		}
		
		$html .= '</tbody>'.
			'</table>';
			
		echo $html;
			
		/* save our workbook as this file name */
		$file_name='test.doc';
	
		$this->generateWord($file_name,$html);
	}
	
	/* create export zip */
	public function exportZip() {
		
		$name = 'test-zip.txt';
		$data = 'this is the testing file';

		$this->zip->add_data($name, $data);

		/* Write the zip file to a folder on your server. */
		$this->zip->archive(base_url(EXPORT_ZIP_PATH.'test.zip'));

		/* Download the file to your desktop. */
		$this->zip->download('test.zip');
		
		unlink(EXPORT_ZIP_PATH.'test.zip');
	}

	/* create print view display */
	public function printView() {
		
		$data = array();
		$data['title'] = 'Print View';
		$data['active_tab'] = ADMIN_PATH.'print-view';
		$data['page_content'] = ADMIN_PATH.'advance/print-view';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

	/* create editors display */
	public function editors() {
		
		$data = array();
		$data['title'] = 'Editors';
		$data['active_tab'] = ADMIN_PATH.'editors';
		$data['page_content'] = ADMIN_PATH.'advance/editors';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

	/* create dynamic generate box display */
	public function dynamicGenerateBox() {
		
		$data = array();
		$data['title'] = 'Dynamic Generate Box';
		$data['active_tab'] = ADMIN_PATH.'dynamic-generate-box';
		$data['page_content'] = ADMIN_PATH.'advance/dynamic-generate-box';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

	/* create form design display */
	public function formDesign() {
		
		$data = array();
		$data['title'] = 'Form Design';
		$data['active_tab'] = ADMIN_PATH.'form-design';
		$data['page_content'] = ADMIN_PATH.'advance/form-design';
		$data['includes'] = 'common';
		$this->load->view(ADMIN_PATH.'template',$data);
	}

}

/* 

End of file :- 

location :- application/controllers/advance_controller.php

*/

?>