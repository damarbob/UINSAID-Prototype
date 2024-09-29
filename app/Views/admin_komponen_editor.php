<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>

<!-- CodeMirror -->
<link rel="stylesheet" href="/assets/vendor/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/assets/vendor/codemirror/addon/hint/show-hint.css">
<link rel="stylesheet" href="/assets/vendor/codemirror/theme/material-darker.css">
<link rel="stylesheet" href="/assets/vendor/codemirror/addon/display/fullscreen.css">
<script src="/assets/vendor/codemirror/lib/codemirror.js"></script>
<script src="/assets/vendor/codemirror/addon/hint/show-hint.js"></script>
<script src="/assets/vendor/codemirror/addon/hint/xml-hint.js"></script>
<script src="/assets/vendor/codemirror/addon/hint/html-hint.js"></script>
<script src="/assets/vendor/codemirror/addon/display/fullscreen.js"></script>
<script src="/assets/vendor/codemirror/mode/xml/xml.js"></script>
<script src="/assets/vendor/codemirror/mode/javascript/javascript.js"></script>
<script src="/assets/vendor/codemirror/mode/css/css.js"></script>
<script src="/assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>

<style>
    .CodeMirror {
        border: 1px solid #eee;
        height: 512px;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
helper('form');

if (!isset($komponen)) {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueNama = (old('nama'));
    $valueGrup = (old('grup'));
    $valueKonten = (old('konten'));
    $valueCSS = (old('css'));
    $valueJS = (old('js'));
    $valueTunggal = (old('tunggal'));
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueNama = old('nama') ?: $komponen['nama'];
    $valueGrup = old('grup') ?: $komponen['grup'];
    $valueKonten = old('konten') ?: htmlspecialchars($komponen['konten']);
    $valueCSS = old('css') ?: $komponen['css'];
    $valueJS = old('js') ?: $komponen['js'];
    $valueTunggal = old('tunggal') ?: $komponen['tunggal'];
}

// Validasi
$errorCSS = validation_show_error('css_file');
$errorJS = validation_show_error('js_file');
?>

<form id="formEditKomponen" action="<?= isset($komponen) ? base_url('/admin/komponen/simpan/') . $komponen['id'] : base_url('/admin/komponen/simpan'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-9">

            <!-- Pesan sukses atau error -->
            <?php if (session()->getFlashdata('sukses')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <a href="<?= base_url('admin/komponen') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                    <?= session()->getFlashdata('sukses') ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (session()->getFlashdata('gagal')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('gagal') ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Nama komponen -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= isset($komponen) ? $komponen['nama'] : ''; ?>">
                <label for="nama"><?= lang('Admin.nama') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('nama'); ?>
                </div>
            </div>

            <!-- Konten komponen -->
            <div class="form-floating mb-3">
                <textarea class="form-control tinymce <?= (validation_show_error('konten')) ? 'is-invalid' : ''; ?>" id="konten" name="konten" rows="10" autofocus><?= $valueKonten; ?></textarea>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('konten'); ?>
                </div>
            </div>


        </div>
        <div class="col-md-3">

            <!-- CSS file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="css" name="css_file">
                <label for="css">CSS</label>
                <div class="form-helper">
                    <small>
                        <a href="<?= $valueCSS ?>" target="_blank">
                            <?php if (isset($komponen['css']) && $komponen['css'] != ''): ?>
                                <?= $komponen_css_file ?>
                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            <?php endif; ?>
                        </a>
                    </small>
                </div>
                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorCSS) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorCSS; ?>
                </div>
            </div>

            <!-- JS file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="js" name="js_file">
                <label for="js">JS</label>
                <div class="form-helper">
                    <small>
                        <a href="<?= $valueJS ?>" target="_blank">
                            <?php if (isset($komponen['js']) && $komponen['js'] != ''): ?>
                                <?= $komponen_js_file ?>
                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            <?php endif; ?>
                        </a>
                    </small>
                </div>
                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorJS) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorJS; ?>
                </div>
            </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.0/beautify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.0/beautify-html.min.js"></script>

<script src="/assets/vendor/codemirror/addon/comment/comment.js"></script>
<script src="/assets/vendor/codemirror/addon/comment/continuecomment.js"></script>

<!-- CodeMirror -->
<script>
    window.onload = function() {
        var editor = CodeMirror.fromTextArea(document.getElementById("konten"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "text/html",
            theme: "material-darker",
            hintOptions: {
                hint: CodeMirror.hint.php
            },
            extraKeys: {
                "Ctrl-Space": "autocomplete",
                "Ctrl-Alt-Z": function(cm) {
                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                },
                "Esc": function(cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                },
                // "Ctrl-B": function(cm) {
                //     var content = cm.getValue();
                //     var beautified = html_beautify(content); // or js_beautify for JS
                //     cm.setValue(beautified);
                // },
                "Ctrl-B": function(cm) {
                    // Store the cursor position
                    var cursor = cm.getCursor();

                    // Store the scroll position
                    var scrollInfo = cm.getScrollInfo();
                    var scrollTop = scrollInfo.top;

                    // Get the code from the editor
                    var content = cm.getValue();

                    // Set the formatted code back to the editor
                    cm.setValue(html_beautify(content));

                    // Restore the cursor position
                    cm.setCursor(cursor);

                    // Restore the scroll position
                    cm.scrollTo(null, scrollTop);
                },
                "Ctrl-S": function(cm) {
                    document.getElementById("formEditKomponen").submit();
                },
                "Ctrl-/": "toggleComment",
            },
            indentUnit: 4,
            indentWithTabs: true,
            viewportMargin: Infinity
        });
    };
</script>

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
    });
</script>
<?= $this->endSection() ?>