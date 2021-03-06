<?php
class Overall_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_overall($code, $name)
	{
		$this->db->select('module_id, setting, store_order');
		$this->db->where('code', $code);
		$this->db->where('name', $name);
		$this->db->from($this->db->dbprefix('module'));
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$row=$query->row_array();
			$row['setting']=unserialize($row['setting']);
			return $row;
		}
		return FALSE;
	}
	
	public function add($setting, $code, $name)
	{	
		$data['setting']=serialize($setting['description']);
		$data['code']=$code;
		$data['name']=$name;
		if(isset($setting['module_id'])){
			$data['module_id']=$setting['module_id'];
		}
		
		
		if(isset($data['module_id'])){
			$this->db->where('module_id', $data['module_id']);
			$this->db->update($this->db->dbprefix('module'), $data);
		}else{
			$this->db->insert($this->db->dbprefix('module'), $data);
		}
	}
}