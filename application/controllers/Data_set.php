<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_set extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Data_set_model');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
    }

    public function index()
    {
        $data_set = $this->Data_set_model->get_all();
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data Training', '/data_set');

        $data = array(
            'title'       => 'Data Training' ,
            'content'     => 'data_set/data_set_list', 
            'breadcrumbs' => $this->breadcrumbs->show(),
            'user'        => $user ,
            
            'data_set_data' => $data_set
        );

        $this->load->view('layout/layout', $data);
    }

    public function read($id) 
    {
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data Training', '/data_set');
        //$this->breadcrumbs->push('detail', '/data_set/read');
        $row = $this->Data_set_model->get_by_id($id);
        if ($row) {
            $data = array(
                'title'       => 'Data Training' ,
                'content'     => 'data_set/data_set_read', 
                'breadcrumbs' => $this->breadcrumbs->show(),
                'user'        => $user ,
				'id_data_set' => $row->id_data_set,
                'gaji_ortu' => $row->gaji_ortu,
				'tanggungan_ortu' => $row->tanggungan_ortu,
				'ipk_mhs' => $row->ipk_mhs,
				'beasiswa' => $row->beasiswa,
				'status' => $row->status,
			);
            $this->load->view('layout/layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_set'));
        }
    }

    public function create() 
    {
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data Training', '/data_set');
        $this->breadcrumbs->push('Tambah', '/data_set/create');
        $data = array(
            'title'       => 'Data Training' ,
            'content'     => 'data_set/data_set_form', 
            'breadcrumbs' => $this->breadcrumbs->show(),
            'user'        => $user ,

            'button' => 'Tambah',
            'action' => site_url('data_set/create_action'),
		    'id_data_set' => set_value('id_data_set'),
		    'gaji_ortu' => set_value('gaji_ortu'),
		    'tanggungan_ortu' => set_value('tanggungan_ortu'),
		    'ipk_mhs' => set_value('ipk_mhs'),
		    'beasiswa' => set_value('beasiswa'),
		    'status' => set_value('status'),
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
				'beasisw' => $this->input->post('beasiswa',TRUE),
				'status' => $this->input->post('status',TRUE),
		    );

            $this->Data_set_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('data_set'));
        }
    }
    
    public function update($id) 
    {
        $user = $this->ion_auth->user()->row();
        $this->breadcrumbs->push('Data_set', '/data_set');
        $this->breadcrumbs->push('update', '/data_set/update');
        
        $row = $this->Data_set_model->get_by_id($id);
        if ($row) {
            $data = array(
                'title'       => 'Data Training' ,
                'content'     => 'data_set/data_set_form', 
                'breadcrumbs' => $this->breadcrumbs->show(),
                'user'        => $user ,

                'button' => 'Update',
                'action' => site_url('data_set/update_action'),
				'id_data_set' => set_value('id_data_set', $row->id_data_set),
				'gaji_ortu' => set_value('gaji_ortu', $row->gaji_ortu),
				'tanggungan_ortu' => set_value('tanggungan_ortu', $row->tanggungan_ortu),
				'ipk_mhs' => set_value('ipk_mhs', $row->ipk_mhs),
				'beasiswa' => set_value('beasiswa', $row->beasiswa),
				'status' => set_value('status', $row->status),
		    );
            $this->load->view('layout/layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_set'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_data_set', TRUE));
        } else {
            $data = array(
				'gaji_ortu' => $this->input->post('gaji_ortu',TRUE),
                'tanggungan_ortu' => $this->input->post('tanggungan_ortu',TRUE),
                'ipk_mhs' => $this->input->post('ipk_mhs',TRUE),
                'beasiswa' => $this->input->post('beasiswa',TRUE),
                'status' => $this->input->post('status',TRUE),
		    );

            $this->Data_set_model->update($this->input->post('id_data_set', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('data_set'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Data_set_model->get_by_id($id);

        if ($row) {
            $this->Data_set_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('data_set'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_set'));
        }
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('gaji_ortu', 'gaji_ortu', 'trim|required');
		$this->form_validation->set_rules('tanggungan_ortu', 'tanggungan_ortu', 'trim|required');
		$this->form_validation->set_rules('ipk_mhs', 'ipk_mhs', 'trim|required');
		$this->form_validation->set_rules('beasiswa', 'beasiswa', 'trim|required');
		$this->form_validation->set_rules('status', 'status', 'trim|required');

		$this->form_validation->set_rules('id_data_set', 'id_data_set', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}