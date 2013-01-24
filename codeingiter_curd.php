<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model {
	/*
	| CodeIgniter Simple CRUD (Create, Retrieve, Update, Delete) with No Table Relation
	| Version		: 0.3
	| Created By	: Vinsensus Angelo (2012)
	| Licence	   	: FREE (But NO GUARANTEE :P )
	| Requirement  	: 
	|	-> CodeIgniter v.2.x (especially CI v.2.1)
	|	-> Need AUTO LOAD CI Database library
	| 	-> insert, update => input data condition on array variable
	|	-> data type condition => must be valid
	|	-> Database : 1 ONLY
 	|
	| Tested:
	|	-> PHP 		: 5.3.1
	|	-> Database	: MySQL 5.1.4.1
	| 
	| Input on function :
	|	-> table name => related table
	|   -> condition (optional) => for WHERE clause
	|	-> $data (optional) => for INSERT / UPDATE clause
	|	-> to BYPASS optional parameter => SET NULL on caller script
	|
	| Result:
	| 	-> on error		=> FALSE
	|	-> on success	=> TRUE or ARRAY DATA (Stdclass object)
	|
	| Custom Query => using custom_query()
	|	-> for custom query you can set query like normal query, BUT you must include TYPE parameter (insert / select / update / delete)
	|
	| Update Logs:
	| v.0.3 => Add Operator OR to retrieve data and retrieve count function
	| v.0.2 => Add Operator LIKE to retrieve data and retrieve count function
	|
	*/
	
	private $tables_name = array();
	private $custom_query = array('insert','select','update','delete'); 
	
	public function __construct(){
		parent::__construct();
		$tables = $this->db->list_tables();
		foreach ($tables as $table){
			$this->tables_name[]=$table;
		} 
	}
	
	public function get_all_tables(){
		return $this->tables_name;
	}
	
	public function create_data($tbl_name = NULL, $data = array()){
		if((isset($tbl_name)) && (in_array($tbl_name, $this->tables_name)) && (count($data) > 0)){
			$this->db->insert($tbl_name, $data);
			if($this->db->affected_rows() > 0){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	public function retrieve_data($tbl_name = NULL, $condition = array(), $limit = NULL, $offset = NULL, $order = array(), $like = array(), $or=array()){
		if((isset($tbl_name)) && (in_array($tbl_name,$this->tables_name))){
			if(count($condition) > 0){
				// get specific record
				$this->db->where($condition);
			}
			else{
				// get all record
			}
			
			if((isset($or)) && (count($or) > 0)){
				foreach($or as $field => $fieldval){
					$this->db->or_where($field,$fieldval);
				}
			}
			
			if(isset($limit)){
				$limit = intval($limit);
				if(isset($offset)){
					$offset = intval($offset);
					$this->db->limit($limit,$offset);
				}
				else{
					$this->db->limit($limit);
				}
			}
			if((isset($order)) && (count($order) == 2)){
				$this->db->order_by($order[0],$order[1]);
			}
			
			if((isset($like)) && (count($like) > 0)){
				foreach($like as $field => $fieldval){
					$this->db->like($field,$fieldval);
				}
			}
			
			$sql = $this->db->get($tbl_name);
			
			if($sql->num_rows() > 0){			
				foreach($sql->result() as $row){
					$data[] = $row;
				}	
				$sql->free_result();
				return $data;
			} 
			else{
				$sql->free_result();
				return null;
			}
		}
		else{
			return false;
		}
	}
	
	public function update_data($tbl_name = NULL, $condition = array() , $data = array()){
		// Beware for update Unique field !!
		if((isset($tbl_name)) && (in_array($tbl_name,$this->tables_name)) && (count($data) > 0)){
			if((isset($condition)) && (is_array($condition)) && (count($condition) > 0)){
				// update specific record
				$this->db->where($condition);
			}
			else{
				// update all record
			}
			$this->db->update($tbl_name, $data);
			if($this->db->affected_rows() > 0){
				return true;
			}
			else{	
				// set true although no affected rows
				return true;
			}
		}
		else{
			return false;
		}
		
	}
	
	public function delete_data($tbl_name = NULL, $condition = array()){
		// Beware for delete record with foreign key !!
		if((isset($tbl_name)) && (in_array($tbl_name,$this->tables_name))){
			if((isset($condition)) && (is_array($condition)) && (count($condition) > 0)){
				// delete specific record
				$this->db->where($condition);
				$this->db->delete($tbl_name);
			}
			else{
				// delete all record (manual query because of Active record can delete only if there is a condition)
				$this->db->query("DELETE FROM $tbl_name");
			}
			
			if($this->db->affected_rows() > 0){
				return true;
			}
			else{
				return false;
			}	  	
		}
		else{
			return false;
		}
	}

	public function custom_query($qrystr = '', $type = '', $activerecord = NULL){
		if((isset($qrystr)) && (!empty($qrystr)) && (in_array($type,$this->custom_query))){
			$activerecord= (isset($activerecord))? $activerecord : 0;
			// $data = array();
			if($activerecord == 1){
				// using active record
				$sql = $this->db->query($qrystr);
				if($type == "select"){
					if($sql->num_rows() == 0){			
						return null;
					} 
					else if($sql->num_rows() > 0){			
						foreach($sql->result() as $row){
							$data[] = $row;
						}	
						$sql->free_result();
						return $data;
					} 
					else{
						$sql->free_result();
						return null;
					}
				}
				else{
					if($this->db->affected_rows() > 0){
						return true;
					}
					else{
						return false;
					}	
				}
			}
			else{
				// using normal query
				$sql = mysql_query($qrystr);
				if($type == "select"){
					if(mysql_num_rows($sql) == 0){
						return null;
					}
					else if(mysql_num_rows($sql) > 0){
						while($rowsql=mysql_fetch_object($sql)){
							$data[] = $rowsql;
						}
						mysql_free_result($sql);
						return $data;
					}
					else{
						mysql_free_result($sql);
						return false;
					}
				}
				else{
					if(mysql_affected_rows()){
						return true;
					}
					else{
						return false;
					}
				}
				
			}
		}
		else{
			return false;
		}
	}
	
	public function retrieve_aggregation($tbl_name = NULL, $type = '', $field = '', $condition = array()){
		$aggr_type=array('min','max','avg','sum');
		if((isset($tbl_name)) && (in_array($tbl_name,$this->tables_name)) && ($field != '') && (in_array($type,$aggr_type))){
			if(count($condition) > 0){
				// select from specific record
				$this->db->where($condition);
			}
			else{
				// select from all record
			}
			if($type == 'max'){
				$this->db->select_max($field);
			}
			if($type == 'min'){
				$this->db->select_min($field);
			}
			if($type == 'avg'){
				$this->db->select_avg($field);
			}
			if($type == 'sum'){
				$this->db->select_sum($field);
			}
			$sql = $this->db->get($tbl_name);
			if($sql->num_rows() > 0){			
				$data = $sql->row();
				$sql->free_result();
				return $data->$field;
			} 
			else{
				$sql->free_result();
				return null;
			}
		}
		else{
			return false;
		}
	}
	
	public function retrieve_count($tbl_name = NULL, $condition = array(), $like=array(), $or=array()){
		if((isset($tbl_name)) && (in_array($tbl_name,$this->tables_name))){
			if(count($condition) > 0){
				// select from specific record
				$this->db->where($condition);
			}
			else{
				// select from all record
			}
			
			if((isset($or)) && (count($or) > 0)){
				foreach($or as $field => $fieldval){
					$this->db->or_where($field,$fieldval);
				}
			}
			
			// LIKE parameters
			if((isset($like)) && (count($like) > 0)){
				foreach($like as $field => $fieldval){
					$this->db->like($field,$fieldval);
				}
			}
			
			
			$result = $this->db->count_all_results($tbl_name);
			return $result;
		}
		else{
			return false;
		}
	}
	
}