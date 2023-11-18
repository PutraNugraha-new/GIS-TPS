<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                <?php
        //for warning -> flash_message
        //for info -> success_message
        
        $arr = $this->session->flashdata();
        if(!empty($arr['flash_message'])){
            $html = '<div class="container" style="margin-top: 10px;">';
            $html .= '<div class="alert alert-warning alert-dismissible" role="alert">';
            $html .= $arr['flash_message'];
            $html .= '</div>';
            $html .= '</div>';
            echo $html;
        }else if (!empty($arr['success_message'])){
            $html = '<div class="container" style="margin-top: 10px;">';
            $html .= '<div class="alert alert-info alert-dismissible" role="alert">';
            $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            $html .= $arr['success_message'];
            $html .= '</div>';
            $html .= '</div>';
            echo $html;
        }else if (!empty($arr['danger_message'])){
            $html = '<div class="container" style="margin-top: 10px;">';
            $html .= '<div class="alert alert-danger alert-dismissible" role="alert">';
            $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            $html .= $arr['danger_message'];
            $html .= '</div>';
            $html .= '</div>';
            echo $html;
        }
    ?>
                <?php 
                    $fattr = array('class' => 'form-signin');
                    echo form_open('users/adduser', $fattr);
                ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Nama Awal</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <?php echo form_input(array('name'=>'firstname', 'id'=> 'firstname', 'placeholder'=>'First Name', 'class'=>'form-control', 'value' => set_value('firstname'))); ?>
                                    <?php echo form_error('firstname');?>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Akhir Nama</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <?php echo form_input(array('name'=>'lastname', 'id'=> 'lastname', 'placeholder'=>'Last Name', 'class'=>'form-control', 'value'=> set_value('lastname'))); ?>
                                    <?php echo form_error('lastname');?>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <?php echo form_input(array('name'=>'email', 'id'=> 'email', 'placeholder'=>'Email', 'class'=>'form-control', 'value'=> set_value('email'))); ?>
                                    <?php echo form_error('email');?>
                                </div>
                                <div class="col-md-4">
                                    <label>Password</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <?php echo form_password(array('name'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control', 'value' => set_value('password'))); ?>
                                    <?php echo form_error('password') ?>
                                </div>
                                <div class="col-md-4">
                                    <label>Konfirmasi Password</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <?php echo form_password(array('name'=>'passconf', 'id'=> 'passconf', 'placeholder'=>'Confirm Password', 'class'=>'form-control', 'value'=> set_value('passconf'))); ?>
                                    <?php echo form_error('passconf') ?>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Role</label>
                                </div>
                                <div class="col-md-8 form-group">
                                <?php
                                    $dd_list = array(
                                            '1'   => 'Admin',
                                            '2'   => 'Operator',
                                            );
                                    $dd_name = "role";
                                    echo form_dropdown($dd_name, $dd_list, set_value($dd_name),'class = "form-control" id="role"');
                                ?>
                                </div>                                
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <!-- <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button> -->
                                    <?php echo form_submit(array('value'=>'Add', 'class'=>'btn btn-primary me-1 mb-1')); ?>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
            </div>
        </div>
    </div>
