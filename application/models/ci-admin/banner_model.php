<?php

/* 

location :- application/models/banner_model.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model {

	private function _get_datatables_query() {
		
		$column_search = array('name'); 
		$order = array('banner_id' => 'desc'); 
		
		$this->db->select('banner_id,name,status');
		$this->db->from('banners');
		$this->db->where('delete_status',NO);
		
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

				$this->db->order_by('name', $_POST['order']['0']['dir']);
			}
			
		} else if(isset($order)) {
			
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables() {
		
		$this->_get_datatables_query();
		if($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered() {
		
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all() {
		
		$this->db->select('banner_id');
		$this->db->from('banners');
		$this->db->where('delete_status',NO);
		return $this->db->count_all_results();
	}
}

/* 

End of file :- 

location :- application/models/banner_model.php

*/
?>