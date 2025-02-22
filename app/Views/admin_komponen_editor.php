<?= $this->extend('layout/admin/admin_template') ?>

<?php
helper('form');
helper('setting'); // Must be declared to use setting helper function

// Pengaturan personal
$context = 'user:' . user_id(); //  Context untuk pengguna

if (!isset($komponen)) {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueNama = (old('nama'));
    $valueGrup = (old('grup'));
    $valueKonten = (old('konten'));
    $valueMeta = (old('meta'));
    $valueCSS = (old('css'));
    $valueJS = (old('js'));
    $valueTunggal = (old('tunggal'));
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueNama = old('nama') ?: $komponen['nama'];
    $valueGrup = old('grup') ?: $komponen['grup'];
    $valueKonten = old('konten') ?: htmlspecialchars($komponen['konten']);
    $valueMeta = old('meta') ?: htmlspecialchars($komponen['meta']);
    $valueCSS = old('css') ?: $komponen['css'];
    $valueJS = old('js') ?: $komponen['js'];
    $valueTunggal = old('tunggal') ?: $komponen['tunggal'];
}

// Validasi
$errorCSS = validation_show_error('css_file');
$errorJS = validation_show_error('js_file');
?>

<?= $this->section('style') ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/melody-parser@1.7.5/lib/index.js"></script> -->
<script type="module">
    import * as monaco from 'https://cdn.jsdelivr.net/npm/monaco-editor@0.52/+esm';
    import prettier from 'https://cdn.jsdelivr.net/npm/prettier@3.3.3/+esm';
    import * as parserHtml from 'https://cdn.jsdelivr.net/npm/prettier@3.3.3/plugins/html.mjs';
    import parserBabel from 'https://cdn.jsdelivr.net/npm/prettier@3.3.3/plugins/babel.mjs'; // For JS formatting

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
            "editor.background": "#252525",
        },
    });

    // Create Monaco Editor
    const editor = monaco.editor.create(document.getElementById('monaco'), {
        value: ``,
        language: 'twig',
        theme: '<?= setting()->get('App.temaDasborAdmin', $context) == 'gelap' ? "vs-dark-dsm" : "vs-dsm" ?>',
        automaticLayout: true
    });

    const editorMeta = monaco.editor.create(document.getElementById('editorMeta'), {
        value: ``,
        language: 'json',
        theme: '<?= setting()->get('App.temaDasborAdmin', $context) == 'gelap' ? "vs-dark-dsm" : "vs-dsm" ?>',
        automaticLayout: true
    });

    $(document).ready(function() {

        // Set initial editor value
        editor.getModel().setValue(document.getElementById("konten").value);
        editorMeta.getModel().setValue(document.getElementById("meta").value);

        // Function to update textarea
        function updateTextarea() {
            const content = editor.getValue();
            const meta = editorMeta.getValue();

            // Update hidden textarea with editor content
            document.getElementById('konten').value = content; 
            document.getElementById('meta').value = meta;
        }

        // Add listener for content changes in the Monaco Editor
        editor.onDidChangeModelContent(() => {
            updateTextarea(); // Update the textarea whenever content changes
        });
        editorMeta.onDidChangeModelContent(() => {
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
</script>
<link href="https://cdn.jsdelivr.net/npm/vscode-codicons@0.0.17/dist/codicon.min.css" rel="stylesheet">

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form id="formEditKomponen" action="<?= isset($komponen) ? base_url('/admin/komponen/simpan/') . $komponen['id'] : base_url('/admin/komponen/simpan'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-9">

            <!-- Pesan sukses atau error -->
            <?php if (session()->getFlashdata('sukses')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <a href="<?= base_url('admin/komponen') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                    <?= session()->getFlashdata('sukses') ?>
                </div>
            <?php elseif (session()->getFlashdata('gagal')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <a href="<?= base_url('admin/komponen') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                    <?= session()->getFlashdata('gagal') ?>
                </div>
            <?php endif; ?>

            <!-- Nama komponen -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= $valueNama ?>">
                <label for="nama"><?= lang('Admin.nama') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('nama'); ?>
                </div>
            </div>

            <!-- Konten komponen (dari monaco editor) -->
            <div class="form-floating mb-3">
                <textarea class="d-none form-control <?= (validation_show_error('konten')) ? 'is-invalid' : ''; ?>" id="konten" name="konten" rows="10" autofocus><?= $valueKonten; ?></textarea>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('konten'); ?>
                </div>
            </div>

            <!-- Meta JSON komponen (dari monaco editor) -->
            <div class="form-floating mb-3">
                <textarea class="d-none form-control <?= (validation_show_error('meta')) ? 'is-invalid' : ''; ?>" id="meta" name="meta" rows="10" autofocus><?= $valueMeta; ?></textarea>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('meta'); ?>
                </div>
            </div>

            <div id="monaco" class="mb-4" style="height: 512px;">
            </div>

            <div id="editorMeta" class="mb-4" style="height: 512px;">
            </div>

        </div>
        <div class="col-md-3">

            <!-- CSS file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="css" name="css_file">
                <label for="css">CSS</label>

                <?php if (isset($komponen['css']) && $komponen['css'] != ''): ?>

                    <!-- CSS lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueCSS) ?>" id="cssOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                            </a>
                        </small>
                    </div>

                    <!-- Button delete CSS -->
                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusCSS" data-mdb-ripple-init="">
                        <i class="bi bi-trash"></i>
                    </button>

                    <script>
                        // Add old css label and handle deletion
                        document.addEventListener('DOMContentLoaded', function() {
                            let cssOldLabel = document.getElementById("cssOldLabel");
                            let buttonHapusCSS = document.getElementById('buttonHapusCSS');

                            cssOldLabel.innerHTML =
                                getFilenameAndExtension('<?= $komponen['css'] ?>') +
                                '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                            buttonHapusCSS.addEventListener("click", function() {
                                // Confirm delete
                                Swal.fire({
                                    title: '<?= lang('Admin.hapusItem') ?>',
                                    text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: 'var(--mdb-danger)',
                                    confirmButtonText: '<?= lang('Admin.hapus') ?>',
                                    cancelButtonText: '<?= lang('Admin.batal') ?>',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Set input cssOld value to empty and hide hapus button
                                        document.getElementById('cssOld').value = '';
                                        buttonHapusCSS.style.display = 'none';
                                        cssOldLabel.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>

                <?php endif; ?>

                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorCSS) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorCSS; ?>
                </div>

            </div>

            <!-- CSS old input -->
            <input type="hidden" class="form-control" id="cssOld" name="css_old" value="<?= $valueCSS ?>">

            <!-- JS file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="js" name="js_file">
                <label for="js">JS</label>

                <?php if (isset($komponen['js']) && $komponen['js'] != ''): ?>

                    <!-- JS lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueJS) ?>" id="jsOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            </a>
                        </small>
                    </div>

                    <!-- Button delete JS -->
                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusJS" data-mdb-ripple-init="">
                        <i class="bi bi-trash"></i>
                    </button>

                    <script>
                        // Add old js label and handle deletion
                        document.addEventListener('DOMContentLoaded', function() {
                            let jsOldLabel = document.getElementById("jsOldLabel");
                            let buttonHapusJS = document.getElementById('buttonHapusJS');

                            jsOldLabel.innerHTML =
                                getFilenameAndExtension('<?= $komponen['js'] ?>') +
                                '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                            buttonHapusJS.addEventListener("click", function() {
                                // Confirm delete
                                Swal.fire({
                                    title: '<?= lang('Admin.hapusItem') ?>',
                                    text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: 'var(--mdb-danger)',
                                    confirmButtonText: '<?= lang('Admin.hapus') ?>',
                                    cancelButtonText: '<?= lang('Admin.batal') ?>',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Set input jsOld value to empty and hide hapus button
                                        document.getElementById('jsOld').value = '';
                                        buttonHapusJS.style.display = 'none';
                                        jsOldLabel.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>

                <?php endif; ?>

                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorJS) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorJS; ?>
                </div>

            </div>

            <!-- JS old input -->
            <input type="hidden" class="form-control" id="jsOld" name="js_old" value="<?= $valueJS ?>">

            <!-- Grup komponen -->
            <div class="form-floating mb-3">
                <select class="form-select <?= (validation_show_error('grup_lainnya')) ? 'is-invalid' : ''; ?>" id="grup" name="grup">
                    <?php foreach ($komponen_grup as $k): ?>
                        <option value="<?= $k['nama'] ?>" <?= $k['nama'] == $valueGrup ? 'selected' : '' ?>><?= $k['nama'] ?></option>
                    <?php endforeach ?>
                    <option value=""><?= lang('Admin.tambahBaru') ?></option>
                </select>
                <label for="grup" class="form-label"><?= lang('Admin.grup') ?></label>
            </div>

            <div class="alert alert-danger <?= (!validation_show_error('grup_lainnya')) ? 'd-none' : ''; ?>" role="alert">
                <?= validation_show_error('grup_lainnya') ?>
            </div>

            <!-- Input grup komponen baru -->
            <div id="divInputGrupLainnya" class="form-outline mb-3" data-mdb-input-init="">
                <input type="text" class="form-control" id="inputGrupLainnya" name="grup_lainnya">
                <label for='inputGrupLainnya' class='form-label'><?= lang("Admin.namaGrup") ?></label>
            </div>

            <!-- <div class="mb-3">
                <label for="grup" class="form-label"><?= lang('Admin.grup') ?></label>
                <input type="number" class="form-control" id="grup" name="grup" value="<?= isset($komponen) ? $komponen['grup'] : ''; ?>">
            </div> -->

            <!-- Komponen tunggal -->
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="tunggal" value="off">
                <input class="form-check-input <?= (validation_show_error('tunggal')) ? 'is-invalid' : ''; ?>" type="checkbox" role="switch" id="tunggal" name="tunggal" <?= ($valueTunggal === "0") ? '' : 'checked' ?> />
                <label class="form-check-label" for="tunggal"><?= lang('Admin.komponenTunggal') ?></label>
            </div>

            <!-- Simpan -->
            <button type="submit" class="btn btn-primary w-100" data-mdb-ripple-init><i class="bi bi-floppy me-2"></i><?= lang('Admin.simpan') ?></button>

        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.0/beautify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.0/beautify-html.min.js"></script>

<script>
    $(document).ready(function() {
        const selectGrup = $('#grup');
        const divInputGrupLainnya = $('#divInputGrupLainnya');

        refreshInputGrup() // Initial refresh

        selectGrup.on('change', function() {
            refreshInputGrup()
        });

        function refreshInputGrup() {
            if (selectGrup.val() === '') { // If "Lainnya" is selected
                divInputGrupLainnya.show();
            } else {
                // divInputGrupLainnya.prop('disabled', true).prop('required', false).val(''); // Clear the input if another option is selected
                divInputGrupLainnya.hide();
            }
        }

        // editor.getModel().setValue(document.getElementById("konten").value);
    });
</script>
<?= $this->endSection() ?>