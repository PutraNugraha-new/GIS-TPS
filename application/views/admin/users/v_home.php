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
                                <a href="users/tambah" class="btn btn-warning my-1">
                                    <i class="bi bi-plus-circle"></i>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Last Login</th>
                                        <th>Role</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($groups as $data):
                                        if($data->role == 1){
                                            $rolename = "Admin";
                                        }elseif($data->role == 2){
                                            $rolename = "Operator";
                                        }
                                        ?>
                                        
                                        <tr>
                                            <td><?= $data->first_name ?></td>
                                            <td><?= $data->email ?></td>
                                            <td><?= $data->last_login ?></td>
                                            <td><?= $rolename ?></td>
                                            <td class="<?= ($data->banned_users == 'unban') ? 'text-info' : 'text-danger';?>"><?= $data->banned_users ?></td>
                                            <td>
                                                <a href="users/deleteuser/<?= $data->id ?>" onclick="return confirm('ingin Menghapus?')">
                                                    <span class="badge bg-danger"><i class="bi bi-trash"></i></span>
                                                </a>
                                                <a href="#" data-bs-toggle="modal" data-id="<?= $data->id ?>" data-bs-target="#exampleModal" class="tampilModalUbah">
                                                    <span class="badge bg-success mb-2"><i class="bi bi-pencil"></i></span>
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
        <h5 class="modal-title" id="exampleModalLabel">Status Ban Akun</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php $fattr = array('class' => 'form-signin');
         echo form_open(site_url().'users/update/', $fattr); ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="hidden" id="id" class="form-control" name="id" readonly required >
                                    <input type="text" id="email" class="form-control" name="email" required >
                                </div>

                                <div class="col-md-4">
                                    <label>Nama Lengkap</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="first_name" class="form-control" name="first_name" required >
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Role</label>
                                </div>
                                <div class="col-md-8 form-group">
                                <select name="role" id="role" class="form-control">
                                    <option value="1">Admin</option>
                                    <option value="2">Operator</option>
                                </select>
                                <?php echo form_error('status');?>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Status Ban</label>
                                </div>
                                <div class="col-md-8 form-group">
                                <?php
                                    $dd_list = array(
                                            'unban'   => 'Unban',
                                            'ban'   => 'Ban',
                                            );
                                    $dd_name = "banned_users";
                                    echo form_dropdown($dd_name, $dd_list, set_value($dd_name),'class = "form-control" id="banuser"');
                                ?>
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
        $('.tampilModalUbah').on('click', function() {
            const id = $(this).data('id');
            $('#exampleModalLabel').html('Ubah Akun');
            $('.modal-body form').attr('action', 'users/update/');
            

            $.ajax({
                url: 'users/edit',
                data: {id : id},
                method: 'post',
                dataType:'json',
                success:function(data){
                    $('#id').val(data.id);
                    $('#email').val(data.email);
                    $('#role').val(data.role);
                    $('#first_name').val(data.first_name);
                    $('#banuser').val(data.banned_users);
                }
            });
        });
    });
</script>