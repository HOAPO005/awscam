<?php
class ThongKeModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getStudentCount() {
        $this->db->query('SELECT COUNT(*) as total FROM sinhvien');
        return $this->db->single();
    }

    public function getStudentCountByClass() {
        $this->db->query('SELECT lop.ten_lop as name, COUNT(sinhvien.id) as count 
                          FROM lop 
                          LEFT JOIN sinhvien ON lop.id = sinhvien.id_lop 
                          GROUP BY lop.id');
        return $this->db->resultSet();
    }

    public function getGradeStats() {
        $this->db->query('SELECT 
                            SUM(CASE WHEN diem_tong_ket >= 8.0 THEN 1 ELSE 0 END) as excellent,
                            SUM(CASE WHEN diem_tong_ket >= 6.5 AND diem_tong_ket < 8.0 THEN 1 ELSE 0 END) as good,
                            SUM(CASE WHEN diem_tong_ket >= 5.0 AND diem_tong_ket < 6.5 THEN 1 ELSE 0 END) as average,
                            SUM(CASE WHEN diem_tong_ket < 5.0 THEN 1 ELSE 0 END) as weak
                          FROM diem');
        return $this->db->single();
    }

    public function getTuitionStats() {
        $this->db->query('SELECT tinh_trang as name, COUNT(*) as count FROM hoc_phi GROUP BY tinh_trang');
        return $this->db->resultSet();
    }

    public function getStudentCountByDept() {
        $this->db->query('SELECT khoa.ten_khoa as name, COUNT(sinhvien.id) as count 
                          FROM khoa 
                          LEFT JOIN lop ON khoa.id = lop.id_khoa
                          LEFT JOIN sinhvien ON lop.id = sinhvien.id_lop 
                          GROUP BY khoa.id');
        return $this->db->resultSet();
    }

    public function getTopStudents($limit = 5) {
        $this->db->query('SELECT sv.ma_sv, sv.ho_ten, AVG(d.diem_tong_ket) as gpa, l.ten_lop
                          FROM sinhvien sv
                          JOIN diem d ON sv.id = d.id_sv
                          JOIN lop l ON sv.id_lop = l.id
                          GROUP BY sv.id
                          HAVING gpa >= 8.0
                          ORDER BY gpa DESC
                          LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getWeakStudents($limit = 5) {
        $this->db->query('SELECT sv.ma_sv, sv.ho_ten, AVG(d.diem_tong_ket) as gpa, l.ten_lop
                          FROM sinhvien sv
                          JOIN diem d ON sv.id = d.id_sv
                          JOIN lop l ON sv.id_lop = l.id
                          GROUP BY sv.id
                          HAVING gpa < 5.0
                          ORDER BY gpa ASC
                          LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
}
