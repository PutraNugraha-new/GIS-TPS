<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                <?php
                $atribut = 'class="form form-horizontal"';
                echo form_open_multipart('admin/add', $atribut);
                ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Nomor TPS</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="no_tps" class="form-control" name="nama_tps"
                                        placeholder="Nomor TPS" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kabupaten</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="kabupaten" name="kode_kab" required>
                                        <option value="">Pilih Kabupaten</option>
                                        <?php foreach($kab as $k): ?>
                                            <option value="<?= $k->kode_kab ?>"><?= $k->nama_kab ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kecamatan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="kecamatan" name="kode_kec" required>
                                        <option value="">Pilih Kecamatan</option>
                                        <!-- <?php foreach($kec as $k): ?>
                                            <option value="<?= $k->kode_kec ?>"><?= $k->nama_kec ?></option>
                                        <?php endforeach; ?> -->
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kelurahan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="kelurahan" name="kode_kel" required>
                                        <option value="">Pilih Kelurahan</option>
                                        <!-- <?php foreach($kel as $k): ?>
                                            <option value="<?= $k->kode_kel ?>"><?= $k->nama_kel ?></option>
                                        <?php endforeach; ?> -->
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Alamat</label>
                                </div>
                                <div class="col-md-8 form-group mb-3">
                                    <textarea class="form-control" name="alamat" rows="3" required></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label>Longitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="longitude" class="form-control" name="longitude"
                                        placeholder="Longitude" required >
                                </div>

                                <div class="col-md-4">
                                    <label>Latitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="latitude" class="form-control" name="latitude"
                                        placeholder="Latitude" required >
                                </div>

                                <div class="col-md-4">
                                    <label>Jumlah Laki - Laki</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="laki-laki" class="form-control" name="lk"
                                        placeholder="laki-laki" required>
                                </div>

                                <div class="col-md-4">
                                    <label>Jumlah Perempuan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="perempuan" class="form-control" name="pr"
                                        placeholder="perempuan" required>
                                </div>
                                
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div id="map"></div>
        <!-- <div class="btn my-2 dariSini btn-danger">Ambil titik</div> -->
    </div>
</div>
