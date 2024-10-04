<?php

namespace App\Models;

class EntitasGrupModel extends \CodeIgniter\Model
{
    protected $table = 'entitas_grup';

    protected $useTimestamps = true;

    protected $allowedFields = ['nama', 'parent_id'];
}
