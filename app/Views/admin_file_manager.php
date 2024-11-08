<?php
helper('setting');

// Pengaturan personal
$context = 'user:' . user_id(); //  Context untuk pengguna

// Get the current request instance
$request = service('request');

// Get the URI string
$currentRoute = $request->uri->getPath();

// Tema default
$temaDefault = base_url("assets/css/hijau.css");
$temaRTLDefault = base_url("assets/css/hijau.rtl.css");
?>

<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/vscode-codicons@0.0.17/dist/codicon.min.css" rel="stylesheet">
<style>
    .loader {
        width: 1rem;
        height: 1rem;
        border: 3px solid var(--mdb-primary);
        border-bottom-color: transparent;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loader-body {
        animation: rotate 1s infinite;
        height: 50px;
        width: 50px;
    }

    .loader-body:before,
    .loader-body:after {
        border-radius: 50%;
        content: "";
        display: block;
        height: 20px;
        width: 20px;
    }

    .loader-body:before {
        animation: ball1 1s infinite;
        background-color: var(--mdb-secondary);
        box-shadow: 30px 0 0 var(--mdb-primary)0;
        margin-bottom: 10px;
    }

    .loader-body:after {
        animation: ball2 1s infinite;
        background-color: var(--mdb-primary);
        box-shadow: 30px 0 0 var(--mdb-body-bg);
    }

    @keyframes rotate {
        0% {
            transform: rotate(0deg) scale(0.8)
        }

        50% {
            transform: rotate(360deg) scale(1.2)
        }

        100% {
            transform: rotate(720deg) scale(0.8)
        }
    }

    @keyframes ball1 {
        0% {
            box-shadow: 30px 0 0 var(--mdb-primary);
        }

        50% {
            box-shadow: 0 0 0 var(--mdb-primary);
            margin-bottom: 0;
            transform: translate(15px, 15px);
        }

        100% {
            box-shadow: 30px 0 0 var(--mdb-primary);
            margin-bottom: 10px;
        }
    }

    @keyframes ball2 {
        0% {
            box-shadow: 30px 0 0 var(--mdb-body-bg);
        }

        50% {
            box-shadow: 0 0 0 var(--mdb-body-bg);
            margin-top: -20px;
            transform: translate(15px, 15px);
        }

        100% {
            box-shadow: 30px 0 0 var(--mdb-body-bg);
            margin-top: 0;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="loaderBody" class="d-none position-fixed d-flex justify-content-center align-items-center top-0 start-0" style="background-color: rgba(var(--mdb-body-bg-rgb), 0.5); width: 100vw; height: 100vh; z-index: 1000000000;">
    <span class="loader-body"></span>
    <span class="visually-hidden">Loading...</span>
</div>
<div class="sticky-top bg-body pb-3" style="top: calc(var(--header-height));">

    <div class="btn-toolbar" role="toolbar" aria-label="">

        <div class="btn-group me-2" role="group" aria-label="">

            <!-- Upload Button to Toggle Dropzone -->
            <button class="btn btn-primary" onclick="toggleDropzone()" data-mdb-ripple-init>
                <i class="fa-solid fa-upload me-2"></i>
                <?= lang('Admin.unggah') ?>
            </button>

            <!-- Upload Button to Toggle Dropzone -->
            <button class="btn btn-primary" onclick="refreshFileList()" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.segarkan') ?>">
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>

        </div>

        <div class="btn-group me-2" role="group" aria-label="">
            <button class="btn btn-secondary" onclick="createFile()" class="btn btn-secondary" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.buatFileBaru') ?>"><i class="fa-solid fa-file-circle-plus"></i></button>
            <button class="btn btn-secondary" onclick="createFolder()" class="btn btn-secondary" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.buatFolderBaru') ?>"><i class="fa-solid fa-folder-plus"></i></button>
        </div>
        <div class="btn-group me-2" role="group" aria-label="">
            <button class="btn btn-secondary" onclick="copySelectedFiles()" class="btn btn-secondary" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.salinTerpilih') ?>"><i class="fa-solid fa-copy"></i></button>
            <button class="btn btn-secondary" onclick="moveSelectedFiles()" class="btn btn-warning" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.pindahkanTerpilih') ?>"><i class="fa-solid fa-scissors"></i></button>
            <button class="btn btn-secondary" onclick="pasteFiles()" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.tempel') ?>"><i class="fa-solid fa-paste"></i></button>
        </div>
        <div class="btn-group me-2" role="group" aria-label="">
            <button class="btn btn-secondary" onclick="extractSelectedFiles()" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.ekstrakFileZIP') ?>"><i class="fa-solid fa-box-open"></i></button>
            <button class="btn btn-secondary" onclick="compressSelectedFiles()" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.kompresFileZIP') ?>"><i class="fa-solid fa-file-zipper"></i></button>
        </div>
        <div class="btn-group me-2" role="group" aria-label="">
            <button class="btn btn-danger" onclick="deleteSelectedFiles()" data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="bottom" title="<?= lang('Admin.hapusTerpilih') ?>"><i class="fa-solid fa-trash"></i></button>
        </div>

    </div>

    <!-- Dropzone Container, initially hidden -->
    <div id="dropzoneContainer" class="mt-3" style="display: none;">
        <form action="<?= base_url('admin/file-manager/upload') ?>" class="dropzone bg-body" id="fileDropzone" style="border-color: var(--mdb-primary); border-radius: var(--mdb-border-radius);"></form>
        <!-- Optional progress text for feedback -->
        <p id="uploadProgress" style="display: none;"><?= lang('Admin.mengunggahFile') ?></p>
    </div>

</div>

<!-- File Table -->
<div class="table-responsive">
    <table class="table table-hover table-sm align-middle">
        <thead>
            <tr>
                <th>
                    <!-- <input type="checkbox" id="selectAll" /> -->
                    <!-- Default checkbox -->
                    <div class="form-check pe-0">
                        <input id="selectAll" class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <!-- <label class="form-check-label" for="flexCheckDefault">Default checkbox</label> -->
                    </div>
                </th>
                <th><?= lang('Admin.nama') ?></th>
                <th><?= lang('Admin.ukuran') ?></th>
                <th><?= lang('Admin.perizinan') ?></th>
                <th><?= lang('Admin.terakhirDiubah') ?></th>
                <th><?= lang('Admin.aksi') ?></th>
            </tr>
        </thead>
        <tbody id="fileList">
            <!-- Dynamic File List here -->
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal modal-lg fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="viewModalLabel">
                        <?= lang('Admin.judul') ?>
                    </span>
                    <span id="loaderModal" class="loader ms-2 me-2 d-none"></span>
                </h5>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="viewModalKonten">
                    ...
                </div>
                <textarea id="fileEditor" class="form-control d-none" rows="10"></textarea>
                <div id="monaco" class="d-none" style="height: 512px;">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">
                    <i class="bi bi-chevron-left me-2"></i>
                    <?= lang('Admin.batal') ?>
                </button>

                <button type="button" id="saveButton" class="btn btn-primary" style="display: none;">
                    <i class="bi bi-save me-2"></i>
                    <?= lang('Admin.simpan') ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    let currentPath = ''; // Keep track of the current path
    let currentFile = ''; // Keep track of the current file

    // Store modal instance in a variable
    let viewModalInstance = null;

    const dropzoneContainer = document.getElementById('dropzoneContainer');
    const uploadProgress = document.getElementById('uploadProgress');
    let isToggledByButton = false;

    // Toggle Dropzone visibility on button click
    function toggleDropzone() {
        isToggledByButton = !isToggledByButton;
        dropzoneContainer.style.display = isToggledByButton ? 'block' : 'none';
    }

    // Show Dropzone when dragging files, but do not hide until upload finishes
    document.addEventListener('dragenter', (event) => {
        if (event.dataTransfer.types.includes('Files')) {
            dropzoneContainer.style.display = 'block';
        }
    });

    // Dropzone configuration with upload progress and visibility control
    Dropzone.options.fileDropzone = {
        init: function() {
            const dropzone = this;
            // Show upload progress
            this.on("addedfile", function() {
                uploadProgress.style.display = 'block';
            });
            // Track number of files in the upload queue
            this.on("queuecomplete", function() {
                uploadProgress.style.display = 'none';

                if (!isToggledByButton) {
                    dropzoneContainer.style.display = 'none';
                }

                // Show success notification after all files are uploaded
                // Show success toast 
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "<?= lang('Admin.fileBerhasilDiunggah') ?>",
                    showConfirmButton: false,
                    timer: 1500,
                });

                listFiles(currentPath); // Refresh the file list after uploading
            });
        },
        params: function(files, xhr, chunk) {
            // Append the path as a parameter
            return {
                path: currentPath
            };
        }
    };

    Dropzone.autoDiscover = false;
    const fileDropzone = new Dropzone("#fileDropzone", {
        maxFilesize: 2,
        success: function(file, response) {
            // alert("File uploaded successfully.");
            // listFiles();
        }
    });

    let clipboard = {
        files: [],
        action: ''
    };

    function downloadFile(path) {
        window.location.href = '<?= base_url('admin/file-manager/download') ?>/' + btoa(path);
    }

    function addToClipboard(path, action) {
        clipboard = {
            files: [path],
            action
        };

        console.log("Setting clipboard:", clipboard); // Debug log

        fetch('<?= base_url('admin/file-manager/setClipboard') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(clipboard)
            }).then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Show success toast 
                    Swal.fire({
                        icon: "success",
                        toast: true,
                        title: `${action.charAt(0).toUpperCase() + action.slice(1)}: <?= lang('Admin.berhasilDisalinSiapUntuk') ?>`,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } else {
                    // Show error toast 
                    Swal.fire({
                        icon: "error",
                        toast: true,
                        title: "<?= lang('Admin.gagalMenyalin') ?>: " + data.error,
                        confirmButtonText: "<?= lang('Admin.tutup') ?>"
                    });
                }
            })
            .catch(error => console.error("Error setting clipboard:", error));
    }

    function pasteFiles() {
        fetch('<?= base_url('admin/file-manager/paste') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    destination: currentPath
                }) // Set the destination path
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Show success toast 
                    Swal.fire({
                        icon: "success",
                        toast: true,
                        title: `<?= lang('Admin.berhasilDitempel') ?>`,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    listFiles(currentPath); // Refresh the file list
                } else if (data.error) {
                    // Show error toast 
                    Swal.fire({
                        icon: "error",
                        toast: true,
                        title: "<?= lang('Admin.gagalDitempel') ?>: " + data.error,
                        confirmButtonText: "<?= lang('Admin.tutup') ?>"
                    });
                }
            })
            .catch(error => console.error("Error pasting files:", error));
    }

    document.addEventListener('DOMContentLoaded', function() {

        listFiles();

        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.file-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        // Delegate click events to dynamically created buttons within #fileList
        // refreshActionButtonListener();

    });

    function refreshActionButtonListener() {
        document.getElementById('fileList').addEventListener('click', function(event) {
            if (event.target.tagName === 'BUTTON') {
                const action = event.target.getAttribute('data-action');
                const path = event.target.getAttribute('data-path');

                if (action === 'open') {
                    listFiles(path);
                } else if (action === 'view') {
                    viewFile(path);
                } else if (action === 'download') {
                    downloadFile(path);
                } else if (action === 'copy') {
                    addToClipboard(path, 'copy');
                } else if (action === 'move') {
                    addToClipboard(path, 'move');
                } else if (action === 'back') {
                    listFiles(path); // Navigate up one level
                } else if (action === 'rename') {
                    renameFile(path);
                }
            }
        });
    }

    function viewFile(path) {
        // Check if the modal instance already exists
        if (!viewModalInstance) {
            viewModalInstance = new mdb.Modal(document.getElementById('viewModal'));
        }

        if (!document.getElementById('monaco').classList.contains("d-none")) {
            document.getElementById('monaco').classList.add('d-none');
        }

        document.getElementById('saveButton').onclick = function() {
            saveFile(path);
        }

        const fileName = path.split('/').pop(); // Get file extension
        const fileExtension = path.split('.').pop().toLowerCase(); // Get file extension
        const imageUrl = '<?= base_url('admin/file-manager/viewFile') ?>/' + btoa(path);

        // UI
        const viewModalKonten = document.getElementById('viewModalKonten');
        document.getElementById('viewModalLabel').innerHTML = fileName;

        if (viewModalKonten.classList.contains("d-none")) {
            viewModalKonten.classList.remove('d-none');
        }

        // Define HTML content based on file extension
        let contentHTML = '';
        let isEditable = false;

        if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'ico'].includes(fileExtension)) {
            // Display image files
            contentHTML = `<img src="${imageUrl}" class="w-100" alt="Image Preview">`;
        } else if (['mp4', 'webm', 'ogg'].includes(fileExtension)) {
            // Display video files
            contentHTML = `<video src="${imageUrl}" class="w-100" controls></video>`;
        } else if (['mp3', 'wav', 'ogg'].includes(fileExtension)) {
            // Display audio files
            contentHTML = `<audio src="${imageUrl}" class="w-100" controls></audio>`;
        } else if (['txt', 'log', 'md', 'json', 'php', 'js', 'css', 'ts', 'tsx', 'html', 'htm',
                'xml', 'yml', 'yaml', 'ini', 'conf', 'bat', 'sh', 'c', 'cpp', 'h', 'hpp',
                'py', 'rb', 'java', 'cs', 'swift', 'rs', 'go', 'pl', 'ps1', 'svelte',
                'scss', 'sass', 'less', 'sql', 'r', 'dockerfile', 'env'
            ]
            .includes(fileExtension)) {
            // Display text files in editable mode
            fetch(imageUrl)
                .then(response => response.text())
                .then(text => {
                    document.getElementById('fileEditor').value = `${text}`;
                    isEditable = true;

                    // Retrieve the editor instance by container ID (e.g., "monaco")
                    const editor = window.editor;
                    const monaco = window.monaco;
                    editor.getModel().setValue(`${text}`);

                    if (document.getElementById('monaco').classList.contains("d-none")) {
                        document.getElementById('monaco').classList.remove('d-none');
                    }
                    if (!viewModalKonten.classList.contains("d-none")) {
                        viewModalKonten.classList.add('d-none');
                    }

                    document.getElementById('saveButton').style.display = 'block'; // Show Save button
                    viewModalInstance.show();

                    let language = 'plaintext';

                    switch (fileExtension) {
                        case "json":
                            language = 'json';
                            break;
                        case "htm":
                        case "html":
                            language = 'html';
                            break;
                        case "php":
                            language = 'php';
                            break;
                        case "js":
                            language = 'javascript';
                            break;
                        case "css":
                            language = 'css';
                            break;
                        case "ts":
                        case "tsx":
                            language = 'typescript';
                            break;
                        case "xml":
                            language = 'xml';
                            break;
                        case "yml":
                        case "yaml":
                            language = 'yaml';
                            break;
                        case "ini":
                        case "conf":
                            language = 'ini';
                            break;
                        case "bat":
                            language = 'bat';
                            break;
                        case "sh":
                            language = 'shell';
                            break;
                        case "c":
                        case "h":
                            language = 'c';
                            break;
                        case "cpp":
                        case "hpp":
                            language = 'cpp';
                            break;
                        case "py":
                            language = 'python';
                            break;
                        case "rb":
                            language = 'ruby';
                            break;
                        case "java":
                            language = 'java';
                            break;
                        case "cs":
                            language = 'csharp';
                            break;
                        case "swift":
                            language = 'swift';
                            break;
                        case "rs":
                            language = 'rust';
                            break;
                        case "go":
                            language = 'go';
                            break;
                        case "pl":
                            language = 'perl';
                            break;
                        case "ps1":
                            language = 'powershell';
                            break;
                        case "scss":
                        case "sass":
                            language = 'scss';
                            break;
                        case "less":
                            language = 'less';
                            break;
                        case "sql":
                            language = 'sql';
                            break;
                        case "r":
                            language = 'r';
                            break;
                        case "md":
                            language = 'markdown';
                            break;
                        case "dockerfile":
                            language = 'dockerfile';
                            break;
                        default:
                            language = 'plaintext';
                            break;
                    }

                    // Assuming `editor` is your Monaco Editor instance
                    monaco.editor.setModelLanguage(editor.getModel(), language);

                });
            return;
        } else {
            // Other file types, provide a download option
            contentHTML = `<p><?= lang('Admin.pratinjauTidakTersediaUntukFile') ?></p>
            <a href="${imageUrl}" class="btn btn-primary" download><?= lang('Admin.unduhFile') ?></a>`;
        }

        // Insert content and display modal
        document.getElementById('viewModalKonten').innerHTML = contentHTML;
        document.getElementById('saveButton').style.display = isEditable ? 'block' : 'none'; // Show or hide Save button
        viewModalInstance.show();
    }

    function refreshFileList() {
        listFiles(currentPath);
    }

    function listFiles(path = '') {
        currentPath = path; // Update the current path

        /* UI */
        if (document.getElementById('loaderBody').classList.contains("d-none")) {
            document.getElementById('loaderBody').classList.remove('d-none');
        }
        /* End of UI */

        fetch('<?= base_url('admin/file-manager/listFiles/') ?>' + btoa(path))
            .then(response => response.json())
            .then(data => {

                /* UI */
                if (!document.getElementById('loaderBody').classList.contains("d-none")) {
                    document.getElementById('loaderBody').classList.add('d-none');
                }
                /* End of UI */

                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Sort folders first
                data.sort((a, b) => b.is_dir - a.is_dir);

                // Generate file table with a back button
                let table = ``;

                // Back button ("..") to go up one level
                if (path) {
                    const upPath = path.split('/').slice(0, -1).join('/');
                    table += `<tr>
                <td></td>
                <td>
                    <a href="#" class="file-link" data-path="${upPath}" data-type="folder" onclick="event.preventDefault()">
                        <span class="me-2"><i class="fas fa-arrow-left"></i></span>..
                    </a>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>`;
                }

                // If no files/folders are found, add a message
                if (data.length === 0) {
                    table += `<tr>
                <td colspan="5" class="text-center"><?= lang('Admin.tidakAdaFileAtauFolderDitemukan') ?></td>
            </tr>`;
                } else {
                    // Loop through files and folders to display
                    // Inside .then(data => { /* process data */ })
                    data.forEach(file => {
                        let icon = file.is_dir ? '<i class="fas fa-folder"></i>' : getIconByExtension(file.name.split('.').pop().toLowerCase());
                        let isDir = file.is_dir ? 'Folder' : 'File';
                        let dateModified = file.modified_date || '-';
                        let permissions = file.permissions || '-'; // New permissions field

                        // TODO: Translation
                        let actionBtns = file.is_dir ?
                            `<span class="btn-action-tooltip" data-title="<?= lang('Admin.buka') ?>"><button data-mdb-ripple-init class="btn btn-primary btn-sm btn-action" data-action="open" data-path="${file.path}"><i class="fa-solid fa-arrow-right"></i></button></span>` :
                            `<span class="btn-action-tooltip" data-title="<?= lang('Admin.lihat') ?>"><button data-mdb-ripple-init class="btn btn-secondary btn-sm btn-action" data-action="view" data-path="${file.path}"><i class="fa-solid fa-eye"></i></button></span>
                            <span class="btn-action-tooltip" data-title="<?= lang('Admin.unduh') ?>"><button data-mdb-ripple-init class="btn btn-secondary btn-sm btn-action" data-action="download" data-path="${file.path}"><i class="fa-solid fa-download"></i></button></span>`;

                        actionBtns += `
                            <span class="btn-action-tooltip" data-title="<?= lang('Admin.salin') ?>"><button data-mdb-ripple-init class="btn btn-secondary btn-sm btn-action" data-action="copy" data-path="${file.path}"><i class="fa-solid fa-copy"></i></button></span>
                            <span class="btn-action-tooltip" data-title="<?= lang('Admin.pindah') ?>"><button data-mdb-ripple-init class="btn btn-secondary btn-sm btn-action" data-action="move" data-path="${file.path}"><i class="fa-solid fa-scissors"></i></button></span>
                            <span class="btn-action-tooltip" data-title="<?= lang('Admin.gantiNama') ?>"><button data-mdb-ripple-init class="btn btn-secondary btn-sm btn-action" data-action="rename" data-path="${file.path}"><i class="fa-solid fa-i-cursor"></i></button></span>`;

                        // Add row with new permissions column
                        table += `
        <tr>
            <td>
                <div class="form-check pe-0">
                    <input class="file-checkbox form-check-input" type="checkbox" data-path="${file.path}" />
                </div>
            </td>
            <td>
                <a href="#" class="file-link" data-path="${file.path}" data-type="${file.is_dir ? 'folder' : 'file'}" onclick="event.preventDefault()">
                    <span class="me-2">${icon}</span>${file.name} (${isDir})
                </a>
            </td>
            <td>${file.size}</td>
            <td>${permissions}</td> <!-- Permissions column -->
            <td>${dateModified}</td>
            <td>${actionBtns}</td>
        </tr>`;
                    });

                }

                // Replace content of fileList to reset old event listeners
                const fileListContainer = document.getElementById('fileList');
                const newContent = document.createElement('tbody');
                newContent.innerHTML = table;
                fileListContainer.replaceWith(newContent);
                newContent.id = 'fileList';

                // Initialize MDB buttons
                const buttonA = [];
                document.querySelectorAll('.btn-action').forEach((button, index) => {
                    // console.log("Initializing MDB Button: ");
                    // console.log(button);

                    // buttonA.push(new mdb.Button(button));

                });
                console.log(buttonA);

                buttonA.forEach(it => {
                    console.log(it._element);
                    // const button = it._element;
                    // // Initialize the tooltip with a bottom position
                    // const tooltipInstance = new mdb.Tooltip(it, {
                    //     placement: 'bottom',
                    //     title: button.getAttribute('data-action').charAt(0).toUpperCase() + button.getAttribute('data-action').slice(1) // Tooltip text based on action
                    // });
                })

                // "Select All" checkbox event
                document.getElementById('selectAll').addEventListener('click', function() {
                    const checkboxes = document.querySelectorAll('.file-checkbox');
                    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                });

                // Initialize MDB buttons with tooltips
                document.querySelectorAll('.btn-action').forEach(button => {
                    // Initialize the MDB button
                    new mdb.Button(button);
                });

                // Initialize MDB buttons with tooltips
                document.querySelectorAll('.btn-action-tooltip').forEach(button => {
                    // Initialize the tooltip with a bottom position
                    const tooltipInstance = new mdb.Tooltip(button, {
                        placement: 'bottom',
                        title: button.getAttribute('data-title').charAt(0).toUpperCase() + button.getAttribute('data-title').slice(1) // Tooltip text based on action
                    });
                });

                // Event listener for actions using delegation
                newContent.addEventListener('click', function(event) {
                    const target = event.target.closest('button, a');

                    if (!target) return;

                    const action = target.getAttribute('data-action');
                    const path = target.getAttribute('data-path');
                    const type = target.getAttribute('data-type');

                    if (action) {
                        if (action === 'open') {
                            listFiles(path);
                        } else if (action === 'view') {
                            viewFile(path);
                        } else if (action === 'download') {
                            downloadFile(path);
                        } else if (action === 'copy') {
                            addToClipboard(path, 'copy');
                        } else if (action === 'move') {
                            addToClipboard(path, 'move');
                        } else if (action === 'back') {
                            listFiles(path);
                        } else if (action === 'rename') {
                            renameFile(path);
                        }
                    } else if (type === 'folder') {
                        listFiles(path);
                    } else if (type === 'file') {
                        viewFile(path);
                    }
                });
            });
    }

    function createFile() {
        Swal.fire({
            title: "<?= lang('Admin.masukkanNamaFileBaruDengan') ?>:",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            cancelButtonText: "<?= lang('Admin.batal') ?>",
            confirmButtonText: "<?= lang('Admin.simpan') ?>",
            // confirmButtonColor: "var(--mdb-primary)",
            showLoaderOnConfirm: true,
            preConfirm: (fileName) => {
                if (!fileName) {
                    Swal.showValidationMessage("<?= lang('Admin.gagalMembuatFile') ?>: <?= lang('Validation.required', ['field' => lang('Admin.nama')]) ?>");
                    return;
                }
                return fetch('<?= base_url('admin/file-manager/createFile') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            path: currentPath,
                            fileName: fileName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.status) {
                            Swal.showValidationMessage(
                                "<?= lang('Admin.gagalMembuatFile') ?>: " + data.error
                            );
                        }
                        return data;
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value.status) {
                Swal.fire({
                    icon: 'success',
                    title: result.value.status
                });
                listFiles(currentPath); // Refresh the list to show the new file
            }
        });
    }

    function createFolder() {
        Swal.fire({
            title: "<?= lang('Admin.masukkanNamaFolderBaru') ?>:",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            cancelButtonText: "<?= lang('Admin.batal') ?>",
            confirmButtonText: "<?= lang('Admin.simpan') ?>",
            // confirmButtonColor: "var(--mdb-primary)",
            showLoaderOnConfirm: true,
            preConfirm: (folderName) => {
                if (!folderName) {
                    Swal.showValidationMessage("<?= lang('Admin.gagalMembuatFolder') ?>: <?= lang('Validation.required', ['field' => lang('Admin.nama')]) ?>");
                    return;
                }
                return fetch('<?= base_url('admin/file-manager/createFolder') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            path: currentPath,
                            folderName: folderName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.status) {
                            Swal.showValidationMessage(
                                "<?= lang('Admin.gagalMembuatFolder') ?>: " + data.error
                            );
                        }
                        return data;
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value.status) {
                Swal.fire({
                    icon: 'success',
                    title: result.value.status
                });
                listFiles(currentPath); // Refresh the list to show the new folder
            }
        });
    }

    function renameFile(oldPath) {
        // Extract the filename from oldPath
        const oldFileName = oldPath.split('/').pop();

        Swal.fire({
            title: "<?= lang('Admin.masukkanNamaFileBaruDengan') ?>:",
            input: "text",
            inputValue: oldFileName, // Set old filename as the default input value
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            cancelButtonText: "<?= lang('Admin.batal') ?>",
            confirmButtonText: "<?= lang('Admin.simpan') ?>",
            // confirmButtonColor: "var(--mdb-primary)",
            showLoaderOnConfirm: true,
            preConfirm: (newName) => {
                if (!newName) {
                    Swal.showValidationMessage("<?= lang('Admin.gagalMengubahNamaFile') ?>: <?= lang('Validation.required', ['field' => lang('Admin.nama')]) ?>");
                    return;
                }
                return fetch('<?= base_url('admin/file-manager/rename') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            oldPath: oldPath,
                            newName: newName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.status) {
                            Swal.showValidationMessage(
                                "<?= lang('Admin.gagalMengubahNamaFile') ?>: " + data.error
                            );
                        }
                        return data;
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value.status) {
                Swal.fire({
                    icon: 'success',
                    title: result.value.status
                });
                listFiles(currentPath); // Refresh the list to show renamed file
            }
        });
    }

    // Helper function to get icon by file extension
    function getIconByExtension(ext) {
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'webp':
                return '<i class="fas fa-file-image"></i>';
            case 'mp4':
            case 'mkv':
            case 'webm':
                return '<i class="fas fa-file-video"></i>';
            case 'mp3':
            case 'wav':
                return '<i class="fas fa-file-audio"></i>';
            case 'pdf':
                return '<i class="fas fa-file-pdf"></i>';
            case 'doc':
            case 'docx':
                return '<i class="fas fa-file-word"></i>';
            case 'xls':
            case 'xlsx':
                return '<i class="fas fa-file-excel"></i>';
            case 'ppt':
            case 'pptx':
                return '<i class="fas fa-file-powerpoint"></i>';
            case 'zip':
            case 'rar':
            case '7z':
                return '<i class="fas fa-file-archive"></i>';
            case 'txt':
            case 'md':
            case 'log':
                return '<i class="fas fa-file-alt"></i>';
            case 'js':
            case 'css':
            case 'html':
            case 'php':
                return '<i class="fas fa-file-code"></i>';
            default:
                return '<i class="fas fa-file"></i>';
        }
    }

    // Save button functionality
    function saveFile(path) {

        /* UI */
        if (document.getElementById('loaderModal').classList.contains("d-none")) {
            document.getElementById('loaderModal').classList.remove('d-none');
        }
        /* End of UI */

        const updatedContent = document.getElementById('fileEditor').value;
        fetch('<?= base_url('admin/file-manager/saveFile') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    path: btoa(path), // Encode the file path
                    content: updatedContent,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);

                /* UI */
                if (!document.getElementById('loaderModal').classList.contains("d-none")) {
                    document.getElementById('loaderModal').classList.add('d-none');
                }
                /* End of UI */

                if (data.success) {
                    // Show success toast 
                    Swal.fire({
                        position: "top",
                        icon: "success",
                        toast: true,
                        title: "<?= lang('Admin.fileBerhasilDisimpan') ?>",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } else {
                    // Show error toast 
                    Swal.fire({
                        icon: "error",
                        toast: true,
                        title: "<?= lang('Admin.gagalMenyimpanFile') ?>: " + data.error,
                        confirmButtonText: "<?= lang('Admin.tutup') ?>"
                    });
                }
            });
    }

    function deleteSelectedFiles() {
        const selectedFiles = Array.from(document.querySelectorAll('.file-checkbox:checked'))
            .map(checkbox => checkbox.getAttribute('data-path'));

        if (selectedFiles.length === 0) {
            // Show error toast 
            Swal.fire({
                icon: "error",
                toast: true,
                title: "<?= lang('Admin.pilihFileUntukDihapus') ?>",
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }

        Swal.fire({
            title: '<?= lang('Admin.hapusItem') ?>',
            text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--mdb-danger) !important',
            confirmButtonText: '<?= lang('Admin.hapus') ?>',
            cancelButtonText: '<?= lang('Admin.batal') ?>',
        }).then((result) => {
            if (result.isConfirmed) {

                // Request item deletion
                fetch('<?= base_url('admin/file-manager/deleteFiles') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            files: selectedFiles
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            // Show success alert dialog
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "<?= lang('Admin.fileBerhasilDihapus') ?>",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            listFiles(currentPath); // Refresh file list
                        } else if (data.error) {
                            // Show error alert dialog
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "<?= lang('Admin.fileGagalDihapus') ?>: " + data.error,
                                confirmButtonText: "<?= lang('Admin.tutup') ?>",
                            });
                        }
                    })
                    .catch(error => console.error("Error deleting files:", error));

            }
        });

    }

    function getSelectedFiles() {
        return Array.from(document.querySelectorAll('.file-checkbox:checked'))
            .map(checkbox => checkbox.getAttribute('data-path'));
    }

    function compressSelectedFiles() {
        const selectedFiles = getSelectedFiles();

        if (selectedFiles.length === 0) {
            Swal.fire({
                icon: "error",
                toast: true,
                title: "<?= lang('Admin.pilihFileUntukDikompresZIP') ?>",
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }

        /* UI */
        if (document.getElementById('loaderBody').classList.contains("d-none")) {
            document.getElementById('loaderBody').classList.remove('d-none');
        }
        /* End of UI */

        fetch('<?= base_url('admin/file-manager/compress') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    files: selectedFiles,
                    path: currentPath
                })
            })
            .then(response => response.json())
            .then(data => {

                /* UI */
                if (!document.getElementById('loaderBody').classList.contains("d-none")) {
                    document.getElementById('loaderBody').classList.add('d-none');
                }
                /* End of UI */

                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: '<?= lang('Admin.berhasilMengompres') ?>',
                        text: data.archive
                    });
                    listFiles(currentPath); // Refresh list to show new zip file
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '<?= lang('Admin.galat') ?>',
                        text: "<?= lang('Admin.gagalMengompresFile') ?>: " + data.error
                    });
                }
            })
            .catch(error => console.error('Error compressing files:', error));
    }

    function extractSelectedFiles() {
        const selectedFiles = getSelectedFiles();

        if (selectedFiles.length !== 1 || !selectedFiles[0].endsWith('.zip')) {
            Swal.fire({
                icon: "error",
                toast: true,
                title: "<?= lang('Admin.pilihFileZIPUntukDiekstrak') ?>",
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }

        /* UI */
        if (document.getElementById('loaderBody').classList.contains("d-none")) {
            document.getElementById('loaderBody').classList.remove('d-none');
        }
        /* End of UI */

        fetch('<?= base_url('admin/file-manager/extract') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    path: selectedFiles[0]
                })
            })
            .then(response => response.json())
            .then(data => {

                /* UI */
                if (!document.getElementById('loaderBody').classList.contains("d-none")) {
                    document.getElementById('loaderBody').classList.add('d-none');
                }
                /* End of UI */

                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: '<?= lang('Admin.berhasilMengekstrak') ?>',
                        toast: true,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    listFiles(currentPath); // Refresh to show extracted files
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: "<?= lang('Admin.gagalMengekstrakFile') ?>: " + data.error
                    });
                }
            })
            .catch(error => console.error("Error extracting file:", error));
    }

    function copySelectedFiles() {
        const selectedFiles = getSelectedFiles();
        if (selectedFiles.length === 0) {
            // Show error toast 
            Swal.fire({
                icon: "error",
                toast: true,
                title: "<?= lang('Admin.pilihFileUntukDisalin') ?>",
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }
        setClipboard(selectedFiles, 'copy');
    }

    function moveSelectedFiles() {
        const selectedFiles = getSelectedFiles();
        if (selectedFiles.length === 0) {
            // Show error toast 
            Swal.fire({
                icon: "error",
                toast: true,
                title: "<?= lang('Admin.pilihFileUntukDipindah') ?>",
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }
        setClipboard(selectedFiles, 'move');
    }

    function setClipboard(files, action) {
        fetch('<?= base_url('admin/file-manager/setClipboard') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    files,
                    action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Show success toast 
                    Swal.fire({
                        icon: "success",
                        toast: true,
                        title: `${action.charAt(0).toUpperCase() + action.slice(1)}: <?= lang('Admin.berhasilDisalinSiapUntuk') ?>`,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } else {
                    // Show error toast 
                    Swal.fire({
                        icon: "error",
                        toast: true,
                        title: "<?= lang('Admin.gagalMenyalin') ?>: " + data.error,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
            })
            .catch(error => console.error("Error setting clipboard:", error));
    }
</script>

<script type="module">
    import * as monaco from 'https://cdn.jsdelivr.net/npm/monaco-editor@0.52/+esm';
    import prettier from 'https://cdn.jsdelivr.net/npm/prettier@3.3.3/+esm';
    import * as parserHtml from 'https://cdn.jsdelivr.net/npm/prettier@3.3.3/plugins/html.mjs';
    import parserBabel from 'https://cdn.jsdelivr.net/npm/prettier@3.3.3/plugins/babel.mjs'; // For JS formatting

    // Export monaco variable
    window.monaco = monaco;

    // 
    monaco.editor.defineTheme("vs-dsm", {
        base: "vs",
        inherit: true,
        rules: [],
        colors: {
            "editor.background": "#f5f5f5",
        },
    });

    // 
    monaco.editor.defineTheme("vs-dark-dsm", {
        base: "vs-dark",
        inherit: true,
        rules: [],
        colors: {
            "editor.background": "#303030",
        },
    });

    // Create Monaco Editor
    window.editor = monaco.editor.create(document.getElementById('monaco'), {
        value: ``,
        language: 'twig',
        theme: '<?= setting()->get('App.temaDasborAdmin', $context) == 'gelap' ? "vs-dark-dsm" : "vs-dsm" ?>',
        automaticLayout: true
    });

    document.addEventListener('DOMContentLoaded', function() {
        editor.getModel().setValue(document.getElementById("fileEditor").value);

        // Function to update textarea
        function updateTextarea() {
            const content = editor.getValue();
            document.getElementById('fileEditor').value = content; // Update textarea with editor content
            // console.log('Updating textearea: ' + content);
        }

        // Add listener for content changes in the Monaco Editor
        editor.onDidChangeModelContent(() => {
            updateTextarea(); // Update the textarea whenever content changes
        });

        // Submit (Ctrl + Alt + Z)
        editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyMod.Alt | monaco.KeyCode.KeyZ, function() {
            const editorContainer = document.getElementById('monaco'); // Replace with your editor's container ID
            if (!document.fullscreenElement) {
                editorContainer.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });


    });

    // Formatting Function
    async function formatCode() {
        let unformattedCode = editor.getValue();

        try {

            // Apply Prettier formatting for HTML parts
            let formattedCode = await prettier.format(unformattedCode, {
                parser: 'html',
                plugins: [parserHtml],
            });

            // Reformat all `{% set ... %}` declarations to ensure each is on its own line
            formattedCode = formattedCode.replace(
                /(\{% set [^%]*?%\})\s*/g,
                (match) => `${match.trim()}\n`
            );

            // Combine split lines and remove extra space before the last `%`
            formattedCode = formattedCode.replace(
                /\{% set ([^%]*?)(\n\s*[^%]*?)?%\}/g,
                (match, p1, p2) => {
                    const trimmedP1 = p1.trim();
                    const trimmedP2 = p2 ? p2.trim() : '';
                    return `{% set ${trimmedP1} ${trimmedP2} %}`;
                }
            );

            // Final cleanup to ensure no extra spaces before last %
            formattedCode = formattedCode
                .replace(/\s*%\}/g, ' %}')
                .replace(/\{\{\s*(.*?)\s*\}\}/g, '{{ $1 }}'); // Ensure spaces inside {{ }}

            // const formattedCode = beautifyCode(unformattedCode);

            // editor.setValue(formattedCode);

            // Apply incremental edit to preserve undo history
            const fullRange = editor.getModel().getFullModelRange();
            editor.executeEdits('', [{
                range: fullRange,
                text: formattedCode,
                forceMoveMarkers: true,
            }]);
        } catch (e) {
            console.error('Formatting error:', e);
        }
    }

    // Register Command for Formatting (Ctrl + B)
    editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyB, () => {
        formatCode();
        // editor.setValue(html_beautify(editor.getValue()));
    });

    // Submit (Ctrl + S)
    editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyS, () => {
        document.getElementById("formEditKomponen").submit();
    });

    function beautifyCode(code) {
        const htmlTagRegex = /<\/?[\w\s="'-:;]+>/;
        const twigTagRegex = /(\{\{.*?\}\}|\{%.*?%\})/;
        const jsLineEndings = /([{};])/g;

        // Split the code by lines to handle indentation
        const lines = code.split('\n');

        let indentLevel = 0;
        const indentSize = 4; // Spaces per indent
        const beautifiedLines = [];

        lines.forEach((line) => {
            let trimmedLine = line.trim();

            // Handle closing braces or tags (reduce indent)
            if (trimmedLine.startsWith('}') || trimmedLine.startsWith('</') || trimmedLine.startsWith('{% end')) {
                indentLevel--;
            }

            // Add proper indentation
            const indentation = ' '.repeat(indentLevel * indentSize);
            beautifiedLines.push(indentation + trimmedLine);

            // Handle opening braces or tags (increase indent after)
            if (trimmedLine.match(htmlTagRegex) || trimmedLine.match(twigTagRegex)) {
                if (!trimmedLine.startsWith('</') && !trimmedLine.startsWith('{% end')) {
                    indentLevel++;
                }
            }

            // Increase indent for JS blocks
            if (trimmedLine.endsWith('{')) {
                indentLevel++;
            }

            // Decrease indent if a closing JS block is found
            if (trimmedLine.endsWith('}')) {
                indentLevel--;
            }
        });

        // Join all the beautified lines
        return beautifiedLines.join('\n');
    }
</script>

<?= $this->endSection() ?>