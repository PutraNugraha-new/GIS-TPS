<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Nomor TPS</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="no_tps" class="form-control" name="nama_tps"
                                        placeholder="Nomor TPS" value="<?= $map->nama_tps ?>" readonly>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kabupaten</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="edit_kabupaten" name="kode_kab"  disabled>
                                        <option value="<?= $map->kode_kab ?>"><?= $map->nama_kab ?></option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kecamatan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="edit_kecamatan" name="kode_kec"  disabled>
                                        <option value="<?= $map->kode_kec ?>"><?= $map->nama_kec ?></option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Kelurahan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="choices form-select" id="edit_kelurahan" name="kode_kel"  disabled>
                                        <option value="<?= $map->kode_kel ?>"><?= $map->nama_kel ?></option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Alamat</label>
                                </div>
                                <div class="col-md-8 form-group mb-3">
                                    <textarea class="form-control" name="alamat" rows="3" readonly><?= $map->alamat ?></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label>Latitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="lat" class="form-control" name="latitude"
                                        placeholder="Latitude" readonly value="<?= $map->latitude ?>">
                                </div>

                                <div class="col-md-4">
                                    <label>Longitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="long" class="form-control" name="longitude"
                                        placeholder="Longitude" readonly value="<?= $map->longitude ?>">
                                </div>
                            </div>
                        </div>
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
    function formatCoordinates(latitude, longitude) {
        // Pengecekan apakah koordinat sudah dalam format yang benar
        const validLatitudePattern = /^-?\d+\.\d+$/;
        const validLongitudePattern = /^-?\d+\.\d+$/; // Updated pattern to allow negative longitude

        if (validLatitudePattern.test(latitude) && validLongitudePattern.test(longitude)) {
            return {
                formattedLatitude: latitude,
                formattedLongitude: longitude
            };
        }

        // Jika koordinat perlu diformat
        const cleanLatitude = latitude.replace(/[^0-9.-]/g, '');
        const cleanLongitude = longitude.replace(/[^0-9.-]/g, '');

        let formattedLatitude = `${cleanLatitude.charAt(0) === '-' ? '-' : ''}${cleanLatitude.charAt(1)}.${cleanLatitude.slice(2, 9)}`;
        let formattedLongitude = `${cleanLongitude.charAt(0)}${cleanLongitude.charAt(1)}${cleanLongitude.charAt(2)}.${cleanLongitude.slice(3)}`;

        // Tambahan: Perbaikan jika hanya salah satu koordinat yang valid
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
        var lat = document.getElementById("lat").value;
        var long = document.getElementById("long").value;
        var formattedCoordinates = formatCoordinates(lat, long);
        var formattedLatitude = parseFloat(formattedCoordinates.formattedLatitude); // Konversi ke angka
        var formattedLongitude = parseFloat(formattedCoordinates.formattedLongitude);

        var latlong = [lat,long];
        var mapp = L.map('edit-map').setView([formattedLatitude, formattedLongitude], 15);
                layer  = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    attributionControl: false
                }).addTo(mapp);

                L.marker([formattedLatitude, formattedLongitude]).addTo(mapp)
        
        // form select kecamatan
        $("#edit_kabupaten").change(function() {
                var id_kabupaten = $(this).val();
                $("#edit_kecamatan").empty();
                $("#edit_kelurahan").empty();
                $("#edit_kecamatan").append('<option>-- Pilih Kecamatan -- </option>');
                $("#edit_kelurahan").append('<option>-- Pilih Kelurahan -- </option>');
                $("#edit_kecamatan").prop('disabled', false);

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
            $("#edit_kelurahan").prop('disabled', false);

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
