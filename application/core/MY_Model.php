<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function raw($sql,$result = 'array'){
        $query = $this->db->query($sql);
        switch ($result) {
            case 'array':
                return $query->result_array();
            break;
            case 'obj':
                return $query->result();
            break;
            case 'row':
            return $query->row();
                break;
            case 'count':
                return $query->num_rows();
            break;
            default:
                return $query->result_array();
            break;
        }
    }

    public function getRows($table,$options = array(),$result = 'array'){
        (!empty($options['select']))        ? $this->db->select($options['select']) : $this->db->select("*");
        (!empty($options['where']))         ? $this->db->where($options['where']) : null;
        (!empty($options['or_where']))      ? $this->db->or_where($options['or_where']) : null;
        (!empty($options['where_not_in']))  ? $this->db->where_not_in($options['where_not_in']['col'],$options['where_not_in']['value']) : null;
        (!empty($options['where_in']))      ? $this->db->where_in($options['where_in']['col'],$options['where_in']['value']) : null;
        if(!empty($options['join'])){
            foreach($options['join'] as $key => $value){
                if(strpos($value,':') !== false){
                    $_join = explode(":",$value);
                    $this->db->join($key,$_join[0],$_join[1]);
                } else {
                    $this->db->join($key,$value);
                }
            }
        }
        if(!empty($options['customjoin'])) {
            $this->db->join($options['customjoin']['table'],$options['customjoin']['value'],$options['customjoin']['pos']);
        }
        if(!empty($options['search_like'])){
            $this->db->group_start();
            foreach($options['column_order'] as $key => $value){
                $this->db->or_like($value, $options['search_like'], 'both');
            }
            $this->db->group_end();
        }
        (!empty($options['group'])) ? $this->db->group_by($options['group']) : null;
        (!empty($options['limit'])) ? $this->db->limit($options['limit'][0],$options['limit'][1]) : null;
        (!empty($options['order'])) ? $this->db->order_by($options['order']) : null;
        $query = $this->db->get($table);
        switch ($result) {
            case 'array':
                return $query->result_array();
            break;
            case 'obj':
                return $query->result();
            break;
            case 'row':
                return $query->row();
                break;
            case 'count':
                return $query->num_rows();
            break;
            default:
                return $query->result_array();
            break;
        }
    }

    public function insert($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    public function batch_insert($table,$set){
        $this->db->batch_insert($table,$set);
        return true;
     }

    public function update($table,$set,$where = []){
        $this->db->where($where);
        $this->db->update($table,$set);
        return true;
    }

    public function delete($table,$where = []){
        $this->db->where($where);
        $this->db->delete($table);
        return true;
    }

}
