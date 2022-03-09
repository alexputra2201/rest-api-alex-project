<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Prodi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prodi_model', 'prd');
        $this->methods['index_get']['limit'] = 100;
        $this->methods['index_post']['limit'] = 100;
        $this->methods['index_put']['limit'] = 100;
        $this->methods['index_delete']['limit'] = 5100;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $Prodi = $this->prd->get();
        } else {
            $Prodi = $this->prd->get($id);
        }
        if ($Prodi) {
            $this->response([
                'status' => true,
                'data' => $Prodi
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
            if ($this->prd->delete($id) > 0) {
                $this->response([
                    'status' => True,
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
            'ruangan' => $this->input->post('ruangan'),
            'jurusan' => $this->input->post('jurusan'),
            'akreditasi' => $this->input->post('akreditasi'),
            'nama_kaprodi' => $this->input->post('nama_kaprodi'),
            'tahun_berdiri' => $this->input->post('tahun_berdiri'),
            'output_lulusan' => $this->input->post('output_lulusan'),
        ];
        if ($this->prd->insert($data) > 0) {
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
            'ruangan' => $this->put('ruangan'),
            'jurusan' => $this->put('jurusan'),
            'akreditasi' => $this->put('akreditasi'),
            'nama_kaprodi' => $this->put('nama_kaprodi'),
            'tahun_berdiri' => $this->put('tahun_berdiri'),
            'output_lulusan' => $this->put('output_lulusan'),
        ];
        if ($this->prd->update($data, $id) > 0) {
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
