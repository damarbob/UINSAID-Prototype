<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/css/style-tentang-kami.css") ?>" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero -->
<section id="hero" class="bg-primary p-0 d-flex align-items-center justify-content-center">

</section>

<!-- Judul -->
<section class="menu-title d-flex align-items-center gradient-1">
    <div class="lurik align-self-start"></div>
    <div class="container text-center">
        <h1 class="">Menu Title</h1>
    </div>
    <div class="lurik-2 align-self-end"></div>
</section>

<!-- Section CTNA -->
<section class="fluid section-batik mt-navbar" id="akademik">
    <div class="container p-5">
        <div class="row d-flex align-items-center g-5">

            <!-- Akademik column -->
            <div class="col-lg-6 ps-5" data-aos="fade-left">
                <h1 class="pb-2 fw-bold">
                    Lorem Ipsum is simply dummy
                    text of the printing
                </h1>
                <div class="lurik-3"></div>
            </div>

            <!-- Picture grid column -->
            <div class="col-lg-6">

                <!-- Picture grid -->
                <div class="row g-0">
                    <div class="col">
                        <img data-aos="fade-up" class="" style="border-radius: 5rem; width: 100%; max-height: 512px;object-fit: contain;" src="assets/img/foto-rektor-wisuda.png" />
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Section CTNA -->

<!-- Section Tentang Kami -->
<section class="fluid section-batik" id="akademik">
    <div class="container p-5">
        <div class="row d-flex g-5">

            <div class="col-3">

                <div class="container bg-light bg-gradient border rounded-5">
                    <div class="row">
                        <div class="col">

                            <!-- Tab navs -->
                            <div class="nav py-4 flex-column nav-tabs text-start" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                                <h5 class="ps-3 fw-bold">Universitas</h5>
                                <a data-mdb-tab-init class="nav-link active text" id="v-tabs-home-tab" href="#v-tabs-home" role="tab" aria-controls="v-tabs-home" aria-selected="true">Sambutan Rektor</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-profile-tab" href="#v-tabs-profile" role="tab" aria-controls="v-tabs-profile" aria-selected="false">Sejarah</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Profil Universitas</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Visi-Misi</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Peta Kampus</a>
                                <br>
                                <h5 class="ps-3 fw-bold">Struktur Organisasi</h5>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Pimpinan</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Universitas</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Pimpinan Biro</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Pimpinan Lembaga</a>
                                <br>
                                <h5 class="ps-3 fw-bold">Identitas</h5>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Arti Lambang</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Mars</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-messages-tab" href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages" aria-selected="false">Hymne</a>

                            </div>
                            <!-- Tab navs -->
                        </div>


                    </div>
                </div>

            </div>

            <div class="col-9">
                <!-- Tab content -->
                <div class="tab-content" id="v-tabs-tabContent">
                    <div class="tab-pane fade show active" id="v-tabs-home" role="tabpanel" aria-labelledby="v-tabs-home-tab">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        Why do we use it?
                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).

                        Where does it come from?
                        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                    </div>
                    <div class="tab-pane fade" id="v-tabs-profile" role="tabpanel" aria-labelledby="v-tabs-profile-tab">
                        Profile content
                    </div>
                    <div class="tab-pane fade" id="v-tabs-messages" role="tabpanel" aria-labelledby="v-tabs-messages-tab">
                        Messages content
                    </div>
                </div>
                <!-- Tab content -->

            </div>

        </div>
    </div>
</section>
<!-- Section Tentang Kami -->

<!-- Section CTNA -->
<section class="fluid section-batik" id="akademik">
    <div class="container p-5">
        <div class="row d-flex align-items-center g-5">

            <!-- Picture grid column -->
            <div class="col-lg-6">

                <!-- Picture grid -->
                <div class="row g-0">
                    <div class="col">
                        <img data-aos="fade-up" class="" style="border-radius: 5rem; width: 100%; max-height: 512px;object-fit: contain;" src="assets/img/foto-rektor-wisuda.png" />
                    </div>
                </div>

            </div>

            <!-- Akademik column -->
            <div class="col-lg-6" data-aos="fade-left">
                <h1 class="pb-2 fw-bold">
                    Lorem Ipsum is simply dummy
                    text of the printing
                </h1>
            </div>

        </div>
    </div>
</section>
<!-- Section CTNA -->

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>