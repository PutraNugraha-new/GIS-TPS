</div>
        </div>
    </section>
</div>

            <footer>
                <div class="footer mb-0 text-muted ">
                    <div class="d-flex justify-content-center">
                        <p><?= date('Y') ?> &copy; Admin</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= base_url() ?>/assets/js/bootstrap.js"></script>
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script src="<?= base_url() ?>/assets/user/js/leaflet-routing-machine.js"></script>
    <script src="<?= base_url() ?>/assets/user/js/Control.Geocoder.js"></script>
    <script src="<?= base_url() ?>/assets/js/leaflet.js"></script>
    <script src="<?= base_url() ?>/assets/extensions/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/sweetAlert.js"></script>

    <script src="<?= base_url() ?>/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="<?= base_url() ?>/assets/js/pages/simple-datatables.js"></script>
    <script src="<?= base_url() ?>/assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.js"></script>

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
        control.addTo(map);
        
</script>
</body>

</html>
