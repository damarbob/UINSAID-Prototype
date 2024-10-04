<?php

namespace App\Controllers;

use App\Controllers\BaseControllerAdmin;

class Refactoring extends BaseControllerAdmin
{

    public function fillBeritaFeaturedImageWithFirstImageFromKontenField()
    {
        $beritaModel = $this->beritaModel;

        $berita = $beritaModel->where('featured_image IS NULL')->findAll();

        if (empty($berita)) {
            echo "No records found with NULL featured_image.";
            return;
        }

        foreach ($berita as $item) {
            $firstImage = $beritaModel->extract_first_image($item['konten'], base_url('assets/img/logo-notext.png'), false);
            if ($firstImage) {
                $sql = "UPDATE berita SET featured_image = '$firstImage' WHERE id = " . $item['id'];
                $beritaModel->db->query($sql);
            }
        }

        echo "Featured images updated successfully.";
    }

    public function combineAgendaModelAndPengumumanModelToAgendaPengumumanModel()
    {
        $agendaModel = $this->agendaModel;
        $pengumumanModel = $this->pengumumanModel;
        $agendaPengumumanModel = $this->agendaPengumumanModel;

        // Get all data from AgendaModel
        $agendaData = $agendaModel->findAll();

        // Add type identifier to agenda data
        foreach ($agendaData as &$agenda) {
            $agenda['id_jenis'] = 3;
            $agenda['judul'] = $agenda['agenda'];
            $agenda['konten'] = $agenda['deskripsi'];
        }

        // Get all data from PengumumanModel
        $pengumumanData = $pengumumanModel->findAll();

        // Add type identifier to pengumuman data
        foreach ($pengumumanData as &$pengumuman) {
            $pengumuman['id_jenis'] = 4;
            $pengumuman['judul'] = $pengumuman['pengumuman'];
            $pengumuman['konten'] = $pengumuman['deskripsi'];
        }

        // Merge both datasets
        $mergedData = array_merge($agendaData, $pengumumanData);

        // Sort the merged data by created_at
        usort($mergedData, function ($a, $b) {
            return strtotime($a['created_at']) <=> strtotime($b['created_at']);
        });

        // Insert into AgendaPengumumanModel
        foreach ($mergedData as $data) {
            $newData = [
                'id_jenis'      => $data['id_jenis'],
                'id_galeri'     => $data['id_galeri'],
                'judul'         => $data['judul'],
                'konten'        => $data['konten'],
                'waktu_mulai'   => $data['waktu_mulai'],
                'waktu_selesai' => $data['waktu_selesai'],
                'status'        => $data['status'],
            ];

            if (!$agendaPengumumanModel->insert($newData)) {
                return json_encode(['status' => 'error', 'message' => 'Failed to insert data']);
            }
        }

        return json_encode(['status' => 'success', 'message' => 'Data migrated successfully']);
    }

