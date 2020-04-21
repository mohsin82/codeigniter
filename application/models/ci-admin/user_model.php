<?php

/* 

location :- application/models/user_model.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	private function _get_datatables_query() {
		
		$column_search = array('u.username','u.email','u.phone_no','ug.name'); 
		$order = array('u.user_id' => 'desc');
		
		$this->db->select('u.user_id,u.username,u.email,u.phone_no,ug.name as group_name,u.status');
		$this->db->from('users u');
		$this->db->where('u.delete_status',NO);
		$this->db->where_in('ug.role',array(ROLE_SUB_ADMIN,ROLE_USER));
		$this->db->join('user_groups ug', 'ug.group_id = u.group_id');
		
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
			
			if($_POST['order']['0']['column'] == '3') {

				$this->db->order_by('u.username', $_POST['order']['0']['dir']);

			} else if($_POST['order']['0']['column'] == '4') {

				$this->db->order_by('u.email', $_POST['order']['0']['dir']);
			
			} else if($_POST['order']['0']['column'] == '5') {

				$this->db->order_by('u.phone_no', $_POST['order']['0']['dir']);
			
			} else if($_POST['order']['0']['column'] == '6') {

				$this->db->order_by('ug.name', $_POST['order']['0']['dir']);
			
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
		
		$this->db->select('u.user_id');
		$this->db->from('users u');
		$this->db->where('u.delete_status',NO);
		$this->db->where_in('ug.role',array(ROLE_SUB_ADMIN,ROLE_USER));
		$this->db->join('user_groups ug', 'ug.group_id = u.group_id');
		return $this->db->count_all_results();
	}
}

/* 

End of file :- 

location :- application/models/user_model.php

*/

?>