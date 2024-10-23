<?php

namespace App\Libraries;

class FileCleanupService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); // Load the database connection
    }

    public function cleanUnusedFiles($folders)
    {
        $deletedFiles = [];

        foreach ($folders as $folder) {
            $directoryIterator = new \RecursiveDirectoryIterator($folder, \FilesystemIterator::SKIP_DOTS);
            $iterator = new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($iterator as $fileInfo) {
                if ($fileInfo->isFile()) {
                    $filePath = $fileInfo->getRealPath();
                    $relativePath = str_replace(FCPATH, '', $filePath);
                    // Ensure the relative path uses forward slashes
                    $relativePath = str_replace('\\', '/', $relativePath);

                    if (!$this->isFileInDatabase($relativePath)) {
                        unlink($filePath);
                        $deletedFiles[] = base_url($relativePath);
                    }
                }
            }
        }

        return $deletedFiles;
    }

    protected function isFileInDatabase($relativePath)
    {
        // Info
        // Absolute URL: posting, acara, galeri, file, entitas
        // Relative URL: media_sosial, halaman, komponen, komponen_meta, settings
        $tables = ['posting', 'acara', 'galeri', 'file', 'entitas', 'media_sosial', 'komponen', 'komponen_meta', 'settings']; // Add your table names here
        // $tables = ['posting'];

        // First, check using the relative path
        $found = $this->checkFileInTables($relativePath, $tables);

        if ($found) {
            return true; // File found using relative path
        }

        // If not found, retry with the absolute URL
        $absolutePath = base_url($relativePath);

        return $this->checkFileInTables($absolutePath, $tables);
    }

    protected function checkFileInTables($filePath, $tables)
    {
        foreach ($tables as $table) {
            // Get the column names for the current table
            $fields = $this->db->getFieldNames($table);

            // Loop through each column and check if the file path exists
            foreach ($fields as $field) {
                $query = $this->db->table($table)
                    ->like($field, $filePath)
                    ->countAllResults();

                if ($query > 0) {
                    return true; // File found in the database
                }
            }
        }

        return false; // File not found in any table or column
    }
}
