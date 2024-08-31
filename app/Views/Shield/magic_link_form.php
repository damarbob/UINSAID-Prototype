<?= $this->extend('layout/auth/auth_template') ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Pesan error -->
<?php if (session('error') !== null) : ?>
    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
<?php elseif (session('errors') !== null) : ?>
    <div class="alert alert-danger" role="alert">
        <?php if (is_array(session('errors'))) : ?>
            <?php foreach (session('errors') as $error) : ?>
                <?= $error ?>
                <br>
            <?php endforeach ?>
        <?php else : ?>
            <?= session('errors') ?>
        <?php endif ?>
    </div>
<?php endif ?>

<p class="">
    <a href="<?= url_to('login') ?>">
        <i class="bi bi-chevron-left me-2"></i>
        <?= lang('Auth.backToLogin') ?>
    </a>
</p>

<form action="<?= url_to('magic-link') ?>" method="post">
    <?= csrf_field() ?>

    <!-- Email -->
    <div class="form-outline mb-3" data-mdb-input-init>
        <input id="email" class="form-control form-control-lg" type="text" name="email" autocomplete="email" value="<?= old('email', auth()->user()->email ?? null) ?>" />
        <label class="form-label" for="email"><?= lang('Auth.email') ?></label>
    </div>

    <!-- Tombol kirim -->
    <button type="submit" class="btn btn-lg btn-primary" data-mdb-ripple-init>
        <i class="bi bi-envelope-arrow-up me-2"></i>
        <?= lang('Auth.send') ?>
    </button>

</form>

<?= $this->endSection() ?>