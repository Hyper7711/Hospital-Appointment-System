-- ============================================
-- Hospital Appointment & OPD Management System
-- Database: hospital_opd_db
-- ============================================

CREATE DATABASE IF NOT EXISTS hospital_opd_db;
USE hospital_opd_db;

-- ============================================
-- Table: Admin
-- ============================================

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin(username,password)
VALUES ('admin','admin123');

-- ============================================
-- Table: Departments
-- ============================================

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL
);

INSERT INTO departments(department_name)
VALUES
('General Medicine'),
('Cardiology'),
('Orthopedics'),
('Neurology'),
('Pediatrics'),
('Dermatology');

-- ============================================
-- Table: Doctors
-- ============================================

CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    department_id INT NOT NULL,
    phone VARCHAR(15),
    email VARCHAR(100),
    specialization VARCHAR(100),

    FOREIGN KEY (department_id)
    REFERENCES departments(id)
    ON DELETE CASCADE
);

INSERT INTO doctors(name,department_id,phone,email,specialization)
VALUES
('Dr. Rajesh Sharma',1,'9876543210','rajesh@gmail.com','General Physician'),
('Dr. Neha Patil',2,'9876543211','neha@gmail.com','Cardiologist'),
('Dr. Amit Joshi',3,'9876543212','amit@gmail.com','Orthopedic Surgeon'),
('Dr. Sneha Kulkarni',4,'9876543213','sneha@gmail.com','Neurologist'),
('Dr. Vivek Shah',5,'9876543214','vivek@gmail.com','Pediatrician');

-- ============================================
-- Table: Patients
-- ============================================

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    age INT NOT NULL,
    phone VARCHAR(15) UNIQUE,
    email VARCHAR(100) UNIQUE,
    address TEXT,
    password VARCHAR(255) NOT NULL
);

-- ============================================
-- Table: Appointments
-- ============================================

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,

    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,

    status ENUM(
        'Pending',
        'Approved',
        'Completed',
        'Cancelled'
    ) DEFAULT 'Pending',

    FOREIGN KEY (patient_id)
    REFERENCES patients(id)
    ON DELETE CASCADE,

    FOREIGN KEY (doctor_id)
    REFERENCES doctors(id)
    ON DELETE CASCADE
);

-- ============================================
-- Sample Patient
-- ============================================

INSERT INTO patients
(name,gender,age,phone,email,address,password)
VALUES
(
'Rahul Sharma',
'Male',
22,
'9876543200',
'rahul@gmail.com',
'Pune',
'123456'
);

-- ============================================
-- Sample Appointment
-- ============================================

INSERT INTO appointments
(patient_id,doctor_id,appointment_date,appointment_time,status)
VALUES
(
1,
2,
'2026-08-10',
'10:30:00',
'Pending'
);

-- ============================================
-- Database Ready
-- ============================================