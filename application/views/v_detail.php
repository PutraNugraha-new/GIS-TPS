<section class="detail mt-4">
    <div class="container">
        <div class="row peta">
            <div class="col-lg-12">
                <div id="detail-map" style="height: 40vh;"></div>
            </div>
        </div>
        <div class="row d-flex justify-content-md-between text-center text-md-start">
            <div class="col-md-5 col-12"> <strong>
                <?= $detail->nama_kab ?> / <?= $detail->nama_kec ?> / <?= $detail->nama_kel ?>
            </strong>
            </div>
            <div class="col-md-3 col-12 text-center my-2">
                <h4>TPS <?= $detail->nama_tps ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center justify-content-md-start my-2">
                <input type="hidden" id="latitude" class="form-control" placeholder="Latitude" name="latNow">
                <input type="hidden" id="longitude" class="form-control" placeholder="Longitude" name="lngNow">
                <button class="btn dariSini">Tentukan Rute</button>
            </div>
        </div>
        <hr>
        <div class="row detail-informasi text-center text-md-start">
            <div class="col-md-12">
                <h2>Informasi</h2>
            </div>
            <div class="col-md-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="39" viewBox="0 0 29 39" fill="none">
                    <path d="M14.5 0C6.47667 0 0 6.47667 0 14.5C0 24.1667 14.5 38.6667 14.5 38.6667C14.5 38.6667 29 24.1667 29 14.5C29 6.47667 22.5233 0 14.5 0ZM14.5 4.83333C19.865 4.83333 24.1667 9.18333 24.1667 14.5C24.1667 19.865 19.865 24.1667 14.5 24.1667C9.18333 24.1667 4.83333 19.865 4.83333 14.5C4.83333 9.18333 9.18333 4.83333 14.5 4.83333Z" fill="#B10505"/>
                </svg>
                <span class="mx-3"><?= $detail->alamat ?></span>
            </div>
            <div class="col-md-12 my-2">
                <span>Tanggal <?= $jadwal ?>
                </span>
            </div>
        </div>
    </div>
</section>
