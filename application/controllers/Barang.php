<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Barang extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model', 'brg');
        $this->methods['index_get']['limit'] = 50;
        $this->methods['index_post']['limit'] = 20;
        $this->methods['index_put']['limit'] = 20;
        $this->methods['index_delete']['limit'] = 20;
    }
    public function index_get()
    {
        $id = $this->get('id_barang');
        if ($id == null) {
            $Barang = $this->brg->get();
        } else {
            $Barang = $this->brg->get($id);
        }
        if ($Barang) {
            $this->response([
                'status' => true,
                'data' => $Barang
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
        $id = $this->delete('id_barang');
        if ($id == null) {
            $this->response([
                'status' => false,
                'message' => 'Masukkan ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->brg->delete($id) > 0) {
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
            'merk' => $this->input->post('merk'),
            'stok' => $this->input->post('stok'),
            'harga' => $this->input->post('harga'),
            'description' => $this->input->post('description'),

        ];
        if ($this->brg->insert($data) > 0) {
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
        $id = $this->put('id_barang');
        $data = [
            'nama' => $this->put('nama'),
            'merk' => $this->put('merk'),
            'stok' => $this->put('stok'),
            'harga' => $this->put('harga'),
            'gambar' => $this->put('gambar'),
            'description' => $this->put('description'),
        ];
        if ($this->brg->update($data, $id) > 0) {
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