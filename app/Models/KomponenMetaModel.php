<?php

namespace App\Models;

class KomponenMetaModel extends \CodeIgniter\Model
{
    protected $table = 'komponen_meta';
    protected $useTimestamps = true;
    protected $allowedFields = ['halaman_id', 'komponen_id', 'meta'];
}
