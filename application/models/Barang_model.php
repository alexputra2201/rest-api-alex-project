<?php
class Barang_model extends CI_Model
{
    public $table = 'barang';
    public $id = 'barang.id_barang';
    public function get($id = null)
    {
        if ($id == null) {
            return $this->db->get($this->table)->result_array();
        } else {
            return $this->db->get_where($this->table, ['id_barang' => $id])->result_array();
        }
    }
    public function delete($id)
    {
        $this->db->delete($this->table, ['id_barang' => $id]);
        return $this->db->affected_rows();
    }
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }
    public function update($data, $id)
    {
        $this->db->update($this->table, $data, ['id_barang' => $id]);
        return $this->db->affected_rows();
    }
}
