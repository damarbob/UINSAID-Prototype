<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call other seeders if needed
        $this->call('TemaSeeder');
        $this->call('MenuSeeder');
    }
}