    public function copyBeritaOrPPIDByItsJenisIdToPosting($jenisNama)
    {
        $postingModel = $this->postingModel;
        $postingDiajukanModel = $this->postingDiajukanModel;

        if ($jenisNama == 'berita') {
            $beritaModel = $this->beritaModel;
            $beritaDiajukanModel = $this->beritaDiajukanModel;

            // Ambil semua berita 
            $beritaData = $beritaModel->getBeritaAll(jenisNama: $jenisNama);
            // d($beritaData);

            foreach ($beritaData as $x) {
                $postingData = [
                    // 'id'                => $x['id'],
                    'id_penulis'        => auth()->id(),
                    'id_kategori'       => $x['id_kategori'],
                    'id_jenis'          => $x['id_posting_jenis'],
                    'judul'             => $x['judul'],
                    'konten'            => $x['konten'],
                    'ringkasan'         => $x['ringkasan'],
                    'gambar_sampul'     => $x['featured_image'] ?: $x['gambar_sampul'],
                    'pengajuan'         => $x['pengajuan'],
                    'slug'              => $x['slug'],
                    'status'            => $x['status'],
                    'seo'               => $x['search_engine_index'] == 'Y' ? 1 : 0,
                    'sumber'            => $x['sumber'] ?: 'https://uinsaid.ac.id',
                    'tanggal_terbit'    => $x['tgl_terbit'],
                    'created_at'        => $x['created_at'],
                    'updated_at'        => $x['updated_at'],
                ];

                // $postingModel->save($postingData);

                // if ($postingModel->getInsertID() != 0 || $postingModel->getInsertID() != null) {
                if ($postingModel->insert($postingData)) {
                    echo $jenisNama . ' with ID: ' . $postingData['id'] . nl2br(" saved successfully to posting \n");
                } else {
                    echo $jenisNama . ' with ID: ' . $postingData['id'] . nl2br(" failed \n");
                }
            }

            // Ambil semua berita diajukan
            $beritaData = $beritaDiajukanModel->getBeritaAll(jenisNama: $jenisNama);

            foreach ($beritaData as $x) {
                $postingData = [
                    // 'id'                => $x['id'],
                    'id_penulis'        => auth()->id(),
                    'id_kategori'       => $x['id_kategori'],
                    'id_jenis'          => $x['id_posting_jenis'],
                    'judul'             => $x['judul'],
                    'konten'            => $x['konten'],
                    'ringkasan'         => $x['ringkasan'],
                    'gambar_sampul'     => $x['featured_image'] ?: $x['gambar_sampul'],
                    'pengajuan'         => $x['pengajuan'],
                    'slug'              => $x['slug'],
                    'status'            => $x['status'],
                    'seo'               => $x['search_engine_index'] == 'Y' ? 1 : 0,
                    'sumber'            => $x['sumber'] ?: 'https://uinsaid.ac.id',
                    'tanggal_terbit'    => $x['tgl_terbit'],
                    'created_at'        => $x['created_at'],
                    'updated_at'        => $x['updated_at'],
                ];

                // $postingDiajukanModel->save($postingData);

                // if ($postingDiajukanModel->getInsertID() != 0 || $postingDiajukanModel->getInsertID() != null) {
                if ($postingDiajukanModel->insert($postingData)) {
                    echo $jenisNama . '_diajukan with ID: ' . $postingData['id'] . nl2br(" saved successfully to posting \n");
                } else {
                    echo $jenisNama . '_diajukan with ID: ' . $postingData['id'] . nl2br(" failed \n");
                }
            }
        } else if ($jenisNama == 'ppid') {
            $ppidModel = $this->ppidModel;

            // Ambil semua ppid
            $beritaData = $ppidModel->getPPIDAll();

            // dd($beritaData);
            foreach ($beritaData as $x) {
                $postingData = [
                    'id_penulis'        => auth()->id(),
                    'id_kategori'       => $x['id_kategori'],
                    'id_jenis'          => 2,
                    'judul'             => $x['judul'],
                    'konten'            => $x['konten'],
                    'ringkasan'         => $x['ringkasan'],
                    'gambar_sampul'     => $x['featured_image'],
                    'pengajuan'         => $x['pengajuan'],
                    'slug'              => $x['slug'],
                    'status'            => $x['status'],
                    'seo'               => $x['search_engine_index'] == 'Y' ? 1 : 0,
                    'sumber'            => $x['sumber'],
                    'tanggal_terbit'    => $x['tgl_terbit'],
                    'created_at'        => $x['created_at'],
                    'updated_at'        => $x['updated_at'],
                ];

                $postingModel->save($postingData);

                if ($postingModel->getInsertID() != 0 || $postingModel->getInsertID() != null) {
                    echo $jenisNama . ' with ID: ' . $x['id'] . nl2br(" saved successfully to posting \n");
                } else {
                    echo $jenisNama . ' with ID: ' . $x['id'] . nl2br(" failed \n");
                }
            }
        }
    }
}
