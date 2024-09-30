<?php

namespace App\Models;

class TemaModel extends \CodeIgniter\Model
{
    protected $table = 'tema';

    protected $useTimestamps = true;

    protected $allowedFields = ['nama', 'css'];
}
