<?php
class Data_pengajuan_model extends CI_Model
{
	var $table = "Tr_Pengajuan p";
	var $column_order = [
		'pengajuan_id',
		'Jenis_Pengajuan_Id',
		'nim'
	];
	var $order = [
		'pengajuan_id',
		'Jenis_Pengajuan_Id',
		'nim'
	];

	private function _get_data_query()
	{
		$this->db->from($this->table);
		$this->db->join('Tr_Pengajuan_Status ps', 'ps.pengajuan_id = p.pengajuan_id', 'left');
		$this->db->join('Tr_Status s', 's.status_id = ps.status_id', 'left');
		$this->db->join('Mstr_Jenis_Pengajuan jp', 'jp.Jenis_Pengajuan_Id = p.Jenis_Pengajuan_Id', 'left');
		$this->db->join('V_Mahasiswa m', 'm.STUDENTID = p.nim', 'left');
		$this->db->join('Mstr_Department d', 'd.DEPARTMENT_ID = m.DEPARTMENT_ID', 'left');
	}

	public function getDataPengajuan()
	{
		$role = $_SESSION['role'];
		if ($role == '') {
			$id_status = '';
		} else if ($role == 1) {
			$id_status = " ps.status_id =  9";
		} else if ($role == 2) {
			$id_status = " (ps.status_id =  2 OR ps.status_id = 5)";
		} else if ($role == 5) {
			$id_status = " ps.status_id =  8";
		} else if ($role == 6) {
			$id_status = " (ps.status_id =  3 OR ps.status_id = 7)";
		}

		// $this->db->where(
		// 	'ps.status_id',
		// 	$this->db->select_max('status_id')
		// 		->from('Tr_Pengajuan_Status ps')
		// 		->where([
		// 			'ps.pengajuan_id = p.pengajuan_id',
		// 			$id_status
		// 		])
		// );

		$this->_get_data_query();
		$query = $this->db->get();

		return $query;
	}
}
