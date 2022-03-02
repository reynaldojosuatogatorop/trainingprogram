<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class DataModel extends CI_Model {
 
    var $table;
    var $column_order;
    var $column_search;
    var $order;
    var $where;
    var $value;
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function data($table, $column_order, $column_search, $order, $where = NULL, $value= NULL)
    {
        $this->table = $table;
        $this->column_order = $column_order;
        $this->column_search=$column_search;
        $this->order = $order;
        $this->where = $where;
        $this->value = $value;
    }
    
    private function _get_datatables_query()
    {
     
        
        if($this->where != NULL)
        {
            $this->db->where($this->where, $this->value);
        }

        $this->db->from($this->table);
        
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($Conditional="",$Sentence="")
    {
        $this->db->from($this->table);
        if ($Conditional!=""){
            $st= $Conditional ."='".$Sentence."'";
            $this->db->where($st);  
        }
    

        return $this->db->count_all_results();
    }
 
}