<?php 
    $ci =& get_instance();;
?>

<div class="content">

    <div class="panel panel-success">
        <div class="panel-heading">
            <h5 class="panel-title">Form <?php echo $button ?> Data Testing</h5>
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
                    <label for="varchar">Tanggungan <?php echo form_error('tanggungan_ortu') ?></label>
                    <input type="text" class="form-control" name="tanggungan_ortu" id="tanggungan_ortu" placeholder="Tanggungan" value="<?php echo $tanggungan_ortu; ?>" />
                </div>
                <div class="form-group">
                    <label for="varchar">IPK <?php echo form_error('ipk_mhs') ?></label>
                    <input type="text" class="form-control" name="ipk_mhs" id="ipk_mhs" placeholder="IPK" value="<?php echo $ipk_mhs; ?>" />
                </div>
                <div class="form-group">
                    <label for="varchar">Menerima Beasiswa Lain <?php echo form_error('beasiswa') ?></label>
                    <select class="form-control" name="beasiswa" id="beasiswa">
                        
                            <option value="0">Tidak Menerima</option>
                            <option value="1">Menerima</option>
                                  
                    </select>
                </div>
                <div class="form-group">
                    <label for="varchar">Status <?php echo form_error('status') ?></label>
                    <input type="text" class="form-control" name="status" id="status" placeholder="status" value="<?php echo $status; ?>" />
                </div>
				<input type="hidden" name="id_data_tes" value="<?php echo $id_data_tes; ?>" />
				<button type="submit" class="btn btn-success"><?php echo $button ?></button> 
                <button type="button" class="btn btn-warning" onclick="hitunghasil();">Hitung</button>
				<a href="<?php echo site_url('data_tes') ?>" class="btn btn-default">Cancel</a>
			</form>
        
        </div>
    </div>
</div>


<script type="text/javascript">

    function hitunghasil() {

    var gaji_ortu           = $("#gaji_ortu").val();
    var tanggungan_ortu     = $("#tanggungan_ortu").val();
    var ipk_mhs             = $("#ipk_mhs").val();
    var beasiswa            = $("#beasiswa").val();


    var kirim        = "gaji="+gaji_ortu+"&tanggungan="+tanggungan_ortu+"&ipk="+ipk_mhs+"&beasiswa="+beasiswa;
    //alert(kirim);

     $.ajax({
        type: "POST",
        url: "<?php echo base_url('Data_tes/hitunghasil') ?>",
        data: kirim,
        cache: false,
        success: function(html)
        {
          alert(html);
          //$("#tampilkan").html(html);
        },
        
        error : function(html){
          //$("#tampilkan").html("Data tidak ditemukan!");
          //alert(html);
        }
      });
  }
</script>