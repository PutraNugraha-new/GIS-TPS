<div class="info">
    <marquee behavior="scroll" direction="left" loop="">
        <p>Ingat...!! Pemilu Serentak, Rabu 14 Februari 2024... Sarana Integrasi Bangsa</p>
    </marquee>
</div>
<div class="backdrop">
    <img src="<?= base_url() ?>assets/user/image/Vector.png" alt="">
</div>
<div class="container my-1 my-lg-5 hero">
    <div class="row">
        <div class="col-lg-5 col-sm-12 text-lg-start text-md-center text-sm-center text-center kiri-hero" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
            <h3>Jelajahi TPS dengan Lebih Mudah menggunakan <span> SILOKAT!</span></h3>
            <h5>Temukan lokasi tempat pemungutan suara di sekitar Anda dengan mudah dan cepat.</h5>
            <a href="#peta" class="btn">Cari TPS mu</a>
        </div>
        <div class="col-lg-7 d-sm-none d-lg-block img-hero" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1500">
            <img src="<?= base_url() ?>assets/user/image/hero.png" class="img-fluid" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col-12 taggar">
            <p class="text-lg-start text-md-center text-sm-center text-center">
                #SuaraAndaKekuatanDemokrasi
            </p>
        </div>
    </div>
</div>

<div class="jumlah-tps">
    <div class="row my-5 m-0" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
        <div class="col-lg-10 text-center mx-auto">
            <h3>Jumlah TPS di Tiap Kabupaten</h3>
        </div>
    </div>
    <div class="wrapper container" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
        <ul class="carousel">
            <?php foreach($jumlah as $data): ?>
            <li class="card">
                <p><?= $data->nama_kab ?></p>
                <p><?= $data->total_tps ?></p>
                <p>TPS</p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- peta -->
<section  class="my-5" id="peta">
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
                <h2>Peta</h2>
            </div>
        </div>
        <div class="col-md-1">
            <h4 class="text-secondary">Filter :</h4>
        </div>
        <div class="row">
            <div class="col-md-3 form-group mb-3">
                <select id="kodeKabFilter" class="form-select">
                    <option value="">Semua Kabupaten/kota</option>
                    <!-- Tambahkan pilihan berdasarkan kode_kab yang ada di database -->
                    <?php foreach($kab as $data): ?>
                        <option value="<?= $data->kode_kab ?>"><?= $data->nama_kab ?></option>
                    <?php endforeach; ?>
                    <!-- ... tambahkan pilihan lainnya sesuai kebutuhan -->
                </select>
            </div>
            <div class="col-md-3 form-group mb-3">
                <select id="kodeKecFilter" name="kodeKecFilter" class="form-select" disabled>
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>
            <div class="col-md-3 form-group mb-3">
                <select id="kodeKelFilter" name="kodeKelFilter" class="form-select" disabled>
                    <option value="">-- Pilih Kelurahan/desa --</option>
                </select>
            </div>
            <div class="col-md-3 form-group mb-3">
                <input type="text" id="tpsNameFilter" class="form-control" placeholder="Nomor TPS dengan format 1,2,3.." disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="text-danger">
                    <strong>*</strong>Jika tidak tau dimana anda mencoblos, silahkan cek data anda di
                    <a href="https://cekdptonline.kpu.go.id/" target="_blank" class="text-decoration-none"><strong>Sini</strong></a>
                </p>
            </div>
        </div>
        <div id="map"></div>
</div>

    </div>
</section>

<!-- close peta -->

<!-- tentang Web -->
<section class="my-5 about" id="tentang">
    <div class="container" >
        <div class="row my-4">
            <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
                <h3>Tentang Sistem</h3>
            </div>
        </div>
        <div class="row d-flex justify-content-center w-100 my-2" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
            <div class="col-lg-7 text-center desk-about">
                <p>
                    SILOKAT atau Sistem Informasi Lokasi TPS adalah sebuah sistem informasi inovatif yang dirancang untuk memberikan pengguna informasi yang lengkap dan akurat mengenai lokasi Tempat Pemungutan Suara (TPS) melalui peta interaktif. Dengan menggunakan aplikasi ini, pengguna dapat dengan mudah menemukan TPS yang mereka butuhkan untuk melakukan hak pilih secara efisien.
                </p>
                <p>
                    Dilengkapi dengan fitur pelacakan dan penentuan lokasi yang canggih, SILOKATT memastikan bahwa pengguna dapat menavigasi dengan lancar dan menemukan TPS dengan tepat. Dalam beberapa kali ketukan di layar ponsel, pengguna dapat melihat peta yang intuitif dan jelas dengan penanda TPS yang terintegrasi.
                </p>
            </div>
        </div>
        <div class="bckdrop d-flex justify-content-center">
            <img src="<?= base_url() ?>assets/user/image/kpu-about.png" width="350">
        </div>
    </div>
</section>
<!-- close tentang web -->



