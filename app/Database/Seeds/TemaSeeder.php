<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TemaSeeder extends Seeder
{
    public function run()
    {
        // Prepare the data to be inserted
        $data = [
            [
                'nama'       => 'UINSAID Hijau',
                'css'        => 'assets/css/c.css',
                'created_at' => date('Y-m-d H:i:s'), // current timestamp
                'updated_at' => date('Y-m-d H:i:s'), // current timestamp
            ],
            [
                'nama'       => 'Kuning',
                'css'        => 'assets/css/c.css',
                'created_at' => date('Y-m-d H:i:s'), // current timestamp
                'updated_at' => date('Y-m-d H:i:s'), // current timestamp
            ]
        ];

        // Use the query builder to insert data
        $this->db->table('tema')->insertBatch($data);
    }
}
