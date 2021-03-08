<?php defined('BASEPATH') or exit('No direct script access allowed');

class Periode extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('periode_model', 'periode_model');
		$this->load->model('pengajuan_model', 'pengajuan_model');
	}

	public function index($status = '')
	{
		$data['daftar_periode'] = $this->periode_model->getPeriode($status);
		$data['title'] = 'Daftar Periode Pencairan';
		$data['view'] = 'admin/periode/index';

		$this->load->view('layout/layout', $data);
	}

	public function tambah()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_rules(
				'nama_periode',
				'Nama Periode',
				'trim|required',
				[
					'required' => '%s Wajib Diisi'
				]
			);

			if ($this->form_validation->run() == FALSE) {
				$data['title'] = 'Tambah Periode';
				$data['view'] = 'admin/periode/tambah';
				$this->load->view('layout/layout', $data);
			} else {
				$data = [
					'nama_periode' => $this->input->post('nama_periode')
				];
				if ($this->periode_model->tambahPeriode($data)) {
					redirect(base_url('admin/periode/index'));
				}
			}
		} else {
			$data['title'] = 'Tambah Periode';
			$data['view'] = 'admin/periode/tambah';
			$this->load->view('layout/layout', $data);
		}
	}

	public function bulan($id_periode)
	{
		$nama_periode = $this->db->get_where('Tr_Periode_Penerbitan', ['id_periode' => $id_periode])->row_object()->nama_periode;
		$data['daftar_pengajuan'] = $this->pengajuan_model->getPengajuanPerPeriode($id_periode);
		$data['title'] = 'Daftar Pengajuan Periode ' . $nama_periode;
		$data['view'] = 'admin/penerbitan_pengajuan/index';

		// var_dump($data);
		// die();
		$this->load->view('layout/layout', $data);
	}
}
