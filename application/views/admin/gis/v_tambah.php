<?php if ($this->session->flashdata('flash_message')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('flash_message'); ?>
    </div>
<?php endif; ?>
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
                                    <label>Latitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="latitude" class="form-control" name="latitude"
                                        placeholder="Latitude" required >
                                </div>

                                <div class="col-md-4">
                                    <label>Longitude</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="longitude" class="form-control" name="longitude"
                                        placeholder="Longitude" required >
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
<script src="<?= base_url() ?>/assets/user/js/leaflet-routing-machine.js"></script>
    <script src="<?= base_url() ?>/assets/user/js/Control.Geocoder.js"></script>
    <script src="<?= base_url() ?>/assets/js/leaflet.js"></script>
    <script>
        var centerMap = false;
        $(document).ready(function() {
            $("#kabupaten").change(function() {
                var id_kabupaten = $(this).val();
                $("#kecamatan").empty();
                $("#kelurahan").empty();
                $("#kecamatan").append('<option>-- Pilih Kecamatan -- </option>');
                $("#kelurahan").append('<option>-- Pilih Kelurahan -- </option>');
                $("#kecamatan").prop('disabled', false);

                $.ajax({
                    url: "<?= base_url('Admin/get_kecamatan_by_kabupaten/'); ?>" + id_kabupaten,
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        // Loop untuk menambahkan opsi Kecamatan
                        for (var i = 0; i < data.length; i++) {
                            $("#kecamatan").append('<option value="' + data[i].kode_kec + '">' + data[i].nama_kec + '</option>');
                        }
                    }
                });
            });

        $("#kecamatan").change(function() {
            var id_kecamatan = $(this).val();
            $("#kelurahan").empty();
            $("#kelurahan").append('<option>-- Pilih Kelurahan -- </option>');
            $("#kelurahan").prop('disabled', false);

            $.ajax({
                url: "<?= base_url('Admin/get_kelurahan_by_kecamatan/') ?>" + id_kecamatan,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    // Loop untuk menambahkan opsi Kelurahan
                    for (var i = 0; i < data.length; i++) {
                        $("#kelurahan").append('<option value="' + data[i].kode_kel + '">' + data[i].nama_kel + '</option>');
                    }
                }
            });
        });
    }); 

    // $.ajax({
    //         url : "https://nominatim.openstreetmap.org/reverse",
    //         data:"lat="+lat+
    //             "&lon="+lng+
    //             "&format=json",
    //         dataType:"JSON",
    //         success:function(data){
    //             console.log(data)
    //             // alamatInput.value = data.display_name;
    //         }
    //     })


        getLocation();
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            $("[id=latitude]").val(position.coords.latitude);
            $("[id=longitude]").val(position.coords.longitude);
            let latLng=[position.coords.latitude,position.coords.longitude];
                control.spliceWaypoints(0, 1, latLng);
                if(centerMap == false){
                    map.panTo(latLng);
                    centerMap=true;
                }
        }
        
        // routing machine
        var control = L.Routing.control({
            waypoints: [
                latLng
            ],
            geocoder: L.Control.Geocoder.nominatim({
                geocodingQueryParams: {
                    format: 'json', // Format respons yang diharapkan
                    addressdetails: 1
                },
                geocodingUrl: 'https://nominatim.openstreetmap.org/reverse', // URL Nominatim Anda
            }),
            routeWhileDragging: true,
            reverseWaypoints: true,
            showAlternative: true,
            altLineOptions: {
                styles: [
                    { color: 'black', opacity: 0.15, weight: 9 },
                    { color: 'white', opacity: 0.8, weight: 6 },
                    { color: 'blue', opacity: 0.5, weight: 2 }
                ]
            },
        });
        // control.addTo(map);
        
</script>