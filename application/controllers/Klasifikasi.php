<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Klasifikasi extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Klasifikasi_model');
		$this->load->model('Users_model');
		$this->load->model('Data_tes_model');
		$this->load->model('Desa_model');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
    }

	public function index()
	{
		$user = $this->ion_auth->user()->row();
		$id_desa = $this->Desa_model->get_by_id($user->id_desa)->id_desa;
		$nama_desa = $this->Desa_model->get_by_id($user->id_desa)->nama_desa;
        $this->breadcrumbs->push('Klasifikasi', '/klasifikasi');
        $this->breadcrumbs->push('tambah', 'dashboard');
		$dusun = $this->Desa_model->get_dusun($id_desa);
        $data = array(
            'title'       => 'Data Desa' ,
            'breadcrumbs' => $this->breadcrumbs->show(),
            'user'        => $user ,
            'button' => 'Klasifikasi',
            'action' => site_url('klasifikasi/hitung_klasifikasi'),
		    'id_data_tes' => set_value('id_data_tes'),
		    'id_desa' => $id_desa,
			'nama_desa' => $nama_desa,
		    'id_user' => set_value('id_user'),
		    'tanggal' => set_value('tanggal'),
		    'kemiringan_lereng' => set_value('kemiringan_lereng'),
		    'kondisi_tanah' => set_value('kondisi_tanah'),
		    'batuan_penyusun_lereng' => set_value('batuan_penyusun_lereng'),
		    'curah_hujan' => set_value('curah_hujan'),
		    'tata_air_lereng' => set_value('tata_air_lereng'),
		    'vegetasi' => set_value('vegetasi'),
		    'pola_tanam' => set_value('pola_tanam'),
		    'penggalian_dan_pemotongan_lereng' => set_value('penggalian_dan_pemotongan_lereng'),
		    'pencetakan_kolam' => set_value('pencetakan_kolam'),
		    'drainase' => set_value('drainase'),
		    'pembangunan_konstruksi' => set_value('pembangunan_konstruksi'),
		    'kepadatan_penduduk' => set_value('kepadatan_penduduk'),
		    'usaha_mitigasi' => set_value('usaha_mitigasi'),
		    'hasil' => set_value('hasil'),

			'data_dusun' => $dusun ,
		);
		// if($this->Klasifikasi_model->get_data_by_date($id_desa) == TRUE ){
		// 	$data['content'] = 'klasifikasi/sudah_input';
		// } else {
			$data['content'] = 'klasifikasi/form';
		//}
		
        $this->load->view('layout/layout', $data);
	}

	public function hitung_klasifikasi()
	{
		$user = $this->ion_auth->user()->row();
		$nama_desa = $this->Desa_model->get_by_id($this->input->post('id_desa',TRUE))->nama_desa;
        $this->breadcrumbs->push('Klasifikasi', '/klasifikasi');
        $this->breadcrumbs->push('tambah', 'dashboard');
		$penginput = $this->Users_model->get_by_id($this->input->post('id_user',TRUE));

		$this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {

				$id_desa = $this->input->post('id_desa',TRUE);
				$id_user = $this->input->post('id_user',TRUE);
				$id_desa_detail = $this->input->post('id_desa_detail',TRUE);
				$dusun = $this->Desa_model->get_dusun_by_id($id_desa_detail);
				$tanggal = $this->input->post('tanggal',TRUE);
				$data = array(
					'title'       => 'Klasifikasi' ,
					'content'     => 'klasifikasi/hasil_klasifikasi', 
					'breadcrumbs' => $this->breadcrumbs->show(),
					'user'        => $user ,
					'button' => 'Klasifikasi',
					'action' => site_url('klasifikasi/simpan_hasil'),
					'nama_desa' => $nama_desa,
					'id_desa' => $this->input->post('id_desa',TRUE),
					'penginput' => $penginput, 
					'id_user' => $this->input->post('id_user',TRUE),
					'tanggal' => $this->input->post('tanggal',TRUE),
					'kemiringan_lereng' => $this->input->post('kemiringan_lereng',TRUE),
					'kondisi_tanah' => $this->input->post('kondisi_tanah',TRUE),
					'batuan_penyusun_lereng' => $this->input->post('batuan_penyusun_lereng',TRUE),
					'curah_hujan' => $this->input->post('curah_hujan',TRUE),
					'tata_air_lereng' => $this->input->post('tata_air_lereng',TRUE),
					'vegetasi' => $this->input->post('vegetasi',TRUE),
					'pola_tanam' => $this->input->post('pola_tanam',TRUE),
					'penggalian_dan_pemotongan_lereng' => $this->input->post('penggalian_dan_pemotongan_lereng',TRUE),
					'pencetakan_kolam' => $this->input->post('pencetakan_kolam',TRUE),
					'drainase' => $this->input->post('drainase',TRUE),
					'pembangunan_konstruksi' => $this->input->post('pembangunan_konstruksi',TRUE),
					'kepadatan_penduduk' => $this->input->post('kepadatan_penduduk',TRUE),
					'usaha_mitigasi' => $this->input->post('usaha_mitigasi',TRUE),
					'dusun'	=> $dusun ,
				);

				 /*  1. Ambil data ---> P(kemiringan_lereng = ? | Y= ?) = hasil_bagi  */
				$kemiringan_lereng_aman  = $this->Klasifikasi_model->get_parameter('kemiringan_lereng',$data["kemiringan_lereng"],'Aman')->hasil_bagi;  
				$kemiringan_lereng_rawan = $this->Klasifikasi_model->get_parameter('kemiringan_lereng',$data["kemiringan_lereng"],'Rawan')->hasil_bagi; 

				/*  2.  */
				$kondisi_tanah_aman  = $this->Klasifikasi_model->get_parameter('kondisi_tanah',$data["kondisi_tanah"],'Aman')->hasil_bagi;  
				$kondisi_tanah_rawan = $this->Klasifikasi_model->get_parameter('kondisi_tanah',$data["kondisi_tanah"],'Rawan')->hasil_bagi; 

				/*  3.  */
				$batuan_penyusun_lereng_aman  = $this->Klasifikasi_model->get_parameter('batuan_penyusun_lereng',$data["batuan_penyusun_lereng"],'Aman')->hasil_bagi;  
				$batuan_penyusun_lereng_rawan = $this->Klasifikasi_model->get_parameter('batuan_penyusun_lereng',$data["batuan_penyusun_lereng"],'Rawan')->hasil_bagi;

				/*  4.  */
				$curah_hujan_aman  = $this->Klasifikasi_model->get_parameter('curah_hujan',$data["curah_hujan"],'Aman')->hasil_bagi;  
				$curah_hujan_rawan = $this->Klasifikasi_model->get_parameter('curah_hujan',$data["curah_hujan"],'Rawan')->hasil_bagi;

				/*  5.  */
				$tata_air_lereng_aman  = $this->Klasifikasi_model->get_parameter('tata_air_lereng',$data["tata_air_lereng"],'Aman')->hasil_bagi;  
				$tata_air_lereng_rawan = $this->Klasifikasi_model->get_parameter('tata_air_lereng',$data["tata_air_lereng"],'Rawan')->hasil_bagi; 

				/*  6.  */
				$vegetasi_aman  = $this->Klasifikasi_model->get_parameter('vegetasi',$data["vegetasi"],'Aman')->hasil_bagi;  
				$vegetasi_rawan = $this->Klasifikasi_model->get_parameter('vegetasi',$data["vegetasi"],'Rawan')->hasil_bagi;

				/*  7.  */
				$pola_tanam_aman  = $this->Klasifikasi_model->get_parameter('pola_tanam',$data["pola_tanam"],'Aman')->hasil_bagi;  
				$pola_tanam_rawan = $this->Klasifikasi_model->get_parameter('pola_tanam',$data["pola_tanam"],'Rawan')->hasil_bagi;

				/*  8.  */
				$penggalian_dan_pemotongan_lereng_aman  = $this->Klasifikasi_model->get_parameter('penggalian_dan_pemotongan_lereng',$data["penggalian_dan_pemotongan_lereng"],'Aman')->hasil_bagi;  
				$penggalian_dan_pemotongan_lereng_rawan = $this->Klasifikasi_model->get_parameter('penggalian_dan_pemotongan_lereng',$data["penggalian_dan_pemotongan_lereng"],'Rawan')->hasil_bagi; 

				/*  9.  */
				$pencetakan_kolam_aman  = $this->Klasifikasi_model->get_parameter('pencetakan_kolam',$data["pencetakan_kolam"],'Aman')->hasil_bagi;  
				$pencetakan_kolam_rawan = $this->Klasifikasi_model->get_parameter('pencetakan_kolam',$data["pencetakan_kolam"],'Rawan')->hasil_bagi; 

				/*  10.  */
				$drainase_aman  = $this->Klasifikasi_model->get_parameter('drainase',$data["drainase"],'Aman')->hasil_bagi;  
				$drainase_rawan = $this->Klasifikasi_model->get_parameter('drainase',$data["drainase"],'Rawan')->hasil_bagi; 

				/*  11.  */
				$pembangunan_konstruksi_aman  = $this->Klasifikasi_model->get_parameter('pembangunan_konstruksi',$data["pembangunan_konstruksi"],'Aman')->hasil_bagi;  
				$pembangunan_konstruksi_rawan = $this->Klasifikasi_model->get_parameter('pembangunan_konstruksi',$data["pembangunan_konstruksi"],'Rawan')->hasil_bagi; 

				/*  12.  */
				$kepadatan_penduduk_aman  = $this->Klasifikasi_model->get_parameter('kepadatan_penduduk',$data["kepadatan_penduduk"],'Aman')->hasil_bagi;  
				$kepadatan_penduduk_rawan = $this->Klasifikasi_model->get_parameter('kepadatan_penduduk',$data["kepadatan_penduduk"],'Rawan')->hasil_bagi; 

				/*  13.  */
				$usaha_mitigasi_aman  = $this->Klasifikasi_model->get_parameter('usaha_mitigasi',$data["usaha_mitigasi"],'Aman')->hasil_bagi;  
				$usaha_mitigasi_rawan = $this->Klasifikasi_model->get_parameter('usaha_mitigasi',$data["usaha_mitigasi"],'Rawan')->hasil_bagi; 


				// probabilitas
				$prob_aman = $kemiringan_lereng_aman * $kondisi_tanah_aman * $batuan_penyusun_lereng_aman * $curah_hujan_aman * $tata_air_lereng_aman * $vegetasi_aman * $pola_tanam_aman * $penggalian_dan_pemotongan_lereng_aman * $pencetakan_kolam_aman * $drainase_aman * $pembangunan_konstruksi_aman * $kepadatan_penduduk_aman * $usaha_mitigasi_aman;
				$prob_rawan = $kemiringan_lereng_rawan * $kondisi_tanah_rawan * $batuan_penyusun_lereng_rawan * $curah_hujan_rawan * $tata_air_lereng_rawan * $vegetasi_rawan * $pola_tanam_rawan * $penggalian_dan_pemotongan_lereng_rawan * $pencetakan_kolam_rawan * $drainase_rawan * $pembangunan_konstruksi_rawan * $kepadatan_penduduk_rawan * $usaha_mitigasi_rawan;

				$jumlah = $prob_aman + $prob_rawan;
				$hasil_prob_aman =  $prob_aman / $jumlah;
				$hasil_prob_rawan =  $prob_rawan / $jumlah;
				
				if ($hasil_prob_aman > $hasil_prob_rawan) {
					$prediksi = "Aman";
				} else {
					$prediksi = "Rawan";
				}
				
				$data["prob_aman"] = $hasil_prob_aman;
				$data["prob_rawan"] = $hasil_prob_rawan;
				$data["prediksi"] = $prediksi;
				$this->load->view('layout/layout', $data);
        }
	}
    
    public function simpan_hasil() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
				'id_desa' => $this->input->post('id_desa',TRUE),
				'id_user' => $this->input->post('id_user',TRUE),
				'tanggal' => $this->input->post('tanggal',TRUE),
				'kemiringan_lereng' => $this->input->post('kemiringan_lereng',TRUE),
				'kondisi_tanah' => $this->input->post('kondisi_tanah',TRUE),
				'batuan_penyusun_lereng' => $this->input->post('batuan_penyusun_lereng',TRUE),
				'curah_hujan' => $this->input->post('curah_hujan',TRUE),
				'tata_air_lereng' => $this->input->post('tata_air_lereng',TRUE),
				'vegetasi' => $this->input->post('vegetasi',TRUE),
				'pola_tanam' => $this->input->post('pola_tanam',TRUE),
				'penggalian_dan_pemotongan_lereng' => $this->input->post('penggalian_dan_pemotongan_lereng',TRUE),
				'pencetakan_kolam' => $this->input->post('pencetakan_kolam',TRUE),
				'drainase' => $this->input->post('drainase',TRUE),
				'pembangunan_konstruksi' => $this->input->post('pembangunan_konstruksi',TRUE),
				'kepadatan_penduduk' => $this->input->post('kepadatan_penduduk',TRUE),
				'usaha_mitigasi' => $this->input->post('usaha_mitigasi',TRUE),
				'hasil' => $this->input->post('hasil',TRUE),
				
				'id_desa_detail' => $this->input->post('id_desa_detail',TRUE) ,
		    );

            $this->Data_tes_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('klasifikasi'));
        }
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('id_desa', 'id desa', 'trim|required');
		$this->form_validation->set_rules('id_user', 'id user', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
		$this->form_validation->set_rules('kemiringan_lereng', 'kemiringan lereng', 'trim|required');
		$this->form_validation->set_rules('kondisi_tanah', 'kondisi tanah', 'trim|required');
		$this->form_validation->set_rules('batuan_penyusun_lereng', 'batuan penyusun lereng', 'trim|required');
		$this->form_validation->set_rules('curah_hujan', 'curah hujan', 'trim|required');
		$this->form_validation->set_rules('tata_air_lereng', 'tata air lereng', 'trim|required');
		$this->form_validation->set_rules('vegetasi', 'vegetasi', 'trim|required');
		$this->form_validation->set_rules('pola_tanam', 'pola tanam', 'trim|required');
		$this->form_validation->set_rules('penggalian_dan_pemotongan_lereng', 'penggalian dan pemotongan lereng', 'trim|required');
		$this->form_validation->set_rules('pencetakan_kolam', 'pencetakan kolam', 'trim|required');
		$this->form_validation->set_rules('drainase', 'drainase', 'trim|required');
		$this->form_validation->set_rules('pembangunan_konstruksi', 'pembangunan konstruksi', 'trim|required');
		$this->form_validation->set_rules('kepadatan_penduduk', 'kepadatan penduduk', 'trim|required');
		$this->form_validation->set_rules('usaha_mitigasi', 'usaha mitigasi', 'trim|required');

		$this->form_validation->set_rules('id_data_tes', 'id_data_tes', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }	

}

/* End of file Klasifikasi.php */
/* Location: ./application/controllers/Klasifikasi.php */