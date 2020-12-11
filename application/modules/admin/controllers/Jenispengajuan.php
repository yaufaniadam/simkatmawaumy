<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenispengajuan extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pengajuan_model', 'pengajuan_model');
	}

	public function index()
	{
		$data['jenis_pengajuan'] = $this->pengajuan_model->get_jenis_pengajuan();
		$data['title'] = 'Jenis Pengajuan';
		$data['view'] = 'jenispengajuan/index';
		$this->load->view('layout/layout', $data);
	}
	public function tambah()
	{
		$data['view'] = 'admin/borang/kategori/tambah_kategori';
		$this->load->view('admin/layout', $data);
	}


	public function edit($id)
	{

		if ($this->input->post('submit')) {
			// $this->form_validation->set_rules(
			// 	'jenis_pengajuan',
			// 	'Kategori',
			// 	'trim|required',
			// 	array('required' => '%s wajib diisi.')
			// );
			// $this->form_validation->set_rules(
			// 	'kode',
			// 	'Kode',
			// 	'trim|required',
			// 	array('required' => '%s wajib diisi.')
			// );
			// $this->form_validation->set_rules(
			// 	'klien',
			// 	'Pengguna',
			// 	'trim|required',
			// 	array('required' => '%s wajib diisi.')
			// );
			$this->form_validation->set_rules(
				'deskripsinya',
				'Deskripsi',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'Jenis_Pengajuan',
				'Nama Jenis Pengajuan',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			// $this->form_validation->set_rules(
			// 	'kat_keterangan_surat[]',
			// 	'Formulir Isian',
			// 	'required',
			// 	array('required' => '%s wajib diisi.')
			// );
			// $this->form_validation->set_rules(
			// 	'template',
			// 	'Template',
			// 	'required',
			// 	array('required' => '%s wajib diisi.')
			// );

			if ($this->form_validation->run() == FALSE) {
				$data['kategori'] = $this->pengajuan_model->get_jenis_pengajuan_byid($id);
				$data['all_fields'] = $this->pengajuan_model->getAllFieldsPengajuan();
				$data['fields_pengajuan'] = $this->pengajuan_model->getAllFieldsPengajuan();
				//	$data['keterangan_surat'] = $this->pengajuan_model->get_kat_keterangan_surat();
				//	$data['title'] = 'Edit Jenis Pengajuan';
				$data['view'] = 'jenispengajuan/edit';
				$this->load->view('layout/layout', $data);
			} else {

				$data = array(
					'jenis_pengajuan' => $this->input->post('Jenis_Pengajuan'),
					// 'kode' => $this->input->post('kode'),
					// 'klien' => $this->input->post('klien'),
					'deskripsi' => $this->input->post('deskripsinya'),
					// 'tujuan_surat' => $this->input->post('tujuan_surat'),
					// 'template' => $this->input->post('template'),
				);

				$dataFieldCheck = [
					'not_exist_fields_data' => implode(',', $this->input->post("kat_keterangan_surat[]")),
					'sent_fields_data' => $this->input->post("kat_keterangan_surat[]"),
				];

				// print_r($data);
				$data = $this->security->xss_clean($data);
				$result = $this->pengajuan_model->edit_jenis_pengajuan($data, $id);
				if ($result) {
					// print_r($data);
					$this->pengajuan_model->editFieldsPengajuan($dataFieldCheck, $id);
					$this->session->set_flashdata('msg', 'Data kategory berhasil diubah!');
					redirect(base_url('admin/jenispengajuan/edit/' . $id));
				}


				// $ssj = $this->input->post("kat_keterangan_surat[]");
				// print_r($ssj['1']);
				// print_r($this->pengajuan_model->editFieldsPengajuan($dataFieldCheck, $id));

				// echo "<br>";
				// print_r(implode(',', $this->input->post("kat_keterangan_surat[]")));
				// echo "<br>";
				// print_r($dataFieldCheck['not_exist_fields_data']);
			}
		} else {
			$data['kategori'] = $this->pengajuan_model->get_jenis_pengajuan_byid($id);
			$data['all_fields'] = $this->pengajuan_model->getAllFieldsPengajuan();
			$data['fields_pengajuan'] = $this->pengajuan_model->getAllFieldsPengajuan();
			//	$data['template'] = $scanned_directory;
			$data['title'] = 'Edit Jenis Pengajuan';
			$data['view'] = 'jenispengajuan/edit';
			$this->load->view('layout/layout', $data);
		}
	}

	public function store_kategori()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_rules('nama', 'Nama Kategori', 'trim|required');
			$this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/borang/kategori/tambah_kategori';
				$this->load->view('admin/layout', $data);
			} else {

				$data = array(
					'kategori_dokumen' => $this->input->post('nama'),
					'singkatan' => $this->input->post('singkatan'),
				);

				print_r($data);

				$data = $this->security->xss_clean($data);
				$result = $this->apt_model->add_kategori($data);
				if ($result) {
					$this->session->set_flashdata('msg', 'Kategori baru berhasil ditambahkan!');
					redirect(base_url('admin/kategori'));
				}
			}
		} else {
			$data['view'] = 'admin/borang/kategori/tambah_kategori';
			$this->load->view('admin/layout', $data);
		}
	}

	// //kategori isian rules
	// public function kat_keterangan_pengajuan_check()
	// {
	// 	//if (isset($_POST['accept_terms_checkbox']))
	//         if ($this->input->post('kat_keterangan_surat'))
	// 	{
	// 		return TRUE;
	// 	}
	// 	else
	// 	{
	// 		$error = 'Please read and accept our terms and conditions.';
	// 		$this->form_validation->set_message('kat_keterangan_surat', $error);
	// 		return FALSE;
	// 	}
	// }
}
