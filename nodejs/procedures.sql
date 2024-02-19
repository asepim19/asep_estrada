CREATE PROCEDURE AddKaryawan(
  IN in_nama VARCHAR(150),
  IN in_alamat TEXT,
  IN in_tgllahir DATETIME,
  IN in_divisi VARCHAR(20),
  IN in_status VARCHAR(20)
)
BEGIN
  DECLARE divisi_code VARCHAR(2);
  DECLARE current_year VARCHAR(2);
  DECLARE max_sequence INT;

  CASE in_divisi
    WHEN 'IT' THEN SET divisi_code = '10';
    WHEN 'HRD' THEN SET divisi_code = '11';
    WHEN 'Finance' THEN SET divisi_code = '12';
    ELSE SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Invalid divisi';
  END CASE;

  SET current_year = SUBSTRING(YEAR(NOW()), 3);

  SELECT COALESCE(MAX(CAST(SUBSTRING(nik, 5) AS UNSIGNED)), 0) INTO max_sequence
  FROM m_karyawan
  WHERE nik LIKE CONCAT(divisi_code, current_year, '%');

  SET @new_nik = CONCAT(divisi_code, current_year, LPAD(max_sequence + 1, 4, '0'));

  INSERT INTO m_karyawan (nik, nama, alamat, tgllahir, divisi, status, created_date)
  VALUES (@new_nik, in_nama, in_alamat, in_tgllahir, in_divisi, in_status, NOW());

  SELECT @new_nik AS new_nik;
END;


CREATE PROCEDURE EditKaryawan(
  IN in_nik VARCHAR(8),
  IN in_nama VARCHAR(150),
  IN in_alamat TEXT,
  IN in_tgllahir DATETIME,
  IN in_divisi VARCHAR(20),
  IN in_status VARCHAR(20)
)
BEGIN
  UPDATE m_karyawan
  SET nama = in_nama,
      alamat = in_alamat,
      tgllahir = in_tgllahir,
      divisi = in_divisi,
      status = in_status
  WHERE nik = in_nik;
  
  SELECT 'Karyawan updated successfully' AS message;
END;


CREATE PROCEDURE DeleteKaryawan(
  IN in_nik VARCHAR(8)
)
BEGIN
  DELETE FROM m_karyawan WHERE nik = in_nik;
  
  SELECT 'Karyawan deleted successfully' AS message;
END;


CREATE PROCEDURE ListKaryawan()
BEGIN
  SELECT * FROM m_karyawan;
END;

CREATE PROCEDURE GetKaryawanDetail(IN p_nik VARCHAR(8))
BEGIN
  SELECT * FROM m_karyawan WHERE nik = p_nik;
END;