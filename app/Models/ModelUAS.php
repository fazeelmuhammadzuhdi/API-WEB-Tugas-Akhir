<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUAS extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rumah';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'type', 'harga', 'lokasi', 'foto'];

    function saveDatas($data)
    {
        $this->insert($data);
    }
}
