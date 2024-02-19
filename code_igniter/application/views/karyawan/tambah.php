<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Tambah Karyawan</title>
</head>
<body>
   <h1>Tambah Karyawan</h1>

   <form action="<?php echo base_url('karyawan/simpan'); ?>" method="post">
      <div>
         <label for="nama">Nama:</label>
         <input type="text" name="nama" required>
      </div>

      <div>
         <label for="alamat">Alamat:</label>
         <textarea name="alamat" required></textarea>
      </div>

      <div>
         <label for="tgllahir">Tanggal Lahir:</label>
         <input type="date" name="tgllahir" required>
      </div>

      <div>
         <label for="divisi">Divisi:</label>
         <select name="divisi" required>
            <option value="IT">IT</option>
            <option value="HRD">HRD</option>
            <option value="Finance">Finance</option>
         </select>
      </div>

      <div>
         <label for="status">Status Karyawan:</label>
         <select name="status" required>
            <option value="Tetap">Tetap</option>
            <option value="Kontrak">Kontrak</option>
         </select>
      </div>

      <!-- Tambahkan input lain sesuai kebutuhan -->

      <div>
         <button type="submit">Simpan</button>
      </div>
   </form>

   <p><a href="<?php echo base_url('karyawan'); ?>">Kembali ke List Karyawan</a></p>
</body>
</html>
