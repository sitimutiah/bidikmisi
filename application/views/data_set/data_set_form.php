<?php 
    $ci =& get_instance();;
?>

<div class="content">

    <div class="panel panel-success">
        <div class="panel-heading">
            <h5 class="panel-title">Form <?php echo $button ?> Data set</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body"> 

            <form action="<?php echo $action; ?>" method="post">
				<div class="form-group">
                    <label for="varchar">Gaji Orang Tua <?php echo form_error('gaji_ortu') ?></label>
                    <input type="text" class="form-control" name="gaji_ortu" id="gaji_ortu" placeholder="Gaji Orang Tua" value="<?php echo $gaji_ortu; ?>" />
                </div>
				<div class="form-group">
                    <label for="varchar">Tanggungan <?php echo form_error('tanggunagan_ortu') ?></label>
                    <input type="text" class="form-control" name="tanggunagan_ortu" id="tanggunagan_ortu" placeholder="Tanggungan" value="<?php echo $tanggungan_ortu; ?>" />
                </div>
				<div class="form-group">
                    <label for="varchar">IPK <?php echo form_error('ipk_mhs') ?></label>
                    <input type="text" class="form-control" name="ipk_mhs" id="ipk_mhs" placeholder="IPK" value="<?php echo $ipk_mhs; ?>" />
                </div>
				<div class="form-group">
                    <label for="varchar">Menerima Beasiswa Lain <?php echo form_error('beasiswa') ?></label>
                    <input type="text" class="form-control" name="beasiswa" id="beasiswa" placeholder="beasiswa" value="<?php echo $beasiswa; ?>" />
                </div>
				<div class="form-group">
                    <label for="varchar">Status <?php echo form_error('status') ?></label>
                    <input type="text" class="form-control" name="status" id="status" placeholder="status" value="<?php echo $status; ?>" />
                </div>
				<input type="hidden" name="id_data_set" value="<?php echo $id_data_set; ?>" /> 
				<button type="submit" class="btn btn-success"><?php echo $button ?></button> 
				<a href="<?php echo site_url('data_set') ?>" class="btn btn-default">Cancel</a>
			</form>
        
        </div>
    </div>
</div>