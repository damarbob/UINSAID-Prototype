<?= $this->extend('layout/admin/admin_template') ?>

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
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueNama = (old('nama')) ? old('nama') : $komponen['nama'];
    $valueGrup = (old('grup_id')) ? old('grup_id') : $komponen['grup_id'];
    $valueKonten = (old('konten')) ? old('konten') : $komponen['konten'];
    $valueCSS = (old('css')) ? old('css') : $komponen['css'];
    $valueJS = (old('js')) ? old('js') : $komponen['js'];
}
?>
<div class="row">
    <div class="col-lg-12">
        <form action="<?= isset($komponen) ? base_url('/admin/komponen/simpan/') . $komponen['id'] : base_url('/admin/komponen/simpan'); ?>" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label"><?= lang('Admin.nama') ?></label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= isset($komponen) ? $komponen['nama'] : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="grup_id" class="form-label"><?= lang('Admin.grup') ?></label>
                <input type="number" class="form-control" id="grup_id" name="grup_id" value="<?= isset($komponen) ? $komponen['grup_id'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="konten" class="form-label"><?= lang('Admin.konten') ?></label>
                <textarea class="form-control" id="konten" name="konten" rows="5" required><?= isset($komponen) ? $komponen['konten'] : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="css" class="form-label">CSS</label>
                <input type="text" class="form-control" id="css" name="css" value="<?= isset($komponen) ? $komponen['css'] : ''; ?>" placeholder="e.g., style-komponen.css">
            </div>
            <div class="mb-3">
                <label for="js" class="form-label">JS</label>
                <input type="text" class="form-control" id="js" name="js" value="<?= isset($komponen) ? $komponen['js'] : ''; ?>" placeholder="e.g., script-komponen.js">
            </div>
            <button type="submit" class="btn btn-primary"><?= isset($komponen) ? 'Update' : 'Create'; ?></button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>