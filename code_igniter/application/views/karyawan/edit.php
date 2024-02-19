<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Edit Karyawan</title>
</head>
<body>
   <h1>Edit Karyawan</h1>

   <form action="<?php echo base_url('karyawan/update/'. $karyawan['nik'] ); ?>" method="post">
      <div>
         <label for="nik">NIK:</label>
         <input type="text" name="nik" value="<?php echo $karyawan['nik']; ?>" readonly>
      </div>

      <div>
         <label for="nama">Nama:</label>
         <input type="text" name="nama" value="<?php echo $karyawan['nama']; ?>" required>
      </div>

      <div>
         <label for="alamat">Alamat:</label>
         <textarea name="alamat" required><?php echo $karyawan['alamat']; ?></textarea>
      </div>

      <div>
         <label for="tgllahir">Tanggal Lahir:</label>
         <input type="date" name="tgllahir" value="<?php echo date('Y-m-d', strtotime($karyawan['tgllahir'])); ?>" required>
      </div>

      <div>
         <label for="divisi">Divisi:</label>
         <select name="divisi" required>
            <option value="IT" <?php echo ($karyawan['divisi'] === 'IT') ? 'selected' : ''; ?>>IT</option>
            <option value="HRD" <?php echo ($karyawan['divisi'] === 'HRD') ? 'selected' : ''; ?>>HRD</option>
            <option value="Finance" <?php echo ($karyawan['divisi'] === 'Finance') ? 'selected' : ''; ?>>Finance</option>
         </select>
      </div>

      <div>
         <label for="status">Status Karyawan:</label>
         <select name="status" required>
            <option value="Tetap" <?php echo ($karyawan['status'] === 'Tetap') ? 'selected' : ''; ?>>Tetap</option>
            <option value="Kontrak" <?php echo ($karyawan['status'] === 'Kontrak') ? 'selected' : ''; ?>>Kontrak</option>
         </select>
      </div>

      <div>
         <button type="submit">Simpan Perubahan</button>
      </div>
   </form>

   <p><a href="<?php echo base_url('karyawan'); ?>">Kembali ke List Karyawan</a></p>
</body>
</html>
