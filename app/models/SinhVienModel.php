<?php
class SinhVienModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getSinhViens($limit = 10, $offset = 0, $search = '', $class_id = '', $dept_id = '') {
        $sql = 'SELECT sinhvien.*, lop.ten_lop, khoa.ten_khoa,
                (SELECT tinh_trang FROM hoc_phi WHERE ma_sv = sinhvien.id ORDER BY id DESC LIMIT 1) as tinh_trang_hp,
                (SELECT id FROM hoc_phi WHERE ma_sv = sinhvien.id ORDER BY id DESC LIMIT 1) as hp_id
                FROM sinhvien 
                LEFT JOIN lop ON sinhvien.id_lop = lop.id 
                LEFT JOIN khoa ON lop.id_khoa = khoa.id 
                WHERE 1=1';
        
        if (!empty($search)) {
            $sql .= ' AND (sinhvien.ma_sv LIKE :search OR sinhvien.ho_ten LIKE :search)';
        }
        if (!empty($class_id)) {
            $sql .= ' AND sinhvien.id_lop = :class_id';
        }
        if (!empty($dept_id)) {
            $sql .= ' AND lop.id_khoa = :dept_id';
        }

        $sql .= ' ORDER BY sinhvien.ma_sv ASC LIMIT :limit OFFSET :offset';

        $this->db->query($sql);
        
        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        if (!empty($class_id)) {
            $this->db->bind(':class_id', $class_id);
        }
        if (!empty($dept_id)) {
            $this->db->bind(':dept_id', $dept_id);
        }
        
        $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
        $this->db->bind(':offset', (int)$offset, PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    public function getTotal($search = '', $class_id = '', $dept_id = '') {
        $sql = 'SELECT COUNT(*) as total FROM sinhvien 
                LEFT JOIN lop ON sinhvien.id_lop = lop.id 
                WHERE 1=1';
        
        if (!empty($search)) {
            $sql .= ' AND (sinhvien.ma_sv LIKE :search OR sinhvien.ho_ten LIKE :search)';
        }
        if (!empty($class_id)) {
            $sql .= ' AND sinhvien.id_lop = :class_id';
        }
        if (!empty($dept_id)) {
            $sql .= ' AND lop.id_khoa = :dept_id';
        }

        $this->db->query($sql);
        
        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        if (!empty($class_id)) {
            $this->db->bind(':class_id', $class_id);
        }
        if (!empty($dept_id)) {
            $this->db->bind(':dept_id', $dept_id);
        }

        $row = $this->db->single();
        return $row->total;
    }

    public function addSinhVien($data) {
        $this->db->query('INSERT INTO sinhvien (ma_sv, ho_ten, ngay_sinh, gioi_tinh, sdt, email, dia_chi, id_lop) 
                          VALUES (:ma_sv, :ho_ten, :ngay_sinh, :gioi_tinh, :sdt, :email, :dia_chi, :id_lop)');
        $this->db->bind(':ma_sv', $data['ma_sv']);
        $this->db->bind(':ho_ten', $data['ho_ten']);
        $this->db->bind(':ngay_sinh', $data['ngay_sinh']);
        $this->db->bind(':gioi_tinh', $data['gioi_tinh']);
        $this->db->bind(':sdt', $data['sdt']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':dia_chi', $data['dia_chi']);
        $this->db->bind(':id_lop', $data['id_lop']);

        $result = $this->db->execute();
        if ($result) {
            $student_id = $this->db->lastInsertId();
            // Automatically create a user account for this student
            $this->db->query('INSERT INTO users (username, password, fullname, email, phone, role_id, id_sinhvien, status) 
                              VALUES (:username, :password, :fullname, :email, :phone, :role_id, :id_sinhvien, :status)');
            $this->db->bind(':username', trim($data['ma_sv']));
            $this->db->bind(':password', '123');
            $this->db->bind(':fullname', trim($data['ho_ten']));
            $this->db->bind(':email', trim($data['email']));
            $this->db->bind(':phone', trim($data['sdt']));
            $this->db->bind(':role_id', 3); // Role 3 is Student
            $this->db->bind(':id_sinhvien', $student_id);
            $this->db->bind(':status', 'active');
            $this->db->execute();

            // Automatically create an unpaid tuition record
            $this->db->query('SELECT so_tien, hoc_ky, nam_hoc FROM hoc_phi ORDER BY id DESC LIMIT 1');
            $latest_hp = $this->db->single();
            
            $so_tien = $latest_hp ? $latest_hp->so_tien : 15000000;
            $hoc_ky = $latest_hp ? $latest_hp->hoc_ky : 1;
            $nam_hoc = $latest_hp ? $latest_hp->nam_hoc : '2025-2026';

            $this->db->query('INSERT INTO hoc_phi (ma_sv, so_tien, tinh_trang, hoc_ky, nam_hoc) VALUES (:ma_sv, :so_tien, "Chua dong", :hoc_ky, :nam_hoc)');
            $this->db->bind(':ma_sv', $student_id);
            $this->db->bind(':so_tien', $so_tien);
            $this->db->bind(':hoc_ky', $hoc_ky);
            $this->db->bind(':nam_hoc', $nam_hoc);
            $this->db->execute();
        }
        return $result;
    }

    public function updateSinhVien($data) {
        $this->db->query('UPDATE sinhvien SET ho_ten = :ho_ten, ngay_sinh = :ngay_sinh, gioi_tinh = :gioi_tinh, 
                          sdt = :sdt, email = :email, dia_chi = :dia_chi, id_lop = :id_lop WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':ho_ten', $data['ho_ten']);
        $this->db->bind(':ngay_sinh', $data['ngay_sinh']);
        $this->db->bind(':gioi_tinh', $data['gioi_tinh']);
        $this->db->bind(':sdt', $data['sdt']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':dia_chi', $data['dia_chi']);
        $this->db->bind(':id_lop', $data['id_lop']);

        $result = $this->db->execute();
        if ($result) {
            // Also update the corresponding user account
            $this->db->query('UPDATE users SET fullname = :fullname, email = :email, phone = :phone WHERE id_sinhvien = :id_sinhvien');
            $this->db->bind(':fullname', trim($data['ho_ten']));
            $this->db->bind(':email', trim($data['email']));
            $this->db->bind(':phone', trim($data['sdt']));
            $this->db->bind(':id_sinhvien', $data['id']);
            $this->db->execute();
        }
        return $result;
    }

    public function updateAddress($id, $dia_chi) {
        $this->db->query('UPDATE sinhvien SET dia_chi = :dia_chi WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':dia_chi', $dia_chi);
        return $this->db->execute();
    }

    public function deleteSinhVien($id) {
        // First delete the corresponding user
        $this->db->query('DELETE FROM users WHERE id_sinhvien = :id_sinhvien');
        $this->db->bind(':id_sinhvien', $id);
        $this->db->execute();

        // Then delete the student
        $this->db->query('DELETE FROM sinhvien WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getSinhVienById($id) {
        $this->db->query('SELECT sinhvien.*, lop.ten_lop, khoa.ten_khoa,
                          (SELECT tinh_trang FROM hoc_phi WHERE ma_sv = sinhvien.id ORDER BY id DESC LIMIT 1) as tinh_trang_hp,
                          (SELECT id FROM hoc_phi WHERE ma_sv = sinhvien.id ORDER BY id DESC LIMIT 1) as hp_id
                          FROM sinhvien 
                          LEFT JOIN lop ON sinhvien.id_lop = lop.id 
                          LEFT JOIN khoa ON lop.id_khoa = khoa.id 
                          WHERE sinhvien.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
