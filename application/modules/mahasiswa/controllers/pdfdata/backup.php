<?php defined('BASEPATH') or exit('No direct script access allowed');
class Pengajuan extends Mahasiswa_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->library('mailer');
		$this->load->model('pengajuan_model', 'pengajuan_model');
		// $this->load->model('notif/Notif_model', 'notif_model');
		$this->load->helper('formulir');
	}

	public function detail($id_surat = 0)
	{
		// $data['surat'] = $this->pengajuan_model->get_detail_surat($id_surat);
		// $data['title'] = $data['surat']['id_mahasiswa'];
		// $data['view'] = 'surat/detail';
		// $this->load->view('layout/layout', $data);
	}

	public function pengajuan_saya()
	{
		$data['title'] = 'Pengajuan Saya';
		$data['view'] = 'pengajuan/pengajuan_saya_ajax';
		// $data['query'] = $this->db->query(
		// 	"SELECT 
		// 	p.*,
		// 	jp.Jenis_Pengajuan,
		// 	m.FULLNAME,
		// 	m.NAME_OF_FACULTY,
		// 	m.DEPARTMENT_ID,
		// 	ps.pic,
		// 	ps.status_id,
		// 	ps.date,
		// 	s.status,
		// 	s.status_id,
		// 	s.badge,
		// 	FORMAT (ps.date, 'dd/MM/yyyy ') as date,
		// 	FORMAT (ps.date, 'hh:mm:ss ') as time
		// 	FROM Tr_Pengajuan p 
		// 	LEFT JOIN Mstr_Jenis_Pengajuan jp ON p.Jenis_Pengajuan_Id = jp.Jenis_Pengajuan_Id
		// 	LEFT JOIN V_Mahasiswa m ON m.STUDENTID = p.nim
		// 	LEFT JOIN Tr_Pengajuan_Status ps ON ps.pengajuan_id = p.pengajuan_id
		// 	LEFT JOIN Tr_Status s ON s.status_id = ps.status_id
		// 	WHERE p.nim = 20190140096
		// 	AND ps.status_pengajuan_id = (SELECT MAX(status_pengajuan_id) 
		// 											FROM Tr_Pengajuan_Status  
		// 											WHERE pengajuan_id = p.pengajuan_id)"
		// )->result_array();
		$this->load->view('layout/layout', $data);
	}

	public function index($id_jenis_pengajuan = 0)
	{
		if ($id_jenis_pengajuan == 0) {
			// $data['jenis_pengajuan'] = $this->pengajuan_model->get_jenis_pengajuan($id_jenis_pengajuan);
			$data['rekognisi'] = $this->pengajuan_model->rekognisi();
			$data['jenis_pengajuan'] = $this->db->query(
				"SELECT * FROM Mstr_Jenis_Pengajuan WHERE parent IS NULL"
			)->result_array();
			$data['title'] = 'Ajukan Prestasi';
			$data['all'] = true;
			$data['view'] = 'pengajuan/index';
		} else {
			$data['jenis_pengajuan'] = $this->pengajuan_model->get_jenis_pengajuan($id_jenis_pengajuan);
			$data['title'] = 'Ajukan Prestasi';
			$data['all'] = false;
			$data['view'] = 'pengajuan/index';
		}
		$this->load->view('layout/layout', $data);
	}

	public function baru($id)
	{
		$data = array(
			'Jenis_Pengajuan_Id' => $id,
			'nim' => $this->session->userdata('studentid'),
		);

		$field = $this->db->select('*')->from('Tr_Pengajuan_Field')
			->join('Mstr_Fields', 'Mstr_fields.field_id=Tr_Pengajuan_Field.field_id', 'left')
			->where(array('Jenis_Pengajuan_Id' => $id))->get()
			->result_array();

		$data = $this->security->xss_clean($data);
		$result = $this->pengajuan_model->tambah($data);
		//ambil last id surat yg baru diinsert
		$insert_id = $this->db->insert_id();
		// set status surat
		$data_user = $this->session->userdata('user_id');
		$this->db->set('pengajuan_id', $insert_id)
			->set('status_id', 1)
			->set('pic', $data_user['STUDENTID'])
			->set('date', date('Y-m-d h:m:s'))
			->insert('Tr_Pengajuan_Status');

		// //ambil id surat berdasarkan last id status surat
		$inserted_id = $this->db->select('pengajuan_id')->from('Tr_Pengajuan_Status')->where('status_pengajuan_id=', $this->db->insert_id())->get()->row_array();
		// // ambil keterangan surat berdasar kategori surat
		// $kat_surat = $this->db->select('kat_keterangan_surat')->from('kategori_surat')->where('id=', $id)->get()->row_array();
		$field_id = $this->db->query(
			"SELECT Tr_Pengajuan_Field.field_id  FROM Mstr_Jenis_Pengajuan
			LEFT JOIN Tr_Pengajuan_Field ON Tr_Pengajuan_Field.Jenis_Pengajuan_Id = Mstr_Jenis_Pengajuan.Jenis_Pengajuan_Id
			WHERE Mstr_Jenis_Pengajuan.Jenis_Pengajuan_Id = $id AND Tr_Pengajuan_Field.terpakai = 1"
		)->result_array();

		// // explode kterangan surat

		// // foreach keterangan surat, lalu masukkan nilai awal (nilai kosong) berdasakan keterangan dari kategori surat kedalam field_value
		foreach ($field_id as $key => $id_kat) {
			$this->db->insert(
				'Tr_Field_Value',
				array(
					'value' => '',
					'pengajuan_id' =>  $inserted_id['pengajuan_id'],
					'field_id' => $id_kat['field_id'],
				)
			);
		}

		// foreach ($field_id as $ad) {
		// 	print_r($ad['field_id']);
		// }

		// $data_notif = array(
		// 	'id_surat' => $insert_id2['id_surat'],
		// 	'id_status' => 1,
		// 	'kepada' => $_SESSION['user_id'],
		// 	'role' => array(3)
		// );

		// $results = $this->notif_model->send_notif($data_notif);

		// if ($results) {
		// 	$this->session->set_flashdata('msg', 'Berhasil!');
		redirect(base_url('mahasiswa/pengajuan/tambah/' . $insert_id));
		// }
	}

	public function getAnggota()
	{
		$search = $this->input->post('search');
		$result_anggota = $this->pengajuan_model->getAnggota($search);

		foreach ($result_anggota as $anggota) {
			$selectajax[] = [
				'value' => $anggota['STUDENTID'],
				'id' => $anggota['STUDENTID'],
				'text' => $anggota['FULLNAME']
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
		}
	}

	public function getPengajuanSaya($id_jenis_pengajuan = 0)
	{
		// $search = $this->input->post('search');
		$result_anggota = $this->pengajuan_model->getPengajuanSaya($id_jenis_pengajuan);

		foreach ($result_anggota as $anggota) {
			$selectajax[] = [
				'pengajuan_id' => $anggota['pengajuan_id'],
				'Jenis_Pengajuan_Id' => $anggota['Jenis_Pengajuan_Id'],
				'nim' => $anggota['nim'],
				'Jenis_Pengajuan' => $anggota['Jenis_Pengajuan'],
				'FULLNAME' => $anggota['FULLNAME'],
				'NAME_OF_FACULTY' => $anggota['NAME_OF_FACULTY'],
				'DEPARTMENT_ID' => $anggota['DEPARTMENT_ID'],
				'pic' => $anggota['pic'],
				'status_id' => $anggota['status_id'],
				'date' => $anggota['date'],
				'status' => $anggota['status'],
				'badge' => $anggota['badge'],
				'time' => $anggota['time'],
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
		}
	}

	public function getPembimbing()
	{
		$search = $this->input->post('search');
		$result_anggota = $this->pengajuan_model->getPembimbing($search);

		foreach ($result_anggota as $anggota) {
			$selectajax[] = [
				'value' => $anggota['id_pegawai'],
				'id' => $anggota['id_pegawai'],
				'text' => $anggota['nama']
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
		}
	}

	public function tambah($pengajuan_id = 0)
	{
		$id_notif = $this->input->post('id_notif');

		$this->load->helper('formulir');
		$pengajuan_id;

		$pengajuan = $this->pengajuan_model->get_detail_pengajuan($pengajuan_id);
		$data['pengajuan'] = $pengajuan;

		$pengajuan_fields = $this->db->query(
			"SELECT * FROM Tr_Pengajuan_Field pf
			LEFT JOIN Mstr_Fields f ON f.field_id = pf.field_id
			WHERE pf.Jenis_Pengajuan_Id = $pengajuan->Jenis_Pengajuan_Id"
		)->result_array();

		$data['timeline'] = $this->db->query(
			"SELECT 
			*,
			FORMAT (ps.date, 'dd/MM/yyyy') as date,
			FORMAT (ps.date, 'hh:mm:ss') as time 
			FROM Tr_Pengajuan_Status ps
			LEFT JOIN Tr_Status s ON s.status_id = ps.status_id
			WHERE ps.pengajuan_id = $pengajuan->pengajuan_id"
		)->result_array();

		// $data['pengajuan'] = $this->pengajuan_model->get_detail_pengajuan($pengajuan_id);
		$data['pengajuan_fields'] = $pengajuan_fields;
		$data['pengajuan_status'] = $pengajuan->status_id;
		$data['pengajuan_id'] = $pengajuan->pengajuan_id;

		if ($this->input->post("submit")) {
			if ($this->input->post('revisi')) {
				$id_status = 5;
			} else {
				$id_status = 2;
			}

			$data_user = $this->session->userdata('user_id');
			$insert = $this->db->set('pengajuan_id', $pengajuan_id)
				->set('status_id', $id_status)
				->set('pic', $data_user['STUDENTID'])
				->set('date', date('Y-m-d h:m:s'))
				->insert('Tr_Pengajuan_Status');

			if ($insert) {
				foreach ($this->input->post('dokumen') as $id => $dokumen) {
					$this->db->where(array('field_id' => $id, 'pengajuan_id' => $pengajuan_id));
					$this->db->update(
						'Tr_Field_Value',
						array(
							'value' => $dokumen
						)
					);
				}

				foreach ($this->input->post('dokumen') as $id => $dokumen) {
					$this->db->where(array('field_id' => $id, 'pengajuan_id' => $pengajuan_id));
					$this->db->update(
						'Tr_Field_Value',
						array(
							'value' => $dokumen
						)
					);
				}
				redirect(base_url('mahasiswa/pengajuan/tambah/' . $pengajuan_id));
			}

			// foreach ($this->input->post('dokumen') as $id => $dokumen) {
			// 	echo $dokumen . "<br>";
			// }
		} else {
			$data['view'] = 'pengajuan/tambah';
			$this->load->view('layout/layout', $data);
		}
	}
	// public function edit()
	// {
	//   $data['query'] = $this->pengajuan_model->get_surat();
	//   $data['title'] = 'Ajukan Surat';
	//   $data['view'] = 'surat/tambah';
	//   $this->load->view('layout/layout', $data);
	// }
	// public function hapus($id_surat = 0)
	// {
	//   $surat_exist = $this->pengajuan_model->get_detail_surat($id_surat);
	//   if ($surat_exist['id_status'] == 4) {
	//     $this->db->delete('surat', array('id' => $id_surat));
	//     $this->session->set_flashdata('msg', 'Surat berhasil dihapus');
	//     redirect(base_url('mahasiswa/surat'));
	//   } else {
	//     $this->session->set_flashdata('msg', 'Surat Gagal dihapus');
	//     redirect(base_url('mahasiswa/surat'));
	//   }
	// }

	public function doupload()
	{
		header('Content-type:application/json;charset=utf-8');
		$upload_path = 'uploads/dokumen';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, TRUE);
		}

		$config = array(
			'upload_path' => $upload_path,
			'allowed_types' => "jpg|png|pdf|docx",
			'overwrite' => FALSE,
		);

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());

			echo json_encode(
				[
					'status' => 'error',
					'message' => $error
				]
			);
		} else {

			$filename = $config['file_name'] . $this->upload->data('file_ext');

			$data = $this->upload->data();

			// cek apakah gambar atau bukan

			if (($filename === '.jpg') || ($filename === '.jpeg') || ($filename === '.png') || ($filename === '.gif')) {

				//$filename = 'gambar';
				// jka gambar, buatkan thumbnail
				$this->_create_thumbs($data['file_name']);

				// $result = 
				$this->db->insert(
					'Tr_Media',
					array(
						'nim' => $this->session->userdata('studentid'),
						'file' =>  $upload_path . '/' . $data['file_name'],
						'thumb' =>  $upload_path . '/' . $data['raw_name'] . '_thumb' . $data['file_ext']
					)
				);
			} else {
				// $result = 
				$this->db->insert(
					'Tr_Media',
					array(
						'nim' => $this->session->userdata('studentid'),
						'file' =>  $upload_path . '/' . $data['file_name'],
						'thumb' =>  ''
					)
				);
			}



			echo json_encode(
				[
					'status' => 'Ok',
					'id' => $this->db->insert_id(),
					// 'path' => $upload_path . '/' . $data['file_name'],
					'thumb' => $upload_path . '/' . $data['raw_name'] . '_thumb' . $data['file_ext'],
					'orig' => $upload_path . '/' . $data['file_name'],
					'filename' => $data['file_name']
				]
			);
		}
	}

	// public function tampil_surat($id_surat)
	// {
	//   $data['title'] = 'Tampil Surat';
	//   $data['surat'] = $this->pengajuan_model->get_detail_surat($id_surat);
	//   $data['no_surat'] = $this->pengajuan_model->get_no_surat($id_surat);
	//   $kategori = $data['surat']['kategori_surat'];
	//   $nim = $data['surat']['username'];

	//   //$this->load->view('admin/surat/tampil_surat', $data);

	//   $mpdf = new \Mpdf\Mpdf([
	//     'tempDir' => __DIR__ . '/pdfdata',
	//     'mode' => 'utf-8',
	//     // 'format' => [24, 24],
	//     'format' => 'A4',
	//     'margin_left' => 0,
	//     'margin_right' => 0,
	//     'margin_bottom' => 20,
	//     'margin_top' => 30,
	//     'float' => 'left'
	//   ]);

	//   $view = $this->load->view('admin/surat/tampil_surat', $data, TRUE);

	//   $mpdf->SetHTMLHeader('
	// 	<div style="text-align: left; margin-left:2cm">
	// 			<img width="390" height="" src="' . base_url() . '/public/dist/img/logokop-pasca.jpg" />
	// 	</div>');
	//   $mpdf->SetHTMLFooter('

	// 	<div style="text-align:center; background:red;">
	// 		<img width="" height="" src="' . base_url() . '/public/dist/img/footerkop-pasca.jpg" />
	// 	</div>');

	//   $mpdf->WriteHTML($view);

	//   $mpdf->Output('Surat-' . $kategori . '-' . $nim . '.pdf', 'D');
	// }

	function _create_thumbs($upload_data)
	{
		// Image resizing config
		$upload_data = $this->upload->data();
		$image_config["image_library"] = "gd2";
		$image_config["source_image"] = $upload_data["full_path"];
		$image_config['create_thumb'] = true;
		$image_config['maintain_ratio'] = TRUE;
		$image_config['thumb_marker'] = "_thumb";
		$image_config['new_image'] = $upload_data["file_path"];
		$image_config['quality'] = "100%";
		$image_config['width'] = 320;
		$image_config['height'] = 240;
		$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
		$image_config['master_dim'] = ($dim > 0) ? "height" : "width";

		$this->load->library('image_lib');
		$this->image_lib->initialize($image_config);

		if (!$this->image_lib->resize()) { //Resize image
			redirect("errorhandler"); //If error, redirect to an error page
		}
	}
}
