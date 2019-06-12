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
				//'nama_desa' => $row->nama_desa,
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
        $this->breadcrumbs->push('Data Testing', '/data_tes');
        $this->breadcrumbs->push('tambah', '/data_tes/create');
        $data = array(
            'title'       => 'Data Testing' ,
            'content'     => 'data_tes/data_tes_form', 
            'breadcrumbs' => $this->breadcrumbs->show(),
            'user'        => $user ,
            'button' => 'Tambah',
            'action' => site_url('data_tes/create_action'),
		    'id_desa' => set_value('id_data_tes'),
		    //'nama_desa' => set_value('nama_desa'),
		);
        $this->load->view('layout/layout', $data);
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
		$this->form_validation->set_rules('nama_desa', 'nama desa', 'trim|required');

		$this->form_validation->set_rules('id_desa', 'id_desa', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
