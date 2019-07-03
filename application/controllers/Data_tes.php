<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_tes extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Data_tes_model');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
    }

    public function index()
    {
        $data_tes = $this->Data_tes_model->get_all();
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data Testing', '/data_tes');
        $data = array(
            'title'       => 'Data Testing' ,
            'content'     => 'data_tes/data_tes_list', 
            'breadcrumbs' => $this->breadcrumbs->show(),
            'user'        => $user ,
            'beasiswa'    => $this->Data_tes_model->get_all(),
            'data_tes_data' => $data_tes
        );

        $this->load->view('layout/layout', $data);
    }

    public function read($id) 
    {
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data Testing', '/data_tes');
        //$this->breadcrumbs->push('detail', '/desa/read');
        $row = $this->Data_tes_model->get_by_id($id);
        //$dusun = $this->Desa_model->get_dusun($id);
        if ($row) {
            $data = array(
                'title'       => 'Data Testing' ,
                'content'     => 'data_tes/data_tes_read', 
                'breadcrumbs' => $this->breadcrumbs->show(),
                'user'        => $user ,
               // 'dusun'       => $dusun ,
				'id_data_tes' => $row->id_data_tes,
			    'gaji_ortu' => $row->gaji_ortu,
                'tanggungan_ortu' => $row->tanggungan_ortu,
                'ipk_mhs' => $row->ipk_mhs,
                'beasiswa' => $row->beasiswa,
                'status' => $row->status,
			);
            $this->load->view('layout/layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_tes'));
        }
    }

    public function create() 
    {
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data Testing', '/data_tes'); //menampilkan data


        $this->breadcrumbs->push('tambah', '/data_tes/create'); //insert



        $data = array(
            'title'       => 'Data Testing' ,
            'content'     => 'data_tes/data_tes_form', 
            'breadcrumbs' => $this->breadcrumbs->show(),
            'user'        => $user ,
            'button' => 'Tambah',
            'action' => site_url('data_tes/create_action'),
            'id_data_tes' => set_value('id_data_tes'),
            'gaji_ortu' => set_value('gaji_ortu'),
            'tanggungan_ortu' => set_value('tanggungan_ortu'),
            'ipk_mhs' => set_value('ipk_mhs'),
            'beasiswa' => set_value('beasiswa'),
            'status' => set_value('status'),
		    //'nama_desa' => set_value('nama_desa'),
		);
        $this->load->view('layout/layout', $data);
    }

    public function hitunghasil()
    {
        $gaji           = '5000000';//$_POST['gaji'];
        $tanggungan     = '2';//$_POST['tanggungan'];
        $ipk            = '3.67';//$_POST['ipk'];
        $beasiswa       = '1';//$_POST['beasiswa']; 


        $query_gj_layak = $this->db->select('AVG(gaji_ortu) as average_gj_layak')->from('data_set')->where('status', 'Layak')->get();

        $mean_gajilayak = $query_gj_layak->row()->average_gj_layak;

        $query_gj_tidak = $this->db->select('AVG(gaji_ortu) as average_gj_tdak')->from('data_set')->where('status', 'Tidak Layak')->get();
          $mean_gaji_tidak_layak = $query_gj_tidak->row()->average_gj_tdak;

        $query_gj_all = $this->db->select('AVG(gaji_ortu) as average_gj_all')->from('data_set')->get();
        $mean_gaji_all = $query_gj_all->row()->average_gj_all;

        // $mean_gaji = $query->row()->average_score;

        /*$query_ipk_layak = $this->db->select('AVG(ipk_mhs) as average_ipk_layak')->from('data_set')->where('status', 'Layak')->get();

        $query_ipk_tidak = $this->db->select('AVG(ipk_mhs) as average_ipk_tdak')->from('data_set')->where('status', 'Tidak Layak')->get();

        $query_ipk_all = $this->db->select('AVG(ipk_mhs) as average_ipk_all')->from('data_set')->get();*/

         $query_sum_gj_all = $this->db->select('sum(gaji_ortu) as sum_gj_all')->from('data_set')->get();
         $sum_gaji_all = $query_sum_gj_all->row()->sum_gj_all;

         $count_layak=$this->db->select('count(status) as count_layak')->from('data_set')->where('status', 'Layak')->get();
         $count_layak = $count_layak->row()->count_layak;

         $count_tidak_layak=$this->db->select('count(status) count_tidak_layak')->from('data_set')->where('status', 'Tidak Layak')->get();
        $count_tidak_layak = $count_tidak_layak->row()->count_tidak_layak;

         $count_all=$this->db->select('count(status) as count_all')->from('data_set')->get();
        $count_all = $count_all->row()->count_all;

       $varian_gj_tidak = pow(($sum_gaji_all-$mean_gaji_tidak_layak),2);

       $varian_a_tdak_layak=($varian_gj_tidak)/($count_tidak_layak);

       // echo'/'.round($varian_gj_tidak);
       // echo'<br>';
       // echo'/'.$count_tidak_layak;

       echo round($varian_a_tdak_layak);



        
        //print_r($mean);


    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(

                'gaji_ortu' => $this->input->post('gaji_ortu',TRUE),
                'tanggungan_ortu' => $this->input->post('tanggungan_ortu',TRUE),
                'ipk_mhs' => $this->input->post('ipk_mhs',TRUE),
                'beasiswa' => $this->input->post('beasiswa',TRUE),
                'status' => $this->input->post('status',TRUE),
		    );

            $this->Data_tes_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('data_tes'));
        }
    }
    
    public function update($id) 
    {
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data Testing', '/data_tes');
        $this->breadcrumbs->push('update', '/data_tes/update');
        
        $row = $this->Data_tes_model->get_by_id($id);
        if ($row) {
            $data = array(
                'title'       => 'Data Testing' ,
                'content'     => 'data_tes/data_tes_form', 
                'breadcrumbs' => $this->breadcrumbs->show(),
                'user'        => $user ,
                'button' => 'Update',
                'action' => site_url('data_tes/update_action'),
                'id_data_tes' => set_value('id_data_tes', $row->id_data_tes),
                'gaji_ortu' => set_value('gaji_ortu', $row->gaji_ortu),
                'tanggungan_ortu' => set_value('tanggungan_ortu', $row->tanggungan_ortu),
                'ipk_mhs' => set_value('ipk_mhs', $row->ipk_mhs),
                'beasiswa' => set_value('beasiswa', $row->beasiswa),
                'status' => set_value('status', $row->status),
		    );
            $this->load->view('layout/layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_tes'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_data_tes', TRUE));
        } else {
            $data = array(
                'gaji_ortu' => $this->input->post('gaji_ortu',TRUE),
                'tanggungan_ortu' => $this->input->post('tanggungan_ortu',TRUE),
                'ipk_mhs' => $this->input->post('ipk_mhs',TRUE),
                'beasiswa' => $this->input->post('beasiswa',TRUE),
                'status' => $this->input->post('status',TRUE),
		    );

            $this->Data_tes_model->update($this->input->post('id_data_tes', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('data_tes'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Data_tes_model->get_by_id($id);

        if ($row) {
            $this->Data_tes_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('data_tes'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_tes'));
        }
    }
   

    public function _rules() 
    {
		$this->form_validation->set_rules('gaji_ortu', 'Gaji Orang Tua', 'trim|required');
        $this->form_validation->set_rules('tanggungan_ortu', 'Tanggungan', 'trim|required');
        $this->form_validation->set_rules('ipk_mhs', 'IPK', 'trim|required');
        $this->form_validation->set_rules('beasiswa', 'Beasiswa', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('id_data_tes', 'id_data_tes', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
