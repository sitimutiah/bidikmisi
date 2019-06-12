<?php 
    $ci =& get_instance();
?>

<div class="content">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h5 class="panel-title">Data_set Detail</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body"> 
        
            <table class="table">
				<tr>
                    <td>Gaji Orang Tua</td><td><?php echo $gaji_ortu; ?></td>
                </tr>
				<tr>
                    <td>Tanggungan Orang Tua</td><td><?php echo $tanggungan_ortu; ?></td>
                </tr>
				<tr>
                    <td>IPK</td><td><?php echo $ipk_mhs; ?></td>
                </tr>
				<tr>
                    <td>Menerima Beasiswa Lain</td><td><?php echo $beasiswa; ?></td>
                </tr>
				<tr>
                    <td>Status</td><td><?php echo $status; ?></td>
                </tr>
				<tr>
                    <td><a href="<?php echo site_url('data_set') ?>" class="btn btn-primary">Back</a></td><td></td>
                </tr>
			</table>
       
       </div>

    </div>
</div>