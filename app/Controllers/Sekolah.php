<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUAS;
use CodeIgniter\API\ResponseTrait;

class Sekolah extends BaseController
{
    use ResponseTrait;
    function __construct()
    {
        $this->model = new ModelUAS();
    }
    public function index()
    {
        $data = $this->model->orderBy('type', 'asc')->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->model->where('id', $id)->findAll();
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data Tidak Ditemukan untuk id $id");
        }
    }

    public function create()
    {
        $data = $this->request->getPost();
        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil memasukkan Data'
            ]
        ];
        return $this->respond($response);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $isExists = $this->model->where('id', $id)->findAll();
        if (!$isExists) {
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }

        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => "Data dengen id $id berhasil diupdate"
            ]
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $data = $this->model->where('id', $id)->findAll();
        if ($data) {
            $this->model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data berhasil dihapus'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
