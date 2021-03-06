<?php
class M_crud extends CI_Model
{

    function insert($table, $data)
    {
        $this->db->insert($table, $data);
    }

    function read($table)
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function select($table, $field_condition, $field_id)
    {
        $query = $this->db->get_where($table, [$field_condition => $field_id]);
        return $query->row_array();
    }

    function update($table, $data, $field_condition, $field_id)
    {
        $this->db->where($field_condition, $field_id)
            ->update($table, $data);
    }

    function delete($table, $field_condition, $field_id)
    {
        $this->db->where($field_condition, $field_id)
            ->delete($table);
    }

    function left_join($table, $table2, $field_join)
    {
        $query = $this->db->select()
            ->from($table)
            ->join($table2, $field_join, 'LEFT')
            ->get();

        return $query->result_array();
    }

    function insert_bulk($table, $data)
    {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows() > 0;
    }
}
