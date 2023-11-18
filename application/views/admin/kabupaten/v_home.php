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
                                <button type="button" class="btn btn-tambah btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                        <th>Kode Kabupaten</th>
                                        <th>Nama Kabupaten</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($kab as $data): ?>
                                        <tr>
                                            <td><?= $data->kode_kab ?></td>
                                            <td><?= $data->nama_kab ?></td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" data-id="<?= $data->kode_kab ?>" data-bs-target="#exampleModal" class="tampilModalUbah">
                                                    <span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span>
                                                </a>
                                                <a href="kabupaten/hapus/<?= $data->kode_kab ?>" onclick="return confirm('ingin Menghapus?')">
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

<!-- Modal tambah -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kabupaten</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form action="kabupaten/add" class="form form-horizontal" method="POST">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Kode Kabupaten</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="kode_kab" class="form-control" name="kode_kab"
                                        placeholder="Kode Kabupaten" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Nama Kabupaten</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="nama_kab" class="form-control" name="nama_kab"
                                            placeholder="Nama Kabupaten" required>
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
            $('#exampleModalLabel').html('Tambah Data Kabupaten');
            $('.modal-body form').attr('action', 'kabupaten/add');
            $('#kode_kab').val('');
            $('#nama_kab').val('');
            
        });
        $('.tampilModalUbah').on('click', function() {
            const id = $(this).data('id');
            $('#exampleModalLabel').html('Ubah Kabupaten');
            $('.modal-body form').attr('action', 'Kabupaten/update/'+id);

            $.ajax({
                url: 'kabupaten/edit',
                data: {id : id},
                method: 'post',
                dataType:'json',
                success:function(data){
                    $('#kode_kab').val(data.kode_kab);
                    $('#kode_kab').prop('readonly',true);
                    $('#nama_kab').val(data.nama_kab);
                }
            });
        });
    });
</script>