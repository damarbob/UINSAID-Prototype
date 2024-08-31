<?= $this->extend('layout/auth/auth_template') ?>

<?= $this->section('title') ?>
<?= lang('Auth.login') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- {{ShieldOAuthButtonForLoginPage}} -->
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

<!-- Pesan sukses -->
<?php if (session('message') !== null) : ?>
    <div class="alert alert-success" role="alert"><?= session('message') ?></div>
<?php endif ?>

<!-- Form input login -->
<form action="<?= url_to('login') ?>" method="post">
    <?= csrf_field() ?>

    <!-- Email -->
    <div class="form-outline mb-3" data-mdb-input-init>
        <input id="email" class="form-control form-control-lg" type="text" name="email" value="<?= old('email') ?>" />
        <label class="form-label" for="email"><?= lang('Auth.email') ?></label>
    </div>

    <!-- Kata sandi -->
    <div class="form-outline mb-3" data-mdb-input-init>
        <input id="password" class="form-control form-control-lg" type="password" inputmode="text" name="password" value="<?= old('password') ?>" autocomplete="current-password" required />
        <label class="form-label" for="password"><?= lang('Auth.password') ?></label>
    </div>

    <div class="d-flex mb-3">
        <div>
            <button type="submit" class="btn btn-lg btn-primary" data-mdb-ripple-init>
                <i class="bi bi-box-arrow-in-right me-2"></i><?= lang('Auth.login') ?>
            </button>
        </div>
        <div class="flex-grow-1 ps-3 d-flex align-items-center">

            <!-- Ingat saya -->
            <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked<?php endif ?>>
                        <?= lang('Auth.rememberMe') ?>
                    </label>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Magic link -->
    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
        <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
    <?php endif ?>

</form>

<!-- Opsi masuk dengan -->
<!-- <a href="<?= base_url('oauth/google') ?>">
    <button type="button" class="btn btn-outline-dark w-100">
        <i class="bi bi-google me-2"></i>
        Masuk dengan Google
    </button>
</a> -->

<!-- Link daftar -->
<?php if (setting('Auth.allowRegistration')) : ?>
    <p class="text-center mt-2"><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
<?php endif ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js' integrity='sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3' crossorigin='anonymous'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js' integrity='sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk' crossorigin='anonymous'></script>
<?= $this->endSection() ?>