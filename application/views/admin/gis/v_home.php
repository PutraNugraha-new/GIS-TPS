<?php if ($this->session->flashdata('sukses')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('sukses'); ?>
    </div>
<?php endif; ?>
<div class="card">
    <div class="card-body">
    <div class="row">
    <div class="col-md-12">
        <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <a href="admin/tambah" class="btn btn-warning my-1">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Data
                        </a>
                        <a href="#" class="btn btn-success importCsv" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i>
                            Import Data
                        </a>
                        <!-- <a href="admin/unduh_file/template-excel.xlsx" class="btn btn-info my-1">
                        <i class="bi bi-file-earmark-arrow-down-fill"></i>
                            Download Template Excel
                        </a> -->
                    </div>
                    <!-- <div class="col-md-3">
                        <select class="form-select" name="kabupaten" id="kabupaten">
                            <option value="">Pilih Kabupaten</option>
                            <?php foreach($kab as $k): ?>
                                <option value="<?= $k->kode_kab ?>"><?= $k->nama_kab ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->
                    <!-- <div class="col-md-3">
                        <select class="form-select" name="kode_kec" id="kecamatan" disabled="true">
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="kode_kel" id="kelurahan" disabled>
                            <option value="">-- Pilih Kelurahan --</option>
                        </select>
                    </div> -->
                </div>
                    
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <!-- <th>Kabupaten/kota</th>
                                <th>Kecamatan</th> -->
                                <th>Kelurahan/desa</th>
                                <th>Nomor Tps</th>
                                <th>Alamat</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="small-font">
                            <?php foreach($map as $data): ?>
                                <tr>
                                    <!-- <td><?= $data->nama_kab ?></td>
                                    <td><?= $data->nama_kec ?></td> -->
                                    <td><?= $data->nama_kel ?></td>
                                    <td><?= $data->nama_tps ?></td>
                                    <td><?= $data->alamat ?></td>
                                    <td><?= $data->latitude ?></td>
                                    <td><?= $data->longitude ?></td>
                                    <td>
                                        <a href="admin/edit/<?= $data->id_tps ?>" >
                                            <span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span>
                                        </a>
                                        <a href="admin/detail/<?= $data->id_tps ?>" >
                                            <span class="badge bg-success mb-2"><i class="bi bi-eye"></i></span>
                                        </a>
                                        <a href="admin/hapus/<?= $data->id_tps ?>" id="tombolHapus" onclick="return confirm('yakin?')">
                                            <span class="badge bg-danger"><i class="bi bi-trash"></i></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            <form action="admin/importData" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row" id="defaultContent">
                            <div class="col-md-4">
                                <label>Import Data</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="file" class="form-control"id="mentahTPS" name="mentahTPS" accept=".xlsx, .xls">
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-1 mb-1 btnImport">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    // Tangkap perubahan pada dropdown select
        $('#kabupaten').change(function () {
            // Ambil nilai yang dipilih dari select box
            var selectedKabupaten = $(this).val();

            // Kirim permintaan AJAX hanya jika ada kabupaten yang dipilih
            if (selectedKabupaten !== '') {
                // Kirim permintaan AJAX
                $.ajax({
                    url: 'Admin/getTpsByKabupaten/',
                    type: 'POST',
                    data: { kabupaten: selectedKabupaten },
                    dataType: 'json',
                    success: function (response) {
                        // Mengganti isi tabel dengan hasil dari AJAX
                        var tpsData = response.tpsData;
                        $('#table1 tbody').empty();
                        // Mengisi tabel dengan data TPS
                        for (var i = 0; i < tpsData.length; i++) {
                            var data = tpsData[i];
                            var row = '<tr>' +
                                '<td class="small-font">' + data.nama_kab + '</td>' +
                                '<td class="small-font">' + data.nama_kec + '</td>' +
                                '<td class="small-font">' + data.nama_kel + '</td>' +
                                '<td class="small-font">' + data.nama_tps + '</td>' +
                                '<td class="small-font">' + data.alamat + '</td>' +
                                '<td class="small-font">' + data.latitude + '</td>' +
                                '<td class="small-font"' + data.longitude + '</td>' +
                                '<td class="small-font">' +
                                '<a href="admin/edit/' + data.id_tps + '">' +
                                '<span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span>' +
                                '</a>' +
                                '<a href="admin/hapus/' + data.id_tps + '" onClick="confirm(\'ingin Menghapus?\')">' +
                                '<span class="badge bg-danger"><i class="bi bi-trash"></i></span>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';

                            $('#table1 tbody').append(row);
                        }
                        console.log(response);
                    }
                });
            }
        });
    });
</script>