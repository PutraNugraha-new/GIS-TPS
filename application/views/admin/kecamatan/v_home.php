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
                            <div class="col-md-3 my-2">
                                <button type="button" class="btn btn-tambah btn-warning" data-bs-toggle="modal" data-bs-target="#modalKecamatan">
                                <i class="bi bi-plus-circle"></i>
                                    Tambah Data
                                </button>
                            </div>
                            <!-- <div class="col-md-3">
                                <select class="form-select" name="kabupaten" id="kabupaten">
                                    <option value="">Pilih Kabupaten</option>
                                    <?php foreach($kab as $k): ?>
                                        <option value="<?= $k->kode_kab ?>"><?= $k->nama_kab ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> -->
                        </div>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Kode kecamatan</th>
                                        <th>Nama kecamatan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($kec as $data): ?>
                                        <tr>
                                            <td><?= $data->kode_kec ?></td>
                                            <td><?= $data->nama_kec ?></td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" data-id="<?= $data->kode_kec ?>" data-bs-target="#modalKecamatan" class="tampilModalUbah">
                                                    <span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span>
                                                </a>
                                                <a href="kecamatan/hapus/<?= $data->kode_kec ?>" onclick="return confirm('ingin Menghapus?')">
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
<div class="modal fade" id="modalKecamatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah kecamatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="kecamatan/add" class="form form-horizontal" method="POST">
                        <div class="form-body">
                            <div class="row">
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
                                    <label>Kode kecamatan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="kode_kec" class="form-control" name="kode_kec"
                                        placeholder="Kode kecamatan" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Nama kecamatan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="nama_kec" class="form-control" name="nama_kec"
                                            placeholder="Nama kecamatan" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-tambah').on('click', function() {
            const id = $(this).data('id');
            $('#exampleModalLabel').html('Tambah Data Kecamatan');
            $('.modal-body form').attr('action', 'kecamatan/add');
            $('#kabupaten').val('');
            $('#nama_kec').val('');
            $('#kode_kec').val('');
        });
        $('.tampilModalUbah').on('click', function() {
            const id = $(this).data('id');
            $('#exampleModalLabel').html('Ubah Data');
            $('.modal-body form').attr('action', 'kecamatan/update/'+id);

            $.ajax({
                url: 'kecamatan/edit',
                data: {id : id},
                method: 'post',
                dataType:'json',
                success:function(data){
                    $('#nama_kec').empty();
                    $('#kode_kec').empty();
                    $('#kabupaten').val(data.kode_kab);
                    $('#kode_kec').val(data.kode_kec);
                    $('#nama_kec').val(data.nama_kec);
                    $('#kode_kec').prop('readonly', true)
                    $('#kabupaten').prop('readonly', true)
                }
            });
        });
    });
</script>
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
                    url: 'Kecamatan/getTpsByKabupaten/',
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
                                '<td class="small-font">' + data.kode_kec + '</td>' +
                                '<td class="small-font">' + data.nama_kec + '</td>' +
                                '<td class="small-font">' +
                                // ' <a href="#" data-bs-toggle="modal" data-id="'+data.kode_kec+'" data-bs-target="#modalKecamatan" class="tampilModalUbah"><span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span></a>' +
                                '<a href="admin/hapus/' + data.kode_kec + '" onClick="confirm(\'ingin Menghapus?\')">' +
                                '<span class="badge bg-danger"><i class="bi bi-trash"></i></span>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';

                            $('#table1 tbody').append(row);
                        }
                    }
                });
            }
        });
    });

</script>