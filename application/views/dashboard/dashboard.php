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
						<th>Desa</th>
                        <th>Daerah</th>
						<th>Pengintput</th>
						<th>Tanggal</th>
						<th>Kemiringan Lereng</th>
						<th>Kondisi Tanah</th>
						<th>Batuan Penyusun Lereng</th>
						<th>Curah Hujan</th>
						<th>Tata Air Lereng</th>
						<th>Vegetasi</th>
						<th>Pola Tanam</th>
						<th>Penggalian Dan Pemotongan Lereng</th>
						<th>Pencetakan Kolam</th>
						<th>Drainase</th>
						<th>Pembangunan Konstruksi</th>
						<th>Kepadatan Penduduk</th>
						<th>Usaha Mitigasi</th>
						<th>Hasil</th>
                    </tr>
                </thead>
				<tbody>
            <?php
                $start = 0;
                foreach ($dashboard_data as $data_tes1)
                {
            ?>
                    <tr>
						<td><?php echo ++$start ?></td>
                        <td><?php echo $this->Desa_model->get_by_id($data_tes1->id_desa)->nama_desa ?></td>
                        <td><?php echo "Dusun ".$this->Desa_model->get_dusun_by_id($data_tes1->id_desa_detail)->dusun." - Luas Daerah ".$this->Desa_model->get_dusun_by_id($data_tes1->id_desa_detail)->luas_daerah;?> Ha</td>
                        <td><?php echo $this->Users_model->get_by_id($data_tes1->id_user)->username ?></td>
						<td><?php echo $data_tes1->tanggal ?></td>
						<td><?php echo $data_tes1->kemiringan_lereng ?></td>
						<td><?php echo $data_tes1->kondisi_tanah ?></td>
						<td><?php echo $data_tes1->batuan_penyusun_lereng ?></td>
						<td><?php echo $data_tes1->curah_hujan ?></td>
						<td><?php echo $data_tes1->tata_air_lereng ?></td>
						<td><?php echo $data_tes1->vegetasi ?></td>
						<td><?php echo $data_tes1->pola_tanam ?></td>
						<td><?php echo $data_tes1->penggalian_dan_pemotongan_lereng ?></td>
						<td><?php echo $data_tes1->pencetakan_kolam ?></td>
						<td><?php echo $data_tes1->drainase ?></td>
						<td><?php echo $data_tes1->pembangunan_konstruksi ?></td>
						<td><?php echo $data_tes1->kepadatan_penduduk ?></td>
						<td><?php echo $data_tes1->usaha_mitigasi ?></td>
						<td><?php echo $data_tes1->hasil ?></td>
						
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