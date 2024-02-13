<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                <?php
                $atribut = 'class="form form-horizontal"';
                echo form_open_multipart('admin/update/'.$map->id_tps, $atribut);
                ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Nomor TPS</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="hidden" id="id_tps" class="form-control" name="id_tps"
                                        placeholder="id TPS" value="<?= $map->id_tps ?>">
                                    <input type="number" id="no_tps" class="form-control" name="nama_tps"
                                        placeholder="Nomor TPS" value="<?= $map->nama_tps ?>" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kabupaten</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="edit_kabupaten" name="kode_kab"  required>
                                        <option value="<?= $map->kode_kab ?>"><?= $map->nama_kab ?></option>
                                        <?php foreach($kab as $k): ?>
                                            <option value="<?= $k->kode_kab ?>"><?= $k->nama_kab ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kecamatan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="edit_kecamatan" name="kode_kec" readonly required>
                                        <option value="<?= $map->kode_kec ?>"><?= $map->nama_kec ?></option>
                                        <!-- <?php foreach($kec as $k): ?>
                                            <option value="<?= $k->kode_kec ?>"><?= $k->nama_kec ?></option>
                                        <?php endforeach; ?> -->
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kelurahan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="edit_kelurahan" name="kode_kel" readonly required>
                                        <option value="<?= $map->kode_kel ?>"><?= $map->nama_kel ?></option>
                                        <!-- <?php foreach($kel as $k): ?>
                                            <option value="<?= $k->kode_kel ?>"><?= $k->nama_kel ?></option>
                                        <?php endforeach; ?> -->
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Alamat</label>
                                </div>
                                <div class="col-md-8 form-group mb-3">
                                    <textarea class="form-control" name="alamat" rows="3" required><?= $map->alamat ?></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label>Latitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="lat" class="form-control" name="latitude"
                                        placeholder="Latitude" required value="<?= $map->latitude ?>">
                                </div>

                                <div class="col-md-4">
                                    <label>Longitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="long" class="form-control" name="longitude"
                                        placeholder="Longitude" required value="<?= $map->longitude ?>">
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
        <div id="edit-map"></div>
        <!-- <div class="btn my-2 dariSini btn-danger">Ambil titik</div> -->
    </div>
</div>
<script>
    // Fungsi format koordinat
    function formatCoordinates(latitude, longitude) {
        const validLatitudePattern = /^-?\d+\.\d+$/;
        const validLongitudePattern = /^-?\d+\.\d+$/;

        if (validLatitudePattern.test(latitude) && validLongitudePattern.test(longitude)) {
            return {
                formattedLatitude: latitude,
                formattedLongitude: longitude
            };
        }

        const cleanLatitude = latitude.replace(/[^0-9.-]/g, '');
        const cleanLongitude = longitude.replace(/[^0-9.-]/g, '');

        let formattedLatitude = `${cleanLatitude.charAt(0) === '-' ? '-' : ''}${cleanLatitude.charAt(1)}.${cleanLatitude.slice(2, 9)}`;
        let formattedLongitude = `${cleanLongitude.charAt(0)}${cleanLongitude.charAt(1)}${cleanLongitude.charAt(2)}.${cleanLongitude.slice(3)}`;

        if (!validLatitudePattern.test(formattedLatitude)) {
            formattedLatitude = latitude;
        }

        if (!validLongitudePattern.test(formattedLongitude)) {
            formattedLongitude = longitude;
        }

        return {
            formattedLatitude,
            formattedLongitude
        };
    }

    // Mendapatkan nilai input latitude dan longitude
    var latInput = document.getElementById("lat");
    var lngInput = document.getElementById("long");

    // Mendapatkan nilai latitude dan longitude dari input
    var lat = latInput.value;
    var long = lngInput.value;
    var formattedCoordinates = formatCoordinates(lat, long);
    var formattedLatitude = parseFloat(formattedCoordinates.formattedLatitude);
    var formattedLongitude = parseFloat(formattedCoordinates.formattedLongitude);

    // Inisialisasi peta pada div dengan id "edit-map"
    var mapp = L.map('edit-map').setView([formattedLatitude, formattedLongitude], 15);
    var layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        attributionControl: false
    }).addTo(mapp);

    // Menambahkan marker awal ke peta
    var marker = L.marker([formattedLatitude, formattedLongitude]).addTo(mapp);

    // Event listener untuk menangkap klik pada peta
    mapp.on('click', function(e) {
        var lat = e.latlng.lat; // Dapatkan latitude dari titik yang diklik
        var lng = e.latlng.lng; // Dapatkan longitude dari titik yang diklik

        // Memperbarui marker pada peta
        marker.setLatLng(e.latlng);

        // Memperbarui nilai input latitude dan longitude
        latInput.value = lat;
        lngInput.value = lng;
    });


    
        // form select kecamatan
        $("#edit_kabupaten").change(function() {
                var id_kabupaten = $(this).val();
                $("#edit_kecamatan").empty();
                $("#edit_kelurahan").empty();
                $("#edit_kecamatan").append('<option>-- Pilih Kecamatan -- </option>');
                $("#edit_kelurahan").append('<option>-- Pilih Kelurahan -- </option>');
                $("#edit_kecamatan").prop('readonly', false);

                $.ajax({
                    url: "<?= base_url('Admin/get_kecamatan_by_kabupaten/'); ?>" + id_kabupaten,
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        // Loop untuk menambahkan opsi Kecamatan
                        for (var i = 0; i < data.length; i++) {
                            $("#edit_kecamatan").append('<option value="' + data[i].kode_kec + '">' + data[i].nama_kec + '</option>');
                        }
                    }
                });
            });

        $("#edit_kecamatan").change(function() {
            var id_kecamatan = $(this).val();
            $("#edit_kelurahan").empty();
            $("#edit_kelurahan").append('<option>-- Pilih Kelurahan -- </option>');
            $("#edit_kelurahan").prop('readonly', false);

            $.ajax({
                url: "<?= base_url('Admin/get_kelurahan_by_kecamatan/') ?>" + id_kecamatan,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    // Loop untuk menambahkan opsi Kelurahan
                    for (var i = 0; i < data.length; i++) {
                        $("#edit_kelurahan").append('<option value="' + data[i].kode_kel + '">' + data[i].nama_kel + '</option>');
                    }
                }
            });
        });
</script>
