<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Jurusan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jurusan_model', 'jsn');
        $this->methods['index_get']['limit'] = 100;
        $this->methods['index_post']['limit'] = 100;
        $this->methods['index_put']['limit'] = 1005;
        $this->methods['index_delete']['limit'] = 1005;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $jurusan = $this->jsn->get();
        } else {
            $jurusan = $this->jsn->get($id);
        }
        if ($jurusan) {
            $this->response([
                'status' => true,
                'data' => $jurusan
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
            if ($this->jsn->delete($id) > 0) {
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
            'nama' => $this->post('nama'),
            'singkatan' => $this->post('singkatan'),
            'nama_kajur' => $this->post('nama_kajur'),
        ];
        if ($this->jsn->insert($data) > 0) {
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
            'singkatan' => $this->put('singkatan'),
            'nama_kajur' => $this->put('nama_kajur'),
        ];
        if ($this->jsn->update($data, $id) > 0) {
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
