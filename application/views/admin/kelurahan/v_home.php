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
                            <div class="col-md-3">
                                <button type="button" class="btn btn-tambah btn-warning" data-bs-toggle="modal" data-bs-target="#modalKelurahan">
                                <i class="bi bi-plus-circle"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Kode Kelurahan</th>
                                        <th>Nama Kelurahan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($kec as $data): ?>
                                        <tr>
                                            <td><?= $data->kode_kel ?></td>
                                            <td><?= $data->nama_kel ?></td>
                                            <td>
                                                <!-- <a href="#" data-bs-toggle="modal" data-id="<?= $data->kode_kel ?>" data-bs-target="#modalKelurahan" class="tampilModalUbah">
                                                    <span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span>
                                                </a> -->
                                                <a href="kelurahan/hapus/<?= $data->kode_kel ?>" onclick="return confirm('ingin Menghapus?')">
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
<div class="modal fade" id="modalKelurahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kelurahan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php
                $atribut = 'class="form form-horizontal"';
                echo form_open_multipart('kelurahan/add', $atribut);
                ?>
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
                                    <label>Kode kelurahan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="kode_kel" class="form-control" name="kode_kel"
                                        placeholder="Kode kelurahan" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Nama kelurahan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="nama_kel" class="form-control" name="nama_kel"
                                            placeholder="Nama kelurahan" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<script>
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
    }); 
</script>
<script>
    $(document).ready(function() {
        $('.btn-tambah').on('click', function() {
            const id = $(this).data('id');
            $('#exampleModalLabel').html('Tambah Data kelurahan');
            $('.modal-body form').attr('action', 'kelurahan/add');
            $('#kabupaten').val('');
            $('#kecamatan').val('');
            $('#nama_kel').val('');
            $('#kode_kel').val('');
        });
        $('.tampilModalUbah').on('click', function() {
            const id = $(this).data('id');
            $('#exampleModalLabel').html('Ubah Data');
            $('.modal-body form').attr('action', 'kelurahan/update/'+id);

            $.ajax({
                url: 'kelurahan/edit',
                data: {id : id},
                method: 'post',
                dataType:'json',
                success:function(data){
                    $('#kabupaten').val(data.kode_kec);
                    $('#kecamatan').val(data.kode_kec);
                    $('#kode_kel').val(data.kode_kel);
                    $('#nama_kel').val(data.nama_kel);
                }
            });
        });
    });
</script>