<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class supplier extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model', 'sup');
        $this->methods['index_get']['limit'] = 100;
        $this->methods['index_post']['limit'] = 100;
        $this->methods['index_put']['limit'] = 1005;
        $this->methods['index_delete']['limit'] = 1005;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $supplier = $this->sup->get();
        } else {
            $supplier = $this->sup->get($id);
        }
        if ($supplier) {
            $this->response([
                'status' => true,
                'data' => $supplier
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Id Tidak Ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id == null) {
            $this->response([
                'status' => false,
                'message' => 'Masukkan ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->sup->delete($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'Data Berhasil Dihapus'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Id Tidak Ditemukan'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
    public function index_post()
    {
        $data = [
            'nama' => $this->input->post('nama'),
            'nama_barang' => $this->input->post('nama_barang'),
            'jumlah' => $this->input->post('jumlah'),
        ];
        if ($this->sup->insert($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data Berhasil diTambahkan'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Menambahkan Data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nama' => $this->put('nama'),
            'nama_barang' => $this->put('nama_barang'),
            'jumlah' => $this->put('jumlah'),
        ];
        if ($this->sup->update($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data Berhasil diubah'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Mengubah Data'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
