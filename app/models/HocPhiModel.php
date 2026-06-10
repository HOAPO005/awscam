<?php
class HocPhiModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getHocPhis($status = '', $sinhvien_id = null, $class_id = '', $dept_id = '', $search = '') {
        $sql = 'SELECT hoc_phi.*, sinhvien.ho_ten as ten_sv, sinhvien.ma_sv as sv_ma_sv, lop.ten_lop, khoa.ten_khoa 
                FROM hoc_phi 
                JOIN sinhvien ON hoc_phi.ma_sv = sinhvien.id
                LEFT JOIN lop ON sinhvien.id_lop = lop.id
                LEFT JOIN khoa ON lop.id_khoa = khoa.id';
        
        $where = [];
        $params = [];
        
        if (!empty($status)) {
            $where[] = 'hoc_phi.tinh_trang = :status';
            $params[':status'] = $status;
        }
        
        if ($sinhvien_id) {
            $where[] = 'hoc_phi.ma_sv = :sinhvien_id';
            $params[':sinhvien_id'] = $sinhvien_id;
        }

        if (!empty($class_id)) {
            $where[] = 'sinhvien.id_lop = :class_id';
            $params[':class_id'] = $class_id;
        }

        if (!empty($dept_id)) {
            $where[] = 'lop.id_khoa = :dept_id';
            $params[':dept_id'] = $dept_id;
        }

        if (!empty($search)) {
            $where[] = '(sinhvien.ho_ten LIKE :search OR sinhvien.ma_sv LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }
        
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        
        $sql .= ' ORDER BY sinhvien.ma_sv ASC, hoc_phi.created_at DESC';
        
        $this->db->query($sql);
        
        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }
        
        return $this->db->resultSet();
    }

    public function checkHocPhiExists($ma_sv, $hoc_ky, $nam_hoc, $exclude_id = null) {
        $query = 'SELECT * FROM hoc_phi WHERE ma_sv = :ma_sv AND hoc_ky = :hoc_ky AND nam_hoc = :nam_hoc';
        if ($exclude_id) {
            $query .= ' AND id != :exclude_id';
        }
        $this->db->query($query);
        $this->db->bind(':ma_sv', $ma_sv);
        $this->db->bind(':hoc_ky', $hoc_ky);
        $this->db->bind(':nam_hoc', $nam_hoc);
        if ($exclude_id) {
            $this->db->bind(':exclude_id', $exclude_id);
        }
        return $this->db->single();
    }

    public function addHocPhi($data) {
        $this->db->query('INSERT INTO hoc_phi (ma_sv, so_tien, tinh_trang, hoc_ky, nam_hoc, ngay_dong, ghi_chu) 
                          VALUES (:ma_sv, :so_tien, :tinh_trang, :hoc_ky, :nam_hoc, :ngay_dong, :ghi_chu)');
        $this->db->bind(':ma_sv', $data['ma_sv']);
        $this->db->bind(':so_tien', $data['so_tien']);
        $this->db->bind(':tinh_trang', $data['tinh_trang']);
        $this->db->bind(':hoc_ky', $data['hoc_ky']);
        $this->db->bind(':nam_hoc', $data['nam_hoc']);
        $this->db->bind(':ngay_dong', $data['ngay_dong']);
        $this->db->bind(':ghi_chu', $data['ghi_chu']);
        return $this->db->execute();
    }

    public function updateHocPhi($data) {
        $this->db->query('UPDATE hoc_phi SET so_tien = :so_tien, tinh_trang = :tinh_trang, 
                          hoc_ky = :hoc_ky, nam_hoc = :nam_hoc, ngay_dong = :ngay_dong, ghi_chu = :ghi_chu WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':so_tien', $data['so_tien']);
        $this->db->bind(':tinh_trang', $data['tinh_trang']);
        $this->db->bind(':hoc_ky', $data['hoc_ky']);
        $this->db->bind(':nam_hoc', $data['nam_hoc']);
        $this->db->bind(':ngay_dong', $data['ngay_dong']);
        $this->db->bind(':ghi_chu', $data['ghi_chu']);
        return $this->db->execute();
    }

    public function deleteHocPhi($id) {
        $this->db->query('DELETE FROM hoc_phi WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getHocPhiById($id) {
        $this->db->query('SELECT hp.*, sv.ho_ten, sv.ma_sv as sv_ma_sv, sv.email 
                          FROM hoc_phi hp 
                          JOIN sinhvien sv ON hp.ma_sv = sv.id 
                          WHERE hp.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function bulkAssign($id_lop, $so_tien, $hoc_ky, $nam_hoc) {
        $this->db->query('INSERT INTO hoc_phi (ma_sv, so_tien, tinh_trang, hoc_ky, nam_hoc)
                          SELECT id, :so_tien, "Chua dong", :hoc_ky, :nam_hoc
                          FROM sinhvien
                          WHERE id_lop = :id_lop
                          AND id NOT IN (
                              SELECT ma_sv FROM hoc_phi WHERE hoc_ky = :hoc_ky2 AND nam_hoc = :nam_hoc2
                          )');
        $this->db->bind(':id_lop', $id_lop);
        $this->db->bind(':so_tien', $so_tien);
        $this->db->bind(':hoc_ky', $hoc_ky);
        $this->db->bind(':nam_hoc', $nam_hoc);
        $this->db->bind(':hoc_ky2', $hoc_ky);
        $this->db->bind(':nam_hoc2', $nam_hoc);
        return $this->db->execute();
    }

    public function bulkAssignByDept($id_khoa, $so_tien, $hoc_ky, $nam_hoc) {
        $this->db->query('INSERT INTO hoc_phi (ma_sv, so_tien, tinh_trang, hoc_ky, nam_hoc)
                          SELECT sv.id, :so_tien, "Chua dong", :hoc_ky, :nam_hoc
                          FROM sinhvien sv
                          JOIN lop l ON sv.id_lop = l.id
                          WHERE l.id_khoa = :id_khoa
                          AND sv.id NOT IN (
                              SELECT ma_sv FROM hoc_phi WHERE hoc_ky = :hoc_ky2 AND nam_hoc = :nam_hoc2
                          )');
        $this->db->bind(':id_khoa', $id_khoa);
        $this->db->bind(':so_tien', $so_tien);
        $this->db->bind(':hoc_ky', $hoc_ky);
        $this->db->bind(':nam_hoc', $nam_hoc);
        $this->db->bind(':hoc_ky2', $hoc_ky);
        $this->db->bind(':nam_hoc2', $nam_hoc);
        return $this->db->execute();
    }

    public function bulkAssignAll($so_tien, $hoc_ky, $nam_hoc) {
        $this->db->query('INSERT INTO hoc_phi (ma_sv, so_tien, tinh_trang, hoc_ky, nam_hoc)
                          SELECT id, :so_tien, "Chua dong", :hoc_ky, :nam_hoc
                          FROM sinhvien
                          WHERE id NOT IN (
                              SELECT ma_sv FROM hoc_phi WHERE hoc_ky = :hoc_ky2 AND nam_hoc = :nam_hoc2
                          )');
        $this->db->bind(':so_tien', $so_tien);
        $this->db->bind(':hoc_ky', $hoc_ky);
        $this->db->bind(':nam_hoc', $nam_hoc);
        $this->db->bind(':hoc_ky2', $hoc_ky);
        $this->db->bind(':nam_hoc2', $nam_hoc);
        return $this->db->execute();
    }
}
