<!-- COntact -->
<section class="my-5 contact" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 w-100 d-flex justify-content-center justify-content-lg-start">
                <img src="<?= base_url() ?>assets/user/image/kpu-black.png" alt="KPU" class="img-fluid">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h3>SILOKAT</h3>
                <P>Dengan SILOKAT, pemilihan umum atau pemilihan lainnya tidak perlu lagi membingungkan. Aplikasi ini menjadi sahabat setia pengguna dalam menavigasi dunia TPS, memberikan kemudahan, keakuratan, dan kenyamanan dalam mencari dan mengunjungi lokasi TPS.</P>
            </div>
            <div class="col-lg-6">
                <!-- <h3>Contact</h3> -->
            </div>
        </div>
    </div>
</section>
<!-- close COntact -->
<!-- floatting button -->
<div class="floating-button">
    <a href="#header" class="button btn">
        <i class="fas fa-arrow-up"></i>
    </a>
</div>

<!-- close floatting button -->

<!-- footer -->
<footer>
    <i class="fas fa-copyright"></i> 2023 Komisi Pemilihan Umum Provinsi Kalimantan Tengah
</footer>

<!-- close footer -->
<script>
  AOS.init();
</script>
<script src="<?= base_url() ?>assets/user/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>/assets/user/js/leaflet-routing-machine.js"></script>
<script src="<?= base_url() ?>/assets/user/js/Control.Geocoder.js"></script>
<!-- <script src="<?= base_url() ?>/assets/js/leaftlet-user.js"></script>     -->

