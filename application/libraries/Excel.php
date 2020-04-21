<?php 

/* 

location :- application/libraries/Excel.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');
 
require_once APPPATH."/third_party/PHPExcel/Classes/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    
    /* function construct */
	function __construct() { 
        
		parent::__construct(); 
    }
}

/* 

End of file :- 

location :- application/libraries/Excel.php

*/

?>