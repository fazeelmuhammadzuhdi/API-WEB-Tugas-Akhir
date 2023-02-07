<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUAS;

class TableUas extends BaseController
{
    public function index()
    {
        $model = new ModelUAS();
        $data['data'] = $model->findAll();
        return view('table_uas', $data);
    }
}