<script>
    var latLng = [-1.5333, 113.7500];
    var map = L.map('map').setView(latLng, 7);
    layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 21
    }).addTo(map);

    var markers = {}; // Objek untuk menyimpan marker-cluster
    var currentZoom = map.getZoom(); // Menyimpan tingkat zoom saat ini

    // Fungsi untuk mengganti ikon cluster berdasarkan 'kode_kab' pada tingkat zoom 7
    function updateClusterIcons() {
        for (var kodeKab in markers) {
        (function(kodeKab) {
            var cluster = markers[kodeKab].cluster;

            var kabIconUrl = '<?= base_url() ?>/assets/user/image/' + kodeKab + '.png';

            // Hapus ikon yang ada dan tambahkan ikon baru
            cluster.options.iconCreateFunction = function(cluster) {
                return L.divIcon({
                    className: 'cluster-icon',
                    html: '<img src="' + kabIconUrl + '" alt="Cluster Icon" width="35" height="35">' + cluster.getChildCount(),
                    iconSize: [20, 20]
                });
            };

            if (map.getZoom() > 7) {
                map.removeLayer(cluster);
                map.addLayer(markers[kodeKab].singleMarkers);
            } else {
                map.removeLayer(markers[kodeKab].singleMarkers);
                map.addLayer(cluster);
            }
        })(kodeKab);
    }
    }

    // Fungsi untuk memperbarui penanda pada peta
    function updateMarkers() {
        <?php foreach ($map as $data): ?>
            var tpsNumber = '<?= $data->nama_tps ?>';
            var kodeKab = '<?= $data->kode_kab ?>';
            var kabIconUrl = '<?= base_url() ?>/assets/user/image/' + kodeKab + '.png'; // Sesuaikan dengan path ikon kabupaten

            // Buat penanda seperti sebelumnya
            var customIcon = L.divIcon({
                className: 'custom-icon',
                html: '<div class="icon-container"><span class="icon-number">' + tpsNumber + '</span></div>',
                iconSize: [15]
            });

            var lokasi = L.marker([<?= $data->latitude ?>, <?= $data->longitude ?>], {
                icon: customIcon,
                kode_kel: '<?= $data->kode_kel ?>'
            })
                .bindPopup('TPS <?= $data->nama_tps ?> <br> Kelurahan <?= $data->nama_kel ?> <br> <a href="<?= base_url() ?>/home/detail/<?= $data->id_tps ?>" class="btn btn-warning">Detail</a> ');

            // Kelompokkan marker berdasarkan 'kode_kab'
            if (!markers.hasOwnProperty(kodeKab)) {
                markers[kodeKab] = {
                    cluster: L.markerClusterGroup(),
                    singleMarkers: L.layerGroup() // Tambahkan layer group untuk marker individu
                };
            }

            // Tambahkan marker ke kelompok yang sesuai
            markers[kodeKab].cluster.addLayer(lokasi);
            markers[kodeKab].singleMarkers.addLayer(lokasi);
        <?php endforeach; ?>

        // Tambahkan cluster atau marker individu berdasarkan tingkat zoom saat ini
        updateClusterIcons();
    }

    // Panggil fungsi untuk memuat penanda pada awal
    updateMarkers();

    // Tambahkan event listener untuk perubahan tingkat zoom
    map.on('zoomend', function() {
        var newZoom = map.getZoom();
        if (newZoom !== currentZoom) {
            currentZoom = newZoom;
            updateClusterIcons();
        }
    });
    // Tambahkan event listener untuk perubahan pilihan filter
    document.getElementById('kodeKabFilter').addEventListener('change', function() {
        var selectedKodeKab = this.value;

         // Enable or disable kecamatan and kelurahan select forms based on kabupaten selection
        if (selectedKodeKab === '') {
            $("#kodeKecFilter").prop('disabled', true);
            $("#kodeKelFilter").prop('disabled', true);
        } else {
            $("#kodeKecFilter").prop('disabled', false);
            $("#kodeKelFilter").prop('disabled', true);
        }

        for (var kodeKab in markers) {
            if (selectedKodeKab === '' || selectedKodeKab === kodeKab) {
                if (map.getZoom() > 7) {
                    map.addLayer(markers[kodeKab].singleMarkers);
                } else {
                    map.addLayer(markers[kodeKab].cluster);
                }
            } else {
                map.removeLayer(markers[kodeKab].cluster);
                map.removeLayer(markers[kodeKab].singleMarkers);
            }
        }
    });

        // form select kecamatan
        $("#kodeKabFilter").change(function() {
            var id_kabupaten = $(this).val();
            $("#kodeKecFilter").empty();
            $("#kodeKelFilter").empty();

            $.ajax({
                url: "Admin/get_kecamatan_by_kabupaten/" + id_kabupaten,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    // Loop untuk menambahkan opsi Kecamatan
                    for (var i = 0; i < data.length; i++) {
                        $("#kodeKecFilter").append('<option value="' + data[i].kode_kec + '">' + data[i].nama_kec + '</option>');
                    }
                }
            });
        });

        // form select kelurahan
        $("#kodeKecFilter").change(function() {
            var id_kecamatan = $(this).val();
            $("#kodeKelFilter").empty();
            $("#kodeKelFilter").prop('disabled', false);

            $.ajax({
                url: "Admin/get_kelurahan_by_kecamatan/" + id_kecamatan,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    // Loop untuk menambahkan opsi Kelurahan
                    for (var i = 0; i < data.length; i++) {
                        $("#kodeKelFilter").append('<option value="' + data[i].kode_kel + '">' + data[i].nama_kel + '</option>');
                    }
                }
            });
        });

        // Tambahkan event listener untuk perubahan pilihan filter kelurahan
    $("#kodeKelFilter").change(function() {
        var id_kelurahan = $(this).val();

        // Hapus semua marker individu yang ada pada peta
        map.eachLayer(function(layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        // Tampung marker yang sesuai dengan filter kelurahan
        var filteredMarkers = [];

        // Loop melalui data untuk menampilkan marker individu berdasarkan filter kelurahan
        for (var kodeKab in markers) {
            var markerGroup = markers[kodeKab].singleMarkers;
            markerGroup.eachLayer(function(marker) {
                var kelurahanKode = marker.options.kode_kel;
                if (id_kelurahan === '' || id_kelurahan === kelurahanKode) {
                    filteredMarkers.push(marker);
                }
            });
        }

        // Tambahkan marker yang sesuai kembali ke peta
        for (var i = 0; i < filteredMarkers.length; i++) {
            map.addLayer(filteredMarkers[i]);
        }

        // Lakukan zoom ke lokasi marker yang ada dengan filter kelurahan yang dipilih
        if (filteredMarkers.length > 0) {
            var bounds = new L.LatLngBounds(filteredMarkers.map(function(marker) {
                return marker.getLatLng();
            }));
            map.fitBounds(bounds);
        }
    });

</script>


<script>
    var lat = '<?= $detail->latitude ?>'
    var long = '<?= $detail->longitude ?>'
    var latLng = [lat, long];
    let centerMap = false;
    var map = L.map('detail-map').setView(latLng, 15);
    // var geocodeService = L.esri.Geocoding.geocodeService();
    layer  = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        attributionControl: false
    }).addTo(map);

        var tpsNumber = '<?= $detail->nama_tps ?>';

        var customIcon = L.divIcon({
            className: 'custom-icon',
            html: '<div class="icon-container"><span class="icon-number">TPS : ' + tpsNumber + '</span></div>',
            iconSize: [60, 50]
        });

        var tujuanMarker = L.marker([<?= $detail->latitude ?>, <?= $detail->longitude ?>], {icon: customIcon})
            .bindPopup('TPS <?= $detail->nama_tps ?> <br> Kelurahan <?= $detail->kode_kel ?>  <br> <button class="btn btn-info keSini" data-lat="'+<?= $detail->latitude ?>+'" data-lng="'+<?= $detail->longitude ?>+'">Kesini</button>')
            .addTo(map)
    

            // ambil titik
        setInterval(()=> {
            getLocation();
        }, 3000);
        function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        $("[name=latNow]").val(position.coords.latitude);
        $("[name=lngNow]").val(position.coords.longitude);
        let latLng=[position.coords.latitude,position.coords.longitude];
            control.spliceWaypoints(0, 1, latLng);
            if(centerMap == false){
                map.panTo(latLng);
                centerMap=false;
            }
    }
    
    // routing machine
    var control = L.Routing.control({
            waypoints: [
                latLng
            ],
            geocoder: L.Control.Geocoder.nominatim(),
            routeWhileDragging :true,
            reverseWaypoints:true,
            showAlternative:true,
            altLineOptions:{
                styles:[
                    {color:'black', opacity:0.15, weight:9},
                    {color:'white', opacity:0.8, weight:6},
                    {color:'blue', opacity:0.5, weight:2}
                ]
            },
        })
        control.addTo(map);

        $(document).on("click", ".keSini", function(){
            let latLng = [$(this).data('lat'), $(this).data('lng')];
            control.spliceWaypoints(control.getWaypoints().length - 1, 1, latLng);
            
            // Menutup popup pada marker tujuan
            tujuanMarker.closePopup();

            // Perbarui zoom peta untuk memuat kedua titik awal dan tujuan rute
            var bounds = L.latLngBounds(latLng, control.getWaypoints()[0].latLng);
            map.fitBounds(bounds);
        });

        

        // Fungsi untuk menentukan rute dari titik awal ke tujuanMarker
        function routeFromCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var currentLatLng = [position.coords.latitude, position.coords.longitude];
                    var tujuanLatLng = tujuanMarker.getLatLng(); // Ganti 'tujuanMarker' dengan variabel yang sesuai

                    // Mengganti titik awal dengan titik geolokasi saat ini
                    control.spliceWaypoints(0, 1, currentLatLng);

                    // Mengganti titik tujuan dengan tujuanMarker
                    control.spliceWaypoints(1, 1, tujuanLatLng);

                    // Fokus peta pada lokasi pengguna (titik awal)
                    map.setView(currentLatLng, 18); // Ganti 'zoomLevel' dengan level zoom yang diinginkan
                });
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }

        $(document).on("click", ".dariSini", function(){
            routeFromCurrentLocation();
        });
</script>

</body>
</html>