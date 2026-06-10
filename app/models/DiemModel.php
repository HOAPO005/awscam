<?php
class DiemModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getDiems($class_id = '', $dept_id = '', $search = '', $subject_id = '') {
        $sql = 'SELECT diem.*, sinhvien.ho_ten as ten_sv, sinhvien.ma_sv, mon_hoc.ten_mh, lop.ten_lop, khoa.ten_khoa 
                FROM diem 
                JOIN sinhvien ON diem.id_sv = sinhvien.id 
                JOIN mon_hoc ON diem.id_mh = mon_hoc.id
                LEFT JOIN lop ON sinhvien.id_lop = lop.id
                LEFT JOIN khoa ON lop.id_khoa = khoa.id';
        
        $where = [];
        $params = [];

        if (!empty($class_id)) {
            $where[] = 'sinhvien.id_lop = :class_id';
            $params[':class_id'] = $class_id;
        }

        if (!empty($dept_id)) {
            $where[] = 'sinhvien.id_lop IN (SELECT id FROM lop WHERE id_khoa = :dept_id)';
            $params[':dept_id'] = $dept_id;
        }

        if (!empty($subject_id)) {
            $where[] = 'diem.id_mh = :subject_id';
            $params[':subject_id'] = $subject_id;
        }

        if (!empty($search)) {
            $where[] = '(sinhvien.ho_ten LIKE :search OR sinhvien.ma_sv LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' ORDER BY sinhvien.ma_sv ASC, diem.created_at DESC';

        $this->db->query($sql);

        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }

        return $this->db->resultSet();
    }

    public function addDiem($data) {
        $this->db->query('INSERT INTO diem (id_sv, id_mh, diem_qua_trinh, diem_thi, diem_tong_ket, hoc_ky, nam_hoc) 
                          VALUES (:id_sv, :id_mh, :diem_qua_trinh, :diem_thi, :diem_tong_ket, :hoc_ky, :nam_hoc)');
        $this->db->bind(':id_sv', $data['id_sv']);
        $this->db->bind(':id_mh', $data['id_mh']);
        $this->db->bind(':diem_qua_trinh', $data['diem_qua_trinh']);
        $this->db->bind(':diem_thi', $data['diem_thi']);
        $this->db->bind(':diem_tong_ket', $data['diem_tong_ket']);
        $this->db->bind(':hoc_ky', $data['hoc_ky']);
        $this->db->bind(':nam_hoc', $data['nam_hoc']);
        return $this->db->execute();
    }

    public function updateDiem($data) {
        $this->db->query('UPDATE diem SET diem_qua_trinh = :diem_qua_trinh, diem_thi = :diem_thi, diem_tong_ket = :diem_tong_ket, 
                          hoc_ky = :hoc_ky, nam_hoc = :nam_hoc WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':diem_qua_trinh', $data['diem_qua_trinh']);
        $this->db->bind(':diem_thi', $data['diem_thi']);
        $this->db->bind(':diem_tong_ket', $data['diem_tong_ket']);
        $this->db->bind(':hoc_ky', $data['hoc_ky']);
        $this->db->bind(':nam_hoc', $data['nam_hoc']);
        return $this->db->execute();
    }

    public function deleteDiem($id) {
        $this->db->query('DELETE FROM diem WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getDiemById($id) {
        $this->db->query('SELECT * FROM diem WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getDiemsBySinhVien($id_sv) {
        $this->db->query('SELECT diem.*, mon_hoc.ten_mh, mon_hoc.ma_mh, mon_hoc.so_tin_chi 
                          FROM diem 
                          JOIN mon_hoc ON diem.id_mh = mon_hoc.id 
                          WHERE diem.id_sv = :id_sv');
        $this->db->bind(':id_sv', $id_sv);
        return $this->db->resultSet();
    }

    public function checkSubjectExistsForStudent($id_sv, $id_mh) {
        $this->db->query('SELECT id FROM diem WHERE id_sv = :id_sv AND id_mh = :id_mh LIMIT 1');
        $this->db->bind(':id_sv', $id_sv);
        $this->db->bind(':id_mh', $id_mh);
        $row = $this->db->single();
        return $row ? true : false;
    }
}
