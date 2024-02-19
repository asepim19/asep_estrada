<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Hapus Karyawan</title>
</head>
<body>
    <h1>Konfirmasi Hapus Karyawan</h1>

    <p>Apakah Anda yakin ingin menghapus data karyawan dengan NIK <?php echo $karyawan['nik']; ?>?</p>

    <form action="<?php echo base_url('karyawan/do_delete/' . $karyawan['nik']); ?>" method="post">
        <button type="submit">Ya</button>
        <a href="<?php echo base_url('karyawan'); ?>">Tidak</a>
    </form>
</body>
</html>
