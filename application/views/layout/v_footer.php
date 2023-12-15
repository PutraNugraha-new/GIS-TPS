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
                <P>Dengan SILOKAT, pemilih tidak perlu lagi bingung. Aplikasi ini menjadi sahabat setia pengguna dalam menavigasi dunia TPS, memberikan kemudahan, keakuratan, dan kenyamanan dalam mencari dan mengunjungi lokasi TPS.</P>
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
<script src="<?= base_url() ?>assets/user/js/bootstrap.bundle.min.js" integrity="" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>/assets/user/js/leaflet-routing-machine.js"></script>
<script src="<?= base_url() ?>/assets/user/js/Control.Geocoder.js"></script>
<!-- <script src="<?= base_url() ?>/assets/js/leaftlet-user.js"></script>     -->
<script>
    $(document).ready(function(){
        // Sembunyikan loader setelah halaman sepenuhnya dimuat
        $('#loader').fadeOut('slow');
    });
</script>
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

        function filterMarkersByKelurahanAndNumber(kelurahan, tpsNumber) {
            filteredMarkers = [];

            for (var kodeKab in markers) {
                markers[kodeKab].singleMarkers.eachLayer(function(marker) {
                    var markerKelurahan = marker.options.kode_kel;
                    var markerTpsNumber = marker.options.nama_tps ? marker.options.nama_tps.toString() : '';

                    if ((kelurahan === '' || kelurahan === markerKelurahan) &&
                        (tpsNumber === '' || markerTpsNumber === tpsNumber)) {
                        marker.addTo(map);
                        filteredMarkers.push(marker); // Tambahkan marker yang cocok ke dalam filteredMarkers
                    } else {
                        map.removeLayer(marker);
                    }
                });
            }
        }


        var latLng = [-1.9673044045635462, 113.74932199263436];
        var map = L.map('map').setView(latLng, 6);
        layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 21
        }).addTo(map);

        var markers = {}; // Objek untuk menyimpan marker-cluster
        var currentZoom = map.getZoom(); // Menyimpan tingkat zoom saat ini
        var kecamatanMarkers = {};
        var filteredMarkers = [];

         // Fungsi untuk mengganti ikon cluster berdasarkan 'kode_kab' pada tingkat zoom 7
    function updateClusterIcons() {
        for (var kodeKab in markers) {
            (function(kodeKab) {
                var kabCluster = markers[kodeKab].cluster;
                var kecamatanCluster = markers[kodeKab].kecamatanCluster;

                var kabIconUrl = '<?= base_url() ?>/assets/user/image/' + kodeKab + '.png';

                // Hapus ikon yang ada dan tambahkan ikon baru untuk cluster kabupaten
                kabCluster.options.iconCreateFunction = function(cluster) {
                    return L.divIcon({
                        className: 'cluster-icon',
                        html: '<img src="' + kabIconUrl + '" alt="Cluster Icon" width="35" height="30">',
                        iconSize: [25, 10]
                        // html: '<img src="' + kabIconUrl + '" alt="Cluster Icon" width="35" height="30">' + cluster.getChildCount(),
                        // iconSize: [25, 10]
                    });
                };

                // Hapus ikon yang ada dan tambahkan ikon baru untuk cluster kecamatan
                kecamatanCluster.options.iconCreateFunction = function(cluster) {
                    var kecamatanName = cluster.getAllChildMarkers()[0].options.kecamatanName;
                    return L.divIcon({
                        className: 'kecamatan-cluster-icon',
                        html: '<div class="kecamatan-name">Kec. ' + kecamatanName + '</div>',
                        iconSize: [100, 30] // Sesuaikan ukuran ikon
                    });
                };

                // Ganti kode berikut sesuai kebutuhan Anda
                if (map.getZoom() > 7) { // Ubah kondisi menjadi lebih dari 7
                    map.removeLayer(kabCluster);
                    map.addLayer(kecamatanCluster);
                    map.removeLayer(markers[kodeKab].singleMarkers);
                } else {
                    map.addLayer(kabCluster);
                    map.removeLayer(kecamatanCluster);
                    map.removeLayer(markers[kodeKab].singleMarkers);
                }

            })(kodeKab);
        }
    }


        // Fungsi untuk memperbarui penanda pada peta
        function updateMarkersWithData(data) {
            // Hapus marker yang ada
            for (var kodeKab in markers) {
                map.removeLayer(markers[kodeKab].cluster);
                map.removeLayer(markers[kodeKab].kecamatanCluster);
                map.removeLayer(markers[kodeKab].singleMarkers);
            }

            // Reset markers
            markers = {};

            // Iterasi data yang diterima dari server
            data.forEach(function (item) {
                var tpsNumber = item.nama_tps;
                var kodeKab = item.kode_kab;
                var kodeKec = item.kode_kec;
                var kodeKel = item.kode_kel;
                var kabIconUrl = '<?= base_url() ?>/assets/user/image/' + kodeKab + '.png'; // Sesuaikan dengan path ikon kabupaten

                var latitude = item.latitude;
                var longitude = item.longitude;
                var formattedCoordinates = formatCoordinates(latitude, longitude);

                var formattedLatitude = parseFloat(formattedCoordinates.formattedLatitude); // Konversi ke angka
                var formattedLongitude = parseFloat(formattedCoordinates.formattedLongitude);

                // Buat penanda seperti sebelumnya
                var customIcon = L.divIcon({
                    className: 'custom-icon',
                    html: '<div class="icon-container"><span class="icon-number">' + tpsNumber + '</span></div>',
                    iconSize: [15]
                });

                var popupContent = `
                    <strong> TPS ${tpsNumber}</strong>
                    <br>
                    <strong> Kecamatan</strong> ${item.nama_kec}
                    <br>
                    <strong> Kelurahan</strong> ${item.nama_kel}
                    <br>
                    <strong> Alamat</strong> ${item.alamat}
                    <br>
                    <a href="https://www.google.com/maps/search/?api=1&query=${item.latitude},${item.longitude}" target="_blank">Jelajahi TPS</a>`;

                var lokasi = L.marker([formattedLatitude, formattedLongitude], {
                    icon: customIcon,
                    nama_tps: item.nama_tps,
                    kode_kel: item.kode_kel,
                    kode_kec: item.kode_kec,
                    kecamatanName: item.nama_kec
                }).bindPopup(popupContent);

                // Kelompokkan marker kecamatan di bawah cluster kabupaten yang sesuai
                if (!markers.hasOwnProperty(kodeKab)) {
                    markers[kodeKab] = {
                        cluster: L.markerClusterGroup(),
                        singleMarkers: L.layerGroup() // Tambahkan layer group untuk marker individu
                    };
                }
                if (!markers[kodeKab].kecamatanCluster) {
                    markers[kodeKab].kecamatanCluster = L.markerClusterGroup(); // Tambahkan cluster khusus kecamatan
                }

                // Pastikan kode kecamatan ada sebelum menambahkan marker ke cluster kecamatan
                if (kodeKec) {
                    markers[kodeKab].kecamatanCluster.addLayer(lokasi); // Tambahkan marker ke cluster kecamatan
                } else {
                    markers[kodeKab].cluster.addLayer(lokasi); // Tambahkan marker ke cluster kabupaten
                }
                // Tambahkan marker ke kelompok yang sesuai
                markers[kodeKab].cluster.addLayer(lokasi);
                markers[kodeKab].singleMarkers.addLayer(lokasi);
                markers[kodeKab].kecamatanCluster.addLayer(lokasi);
            });

            // Tambahkan cluster atau marker individu berdasarkan tingkat zoom saat ini
            updateClusterIcons();
        }
        function loadDataWithAjax() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Tanggapi data dan perbarui tampilan
                    var data = JSON.parse(this.responseText);
                    updateMarkersWithData(data);
                }
            };

            // Lakukan permintaan Ajax ke file PHP yang menangani data
            xhr.open('GET', '<?= base_url("home/getMarkers") ?>', true);
            xhr.send();
        }

        // Panggil fungsi untuk memuat data pada awal
        loadDataWithAjax();

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
            $("#tpsNameFilter").prop('disabled', true);
        } else {
            $("#kodeKecFilter").prop('disabled', false);
            $("#kodeKelFilter").prop('disabled', true);
        }

        for (var kodeKab in markers) {
            if (selectedKodeKab === '' || selectedKodeKab === kodeKab) {
                // if (map.getZoom() > 10 ) {
                //     map.addLayer(markers[kodeKab].singleMarkers);
                // } else {
                //     map.addLayer(markers[kodeKab].cluster);
                // }
                if(map.getZoom() < 8){
                    map.addLayer(markers[kodeKab].cluster);
                }
            } else {
                map.removeLayer(markers[kodeKab].cluster);
                map.removeLayer(markers[kodeKab].singleMarkers);
            }
        }
    });

    var typingTimer;
    var doneTypingInterval = 1000; // Menunggu 1 detik setelah pengguna selesai menginputkan

    document.getElementById('tpsNameFilter').addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    // Fungsi yang akan dipanggil setelah selesai menginputkan
    function doneTyping() {
        var selectedKelurahan = document.getElementById('kodeKelFilter').value;
        var tpsNumber = document.getElementById('tpsNameFilter').value;

        filterMarkersByKelurahanAndNumber(selectedKelurahan, tpsNumber);

        // Lakukan zoom ke lokasi marker yang cocok jika ada
        if (filteredMarkers.length > 0) {
            var bounds = new L.LatLngBounds(filteredMarkers.map(function(marker) {
                return marker.getLatLng();
            }));
            map.fitBounds(bounds);
        }
    }




        // form select kecamatan
        $("#kodeKabFilter").change(function() {
            var id_kabupaten = $(this).val();
            $("#kodeKecFilter").empty();
            $("#kodeKelFilter").empty();
            $("#tpsNameFilter").empty();
            $("#kodeKecFilter").append('<option>-- Pilih Kecamatan --</option>');
            $("#kodeKelFilter").append('<option>-- Pilih Kelurahan --</option>');

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
            $("#kodeKelFilter").append('<option>-- Pilih Kelurahan --</option>');
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

        $("#kodeKelFilter").change(function() {
            var id_kelurahan = $(this).val();
            $("#tpsNameFilter").prop('disabled', false);

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


</body>
</html>