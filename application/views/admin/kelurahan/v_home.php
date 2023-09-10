<?php if ($this->session->flashdata('sukses')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('sukses'); ?>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                        <!-- <a href="kecamatan/edit/<?= $data->kode_kel ?>">
                                            <span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span>
                                        </a> -->
                                        <a href="kecamatan/hapus/<?= $data->kode_kel ?>" onclick="return confirm('ingin Menghapus?')">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="text" id="nama_kab" class="form-control" name="nama_kab"
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