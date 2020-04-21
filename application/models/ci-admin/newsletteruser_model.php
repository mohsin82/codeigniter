<?php

/* 

location :- application/models/newsletteruser_model.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletteruser_model extends CI_Model {

	private function _get_datatables_query($startDate,$endDate) {
		
		$column_search = array('email'); 
		$order = array('newsletter_user_id' => 'desc'); 
		
		$this->db->select('newsletter_user_id,email,status');
		$this->db->from('newsletter_users');
		$this->db->where('delete_status',NO);
		
		if($startDate != "0" && $endDate != "0") {
		
			$this->db->where('created_at >=',$startDate);
			$this->db->where('created_at <=',$endDate);
		}

		$i = 0;
		foreach ($column_search as $item) {
			
			if($_POST['search']['value']) {
				
				if($i === 0) {
					
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				
				} else {
					
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order'])) {
			
			if($_POST['order']['0']['column'] == '2') {

				$this->db->order_by('email', $_POST['order']['0']['dir']);
			}
		
		} else if(isset($order)) {
			
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables($startDate,$endDate) {
		
		$this->_get_datatables_query($startDate,$endDate);
		if($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered($startDate,$endDate) {
		
		$this->_get_datatables_query($startDate,$endDate);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($startDate,$endDate) {
		
		if($startDate != "0" && $endDate != "0") {
			
			$this->db->where('created_at >=',$startDate);
			$this->db->where('created_at <=',$endDate);
		}

		$this->db->select('newsletter_user_id');
		$this->db->from('newsletter_users');
		$this->db->where('delete_status',NO);
		return $this->db->count_all_results();
	}
}

/* 

End of file :- 

location :- application/models/newsletteruser_model.php

*/
?>