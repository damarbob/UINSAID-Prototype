<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class FileManager extends BaseControllerAdmin
{
    private $baseDir;

    public function __construct()
    {
        $this->baseDir = ROOTPATH . ''; // Define the base directory for file management
        // // Decode the received path to interpret slashes correctly
        // $path = urldecode('index.php');
        // d($path);

        // // Ensure $path starts from baseDir
        // $relativePath = realpath($this->baseDir . '/' . $path);
        // // d(FCPATH);
        // // d(realpath($this->baseDir . '/' . 'preload.php'));
        // d($relativePath);
        // d($this->baseDir);
        // d(strpos($relativePath, $this->baseDir));
        // dd(!$relativePath || strpos($relativePath, $this->baseDir) !== 0);
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.penjelajahFile');
        $this->data['baseDir'] = $this->baseDir;
        return view('admin_file_manager', $this->data);
    }

    private function validateDirectory(string $directory, string $baseDir): bool
    {
        // Ensure both paths have no trailing slashes
        $normalizedBaseDir = rtrim($baseDir, '/\\');
        $normalizedRelativePath = rtrim($directory, '/\\');

        // Check if the path is within the base directory
        if (!$normalizedRelativePath || strpos($normalizedRelativePath, $normalizedBaseDir) !== 0) {
            return false;
        }

        return true;
    }

    public function listFiles($path = '')
    {
        // Decode the received path to interpret slashes correctly
        $path = urldecode(base64_decode($path));

        // Ensure $path starts from baseDir
        $relativePath = realpath($this->baseDir . '/' . $path);

        if (!$this->validateDirectory($relativePath, $this->baseDir)) {
            return $this->response->setJSON(['error' => 'Invalid directory']);
        }

        $files = array_diff(scandir($relativePath), ['.', '..']);
        $fileList = [];
        foreach ($files as $file) {
            $fullPath = $relativePath . '/' . $file;

            // Retrieve and format the permissions
            $permissions = substr(sprintf('%o', fileperms($fullPath)), -4);

            $fileList[] = [
                'name' => $file,
                'path' => ltrim($path . '/' . $file, '/'), // Preserve nested paths
                'size' => is_dir($fullPath) ? '-' : $this->formatSize(filesize($fullPath)),
                'modified_date' => date("Y-m-d H:i:s", filemtime($fullPath)),
                'is_dir' => is_dir($fullPath),
                'permissions' => $permissions // Add permissions to each file
            ];
        }

        return $this->response->setJSON($fileList);
    }


    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }


    public function upload()
    {
        $path = $this->request->getPost('path');
        $destination = realpath($this->baseDir . '/' . $path);

        if (!$this->validateDirectory($destination, $this->baseDir)) {
            return $this->response->setJSON(['error' => 'Invalid destination directory']);
        }

        $file = $this->request->getFile('file');
        if ($file->isValid() && !$file->hasMoved()) {
            $file->move($destination);
            return $this->response->setJSON(['status' => 'File uploaded']);
        } else {
            return $this->response->setJSON(['error' => 'File upload failed']);
        }
    }

    // Modified validateDirectory to allow folders in base directory
    private function validateDirectory2(string $directory, string $baseDir): bool
    {
        $normalizedBaseDir = rtrim($baseDir, '/\\');
        $normalizedDirectory = rtrim($directory, '/\\');

        // Check if directory is the same as or within the base directory
        return $normalizedDirectory === $normalizedBaseDir || strpos($normalizedDirectory, $normalizedBaseDir) === 0;
    }

    public function compress()
    {
        $data = $this->request->getJSON(true);
        $selectedFiles = $data['files'];
        $currentPath = realpath($this->baseDir . '/' . $data['path']);

        // d($selectedFiles[0]);
        // dd($currentPath);

        // Determine archive name based on selection
        if (count($selectedFiles) === 1) {
            $archiveName = basename($selectedFiles[0]) . '.zip';
        } else {
            $archiveName = basename($currentPath) . '.zip';
        }
        $zipFilePath = $currentPath . '/' . $this->getUniqueArchiveName($archiveName, $currentPath);

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            // dd('A');
            return $this->response->setJSON(['error' => 'Could not create zip file.']);
        }

        foreach ($selectedFiles as $file) {
            $filePath = realpath($this->baseDir . '/' . $file);
            // dd($this->validateDirectory2($filePath, $this->baseDir));
            if ($this->validateDirectory2($filePath, $this->baseDir)) {
                $this->addToZipWithoutTopLevel($zip, $filePath, $file);
            }
        }

        $zip->close();
        return $this->response->setJSON(['status' => 'Files compressed', 'archive' => basename($zipFilePath)]);
    }

    // Recursive function to add folder contents without including the top-level folder in the archive
    private function addToZipWithoutTopLevel($zip, $filePath, $originalSelectedPath)
    {
        // d('Proceeding addToZipWithoutTopLevel()');
        if (is_dir($filePath)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($filePath, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            // Calculate the relative path length for folder contents
            $cutoffPathLength = strlen(dirname($filePath)) + 1;
            // d($cutoffPathLength);

            foreach ($files as $file) {
                $relativePath = substr($file->getRealPath(), $cutoffPathLength);
                // d($relativePath);

                if ($file->isDir()) {
                    $zip->addEmptyDir($relativePath);
                } else {
                    $zip->addFile($file->getRealPath(), $relativePath);
                }
            }
        } else {
            // Single file addition without folder structure
            $relativePath = basename($filePath);
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Helper function to avoid archive name conflicts
    private function getUniqueArchiveName($archiveName, $currentPath)
    {
        $counter = 1;
        $zipName = $archiveName;
        $pathInfo = pathinfo($zipName);
        $baseName = $pathInfo['filename'];

        while (file_exists($currentPath . '/' . $zipName)) {
            $zipName = $baseName . '_' . $counter++ . '.zip';
        }

        return $zipName;
    }

    public function extract()
    {
        $data = $this->request->getJSON(true);
        $archive = realpath($this->baseDir . '/' . $data['path']);

        if (!$archive || !file_exists($archive) || pathinfo($archive, PATHINFO_EXTENSION) !== 'zip') {
            return $this->response->setJSON(['error' => 'Invalid zip file path']);
        }

        $zip = new ZipArchive();
        if ($zip->open($archive) === TRUE) {
            $zip->extractTo(dirname($archive));
            $zip->close();
            return $this->response->setJSON(['status' => 'Archive extracted']);
        } else {
            return $this->response->setJSON(['error' => 'Could not open archive']);
        }
    }

    public function bulkAction()
    {
        $action = $this->request->getPost('action');
        $files = $this->request->getPost('files');
        $destination = $this->request->getPost('destination');

        foreach ($files as $file) {
            $filePath = realpath($this->baseDir . '/' . $file);

            if (!$this->validateDirectory($filePath, $this->baseDir)) {
                return $this->response->setJSON(['error' => 'Invalid file path']);
            }

            switch ($action) {
                case 'copy':
                    $destPath = $this->baseDir . '/' . $destination . '/' . basename($filePath);
                    copy($filePath, $destPath);
                    break;
                case 'move':
                    $destPath = $this->baseDir . '/' . $destination . '/' . basename($filePath);
                    rename($filePath, $destPath);
                    break;
                case 'delete':
                    if (is_dir($filePath)) {
                        rmdir($filePath);
                    } else {
                        unlink($filePath);
                    }
                    break;
                default:
                    return $this->response->setJSON(['error' => 'Invalid action']);
            }
        }

        return $this->response->setJSON(['status' => 'Bulk action completed']);
    }

    public function download($path)
    {
        $filePath = realpath($this->baseDir . '/' . base64_decode($path));
        if (!$this->validateDirectory($filePath, $this->baseDir) || !is_file($filePath)) {
            return $this->response->setJSON(['error' => 'Invalid file path']);
        }
        return $this->response->download($filePath, null);
    }

    public function viewFile($encodedPath = '')
    {
        $path = base64_decode($encodedPath); // Decode the Base64 path
        $fullPath = realpath($this->baseDir . '/' . $path);

        if (!$this->validateDirectory($fullPath, $this->baseDir) || !file_exists($fullPath)) {
            return $this->response->setStatusCode(404, 'File not found');
        }

        // Serve the file content with correct headers
        $mimeType = mime_content_type($fullPath);
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setBody(file_get_contents($fullPath));
    }

    public function setClipboard()
    {
        $request = $this->request->getJSON(true);
        $files = $request['files'] ?? [];
        $action = $request['action'] ?? '';

        if (!in_array($action, ['copy', 'move']) || empty($files)) {
            return $this->response->setJSON(['error' => 'Invalid clipboard action or no files selected']);
        }

        // Save files and action in session
        session()->set('clipboard', [
            'files' => $files,
            'action' => $action
        ]);

        return $this->response->setJSON(['status' => 'Clipboard set successfully']);
    }

    // Recursive function to copy directories
    private function recursiveCopy($source, $destination)
    {
        $dir = opendir($source);
        mkdir($destination);

        while (($file = readdir($dir)) !== false) {
            if ($file === '.' || $file === '..') continue;
            $srcPath = $source . '/' . $file;
            $destPath = $destination . '/' . $file;

            if (is_dir($srcPath)) {
                $this->recursiveCopy($srcPath, $destPath);
            } else {
                copy($srcPath, $destPath);
            }
        }
        closedir($dir);
    }

    // Recursive function to move directories
    private function recursiveMove($source, $destination)
    {
        if (rename($source, $destination)) return; // Fast path if rename works
        mkdir($destination);

        $dir = opendir($source);
        while (($file = readdir($dir)) !== false) {
            if ($file === '.' || $file === '..') continue;
            $srcPath = $source . '/' . $file;
            $destPath = $destination . '/' . $file;

            if (is_dir($srcPath)) {
                $this->recursiveMove($srcPath, $destPath);
            } else {
                rename($srcPath, $destPath);
            }
        }
        closedir($dir);
        rmdir($source); // Remove the source directory after moving
    }

    public function paste()
    {
        $destination = $this->request->getJSON(true)['destination'] ?? '';
        $clipboard = session()->get('clipboard');

        if (!is_array($clipboard) || !isset($clipboard['files']) || !is_array($clipboard['files'])) {
            return $this->response->setJSON(['error' => 'Clipboard is empty or invalid format']);
        }

        $destinationPath = realpath($this->baseDir . '/' . $destination);
        if (!$destinationPath || !is_dir($destinationPath)) {
            return $this->response->setJSON(['error' => 'Invalid destination path']);
        }

        foreach ($clipboard['files'] as $file) {
            $sourcePath = realpath($this->baseDir . '/' . $file);
            if (!$sourcePath || !file_exists($sourcePath)) {
                return $this->response->setJSON(['error' => "Source file {$file} not found"]);
            }

            $targetPath = $destinationPath . '/' . basename($file);

            // Generate unique filename if file or directory already exists
            if (file_exists($targetPath)) {
                $pathInfo = pathinfo($targetPath);
                $baseName = $pathInfo['filename'];
                $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
                $counter = 1;

                do {
                    $newName = $baseName . " ($counter)" . $extension;
                    $targetPath = $destinationPath . '/' . $newName;
                    $counter++;
                } while (file_exists($targetPath));
            }

            // Check if it's a file or directory, then copy/move accordingly
            try {
                if ($clipboard['action'] === 'copy') {
                    if (is_dir($sourcePath)) {
                        $this->recursiveCopy($sourcePath, $targetPath);
                    } else {
                        if (!copy($sourcePath, $targetPath)) {
                            throw new \Exception("Failed to copy {$file}");
                        }
                    }
                } elseif ($clipboard['action'] === 'move') {
                    if (is_dir($sourcePath)) {
                        $this->recursiveMove($sourcePath, $targetPath);
                    } else {
                        if (!rename($sourcePath, $targetPath)) {
                            throw new \Exception("Failed to move {$file}");
                        }
                    }
                }
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => $e->getMessage()]);
            }
        }

        // Clear clipboard after pasting
        session()->remove('clipboard');
        return $this->response->setJSON(['status' => 'Paste completed']);
    }

    public function createFile()
    {
        $data = $this->request->getJSON(true);
        $path = realpath($this->baseDir . '/' . $data['path']);
        $fileName = basename($data['fileName']);
        $newFilePath = $path . '/' . $fileName;

        // Validate the current path and check if file already exists
        if (!$path || !is_dir($path)) {
            return $this->response->setJSON(['error' => 'Invalid directory']);
        }
        if (file_exists($newFilePath)) {
            return $this->response->setJSON(['error' => 'A file with that name already exists']);
        }

        // Attempt to create the file
        try {
            if (!touch($newFilePath)) {
                throw new \Exception('Failed to create file');
            }
            return $this->response->setJSON(['status' => 'File created successfully']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function createFolder()
    {
        $data = $this->request->getJSON(true);
        $path = realpath($this->baseDir . '/' . $data['path']);
        $folderName = basename($data['folderName']);
        $newFolderPath = $path . '/' . $folderName;

        // Validate the current path and check if folder already exists
        if (!$path || !is_dir($path)) {
            return $this->response->setJSON(['error' => 'Invalid directory']);
        }
        if (file_exists($newFolderPath)) {
            return $this->response->setJSON(['error' => 'A folder with that name already exists']);
        }

        // Attempt to create the folder
        try {
            if (!mkdir($newFolderPath, 0755)) {
                throw new \Exception('Failed to create folder');
            }
            return $this->response->setJSON(['status' => 'Folder created successfully']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }


    public function rename()
    {
        $data = $this->request->getJSON(true);
        $oldPath = realpath($this->baseDir . '/' . $data['oldPath']);
        $newName = $data['newName'];
        $newPath = dirname($oldPath) . '/' . $newName;

        // Validate old file existence
        if (!$oldPath || !file_exists($oldPath)) {
            return $this->response->setJSON(['error' => 'Original file not found']);
        }

        // Check if the new name already exists in the directory
        if (file_exists($newPath)) {
            return $this->response->setJSON(['error' => 'A file with the new name already exists']);
        }

        // Attempt to rename
        try {
            if (!rename($oldPath, $newPath)) {
                throw new \Exception('Failed to rename file');
            }
            return $this->response->setJSON(['status' => 'File renamed successfully']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function saveFile()
    {
        $data = json_decode($this->request->getBody(), true);
        $relativePath = $data['path'] ?? ''; // Fetch and decode path, defaulting to root
        $content = $data['content'] ?? '';

        // Construct the full path safely using the base directory
        $filePath = realpath($this->baseDir . '/' . ($relativePath ? base64_decode($relativePath) : ''));

        if (!$this->validateDirectory($filePath, $this->baseDir)) {
            return $this->response->setJSON(['error' => 'Invalid file path']);
        }

        // Attempt to save content
        if (file_put_contents($filePath, $content) !== false) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to save file.']);
        }
    }

    // Recursive function to delete non-empty directories
    private function recursiveDelete($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->recursiveDelete($path) : unlink($path);
        }
        return rmdir($dir);
    }

    public function deleteFiles()
    {
        $files = $this->request->getJSON(true)['files'] ?? [];

        if (empty($files)) {
            return $this->response->setJSON(['error' => 'No files selected for deletion']);
        }

        foreach ($files as $file) {
            $filePath = realpath($this->baseDir . '/' . $file);

            if (!$filePath || !file_exists($filePath)) {
                return $this->response->setJSON(['error' => "File {$file} not found"]);
            }

            if (is_file($filePath)) {
                unlink($filePath);
            } elseif (is_dir($filePath)) {
                $this->recursiveDelete($filePath); // Use recursive delete for non-empty directories
            }
        }

        return $this->response->setJSON(['status' => 'Files deleted successfully']);
    }

    public function settings()
    {
        // Fetch or save file manager settings here
    }
}
