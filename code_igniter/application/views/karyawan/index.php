<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>List Karyawan</title>
</head>
<body>
   <h1>List Karyawan</h1>

   <p><a href="<?php echo base_url('karyawan/tambah'); ?>">Tambah Karyawan</a></p>

   <table border="1">
      <tr>
         <th>NIK</th>
         <th>Nama</th>
         <th>Alamat</th>
         <th>Tanggal Lahir</th>
         <th>Divisi</th>
         <th>Status</th>
         <th>Aksi</th>
      </tr>
      <?php foreach ($karyawan_list as $karyawan): ?>
         <tr>
            <td><?php echo $karyawan['nik']; ?></td>
            <td><?php echo $karyawan['nama']; ?></td>
            <td><?php echo $karyawan['alamat']; ?></td>
            <td><?php echo date('d-m-Y', strtotime($karyawan['tgllahir'])); ?></td>
            <td><?php echo $karyawan['divisi']; ?></td>
            <td><?php echo $karyawan['status']; ?></td>
            <td>
               <a href="<?php echo base_url('karyawan/edit/' . $karyawan['nik']); ?>">Edit</a> |
               <a href="<?php echo base_url('karyawan/delete/' . $karyawan['nik']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
            </td>
         </tr>
      <?php endforeach; ?>
   </table>

</body>
</html>
