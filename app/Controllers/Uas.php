<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUAS;

class Uas extends BaseController
{
    public function index()
    {
        return view('index');
    }

    function simpanData()
    {
        $model = new ModelUAS();
        $data = $this->request->getPost();
        $model->saveDatas($data);
        return json_encode(['success' => $data]);
    }
}
