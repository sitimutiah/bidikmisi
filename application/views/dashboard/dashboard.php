<?php 
    $ci =& get_instance();
?>

<script src="<?php echo base_url('assets/js/plugins/tables/datatables/datatables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/tables/datatables/extensions/responsive.min.js') ?>"></script>

<div class="content">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h5 class="panel-title">Rekap Data Desa Sementara</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body"> 
            <div class="row">
                <div class="col-md-5 text-left">
                    <button type="button" class="btn btn-sm btn-danger" onclick="printHistori()"><i class="icon-file-pdf"></i> Cetak</button>
				</div>
                <div class="col-md-7 text-center">
                    <div style="margin-top: 4px"  id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
            </div>          
            <br>
            <table class="table datatable-responsive table-sm table-striped" id="mytable">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th>Gaji Orang Tua</th>
                        <th>Tanggungan Orang Tua</th>
                        <th>IPK</th>
                        <th>Menerima Beasiswa Lain</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
				<tbody>
            <?php
                $start = 0;
                foreach ($data_tes_data as $data_tes)
                {
            ?>
                    <tr>
                        <td><?php echo ++$start ?></td>
                        <td>Rp<?php echo number_format($data_tes->gaji_ortu,2,',','.') ?></td>
                        <td><?php echo $data_tes->tanggungan_ortu ?></td>
                        <td><?php echo $data_tes->ipk_mhs ?></td>
                        <td><?php if ($data_tes->beasiswa == "0") {
                            echo "Tidak Menerima";
                        }else{
                            echo "Menerima";
                        }?></td>
                        <td><?php echo $data_tes->status ?></td>
                        <td style="text-align:center" width="200px">
                        <?php 
                            echo anchor(site_url('data_tes/update/'.$data_tes->id_data_tes),'Update'); 
                            echo ' | '; 
                            echo anchor(site_url('data_tes/delete/'.$data_tes->id_data_tes),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                        ?>
                        </td>
                    </tr>
            <?php
                }
            ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script type="text/javascript">

function printHistori() {
        var alamat = '<?php echo base_url();?>' + 'dashboard/cetak_histori';
        var printHistoriWindow = window.open(alamat, 'Rekap Histori', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes');
        printHistoriWindow.print();   
        return false;
}

$(function() {

    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        responsive: true,
        columnDefs: [{ 
            orderable: false,
            width: '100px',
            targets: [ 5 ]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Cari :</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'Cari' : 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    // Basic responsive configuration
    $('.datatable-responsive').DataTable();


    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Ketik ...');

    
});
</script>