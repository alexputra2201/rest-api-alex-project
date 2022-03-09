<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Mahasiswa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mhs');
        $this->methods['index_get']['limit'] = 50;
        $this->methods['index_post']['limit'] = 20;
        $this->methods['index_put']['limit'] = 20;
        $this->methods['index_delete']['limit'] = 20;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $Mahasiswa = $this->mhs->get();
        } else {
            $Mahasiswa = $this->mhs->get($id);
        }
        if ($Mahasiswa) {
            $this->response([
                'status' => true,
                'data' => $Mahasiswa
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
            if ($this->mhs->delete($id) > 0) {
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
            'nim' => $this->input->post('nim'),
            'email' => $this->input->post('email'),
            'prodi' => $this->input->post('prodi'),
            'alamat' => $this->input->post('alamat'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'no_hp' => $this->input->post('no_hp'),
            'asal_sekolah' => $this->input->post('asal_sekolah'),
        ];
        if ($this->mhs->insert($data) > 0) {
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
                'nim' => $this->put('nim'),
                'email' => $this->put('email'),
                'prodi' => $this->put('prodi'),
                'alamat' => $this->put('alamat'),
                'jenis_kelamin' => $this->put('jenis_kelamin'),
                'no_hp' => $this->put('no_hp'),
                'asal_sekolah' => $this->put('asal_sekolah'),
            ];
        if ($this->mhs->update($data, $id) > 0) {
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
