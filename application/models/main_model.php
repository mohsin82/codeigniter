<?php

/* 

location :- application/models/main_model.php

*/

defined('BASEPATH') OR exit('No direct script access allowed');

/* this model is used in all side */
class Main_model extends CI_Model {
	
	/* insert data function */
	public function insert_data($insert,$tableName,$type) {

		/* for single insert and multiple insert both with its type */
		if($type == "single") {

			$this->db->insert($tableName, $insert);
			return $this->db->affected_rows() > 0 ? $this->db->insert_id() : false;

		} else if($type == "multiple") {

			$this->db->insert_batch($tableName, $insert);
			return $this->db->affected_rows() > 0 ? true : false;
		}
	}
	
	/* update data function */
	public function update_data($where,$update,$tableName) {

		$this->db->where($where);
		$this->db->update($tableName, $update);
		return $this->db->affected_rows() > 0 ? true : false;
	}
	
	/* update multiple data function */
	public function update_multiple_data($where_in_field,$where_in_val,$update,$tableName) {

		$this->db->where_in($where_in_field, $where_in_val);
		$this->db->update($tableName, $update);
		return $this->db->affected_rows() > 0 ? true : false;
	}

	/* update multiple data function */
	public function update_multiple_data_where($where,$where_in_field,$where_in_val,$update,$tableName) {

		$this->db->where($where);
		$this->db->where_in($where_in_field, $where_in_val);
		$this->db->update($tableName, $update);
		return $this->db->affected_rows() > 0 ? true : false;
	}
	
	/* delete data function */
	public function delete_data($where,$tableName) {
		
		$this->db->where($where);
		$this->db->delete($tableName);
		return $this->db->affected_rows() > 0 ? true : false;
	}
	
	/* fetch single row function */ 
	public function get_first_row($select,$where,$tableName) {

		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->first_row() : false;
	}

	/* fetch single row with where_in and join function */ 
	public function get_first_row_with_join($select,$where,$where_in_field,$where_in_val,$join_where,$tableNameJoin1,$tableNameJoin2,$join_type) {
	
		$this->db->select($select);
		$this->db->from($tableNameJoin1);
		$this->db->where($where);
		$this->db->where_in($where_in_field, $where_in_val);
		$this->db->join($tableNameJoin2, $join_where, $join_type);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->first_row() : false;
	}
	
	/* fetch all data with where condition function */ 
	public function get_result_where($select,$where,$tableName) {

		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	/* fetch all data with where and order desc condition function */ 
	public function get_result_with_order($select,$where,$order_field,$order_val,$tableName) {

		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		$this->db->order_by($order_field, $order_val);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	/* fetch all data with where and order desc and pagination parameter function */ 
	public function get_result_where_with_order_and_pagination($select,$where,$order_field,$order_val,$per_page,$start,$tableName) {

		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		$this->db->order_by($order_field, $order_val);
		$this->db->limit($per_page, $start);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}
}

/* 

End of file :- 

location :- application/models/main_model.php

*/

?>