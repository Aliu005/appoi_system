-- قاعدة بيانات نظام المواعيد لأمانة الأحساء
-- Appointments System Database for Al-Ahsa Municipality

CREATE DATABASE IF NOT EXISTS appointments_system 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE appointments_system;

-- جدول المواعيد
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    national_id VARCHAR(10) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_reason VARCHAR(200) NOT NULL,
    reason_description TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    admin_notes TEXT NULL,
    sms_code VARCHAR(6) DEFAULT '123456',
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_national_id (national_id),
    INDEX idx_status (status),
    INDEX idx_appointment_date (appointment_date),
    INDEX idx_created_at (created_at)
);

-- جدول إحصائيات سريعة (للاستعلامات السريعة)
CREATE TABLE statistics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_users INT DEFAULT 0,
    total_appointments INT DEFAULT 0,
    pending_appointments INT DEFAULT 0,
    approved_appointments INT DEFAULT 0,
    rejected_appointments INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- إدراج إحصائيات أولية
INSERT INTO statistics (total_users, total_appointments, pending_appointments, approved_appointments, rejected_appointments) 
VALUES (0, 0, 0, 0, 0);

-- إدراج بيانات تجريبية للاختبار
INSERT INTO appointments (national_id, full_name, phone_number, appointment_date, appointment_reason, reason_description, status, admin_notes) VALUES
('1234567890', 'أحمد محمد علي', '0501234567', '2025-10-10', 'استخراج رخصة بناء', 'أريد استخراج رخصة بناء لقطعة أرض في حي الملك فهد', 'pending', NULL),
('2345678901', 'فاطمة سعد الأحمد', '0512345678', '2025-10-12', 'شكوى على خدمة', 'شكوى بخصوص تأخير في صيانة الطرق في الحي', 'approved', 'تم الموافقة - سيتم التواصل خلال 3 أيام عمل'),
('3456789012', 'خالد عبدالله', '0523456789', '2025-10-08', 'استعلام عن معاملة', 'استعلام عن حالة معاملة ترخيص محل تجاري', 'rejected', 'المعاملة تحتاج مستندات إضافية'),
('4567890123', 'نورا محمد', '0534567890', '2025-10-15', 'تجديد ترخيص', 'تجديد ترخيص نشاط تجاري لمحل بقالة', 'pending', NULL),
('5678901234', 'سعد الغامدي', '0545678901', '2025-10-20', 'استخراج شهادة', 'استخراج شهادة عدم ممانعة لفتح محل', 'pending', NULL);

-- تحديث الإحصائيات
UPDATE statistics SET 
    total_users = (SELECT COUNT(DISTINCT national_id) FROM appointments),
    total_appointments = (SELECT COUNT(*) FROM appointments),
    pending_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'pending'),
    approved_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'approved'),
    rejected_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'rejected');

-- triggers لتحديث الإحصائيات تلقائياً
DELIMITER //

CREATE TRIGGER update_stats_after_insert
AFTER INSERT ON appointments
FOR EACH ROW
BEGIN
    UPDATE statistics SET 
        total_users = (SELECT COUNT(DISTINCT national_id) FROM appointments),
        total_appointments = (SELECT COUNT(*) FROM appointments),
        pending_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'pending'),
        approved_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'approved'),
        rejected_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'rejected');
END//

CREATE TRIGGER update_stats_after_update
AFTER UPDATE ON appointments
FOR EACH ROW
BEGIN
    UPDATE statistics SET 
        total_users = (SELECT COUNT(DISTINCT national_id) FROM appointments),
        total_appointments = (SELECT COUNT(*) FROM appointments),
        pending_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'pending'),
        approved_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'approved'),
        rejected_appointments = (SELECT COUNT(*) FROM appointments WHERE status = 'rejected');
END//

DELIMITER ;

-- عرض البيانات للتأكد
SELECT 'Appointments Table' as table_name;
SELECT * FROM appointments;

SELECT 'Statistics Table' as table_name;
SELECT * FROM statistics;