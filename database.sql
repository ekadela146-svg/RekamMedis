db_rekam_medis

CREATE TABLE pasien (
    id_pasien INT AUTO_INCREMENT PRIMARY KEY,
    no_rm VARCHAR(20),
    nama_pasien VARCHAR(100),
    jenis_kelamin ENUM('L','P'),
    tanggal_lahir DATE,
    alamat TEXT
);


CREATE TABLE dokter (
    id_dokter INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100),
    spesialisasi VARCHAR(50)
);

CREATE TABLE obat (
    id_obat INT AUTO_INCREMENT PRIMARY KEY,
    nama_obat VARCHAR(100),
    satuan VARCHAR(30),
    stok INT
);


CREATE TABLE rekam_medis (
    id_rekam INT AUTO_INCREMENT PRIMARY KEY,
    id_pasien INT,
    id_dokter INT,
    id_obat INT,
    tanggal_periksa DATE,
    keluhan TEXT,
    diagnosa TEXT,
    tindakan TEXT,
    resep VARCHAR(100),

    FOREIGN KEY (id_pasien)
        REFERENCES pasien(id_pasien),

    FOREIGN KEY (id_dokter)
        REFERENCES dokter(id_dokter),

    FOREIGN KEY (id_obat)
        REFERENCES obat(id_obat)
);

INSERT INTO pasien (no_rm, nama_pasien, jenis_kelamin, tanggal_lahir, alamat)
VALUES ('RM001', 'Andi Saputra', 'L', '2005-04-12', 'Tuban'),
('RM002', 'Siti Aminah', 'P', '2006-08-20', 'Lamongan'),
('RM003', 'Budi Santoso', 'L', '2005-11-15', 'Bojonegoro');

INSERT INTO dokter (nama_dokter, spesialisasi)
VALUES ('Dr. Ahmad', 'Umum'), 
('Dr. Sinta', 'Gigi');

INSERT INTO obat (nama_obat, satuan, stok)
VALUES ('Paracetamol', 'Tablet', 100),
('Amoxicillin', 'Kapsul', 50),
('Vitamin C', 'Tablet', 75);